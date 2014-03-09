<link href="/Libs/Bootstrap-3.1.0/css/select2.css" rel="stylesheet"/>
<script src="/Libs/Bootstrap-3.1.0/js/select2.js"></script>
<script src="/js/app/form.js"></script>

<div class="row">
    <div class="col-md-12">
        <h1>Восстановление пароля</h1>
    </div>
</div>

<br/>

<div class="row">
    <div class="col-md-12">
        <form class="form-horizontal" role="form" id="form" action="/auth/new_password">
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Новый пароль</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Введите новый пароль">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password2" class="col-sm-2 control-label">Пароль еще раз</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" name="password2" id="password2" placeholder="Введите пароль еще раз">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
        </form>

        <input type="hidden" id="error_not_empty" value="Поле не может быть пустым!" />
        <input type="hidden" id="error_password2" value="Пароли не совпадают!" />
        <input type="hidden" id="error_email" value="Не корректный email адрес!" />

        <div class="form-group">
            <div class="col-sm-2"></div>
            <div class="col-sm-10">
                <button type="submit" class="btn btn-default" id="form_btn">Сохранить новый пароль</button>
            </div>
        </div>

    </div>
    <div class="col-md-8"></div>
</div>