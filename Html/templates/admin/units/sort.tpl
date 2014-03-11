<script>
    {literal}
    $( "#sortable" ).sortable({
        helper: "clone",
        cursor: "move",
        items: "tr.drag",
        update: function(event, ui) {
            var id_order = $('#sortable tr .hidden_identity');
            var new_order = '';
            for (i = 0; i < id_order.length; i++) {
                var cur = $(id_order[i]).val();
                new_order += (new_order == '') ? cur : ',' + cur;
            }
            $.get('/admin/api/sort/{/literal}{$class}{literal}/?order=' + new_order, function (data) {
                var index = 1;
                var fields = $('.sort_field');
                for (i = 0; i < fields.length; i++) {
                    $(fields[i]).html(index);
                    index++;
                }

            });
        },
        start: function (event, ui) {
            var tds = $('#sortable tr th');
            var helper = $($('#sortable tr')[$('#sortable tr').length-1]);
            //if (typeof helper !== 'undefined') {
            for (i = 0; i < tds.length; i++) {
                $($(helper).find('td')[i]).width($(tds[i]).width());
            }
            //}
        }
    });
    {/literal}
</script>