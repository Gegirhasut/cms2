<script src="/js/app/location.js"></script>

{if isset($activation)}

<div class="row">
    <div class="col-md-12">
        <div class="form-group has-error">
            <label class="control-label">Требуется email активация для работы на сайте!</label>
        </div>
        <div class="form-group">
            На почтовый ящик <label class="control-label">{$user_auth.email}</label>, указанный при регистрации, было отправлено письмо со ссылкой для активации.
            <br>
            Пожалуйста, откройте это письмо и перейдите по ссылке для активации Вашего аккаунта.
            <br>
            В противном случае Вы не сможете пользоваться сайтом в полном объеме.

        </div>
        <div class="form-group has-error">
            Если Вы не получили письмо, то сделайте <label class="control-label"><a href="/activation/resend">повторную активацию</a></label>.
        </div>

        {if isset($cabinet_message) && !empty($cabinet_message)}
            {foreach from=$cabinet_message item=message}
            <div class="form-group has-error" id="cabinet_message">
                <label class="control-label">{$message}</label>
            </div>
            {/foreach}
        {/if}
    </div>
</div>

{else}

<div class="row">
    <div class="col-md-12">
        <form role="form" class="form-horizontal" method="post" id="form" action="/cabinet">
            <div class="form-group">
                <label for="fio" class="col-sm-1 control-label">ФИО</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="fio" id="fio" placeholder="Ваше ФИО" value="{$user_auth.fio}">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-1 control-label">Email</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Ваш email" value="{$user_auth.email}">
                    <span class="help-block">На новый email адрес будет выслано письмо с подтверждением операции изменения email</span>
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-1 control-label">Пароль</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Введите новый пароль">
                    <span class="help-block">Оставьте это поле пустым, если не собираетесь менять пароль</span>
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="country" class="col-sm-1 control-label">Страна</label>
                <div class="col-sm-4">
                    <input type="hidden" name="country" id="country" style="width:100%" value="{$user_auth.country}">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="region" class="col-sm-1 control-label">Регион</label>
                <div class="col-sm-4">
                    <input type="hidden" name="region" id="region" style="width:100%" value="{$user_auth.region}">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="city" class="col-sm-1 control-label">Город</label>
                <div class="col-sm-4">
                    <input type="hidden" name="city" id="city" style="width:100%" value="{$user_auth.city}">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
        </form>

        <input type="hidden" id="error_unique" value="Пользователь с таким email уже существует!" />
        <input type="hidden" id="error_not_empty" value="Поле не может быть пустым!" />
        <input type="hidden" id="error_email" value="Не корректный email адрес!" />
        <input type="hidden" id="error_unique" value="Пользователь с таким email уже существует!" />

        <div class="form-group">
            <div class="col-sm-offset-1 col-sm-8">
                <button type="submit" class="btn btn-default" id="form_btn">Сохранить</button>
            </div>
        </div>


    </div>
</div>

{include file="units/notify_message.tpl"}

<script>
    {if isset($country)}
        country_data = {ldelim} id: {$user_auth.country}, text: '{$country}' {rdelim};
    {/if}
    {if isset($region)}
        region_data = {ldelim} id: {$user_auth.region}, text: '{$region}' {rdelim};
    {/if}
    {if isset($city)}
        city_data = {ldelim} id: {$user_auth.city}, text: '{$city}' {rdelim};
    {/if}
</script>
{/if}