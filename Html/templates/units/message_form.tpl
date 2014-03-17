<script src="/js/app/bootstrap-form.js"></script>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" id="modal_message" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Отправить сообщение</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal" role="form" id="form" action="/user/{$user.u_id}">
                    <div class="form-group" id="key_message">
                        <label for="cost" class="col-sm-2 control-label">Сообщение</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="message" name="message" placeholder="Введите сообщение" rows="15"></textarea>
                        </div>
                    </div>
                </form>

                <div class="form-group">
                    <div class="col-sm-offset-2">
                        <button type="submit" class="btn btn-default" id="form_btn">Отправить</button>
                    </div>
                </div>

            </div>
            <div style="clear: both"></div>
        </div>
    </div>
</div>