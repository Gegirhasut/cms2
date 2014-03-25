{foreach from=$teachers item=teacher}
    <div class="tutor">
        <a href="/user/{$teacher.u_id}">{$teacher.fio}</a>
        <br/>
        <a href="/user/{$teacher.u_id}"><img src="/{$small_path}{$teacher.user_pic}" /></a>
        <br/>
        {$teacher.subject}
    </div>
{/foreach}