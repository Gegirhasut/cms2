<div class="row">
    <div class="col-md-12">
        <h1>Предметы для обучения</h1>
    </div>
</div>
<br>
<div class="row">
    <div class="col-md-12">
        {foreach from=$rubrics item=rubric}
            <div class="row" style="padding-bottom: 10px;">
                <div class="col-md-12">
                    <h2 class="label label-danger rubric">
                        {$rubric.title}
                    </h2>
                </div>
            </div>

            <div style="padding-left: 20px;padding-bottom: 20px;">
                {foreach from=$rubric.subjects item=subject}
                    <div style="float: left;padding-right: 20px;"><a href="/teachers/{$subject.url}" title="Найти учителя по {$subject.subject_po}">{$subject.subject}</a></div>
                {/foreach}
                <div style="clear: both;"></div>
            </div>
        {/foreach}
    </div>
</div>

<div class="row"><div class="col-md-12">&nbsp;</div></div>