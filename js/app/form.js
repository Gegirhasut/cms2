var country_data = [];
var region_data = [];
var city_data = [];

$(document).ready(function() {
    $("#country").select2({
        placeholder: "Выберите Вашу страну",
        minimumInputLength: 1,
        ajax: {
            url: '/api/getCountry/',
            dataType: 'json',
            data: function (term) {
                return {
                    title: term
                };
            },
            results: function (data) {
                return {
                    results: data
                };
            }
        },
        initSelection : function (element, callback) {
            if (country_data.length != 0) {
                callback(country_data);
            }
        },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Пожалуйста, начните ввод..."; },
        formatSearching: function () { return "Поиск..."; }
    });

    $('#country').change(function() {
        $("#region").select2("enable", true);
        $("#region").select2("val", '');
        $("#city").select2("enable", false);
        $("#city").select2("val", '');
    });

    $("#region").select2({
        placeholder: "Выберите Ваш регион",
        minimumInputLength: 1,
        ajax: {
            url: '/api/getRegion/',
            dataType: 'json',
            data: function (term) {
                return {
                    country_id: $('#country').val(),
                    title: term
                };
            },
            results: function (data) {
                return {results: data};
            }
        },
        initSelection : function (element, callback) {
            if (region_data.length != 0) {
                callback(region_data);
            }
        },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Пожалуйста, начните ввод..."; },
        formatSearching: function () { return "Поиск..."; }
    });

    $('#region').change(function() {
        $("#city").select2("enable", true);
        $("#city").select2("val", '');
    });

    if ($("#country").val() == '') {
        $("#region").select2("enable", false);
    }

    $("#city").select2({
        placeholder: "Выберите Ваш город",
        minimumInputLength: 0,
        ajax: {
            url: '/api/getCity/',
            dataType: 'json',
            data: function (term) {
                return {
                    country_id: $('#country').val(),
                    region_id: $('#region').val(),
                    title: term
                };
            },
            results: function (data) {
                return {results: data};
            }
        },
        initSelection : function (element, callback) {
            if (city_data.length != 0) {
                callback(city_data);
            }
        },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Пожалуйста, начните ввод..."; },
        formatSearching: function () { return "Поиск..."; }
    });

    if ($("#country").val() == '') {
        $("#city").select2("enable", false);
    }

    $('#register_btn').bind("click touchstart", function(){
        $('#cabinet_message').hide();

        var postData = $('#form_reg').serializeArray();
        var formURL = $('#form_reg').attr("action");

        showOverlay('Подождите немного ...');
        var start_time = (new Date()).getTime();

        $.ajax(
        {
            url : formURL,
            type: "POST",
            data : postData,
            success:function(data, textStatus, jqXHR)
            {
                registrationData = data;

                var stop_time = (new Date()).getTime();
                if (stop_time - start_time < 1000) {
                    setTimeout("getRegistrationResult()", 1000 - (stop_time - start_time));
                } else {
                    getRegistrationResult();
                }
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                //if fails
            }
        });
    });

    $('#login_btn').bind("click touchstart", function(){
        var postData = $('#login_reg').serializeArray();
        var formURL = $('#login_reg').attr("action");

        showOverlay('Подождите немного ...');
        var start_time = (new Date()).getTime();

        $.ajax(
            {
                url : formURL,
                type: "POST",
                data : postData,
                success:function(data, textStatus, jqXHR)
                {
                    registrationData = data;

                    var stop_time = (new Date()).getTime();
                    if (stop_time - start_time < 1000) {
                        setTimeout("getLoginResult()", 1000 - (stop_time - start_time));
                    } else {
                        getLoginResult();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown)
                {
                    //if fails
                }
            });
    });
});

var registrationData = '';

function getRegistrationResult() {
    hideOverlay();

    if (registrationData == 'success') {
        window.location.href = '/cabinet';
        return;
    }

    $('.has-error').removeClass('has-error');
    $('#email_unique').hide();

    try {
        var result = $.parseJSON(registrationData);
        if (typeof result.error !== 'undefined') {
            for (var i = 0; i < result.error.length; i++) {
                var form_group = $('#' + result.error[i].name).closest('.form-group');
                form_group.addClass('has-error');

                var message_id = result.error[i].message;
                var message = $('#error_' + message_id).val();
                form_group.find('.error .help-block').html(message);
            }
        }
    } catch (e) {
        alert(registrationData);
    }
}

function getLoginResult() {
    hideOverlay();

    if (registrationData == 'success') {
        window.location.href = '/cabinet';
        return;
    }

    $('#login_error').show();
}