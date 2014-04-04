<li {if $cabinet_page eq 'personal'}class="active"{/if}  {if isset($activation)}class="disabled"{/if}>
    <a href="{if isset($activation)}javascript:;{else}/cabinet{/if}">Персональные данные</a>
</li>
<li {if $cabinet_page eq 'contacts'}class="active"{/if} {if isset($activation)}class="disabled"{/if}>
    <a href="{if isset($activation)}javascript:;{else}/cabinet/contacts{/if}">Дополнительная информация</a>
</li>
{if $user_auth.i_am_teacher eq 1}
    <li {if $cabinet_page eq 'study'}class="active"{/if} {if isset($activation)}class="disabled"{/if}>
        <a href="{if isset($activation)}javascript:;{else}/cabinet/study{/if}">Обучение</a>
    </li>
{/if}
<li {if $cabinet_page eq 'messages' || $cabinet_page eq 'messages_with'}class="active"{/if} {if isset($activation)}class="disabled"{/if}>
    <a href="{if isset($activation)}javascript:;{else}/cabinet/messages{/if}">Сообщения{if $messages_cnt neq 0} <span class="badge">{$messages_cnt}</span>{/if}</a>
</li>