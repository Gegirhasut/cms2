var blockTimeout = 8000;

$( document ).ready(function() {
    var width = $('.tutor').outerWidth();
    var count = $('.tutor').length;
    $('.kv').width(width * count);
    setTimeout("runnerBlock()", blockTimeout);
});

var direction = '-';

function runnerBlock() {
    runBlock('.tutor', '.kv');
}

function runBlock(block, kv) {
    var width = $(block).outerWidth();
    var full_width = $(kv).outerWidth();
    var shown = 5;
    var count = $(block).length;
    if (count <= shown) {
        return;
    }

    $(kv).animate({
        "marginLeft": direction + "=" + width + "px"
    }, 500, function() {
        if (width * shown - parseInt($(kv).css('margin-left')) >= full_width) {
            direction = '+';
        }
        if (parseInt($(kv).css('margin-left')) >= 0) {
            direction = '-';
        }
        setTimeout("runBlock()", blockTimeout);
    });
}

function showOverlay(text) {
    $('<div class="modal-backdrop fade in" style="z-index: 1;"></div><div class="loader">' + text + '</div>').appendTo(document.body);
}

function hideOverlay() {
    $(".modal-backdrop").remove();
    $(".loader").remove();
}