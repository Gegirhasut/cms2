<link rel="stylesheet" type="text/css" href="/Libs/Bootstrap-3.1.0/css/bootstrap3-wysiwyg5-color.css" />
<link rel="stylesheet" type="text/css" href="/Libs/Bootstrap-3.1.0/css/bootstrap3-wysiwyg5.css" />
<script src="/Libs/Bootstrap-3.1.0/js/wysihtml5-0.3.0.min.js" type="text/javascript"></script>
<script src="/Libs/Bootstrap-3.1.0/js/bootstrap3-wysihtml5.js" type="text/javascript"></script>
<script src="/Libs/Bootstrap-3.1.0/locales/bootstrap-wysihtml5.ru-RU.js" type="text/javascript"></script>

<textarea id="{$key}" name="{$key}" placeholder="{$field.placeholder}" style="width:100%;" rows="{if isset($field.rows)}{$field.rows}{else}10{/if}">{$values[$key]}</textarea>

<script type="text/javascript">
    $.fn.wysihtml5.locale["ru-RU"].emphasis = {ldelim} bold: "B", italic: "I", underline: "U" {rdelim};
    $('#{$key}').wysihtml5({ldelim}
        "font-styles": true,
        "emphasis": true,
        "lists": true,
        "html": true,
        "link": true,
        "image": true,
        "color": true,
        "size": 'sm', //sm | xs
        "locale": "ru-RU",
        "events": {ldelim}
            "change": function() {ldelim}
                $('#{$key}').html($('#{$key}').val());
                {rdelim}
            {rdelim}
        {rdelim});
</script>