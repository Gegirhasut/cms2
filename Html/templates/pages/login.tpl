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
    <div class="col-md-4">
        <form class="form-horizontal" role="form" id="login_reg" action="/login">
            <div class="form-group">
                <label for="email" class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-3 control-label">Пароль</label>
                <div class="col-sm-9">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
                </div>
            </div>

        </form>

        <div class="form-group">
            <div class="col-sm-3"></div>
            <div class="col-sm-9">
                <button type="submit" class="btn btn-default" id="login_btn">Войти</button>
            </div>
        </div>

    </div>
    <div class="col-md-8"></div>
</div>

<div class="row" id="login_error" style="display: none;">
    <div class="col-sm-offset-1 col-sm-11">
        <div class="form-group has-error">
            <label class="control-label" for="inputError2">
                <br>
                Пара email и пароль не найдена!
            </label>
        </div>
    </div>
</div>