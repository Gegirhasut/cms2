<link rel="stylesheet" type="text/css" href="/Libs/Bootstrap-3.1.0/css/bootstrap3-wysiwyg5-color.css" />
<link rel="stylesheet" type="text/css" href="/Libs/Bootstrap-3.1.0/css/bootstrap3-wysiwyg5.css" />
<script src="/Libs/Bootstrap-3.1.0/js/wysihtml5-0.3.0.min.js" type="text/javascript"></script>
<script src="/Libs/Bootstrap-3.1.0/js/bootstrap3-wysihtml5.js" type="text/javascript"></script>
<script src="/Libs/Bootstrap-3.1.0/locales/bootstrap-wysihtml5.ru-RU.js" type="text/javascript"></script>

<textarea {if isset($field.maxlength)}maxlength="{$field.maxlength}"{/if} id="{$key}" name="{$key}" placeholder="{$field.placeholder}" style="width:100%;" rows="10">{$form.value[$key]}</textarea>

<script type="text/javascript">
    $.fn.wysihtml5.locale["ru-RU"].emphasis = {ldelim} bold: "B", italic: "I", underline: "U" {rdelim};
    $('#{$key}').wysihtml5({ldelim}
        "font-styles": false,
        "emphasis": true,
        "lists": true,
        "html": false,
        "link": true,
        "image": false,
        "color": false,
        "size": 'sm', //sm | xs
        "locale": "ru-RU",
        "events": {ldelim}
            "change": function() {ldelim}
                $('#{$key}').html($('#{$key}').val());
            {rdelim}
        {rdelim}
    {rdelim});
</script>