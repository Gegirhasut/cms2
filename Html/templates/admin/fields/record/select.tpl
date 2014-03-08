{if isset($field.values)}
    <select name="{$key}">
        {foreach from=$field.values item=v_id key=k_id}
            <option value="{$k_id}" {if $k_id eq $values[$key]}selected="selected"{/if}>{$v_id}</option>
        {/foreach}
    </select>
{else}
    <input type="text" id="filter_{$field.relation.on}" onkeyup="fill_select('{$field.relation.on}', '{$field.relation.show}', '{$field.relation.join}')" value="{$select_values[$key]}" autocomplete="off"/>
    <input type="hidden" name="{$key}" id="{$key}" value="{$values[$key]}" />
{/if}