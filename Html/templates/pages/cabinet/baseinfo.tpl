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
            Если Вы не получили письмо, то сделайте <label class="control-label"><a href="/school/activation/resend">повторную активацию</a></label>.
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
    {if isset($school)}
        sr_id_data = {ldelim} id: {$form.value.sr_id}, text: '{$school}' {rdelim};
    {/if}
</script>
{/if}