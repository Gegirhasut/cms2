var jcrop_api;
var picW = 0;
var picH = 0;
var realw = 0;
var realh = 0;
var filePath = '';
var fieldName = '';
var uploadObject = '';
var actionUrl = '';

function ajaxFileUpload(fileId, object, field, action)
{
    actionUrl = action;
    uploadObject = object;

    if ($('#' + fileId).val() == "")
        return false;

    $("#loading")
        .ajaxStart(function(){
            $(this).show();
        })
        .ajaxComplete(function(){
            $(this).hide();
        });

    try {
        $.ajaxFileUpload
        (
            {
                url: actionUrl + 'upload/' + uploadObject,
                secureuri:false,
                fileElementId: fileId,
                dataType: 'json',
                data: {field: field},
                success: function (data, status)
                {
                    $('body').prepend(
                    '<div id="image_preview_window">\
                        <div id="outer">\
                        Загрузка картинки. Выделите область на картинке.\
                            <div id="image_preview">\
                            </div>\
                            <div>Миниатюра</div>\
                            <div id="image_crop" style="overflow:hidden;margin-top:5px;border: 1px solid grey;">\
                            </div>\
                            <button id="submit" onclick="createCropImage(\'' + uploadObject +  '\')">Создать миниатюру</button>\
                            <button onclick="cancelUpload(\'' + uploadObject +  '\')">Отменить</button>\
                        </div>\
                    </div>\
                    <div id="overlay_crop"></div>');

                    $('#image_preview_window').show();
                    $('#overlay_crop').show();
                    $('#image_preview').html('<img id="jcrop_target" src="/' + data.to + '" />');
                    $('#image_crop').html('<img id="jcrop_preview" src="/' + data.to + '" />');
                    $('#image_crop').css('width', data.picw);
                    $('#image_crop').css('height', data.pich);

                    picW = data.picw;
                    picH = data.pich;
                    realw = data.realw;
                    realh = data.realh;
                    filePath = data.filePath;
                    fieldName = data.field;

                    $('#jcrop_target').Jcrop({
                        onChange: showPreview,
                        onSelect: showPreview,
                        setSelect: [0,0,data.picw, data.pich],
                        aspectRatio: data.picw / data.pich
                    }, function() {
                        jcrop_api = this;
                    });

                },
                error: function (data, status, e)
                {
                    alert(e);
                }
            }
        )
    }catch (e) {
        var i=0;
        i++;
    }

    return false;
}

function showPreview(coords)
{
    var rx = picW / coords.w;
    var ry = picH / coords.h;

    $('#jcrop_preview').css({
        width: Math.round(rx * realw) + 'px',
        height: Math.round(ry * realh) + 'px',
        marginLeft: '-' + Math.round(rx * coords.x) + 'px',
        marginTop: '-' + Math.round(ry * coords.y) + 'px'
    });
}

function createCropImage(object) {
    $("#submit").attr('disabled', 'disabled');

    var obj = jcrop_api.tellSelect();
    $.post(
        actionUrl + "/crop/" + object,
        {x: obj.x, y: obj.y, x2: obj.x2, y2: obj.y2, filePath : filePath, field: fieldName},
        function (data) {
            try {
                data = $.parseJSON(data);
            } catch (e) {}

            if (typeof data.path !== 'undefined') {
                addPreviewValue(data.path, data.field, data.file);
                $('#image_preview_window').remove();
                $('#overlay_crop').remove();
                $("#submit").removeAttr("disabled");
                $('#remove').show();
            }
        }
    );
}

function addPreviewValue(path, field, file) {
    var html = '<div id="loading"><img src="/images/app/loading.gif"></div>';
    html += '<img src="/' + path + '" style="max-width:100" />';
    html += '<input type="hidden" name="' + field + '" value="' + file + '" />';
    $('#small_image_' + field).html(html);
}

function cancelUpload(object) {
    $.post(
        actionUrl + "/crop/" + object + '?cancel=1',
        { field: fieldName },
        function () {
            $('#image_preview_window').remove();
            $('#overlay_crop').remove();
            $("#submit").removeAttr("disabled");
        }
    );
}

function deleteImage(field) {
    $('#small_image_' + field + ' img').remove();
    $('#small_image_' + field + ' input').val('');
    $('#remove').hide();
}