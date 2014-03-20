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
                if (typeof result.error[i].key !== 'undefined') {
                    $('#' + result.error[i].key).show();
                    $('#' + result.error[i].key + ' .form-group').addClass('has-error');
                } else {
                    var form_group = $('#' + result.error[i].name).closest('.form-group');
                    form_group.addClass('has-error');

                    var message_id = result.error[i].message;
                    var message = $('#error_' + message_id).val();
                    form_group.find('.error .help-block').html(message);
                }
            }
        }
    } catch (e) {
        alert(formResponse);
    }
}