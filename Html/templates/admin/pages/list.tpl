<a href="javascript:open_window('/admin/record/{$class}/',1000,800);">Добавить</a>
<br>
<table border="1" cellspacing="0" cellpadding="53" bordercolor="#C3BD7C" bordercolordark="#FFFFE2" width="100%">
    <tr>
        <th style="text-align: center;">Операции</th>
        {foreach from=$object->fields item=field key=name}
            {if !isset($field.nolist)}
                <th style="text-align: center;">
                    {$field.title}
                    {if !isset($field.relation)}
                        <br>
                        <a href="?order={$name}">&nbsp;↑&nbsp;</a>
                        <a href="?order={$name}&direction=desc">&nbsp;↓&nbsp;</a>
                    {/if}
                </th>
            {/if}
        {/foreach}
    </tr>

    {foreach from=$data item=values}
        <tr id="tr_object_{$values[$identity]}">
            <td style="text-align: center;">
                <a title="Редактировать" href="javascript:open_window('/admin/record/{$class}/{$values[$identity]}',1000,800);"><img src="/images/admin/edit.png" width="16"></a>
                <a title="Удалить" href="javascript:;" onclick="delete_object('{$class}', '{$values[$identity]}');"><img src="/images/admin/deletered.png" width="16"></a>
            </td>
            {foreach from=$object->fields item=field key=key}
                {if !isset($field.nolist)}
                    <td style="text-align: center;">
                        {assign var="file_name" value=$field.type}
                        {assign var="file_name_full" value=Html/templates/admin/fields/list/$file_name.tpl}
                        {assign var="file_name_tpl" value=admin/fields/list/$file_name.tpl}
                        {if file_exists($file_name_full)}
                            {include file=$file_name_tpl}
                        {else}
                            {$values[$key]}
                        {/if}
                    </td>
                {/if}
            {/foreach}
        </tr>
    {/foreach}
</table>

{include file="admin/units/pager.tpl"}