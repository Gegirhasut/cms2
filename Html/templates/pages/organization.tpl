<link rel="stylesheet" type="text/css" href="/Libs/Bootstrap-3.1.0/css/bootstrap3-wysiwyg5-color.css" />

<div class="row">
    <div class="col-md-12">
        <h1>{$h1}</h1>
    </div>
</div>
<hr>
<div class="row user_info">
    {if !empty($school.banner)}
        <div class="col-md-2">
            <img class="img-thumbnail" src="/{$small_path}{$school.banner}" />
        </div>
    {/if}
    <div class="col-md-{if !empty($school.banner)}5{else}6{/if}">
        <table>
        {if !empty($school.website)}
            <tr>
                <td><b>Вебсайт&nbsp;&nbsp;</b></td>
                <td><a href="{$school.website}" target="_blank">{$school.website}</a></td>
            </tr>
        {/if}
        {if !empty($school.email)}
            <tr>
                <td><b>Емайл&nbsp;&nbsp;</b></td>
                <td><a href="mailto:{$school.email}">{$school.email}</a></td>
            </tr>
        {/if}
        </table>
        <br>
        {if !empty($school.info)}
            <b>Информация об организации</b>
            <br><br>
            {$school.info}
        {/if}
    </div>
    <div class="col-md-{if !empty($school.banner)}5{else}6{/if}">
        <b>Направления</b>
        <br><br>
        {foreach from=$subjects item=subject}
            {$subject.subject}<br>
        {/foreach}
    </div>
</div>

<br>
<div class="row"><div class="col-md-12"><b>Адреса организации</b></div></div>
<br>

{include file='units/schools/addresses.tpl'}

<br>