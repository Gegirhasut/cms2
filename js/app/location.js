var country_data = [];
var region_data = [];
var city_data = [];

$(document).ready(function() {
    $("#country").select2({
        minimumInputLength: 1,
        allowClear: true,
        ajax: {
            url: '/api/select2/Country/?nosession=1',
            dataType: 'json',
            maxSearchLetters: 1,
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
        lastResults = null;
    });

    if ($("#country").val() == '') {
        $("#region").select2("enable", false);
    }

    if ($("#country").val() == '') {
        $("#city").select2("enable", false);
    }

    $("#region").select2({
        minimumInputLength: 0,
        allowClear: true,
        ajax: {
            url: '/api/getRegion/?nosession=1',
            dataType: 'json',
            maxSearchLetters: 0,
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
        lastResults = null;
    });


    $("#city").select2({
        minimumInputLength: 0,
        allowClear: true,
        ajax: {
            url: '/api/select2/City/?nosession=1',
            dataType: 'json',
            maxSearchLetters: 0,
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

});