<script src="/js/app/personal-study.js"></script>

<div class="row">
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                Укажите предметы, которым Вы можете обучать
                <br><br>
            </div>
        </div>

        {include file="units/form.tpl"}

        {include file="units/notify_message.tpl"}

    </div>
    <div class="col-md-6">
        {foreach from=$subjects item=subject}
            <div>{$subject.subject} - {$subject.cost} руб. / {$subject.duration} мин.</div>
        {/foreach}
    </div>
</div>


