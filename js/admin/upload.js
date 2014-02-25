var jcrop_api;
var picW = 0;
var picH = 0;
var realw = 0;
var realh = 0;
var filePath = '';
var fieldName = '';

function ajaxFileUpload(fileId, object, field)
{
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
                url:'/admin/api/upload/' + object,
                secureuri:false,
                fileElementId: fileId,
                dataType: 'json',
                data: {field: field},
                success: function (data, status)
                {
                    $('#image_preview_window').show();
                    $('#overlay').show();
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
        "/admin/api/crop/" + object,
        {x: obj.x, y: obj.y, x2: obj.x2, y2: obj.y2, filePath : filePath, field: fieldName},
        function (data) {
            try {
                data = $.parseJSON(data);
            } catch (e) {}

            if (typeof data.path !== 'undefined') {
                addPreviewValue(data.path, data.field, data.file);
                $('#image_preview_window').hide();
                $('#overlay').hide();
                $("#submit").removeAttr("disabled");
            }
        }
    );
}

function addPreviewValue(path, field, file) {
    var html = '<img src="/' + path + '" style="max-width:100" />';
    html += '<input type="hidden" name="' + field + '" value="' + file + '" />';
    $('#small_image_' + field).html(html);
}

function cancelUpload(object) {
    $.post(
        "/admin/api/crop/" + object + '?cancel=1',
        { field: fieldName },
        function () {
            $('#image_preview_window').hide();
            $('#overlay').hide();
            $("#submit").removeAttr("disabled");
        }
    );
}