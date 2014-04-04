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
            {if isset($menu)}
                {include file="units/menus/$menu.tpl"}
            {else}
                {include file="units/menus/cabinet.tpl"}
            {/if}
        </ul>
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>

{include file="pages/cabinet/$cabinet_page.tpl"}