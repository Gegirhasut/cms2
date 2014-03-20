<link rel="stylesheet" type="text/css" href="/Libs/Bootstrap-3.1.0/css/bootstrap3-wysiwyg5-color.css" />

<div class="row">
    <div class="col-md-12">
        <h1>{$h1}</h1>
    </div>
    {if !empty($subjects)}
        <div class="col-md-12">
            <h2>Учитель по {$subject_po}</h2>
        </div>
    {/if}
</div>
<hr>
<div class="row">
    <div class="col-md-12">
        {include file="units/notify_message.tpl"}
    </div>
</div>
<br>
<div class="row user_info">
    <div class="col-md-6">
        {if !empty($user.user_pic)}
            <div class="row">
                <div class="col-md-5">
                    Фото
                </div>
                <div class="col-md-7">
                    <img class="img-thumbnail" src="/{$small_path}{$user.user_pic}" />
                </div>
            </div>
            <div class="row"><div class="col-md-12"></div></div>
        {/if}
        <div class="row">
            <div class="col-md-5">
                Имя
            </div>
            <div class="col-md-7">
                {$user.fio}
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                Место жительства
            </div>
            <div class="col-md-7">
                {$user.country}, {$user.region}, г. {$user.city}
            </div>
        </div>
        <div class="row"><div class="col-md-12"></div></div>
        <div class="row">
            <div class="col-md-5">
                <b>Контакты</b>
            </div>
            <div class="col-md-7">
                {if !isset($user_auth)}
                    <a href="/auth/registration" title="Регистрация на сайте Все Учителя">Контактная информация доступна только для зарегистрированных пользователей</a>
                {/if}
            </div>
        </div>
        {if isset($user_auth)}
            <div class="row">
                <div class="col-md-5">
                    Контактый телефон
                </div>
                <div class="col-md-7">
                    {if $user.phone eq ''}
                        не указан
                    {else}
                        {$user.phone}
                    {/if}
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    Skype
                </div>
                <div class="col-md-7">
                    {if $user.skype eq ''}
                        не указан
                    {else}
                        {$user.skype}
                    {/if}
                </div>
            </div>
            <div class="row">
                <div class="col-md-5">
                    Связаться
                </div>
                <div class="col-md-7">
                    <a href="/cabinet/messages/{$user.u_id}">Отправить сообщение</a>
                </div>
            </div>
        {/if}
    </div>
    <div class="col-md-6">
        {if !empty($subjects)}

            <p><b>Обучает:</b></p>
            <table class="table table-striped">
                <tr>
                    <th>Предмет</th>
                    <th>Продолжительность урока</th>
                    <th>Стоимость</th>
                </tr>
                {foreach from=$subjects item=subject}
                    <tr id="subject_{$subject.us_id}">
                        <td><b>{$subject.subject}</b></td>
                        <td style="text-align: center;">{$subject.duration} мин.</td>
                        <td style="text-align: center;">{$subject.cost} руб.</td>
                    </tr>
                {/foreach}
            </table>

        {/if}
        <div class="row">
            <div class="col-md-12">
                <b>Дополнительная информация:</b>
            </div>
            <div class="col-md-12">
                <br/>
                {$user.info}
            </div>
        </div>
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

{include file="units/message_form.tpl"}