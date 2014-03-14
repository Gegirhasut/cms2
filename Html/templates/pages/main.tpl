<div class="row">
    <div class="col-md-3">
        <div style="text-align: center">
            <h1>Все учителя</h1>
            <h2>онлайн ассоциация</h2>
        </div>
        <ol class="list-unstyled menu-left">
            <li><a href="/subjects/">Предметы</a></li>
            <li><a href="/">БИЗНЕС ТРЕНИНГИ</a></li>
            <li><a href="/">ЛИЧНОСТНЫЙ РОСТ</a></li>
            <li><a href="/">ВЕБИНАРЫ</a></li>
        </ol>
    </div>
    <div class="col-md-9">
        {include file="units/main/banner2.tpl"}
    </div>
</div>
<div style="text-align: center;">
    <h2>
        Наши учителя
    </h2>
</div>
<div class="block">
    <div class="viewport">
        <div class="kv">
            <div class="tutor">
                Максим
                <br/>
                <img src="/images/userpics/1-maksim.jpg" />
                <br/>
                Программирование
            </div>
            <div class="tutor">
                Максим
                <br/>
                <img src="/images/userpics/1-maksim.jpg" />
                <br/>
                Программирование
            </div>
            <div class="tutor">
                Максим
                <br/>
                <img src="/images/userpics/1-maksim.jpg" />
                <br/>
                Программирование
            </div>
            <div class="tutor">
                Максим
                <br/>
                <img src="/images/userpics/1-maksim.jpg" />
                <br/>
                Программирование
            </div>
            <div class="tutor">
                Максим
                <br/>
                <img src="/images/userpics/1-maksim.jpg" />
                <br/>
                Программирование
            </div>
            <div class="tutor">
                Максим
                <br/>
                <img src="/images/userpics/1-maksim.jpg" />
                <br/>
                Программирование
            </div>
            <div class="tutor">
                Максим
                <br/>
                <img src="/images/userpics/1-maksim.jpg" />
                <br/>
                Программирование
            </div>
        </div>
    </div>
</div>
<div style="text-align: center;">
    <h2>
        Поиск учителя
    </h2>
</div>
<div>
    <div class="row search">
        {foreach from=$rubrics item=rubric}
            <div class="col-md-3">
                <span class="title">{$rubric.title}</span>
                <ul>
                    {foreach from=$rubric.subjects item=subject}
                        <li><a href="/teachers/{$subject.url}/" title="{$subject.subject}">{$subject.subject}</a></li>
                    {/foreach}
                </ul>
            </div>
        {/foreach}
    </div>
    <div class="row search">
        <div class="col-md-12">
            <span class="title"><a href="/teachers/">Расширенный поиск</a></span>
        </div>
    </div>
    <div class="row search" style="padding-top: 20px;">
        <div class="col-md-4">
            <button type="button" class="btn btn-info">С нами 3000 учителей</button>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-info">У нас 1000 учеников</button>
        </div>
        <div class="col-md-4">
            <button type="button" class="btn btn-info">У нас 500 предметов</button>
        </div>
    </div>
</div>