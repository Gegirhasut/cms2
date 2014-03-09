{if isset($cabinet_message) && !empty($cabinet_message)}
    <br>
    <div class="row" id="cabinet_message">
        <div class="form-group has-error">
            {foreach from=$cabinet_message item=message}
                <div class="col-sm-offset-1 col-sm-8">
                    <label class="control-label">{$message}</label>
                </div>
            {/foreach}
        </div>
    </div>
{/if}