<link rel="stylesheet" type="text/css" href="/Libs/Bootstrap-3.1.0/css/bootstrap3-wysiwyg5-color.css" />

<div class="row">
    <div class="col-md-12">
        <h1>{$h1}</h1>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-3">
        {include file="units/teachers/search-teachers.tpl"}
    </div>
    <div class="col-md-9">
        {if $teachers|@count neq 0}
        <table class="table table-striped">
            <tr>
                <th colspan="2">Учитель</th>
                {if isset($subject)}
                    <th style="text-align: center;">Стоимость обучения</th>
                {/if}
                <th style="text-align: center;">Город</th>
                <th style="text-align: center;">Skype</th>
            </tr>
            {foreach from=$teachers item=teacher}
                <tr class="teacher">
                    <td width="50">
                        <a href="/user/{$teacher.u_id}"><img class="img-thumbnail" width="50" src="/{$small_path}/{if empty($teacher.user_pic)}no-photo.png{else}{$teacher.user_pic}{/if}" /></a>
                    </td>
                    <td>
                        <a href="/user/{$teacher.u_id}">{$teacher.fio}</a>
                        <br>
                        <span class="short">{$teacher.info}</span>
                    </td>
                    {if isset($subject)}
                        <td style="text-align: center;">{$teacher.cost} руб. / {$teacher.duration} мин.</td>
                    {/if}
                    <td style="text-align: center;">{$teacher.city_name}</td>
                    <td style="text-align: center;">{if $teacher.skype eq ''}Нет{else}Есть{/if}</td>
                </tr>
            {/foreach}
        </table>

        {include file="units/teachers/pager.tpl"}

        {else}
            <div style="text-align: center;">
                {if isset($location)}
                    {if isset($location.city)}
                        К сожалению, мы не нашли учителей {if isset($subject)}по <b>{$subject.subject_po}</b> {/if}в городе <b>{$location.city}</b>, страна <b>{$location.country}</b>.
                        <br><br>
                        Сделать поиск по <b><a href="/teachers{if isset($subject)}/{$subject_url}{/if}/{$location.country_id}/{$location.region_id}" title="Все учителя">всем учителям{if isset($subject)} по {$subject.subject_po}{/if} в {$location.region}, страна {$location.country}</a></b>?
                        <br><br>
                        Сделать поиск по <b><a href="/teachers{if isset($subject)}/{$subject_url}{/if}/{$location.country_id}" title="Все учителя">всем учителям{if isset($subject)} по {$subject.subject_po}{/if} в страна {$location.country}</a></b>?
                        <br><br>
                        Сделать поиск по <b><a href="/teachers{if isset($subject)}/{$subject_url}{/if}" title="Все учителя">всем учителям{if isset($subject)} по {$subject.subject_po}{/if} везде</a></b>?
                    {elseif isset($location.region)}
                        К сожалению, мы не нашли учителей {if isset($subject)}по <b>{$subject.subject_po}</b> {/if}в <b>{$location.region}</b>, страна <b>{$location.country}</b>.
                        <br><br>
                        Сделать поиск по <b><a href="/teachers{if isset($subject)}/{$subject_url}{/if}/{$location.country_id}" title="Все учителя">всем учителям{if isset($subject)} по {$subject.subject_po}{/if} в страна {$location.country}</a></b>?
                        <br><br>
                        Сделать поиск по <b><a href="/teachers{if isset($subject)}/{$subject_url}{/if}" title="Все учителя">всем учителям{if isset($subject)} по {$subject.subject_po}{/if} везде</a></b>?
                    {elseif isset($location.country)}
                        К сожалению, мы не нашли учителей {if isset($subject)}по <b>{$subject.subject_po}</b> {/if}в страна <b>{$location.country}</b>.
                        <br><br>
                        Сделать поиск по <b><a href="/teachers{if isset($subject)}/{$subject_url}{/if}" title="Все учителя">всем учителям{if isset($subject)} по {$subject.subject_po}{/if} везде</a></b>?
                    {/if}

                    {if isset($from) || isset($to)}
                        <br><br>
                        Заданный диапозон цен:<b>{if isset($from)} от {$from}{/if}{if isset($to)} до {$to}{/if} рублей</b>
                    {/if}
                {else}
                    <b>К сожалению, мы не нашли учителей по Вашему запросу.</b>
                    {if isset($from) || isset($to)}
                        <br><br>
                        Заданный диапозон цен:<b>{if isset($from)} от {$from}{/if}{if isset($to)} до {$to}{/if} рублей</b>
                    {/if}
                {/if}
            </div>
        {/if}
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>