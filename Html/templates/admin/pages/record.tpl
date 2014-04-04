<form action="" method="post">
    <table border="1" cellspacing="0" cellpadding="53" bordercolor="#C3BD7C" bordercolordark="#FFFFE2" width="100%">
        {foreach from=$object->fields item=field key=key}
            {if !isset($field.nondb)}
                {if $key eq $object->identity and $add_new}
                {else}
                    <tr>
                        <td style="text-align: center;">
                            {if $key eq $object->identity}
                                Идентификатор
                            {else}
                                {$field.title}
                            {/if}
                        </td>
                        <td style="width:*;">
                            {if $key eq $object->identity}
                                <input type="hidden" name="{$key}" value="{$values[$key]}" />
                                {$values[$key]}
                            {else}
                                {assign var="file_name" value=$field.type}
                                {assign var="file_name_full" value=Html/templates/admin/fields/record/$file_name.tpl}
                                {assign var="file_name_tpl" value=admin/fields/record/$file_name.tpl}
                                {if file_exists($file_name_full)}
                                    {include file=$file_name_tpl}
                                {else}
                                    <input type="text" style="width:400px" id="{$key}" name="{$key}" value="{$values[$key]}" {if isset($field.events)}{foreach from=$field.events item=event key=action}{$action}="{$event}"{/foreach}{/if} />
                                {/if}
                            {/if}
                        </td>
                    </tr>
                {/if}
            {/if}
        {/foreach}
    </table>
    <input type="submit" value="Сохранить" />
</form>