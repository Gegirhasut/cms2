<link rel="stylesheet" type="text/css" href="/Libs/Bootstrap-3.1.0/css/bootstrap3-wysiwyg5-color.css" />

<div class="row">
    <div class="col-md-12">
        <h1>{$h1}</h1>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-3">
        {include file="units/schools/search-schools.tpl"}
    </div>
    <div class="col-md-9">
        {if $schools|@count neq 0}
        <table class="table table-striped">
            <tr>
                <th colspan="2">Организация</th>
                {if isset($subject)}
                    <th style="text-align: center;">Направления</th>
                {/if}
                <th style="text-align: center;">Адреса</th>
            </tr>
            {foreach from=$schools item=school}
                <tr class="teacher">
                    <td width="50">
                        <a href="/organization/{$school.s_id}"><img class="img-thumbnail" width="50" src="/{$small_path}/{if empty($school.banner)}no-photo.png{else}{$school.banner}{/if}" /></a>
                    </td>
                    <td>
                        <a href="/organization/{$school.s_id}">{$school.school_name}</a>
                        <br>
                        <span class="short">{$school.info}</span>
                    </td>
                    {if isset($subject)}
                        <td style="text-align: center;width: 180px;">{$school.subjects}</td>
                    {/if}
                    <td style="text-align: center;width: 280px;">{$school.addresses}</td>
                </tr>
            {/foreach}
        </table>

        {include file="units/teachers/pager.tpl"}

        {else}
            <div style="text-align: center;">
                {if isset($location)}
                    {if isset($location.city)}
                        К сожалению, мы не нашли образовательных центров {if isset($subject)}по <b>{$subject.subject_po}</b> {/if}в городе <b>{$location.city}</b>, страна <b>{$location.country}</b>.
                        <br><br>
                        Сделать поиск по <b><a href="/schools{if isset($rubric)}/{$rubric.r_url}{else}/0{/if}{if isset($subject)}/{$subject.url}{else}/0{/if}/{$location.country_id}/{$location.region_id}" title="Все образовательные центры">всем образовательным центрам{if isset($subject)} по {$subject.subject_po}{/if} в {$location.region}, страна {$location.country}</a></b>?
                        <br><br>
                        Сделать поиск по <b><a href="/schools{if isset($rubric)}/{$rubric.r_url}{else}/0{/if}{if isset($subject)}/{$subject.url}{else}/0{/if}/{$location.country_id}" title="Все образовательные центры">всем образовательным центрам{if isset($subject)} по {$subject.subject_po}{/if} в страна {$location.country}</a></b>?
                        <br><br>
                        Сделать поиск по <b><a href="/schools{if isset($rubric)}/{$rubric.r_url}{else}/0{/if}{if isset($subject)}/{$subject.url}{else}/0{/if}" title="Все образовательные центры">всем образовательным центрам{if isset($subject)} по {$subject.subject_po}{/if} везде</a></b>?
                    {elseif isset($location.region)}
                        К сожалению, мы не нашли образовательных центров {if isset($subject)}по <b>{$subject.subject_po}</b> {/if}в <b>{$location.region}</b>, страна <b>{$location.country}</b>.
                        <br><br>
                        Сделать поиск по <b><a href="/schools{if isset($rubric)}/{$rubric.r_url}{else}/0{/if}{if isset($subject)}/{$subject.url}{else}/0{/if}/{$location.country_id}" title="Все образовательные центры">всем образовательным центрам{if isset($subject)} по {$subject.subject_po}{/if} в страна {$location.country}</a></b>?
                        <br><br>
                        Сделать поиск по <b><a href="/schools{if isset($rubric)}/{$rubric.r_url}{else}/0{/if}{if isset($subject)}/{$subject.url}{else}/0{/if}" title="Все образовательные центры">всем образовательным центрам{if isset($subject)} по {$subject.subject_po}{/if} везде</a></b>?
                    {elseif isset($location.country)}
                        К сожалению, мы не нашли образовательных центров {if isset($subject)}по <b>{$subject.subject_po}</b> {/if}в страна <b>{$location.country}</b>.
                        <br><br>
                        Сделать поиск по <b><a href="/schools{if isset($rubric)}/{$rubric.r_url}{else}/0{/if}{if isset($subject)}/{$subject.url}{else}/0{/if}" title="Все образовательные центры">всем образовательным центрам{if isset($subject)} по {$subject.subject_po}{/if} везде</a></b>?
                    {/if}
                {else}
                    <b>К сожалению, мы не нашли образовательных центров по Вашему запросу.</b>
                {/if}
            </div>
        {/if}
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>