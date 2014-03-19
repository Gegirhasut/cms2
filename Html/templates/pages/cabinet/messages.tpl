<div style="padding: 0px 0px 0px 15px;">
    <a href="/cabinet/messages">Все диалоги</a>&nbsp;&nbsp;&nbsp;&nbsp;
    <br><br>

    {if empty($messages)}
        У Вас нет {$messages_type} диалогов!
    {else}
        <table class="table">
            {foreach from=$messages item=message}
                <tr class="message {if $message.readed eq 0}active{/if}" id="message_{$message.another_u}">
                    <td width="50"><img width="45" src="/{$small_path}{if empty($message.user_pic)}no-photo.png{else}{$message.user_pic}{/if}" /></td>
                    <td width="160" style="text-align: left;">{$message.fio}<br>{$message.posted_time}</td>
                    <td style="text-align: left;">{$message.subject}</td>
                    <td width="25" style="vertical-align: middle;">
                        {if $message.is_out eq 1}
                            <img alt="Исходящее сообщение" title="Исходящее сообщение" width="20" src="/images/app/mail_outgoing.png" />
                        {else}
                            <img alt="Входящее сообщение" title="Входящее сообщение" width="20" src="/images/app/mail_incoming.png" />
                        {/if}
                    </td>
                </tr>
            {/foreach}
        </table>
    {/if}
</div>