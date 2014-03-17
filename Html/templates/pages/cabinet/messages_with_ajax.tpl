{foreach from=$messages item=message}
    <tr {if $message.readed eq 0}class="active"{/if} id="m_id_{$message.m_id}">
        <td width="50"><a href="/user/{$message.u_id_from}"><img width="45" src="/{$small_path}/{if empty($message.user_pic)}no-photo.png{else}{$message.user_pic}{/if}" /></a></td>
        <td>
            {if $message.u_id_to neq $user_auth.u_id}
                <b>Вы</b>
            {else}
                <a href="/user/{$message.u_id_from}">{$message.fio}</a>
            {/if}
            <br>
            {$message.message}
        </td>
        <td width="160" style="text-align: left;">{$message.posted_time}</td>
    </tr>
{/foreach}
