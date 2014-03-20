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
                <th style="text-align: center;">Стоимость обучения</th>
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
                    <td style="text-align: center;">{$teacher.cost} руб. / {$teacher.duration} мин.</td>
                    <td style="text-align: center;">{$teacher.city_name}</td>
                    <td style="text-align: center;">{if $teacher.skype neq ''}Нет{else}Есть{/if}</td>
                </tr>
            {/foreach}
        </table>

        {include file="units/teachers/pager.tpl"}

        {else}
            <div style="text-align: center;"><b>По Вашему запросу ничего не найдено</b></div>
        {/if}
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>