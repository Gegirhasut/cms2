<link rel="stylesheet" type="text/css" href="/Libs/Bootstrap-3.1.0/css/bootstrap3-wysiwyg5-color.css" />
<link rel="stylesheet" type="text/css" href="/Libs/Bootstrap-3.1.0/css/bootstrap3-wysiwyg5.css" />
<script src="/Libs/Bootstrap-3.1.0/js/wysihtml5-0.3.0.min.js" type="text/javascript"></script>
<script src="/Libs/Bootstrap-3.1.0/js/bootstrap3-wysihtml5.js" type="text/javascript"></script>
<script src="/Libs/Bootstrap-3.1.0/locales/bootstrap-wysihtml5.ru-RU.js" type="text/javascript"></script>

<textarea id="{$key}" name="{$key}" placeholder="{$field.placeholder}" cols="80" rows="5">{$form.value[$key]}</textarea>

<script type="text/javascript">
    $('#{$key}').wysihtml5({ldelim}
        "font-styles": false,
        "emphasis": true,
        "lists": false,
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