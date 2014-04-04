<input type="button" onclick="changeAddress()" value=" Найти объект на карте " />
<div id="ymaps-map-id_13401264085565651343" style="width: 100%; height: 400px;"></div>

<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=loadMap"></script>
<script type="text/javascript" src="/js/app/yandexmap.js"></script>

<script type="text/javascript">
    var address_fields = '{$field.address}'.split(',');
    var f_latitude = '{$field.fields.latitude}';
    var f_longitude = '{$field.fields.longitude}';
</script>
