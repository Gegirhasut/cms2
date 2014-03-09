<div class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-1">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="/">Главная</a>
                </div>
            </div>
            <div class="col-md-11">
                <div class="collapse navbar-collapse">
                    <div class="col-md-8">
                        <ul class="nav navbar-nav">
                            <li><a href="/">Учителя</a></li>
                            <li><a href="/">Предметы</a></li>
                            <li><a href="/">Образовательные центры</a></li>
                        </ul>
                    </div>
                    {if !isset($user_auth)}
                        <div class="col-md-4">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="/login">Вход</a></li>
                                <li><a href="/registration">Регистрация</a></li>
                            </ul>
                        </div>
                    {else}
                        <div class="col-md-4">
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="/cabinet">Личный кабинет</a></li>
                                <li><a href="/logout">Выход</a></li>
                            </ul>
                        </div>
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>