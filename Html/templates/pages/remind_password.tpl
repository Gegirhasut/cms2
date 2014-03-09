<link href="/Libs/Bootstrap-3.1.0/css/select2.css" rel="stylesheet"/>
<script src="/Libs/Bootstrap-3.1.0/js/select2.js"></script>
<script src="/js/app/form.js"></script>

<div class="row">
    <div class="col-md-12">
        <h1>Восстановление пароля</h1>
    </div>
</div>

<div class="form-group has-error">
    <div class="row">
        <div class="col-md-12">
            <label class="control-label">Введите Ваш email. На него будет выслана ссылка для восстановления пароля!</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" role="form" id="form" action="/remind_password">
            <div class="form-group">
                <label for="email" class="col-sm-1 control-label">Email</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
        </form>

        <input type="hidden" id="error_email" value="Не корректный email адрес!" />
        <input type="hidden" id="error_not_empty" value="Поле не может быть пустым!" />
        <input type="hidden" id="error_not_found" value="Указанный Вами email не найден!" />

        <div class="form-group">
            <div class="col-sm-1"></div>
            <div class="col-sm-11">
                <button type="submit" class="btn btn-default" id="form_btn">Восстановить</button>
            </div>
        </div>

    </div>
    <div class="col-md-8"></div>
</div>

{include file="units/notify_message.tpl"}