<link href="/Libs/Bootstrap-3.1.0/css/select2.css" rel="stylesheet"/>
<script src="/Libs/Bootstrap-3.1.0/js/select2.js"></script>
<script src="/js/app/form.js"></script>

<div class="row">
    <div class="col-md-12">
        <h1>Вход на сайт</h1>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" role="form" id="form" action="/login">
            <div class="form-group">
                <label for="email" class="col-sm-1 control-label">Email</label>
                <div class="col-sm-3">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
                <div class="col-sm-8 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-1 control-label">Пароль</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
                </div>
                <div class="col-sm-8 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>

        </form>

        <input type="hidden" id="error_not_empty" value="Поле не может быть пустым!" />
        <input type="hidden" id="error_email" value="Не корректный email адрес!" />

        <div class="form-group">
            <div class="col-sm-1"></div>
            <div class="col-sm-11">
                <button type="submit" class="btn btn-default" id="form_btn">Войти</button>
            </div>
        </div>

    </div>
    <div class="col-md-8"></div>
</div>

<div class="row" id="error_login" style="display: none;">
    <div class="col-sm-offset-1 col-sm-11">
        <div class="form-group">
            <label class="control-label">
                <br>
                Пара email и пароль не найдена!
            </label>
        </div>
    </div>
</div>

{include file="units/notify_message.tpl"}

<div class="row">
    <div class="col-sm-offset-1 col-sm-11">
        <div class="form-group">
            <label class="control-label">
                <br>
                <a href="/remind_password">Восстановить пароль</a>
            </label>
        </div>
    </div>
</div>

