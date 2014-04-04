<input type="button" onclick="changeAddress()" value=" Показать объект на карте " style="margin-bottom: 5px;" />
<div id="ymaps-map-id_13401264085565651343" style="width: {if !empty($map_field.width)}{$map_field.width}{else}100%{/if}; height: {if !empty($map_field.height)}{$map_field.height}{else}400px;{/if};"></div>

<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=loadMap"></script>
<script type="text/javascript" src="/js/app/yandexmap.js"></script>

<script type="text/javascript">
    var address_fields = '{$map_field.address}'.split(',');
    var f_latitude = '{$map_field.fields.latitude}';
    var f_longitude = '{$map_field.fields.longitude}';
    getAddress = function() {ldelim}
        if ($('#country').val() == '') {ldelim}
            return null;
        {rdelim}

        var address = $('#s2id_country .select2-chosen').text() + ', ' + $('#s2id_region .select2-chosen').text() + ', ' + $('#s2id_city .select2-chosen').text() + ', ' + $('#street').val();

        return jQuery.trim(address);
    {rdelim}
</script>
