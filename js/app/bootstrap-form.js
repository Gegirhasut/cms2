$(document).ready(function() {
    $('#form_btn').bind("click touchstart", function(){
        submitForm();
    });
});

function submitForm () {
    $('#cabinet_message').hide();

    var postData = $('#form').serializeArray();
    var formURL = $('#form').attr("action");

    showOverlay('Подождите немного ...');
    var start_time = (new Date()).getTime();

    $.ajax(
        {
            url : formURL,
            type: "POST",
            data : postData,
            success:function(data, textStatus, jqXHR)
            {
                formResponse = data;

                var stop_time = (new Date()).getTime();
                if (stop_time - start_time < 1000) {
                    setTimeout("parseFormResult()", 1000 - (stop_time - start_time));
                } else {
                    parseFormResult();
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails
            }
        });
}

var formResponse = '';

function parseFormResult() {
    hideOverlay();

    try {
        var result = $.parseJSON(formResponse);

        if (typeof result.success !== 'undefined') {
            if (result.success == '') {
                window.location.reload();
            } else {
                window.location.href = result.success;
            }
            return;
        }

        $('.has-error').removeClass('has-error');

        if (typeof result.error !== 'undefined') {
            for (var i = 0; i < result.error.length; i++) {
                var form_group = $('#key_' + result.error[i].name);
                form_group.find('.error').remove();
                form_group.addClass('has-error');

                var message = result.error[i].message;
                var help_width = $('#help_width').val();
                var className = 'col-sm-' + help_width;
                var help_offset = $('#help_offset').val();
                if (help_offset != '') {
                    className += ' col-sm-offset-' + help_offset;
                }

                var help_html = '<div class="' + className + ' error"><span class="help-block control-label">' + message + '</span></div>';

                form_group.append(help_html);
            }
        }
    } catch (e) {
        alert(formResponse);
    }
}