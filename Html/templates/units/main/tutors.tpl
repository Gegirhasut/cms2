{foreach from=$teachers item=teacher}
    <div class="tutor">
        <a href="/user/{$teacher.u_id}">{$teacher.fio}</a>
        <br/>
        <a href="/user/{$teacher.u_id}"><img src="/{$small_path}{if empty($teacher.user_pic)}/no-photo.png{else}{$teacher.user_pic}{/if}" /></a>
        <br/>
        {$teacher.subject}
    </div>
{/foreach}