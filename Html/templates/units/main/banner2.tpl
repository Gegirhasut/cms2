<div class="row">
    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="item active">
                <img src="/images/app/service-panel-tutors.jpg" style="height:290px">
                <div class="carousel-caption">
                    <div style="height: auto;">
                        <div class="promo_text">- Оставьте информацию о себе на нашем сайте</div>
                        <div class="promo_text">- Позвольте ученикам быстро найти вас</div>
                        <div class="promo_text">- Укажите предмет обучения и сами определите стоимость</div>
                        <div style="position: absolute;bottom: 0px;right: 140px;"><a href="/auth/registration"><button type="button" class="btn btn-danger">Зарегистрироваться</button></a></div>
                    </div>
                </div>
            </div>
            <div class="item">
                <img src="/images/app/service-panel-students.jpg" style="height:290px">
                <div class="carousel-caption">
                    <div style="height: auto;">
                        <div class="promo_text">- Найдите учителя недалеко от дома</div>
                        <div class="promo_text">- Свяжитесь с учителем и договоритесь об обучении</div>
                        <div class="promo_text">- Оставьте отзыв об учителе</div>
                        <div style="position: absolute;bottom: 0px;right: 150px;"><a href="/auth/registration"><button type="button" class="btn btn-danger">Зарегистрироваться</button></a></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
</div>
<script>
    $('.carousel').carousel({ldelim}
        interval: 10000
    {rdelim});
</script>