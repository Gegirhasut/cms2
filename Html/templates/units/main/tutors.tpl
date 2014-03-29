{foreach from=$teachers item=teacher}
    <div class="tutor">
        <div class="tutor_name">
            <a href="/user/{$teacher.u_id}">{$teacher.fio}</a>
        </div>
        <a href="/user/{$teacher.u_id}"><img src="/{$small_path}{if empty($teacher.user_pic)}/no-photo.png{else}{$teacher.user_pic}{/if}" /></a>
        <br/>
        {$teacher.subject}
    </div>
{/foreach}