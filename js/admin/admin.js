function open_window(link,w,h)
{
    var win = "width="+w+",height="+h+",menubar=no,location=no,resizable=yes,scrollbars=yes";
    newWin = window.open(link,'newWin',win);
    setTimeout("checkWin()", 1000);
}

function checkWin() {
    if (newWin.closed == false) {
        setTimeout("checkWin()", 500);
    } else {
        window.location.reload();
    }
}

function delete_object(object, identity) {
    var del = confirm('Удалить ' + object + '[' + identity + ']?');
    if (del) {
        $.get('/admin/api/delete/' + object + '/' + identity, function(data) {
            if (data == 1) {
                $('#tr_object_' + identity).hide(500, function () {location.reload();});
            } else {
                location.reload();
            }
        });
    }
}

var source = [];
var prev_search = '';

function fill_select(key, show, obj) {
    var search = $('#filter_' + key).val();
    if (search.length == 0) {
        return;
    }
    if (search == prev_search) {
        return;
    }
    $('#' + key).val('');
    prev_search = search;
    var url = '/admin/api/get/' + obj + '/?' + show + '=' + search + '%';
    $.post(
        url,
        {
            'fields' : key + ',' + show
        },
        function(data) {
            var jsonData = $.parseJSON(data);
            source[obj] = [];
            source[obj]['source'] = [];
            source[obj]['key'] = key;

            for (var i = 0; i < jsonData.length; i++) {
                source[obj]['source'].push({'id' : jsonData[i][key], 'value' : jsonData[i][show], 'label' : jsonData[i][show]});
            }

            $( "#filter_" + key).autocomplete({
                source: source[obj]['source'],
                select: function( event, ui )
                {
                    $('#' + source[obj]['key']).val(ui.item.id);
                    prev_search = ui.item.label;
                },
                focus: function (event, ui) {
                    event.preventDefault(); // Prevent the default focus behavior.
                }
            });

            $( "#filter_" + key ).autocomplete( "search",  $( "#filter_" + key).val());
        }
    );
}