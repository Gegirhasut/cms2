<link href="/Libs/Bootstrap-3.1.0/css/select2.css" rel="stylesheet"/>
<script src="/Libs/Bootstrap-3.1.0/js/select2.js"></script>
<script src="/js/app/form.js"></script>

<div class="row">
    <div class="col-md-12">
        <h1>Регистрация</h1>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        <form role="form" class="form-horizontal" method="post" id="form_reg" action="/registration">
            <div class="form-group">
                <label for="fio" class="col-sm-2 control-label">ФИО</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="fio" id="fio" placeholder="Введите Ваше ФИО">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-4">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Введите email">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-2 control-label">Пароль</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Введите пароль">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="password2" class="col-sm-2 control-label">Пароль еще раз</label>
                <div class="col-sm-4">
                    <input type="password" class="form-control" name="password2" id="password2" placeholder="Введите пароль еще раз">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="country" class="col-sm-2 control-label">Страна</label>
                <div class="col-sm-4">
                    <input type="hidden" name="country" id="country" style="width:100%">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="region" class="col-sm-2 control-label">Регион</label>
                <div class="col-sm-4">
                    <input type="hidden" name="region" id="region" style="width:100%">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="city" class="col-sm-2 control-label">Город</label>
                <div class="col-sm-4">
                    <input type="hidden" name="city" id="city" style="width:100%">
                </div>
                <div class="col-sm-6 error">
                    <span class="help-block control-label"></span>
                </div>
            </div>
        </form>

        <input type="hidden" id="error_unique" value="Пользователь с таким email уже существует!" />
        <input type="hidden" id="error_not_empty" value="Поле не может быть пустым!" />
        <input type="hidden" id="error_password2" value="Пароли не совпадают!" />
        <input type="hidden" id="error_email" value="Не корректный email адрес!" />

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-8">
                <button type="submit" class="btn btn-default" id="register_btn">Зарегистрироваться</button>
            </div>
        </div>

    </div>
</div>