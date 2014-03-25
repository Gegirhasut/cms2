var s_id_data = [];
var r_id_data = [];

$(document).ready(function() {
    $("#r_id").select2({
        minimumInputLength: 0,
        allowClear: true,
        ajax: {
            url: '/api/getRubric/?nosession=1',
            dataType: 'json',
            quietMillis: 300,
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
            if (r_id_data.length != 0) {
                callback(r_id_data);
            }
        },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Пожалуйста, начните ввод..."; },
        formatSearching: function () { return "Поиск..."; }
    });

    $('#r_id').change(function() {
        $("#s_id").select2("enable", true);
        $("#s_id").select2("val", '');
    });

    $("#s_id").select2({
        minimumInputLength: 0,
        allowClear: true,
        ajax: {
            url: '/api/getSubject/?nosession=1',
            dataType: 'json',
            quietMillis: 300,
            data: function (term) {
                return {
                    r_id: $('#r_id').val(),
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
            if (s_id_data.length != 0) {
                callback(s_id_data);
            }
        },
        formatInputTooShort: function (input, min) { var n = min - input.length; return "Пожалуйста, начните ввод..."; },
        formatSearching: function () { return "Поиск..."; }
    });

    if ($("#r_id").val() == '') {
        $("#s_id").select2("enable", false);
    }
});