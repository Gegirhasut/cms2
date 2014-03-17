<div style="padding: 0px 0px 0px 15px;">
    {if empty($messages)}
        У Вас нет входящих сообщений!
    {else}
        <a href="/cabinet/messages">Все сообщения</a>
        <br><br>
        <table class="table">
            {foreach from=$messages item=message}
                <tr class="message {if $message.readed eq 0}active{/if}" id="message_{$message.u_id_from}">
                    <td width="50"><img width="45" src="/{$small_path}/{if empty($message.user_pic)}no-photo.png{else}{$message.user_pic}{/if}" /></td>
                    <td width="160" style="text-align: left;">{$message.fio}<br>{$message.posted_time}</td>
                    <td style="text-align: left;">{$message.subject}</td>
                </tr>
            {/foreach}
        </table>
    {/if}
</div>