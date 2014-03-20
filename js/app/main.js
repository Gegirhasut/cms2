var blockTimeout = 8000;

$( document ).ready(function() {
    var width = $('.tutor').outerWidth();
    var count = $('.tutor').length;
    $('.kv').width(width * count);
    setTimeout("runnerBlock()", blockTimeout);

    $('form').keypress(function (e) {
        if(e.which == 13) {
            submitForm();
        }
    });
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
    $('<div class="modal-backdrop fade in" style="z-index: 1002;"></div><div class="loader">' + text + '</div>').appendTo(document.body);
}

function hideOverlay() {
    $(".modal-backdrop").remove();
    $(".loader").remove();
}

/*  Cabinet JS */
var s_id = 0;
function showRemoveSubject(subject) {
    s_id = subject;
    $('#modal_remove').modal('show');
}

function removeSubject() {
    $.get('/api/delete/UserSubject/' + s_id, function (data) {
        if (data != 0) {
            $('#subject_' + data).remove();
        }

        $('#modal_remove').modal('hide');
    });
}

var last_message = false;
$( document ).ready(function() {
    $('.message').bind("click touchstart", function(event) {
        var id = event.currentTarget.id;
        id = id.substr(8);
        window.location.href = "/cabinet/messages/" + id;
    });

    var scroll = $('#scroll');

    if (scroll.length != 0) {
        var height = scroll[0].scrollHeight;
        scroll.scrollTop(height);

        scroll.scroll(function () {
            if (scroll.scrollTop() == 0 && !last_message) {
                var trs = $('.table tr');
                if (trs.length > 0) {
                    var id = $(trs[0]).attr('id').substr(5);
                    $.get(window.location.href + '?ajax&from=' + id, function(data)
                    {
                        if (data != '') {
                            var h1 = scroll[0].scrollHeight;
                            $('#scroll .table tr:first').before(data);
                            var h2 = scroll[0].scrollHeight;
                            var delta = h2 - h1;
                            scroll.scrollTop(delta);
                        } else {
                            last_message = true;
                        }
                    });
                }
            }
        });
    }
});