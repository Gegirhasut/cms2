<link href="/Libs/Bootstrap-3.1.0/css/select2.css" rel="stylesheet"/>
<script src="/Libs/Bootstrap-3.1.0/js/select2.js"></script>
<script src="/js/app/bootstrap-form.js"></script>

<div class="row">
    <div class="col-md-12">
        <h1>{$h1}</h1>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-tabs">
            <li {if $cabinet_page eq 'personal'}class="active"{/if}  {if isset($activation)}class="disabled"{/if}>
                <a href="{if isset($activation)}javascript:;{else}/cabinet{/if}">Персональные данные</a>
            </li>
            <li {if $cabinet_page eq 'contacts'}class="active"{/if} {if isset($activation)}class="disabled"{/if}>
                <a href="{if isset($activation)}javascript:;{else}/cabinet/contacts{/if}">Дополнительная информация о Вас</a>
            </li>
            <li {if $cabinet_page eq 'study'}class="active"{/if} {if isset($activation)}class="disabled"{/if}>
                <a href="{if isset($activation)}javascript:;{else}/cabinet/study{/if}">Обучение</a>
            </li>
            <li {if $cabinet_page eq 'messages' || $cabinet_page eq 'messages_with'}class="active"{/if} {if isset($activation)}class="disabled"{/if}>
                <a href="{if isset($activation)}javascript:;{else}/cabinet/messages{/if}">Сообщения{if $messages_cnt neq 0} <span class="badge">{$messages_cnt}</span>{/if}</a>
            </li>
        </ul>
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

{include file="pages/cabinet/$cabinet_page.tpl"}