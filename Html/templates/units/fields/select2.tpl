<input type="hidden" name="{$key}" id="{$key}" style="width:100%" value="{$form.value[$key]}" placeholder="{$field.placeholder}">

<script>
    var {$key}_data = [];
    {literal}
    $(document).ready(function() {
        $("#{/literal}{$key}").select2({ldelim}
            minimumInputLength: {if isset($field.minimumInputLength)}{$field.minimumInputLength}{else}1{/if},
            {literal}
            allowClear: true,
            ajax: {
                {/literal}
                url: '/api/select2/{$field.relation.join}/?nosession=1',
                dataType: 'json',
                {if isset($field.maxSearchLetters)}
                    maxSearchLetters: {$field.maxSearchLetters},
                {else}
                    maxSearchLetters: 1,
                {/if}
                {literal}
                data: function (term) {
                    return {
                        {/literal}
                        {if isset($field.select_fields)}
                            {foreach from=$field.select_fields item=sf key=sf_key}
                                {$sf_key} : $('#{$sf}').val(),
                            {/foreach}
                        {/if}
                        {literal}
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
                if ({/literal}{$key}{literal}_data.length != 0) {
                    callback({/literal}{$key}{literal}_data);
                }
            },
            formatInputTooShort: function (input, min) { var n = min - input.length; return "Пожалуйста, начните ввод..."; },
            formatSearching: function () { return "Поиск..."; }
        });

        {/literal}

        {if isset($field.relative_fields)}

            $('#{$key}').change(function()
            {ldelim}
                {foreach from=$field.relative_fields item=rel_f key=rel_name}
                $("#{$rel_name}").select2("enable", {if $rel_f eq 'enable'}true{else}false{/if} );
                $("#{$rel_name}").select2("val", '');
                {/foreach}
            {rdelim});

            {foreach from=$field.relative_fields item=rel_f key=rel_name}
                if ($("#{$key}").val() == '') {ldelim}
                    $("#{$rel_name}").select2("enable", false);
                {rdelim}
            {/foreach}

        {/if}

        {literal}
    });
    {/literal}
</script>
