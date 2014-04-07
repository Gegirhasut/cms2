<div class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="row">
            <div class="col-md-1">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Показать меню</span>
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
                            <li><a href="/teachers">Учителя</a></li>
                            <li><a href="/subjects">Предметы</a></li>
                            <li><a href="/schools">Образовательные центры</a></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="nav navbar-nav navbar-right">
                            {if isset($user_auth) && $user_auth.class eq 'User'}
                                <li><a href="/cabinet">Личный кабинет</a></li>
                                <li><a href="/auth/logout">Выход</a></li>
                            {elseif isset($user_auth) && $user_auth.class eq 'School'}
                                <li><a href="/school">Личный кабинет</a></li>
                                <li><a href="/school/logout">Выход</a></li>
                            {else}
                                <li><a href="/auth/login">Вход</a></li>
                                <li><a href="/auth/registration">Регистрация</a></li>
                            {/if}

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>