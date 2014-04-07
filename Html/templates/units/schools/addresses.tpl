<script src="/js/app/form-add-address.js"></script>
<script src="/js/app/yandexmap.js"></script>
{if $addresses|@count neq 0}
    {if isset($no_operations)}
        <script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?coordorder=longlat&load=package.full&wizard=constructor&lang=ru-RU&onload=loadMap"></script>
    {/if}

    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped">
                <tr>
                    <th>Адрес</th>
                    <th>Карта</th>
                    <th>Телефоны</th>
                    <th>Емайлы</th>
                    {if !isset($no_operations)}
                        <th style="text-align: center;">Удалить</th>
                    {/if}
                </tr>
                {foreach from=$addresses item=address}
                    <tr id="subject_{$address.sa_id}">
                        <td>{$address.country}, {$address.region}, {$address.city}{if !empty($address.street)}, {$address.street}{/if}</td>
                        <th><a href="javascript:;" onclick="showMap({$address.latitude}, {$address.longitude})">Показать</a></th>
                        <td>{$address.phones}</td>
                        <td>{$address.emails}</td>
                        {if !isset($no_operations)}
                            <td style="text-align: center;"><a href="javascript:;" onclick="showRemoveSubject({$address.sa_id})"><img src="/images/app/deletered.png" width="20px" /></a></td>
                        {/if}
                    </tr>
                {/foreach}
            </table>

            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="modal_remove"  aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-center">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Удалить адрес</h4>
                        </div>
                        <div class="modal-body" style="float: right;">
                            <button type="button" class="btn btn-primary" onclick="removeSubject('SchoolAddress')">Да</button>
                            <button type="button" class="btn btn-primary" onclick="$('#modal_remove').modal('hide')">Нет</button>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </div>

            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="modal_map"  aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="width:90%;">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div id="ymaps-map-id_address" style="width: 90%; height: 500px;"></div>
                        </div>
                        <div class="modal-body" style="float: right;">
                            <button type="button" class="btn btn-primary" onclick="$('#modal_map').modal('hide')">Закрыть</button>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}