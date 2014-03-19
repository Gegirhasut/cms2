<script src="/Libs/bootstrap-3.1.0/js/bootstrap-maxlength.min.js"></script>

<div style="padding: 0px 0px 0px 15px;">
    <a href="/cabinet/messages">Все диалоги</a>
    <br>
    <br>
    <div id="scroll" style="max-height: 350px;overflow-y:scroll;border-top:1px solid #ddd;">
        <table class="table" style="margin-bottom: 0px;">
            {include file="pages/cabinet/messages_with_ajax.tpl"}
        </table>
    </div>
    <table class="table">
        <form class="form-horizontal" role="form" id="form" action="/cabinet/messages/{$user_from.u_id}">
            <tr style="margin-top: 10px;">
                <td width="50"><img width="45" src="/{$small_path}/{if empty($user_auth.user_pic)}no-photo.png{else}{$user_auth.user_pic}{/if}" /></td>
                <td><textarea maxlength="5000" class="form-control" id="message" name="message" placeholder="Введите сообщение" rows="5"></textarea></td>
                <td width="50"><img width="45" src="/{$small_path}/{if empty($user_from.user_pic)}no-photo.png{else}{$user_from.user_pic}{/if}" /></td>
            </tr>
        </form>
        <tr><td class="no"></td><td class="no"><button type="submit" class="btn btn-info" id="form_btn">Отправить</button></td></tr>
    </table>
</div>

<script>
    {literal}
    $('#message').maxlength({
        alwaysShow: true
    });
    {/literal}
</script>