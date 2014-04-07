<li {if $cabinet_page eq 'baseinfo'}class="active"{/if}  {if isset($activation)}class="disabled"{/if}>
    <a href="{if isset($activation)}javascript:;{else}/school{/if}">Общая информация</a>
</li>
<li {if $cabinet_page eq 'school_study'}class="active"{/if} {if isset($activation)}class="disabled"{/if}>
    <a href="{if isset($activation)}javascript:;{else}/school/study{/if}">Направления</a>
</li>
<li {if $cabinet_page eq 'school_addresses'}class="active"{/if} {if isset($activation)}class="disabled"{/if}>
    <a href="{if isset($activation)}javascript:;{else}/school/addresses{/if}">Адреса организации</a>
</li>