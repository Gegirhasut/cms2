<div class="row">
    <div class="col-md-3">
        <div style="text-align: center">
            <div class="row">
                <div class="col-md-12 col-sm-6 col-xs-6">
                    <h1>Все учителя</h1>
                </div>
                <div class="col-md-12 col-sm-6 col-xs-6">
                    <h2>онлайн ассоциация</h2>
                </div>
            </div>
        </div>
        <div class="row menu">
            <div class="col-md-12 col-sm-3">
                <a href="/subjects">Предметы</a>
            </div>
            <div class="col-md-12 col-sm-3">
                <a href="/">БИЗНЕС ТРЕНИНГИ</a>
            </div>
            <div class="col-md-12 col-sm-3">
                <a href="/">ЛИЧНОСТНЫЙ РОСТ</a>
            </div>
            <div class="col-md-12 col-sm-3">
                <a href="/">ВЕБИНАРЫ</a>
            </div>
        </div>
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
                David Kessel
                <br/>
                <img src="/images/userpics/big/p/k/4a83492f47e39a29f77f4e08729c751d.jpg" />
                <br/>
                английский язык
            </div>
            <div class="tutor">
                David Kessel
                <br/>
                <img src="/images/userpics/big/p/k/4a83492f47e39a29f77f4e08729c751d.jpg" />
                <br/>
                английский язык
            </div>
            <div class="tutor">
                David Kessel
                <br/>
                <img src="/images/userpics/big/p/k/4a83492f47e39a29f77f4e08729c751d.jpg" />
                <br/>
                английский язык
            </div>
            <div class="tutor">
                David Kessel
                <br/>
                <img src="/images/userpics/big/p/k/4a83492f47e39a29f77f4e08729c751d.jpg" />
                <br/>
                английский язык
            </div>
            <div class="tutor">
                David Kessel
                <br/>
                <img src="/images/userpics/big/p/k/4a83492f47e39a29f77f4e08729c751d.jpg" />
                <br/>
                английский язык
            </div>
            <div class="tutor">
                David Kessel
                <br/>
                <img src="/images/userpics/big/p/k/4a83492f47e39a29f77f4e08729c751d.jpg" />
                <br/>
                английский язык
            </div>
            <div class="tutor">
                David Kessel
                <br/>
                <img src="/images/userpics/big/p/k/4a83492f47e39a29f77f4e08729c751d.jpg" />
                <br/>
                английский язык
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