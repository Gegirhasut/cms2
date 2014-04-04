<script src="/js/app/personal-study.js"></script>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                <p>Укажите предметы, которым Вы можете обучать</p>
            </div>
        </div>

        {include file="units/form.tpl"}

        {include file="units/notify_message.tpl"}

    </div>
    <div class="col-md-6">
        {if $subjects|@count neq 0}
            <p>Предметы:</p>
            <table class="table table-striped">
                <tr>
                    <th>Предмет</th>
                    <th>Продолжительность урока</th>
                    <th>Стоимость</th>
                    <th>Удалить</th>
                </tr>
                {foreach from=$subjects item=subject}
                    <tr id="subject_{$subject.us_id}">
                        <td>{$subject.subject}</td>
                        <td style="text-align: center;">{$subject.duration} мин.</td>
                        <td style="text-align: center;">{$subject.cost} руб.</td>
                        <td style="text-align: center;"><a href="javascript:;" onclick="showRemoveSubject({$subject.us_id})"><img src="/images/app/deletered.png" width="20px" /></a></td>
                    </tr>
                {/foreach}
            </table>

            <div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="modal_remove"  aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-sm modal-dialog-center">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="myModalLabel">Удалить предмет</h4>
                        </div>
                        <div class="modal-body" style="float: right;">
                            <button type="button" class="btn btn-primary" onclick="removeSubject('UserSubject')">Да</button>
                            <button type="button" class="btn btn-primary" onclick="$('#modal_remove').modal('hide')">Нет</button>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </div>
            </div>
        {/if}
    </div>
</div>


