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
            Если Вы не получили письмо, то сделайте <label class="control-label"><a href="/auth/activation/resend">повторную активацию</a></label>.
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

{include file="units/form.tpl"}

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