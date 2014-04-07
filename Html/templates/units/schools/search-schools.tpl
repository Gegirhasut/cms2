<link href="/Libs/Bootstrap-3.1.0/css/select2.css" rel="stylesheet"/>
<script src="/Libs/Bootstrap-3.1.0/js/select2.js"></script>
<script type="text/javascript" src="/js/app/schools-search.js"></script>
<script type="text/javascript" src="/js/app/bootstrap-form.js"></script>

<form class="form-horizontal" role="form" id="form" action="/search/schools">
    <div class="form-group">
        <b>Предмет обучения</b>
    </div>

    <div class="form-group" id="key_r_id">
        <input type="hidden" name="r_id" id="r_id" style="width:100%" value="{$rubric.sr_id}" placeholder="Выберите тип школы">
    </div>

    <div class="form-group" id="key_s_id">
        <input type="hidden" name="s_id" id="s_id" style="width:100%" value="{$subject.ss_id}" placeholder="Выберите направление">
    </div>

    <div class="form-group">
        <b>Местоположение</b>
    </div>

    <div class="form-group" id="key_country">
        <input type="hidden" name="country" id="country" style="width:100%" value="{$location.country_id}" placeholder="Выберите страну">
    </div>

    <div class="form-group" id="key_region">
        <input type="hidden" name="region" id="region" style="width:100%" value="{$location.region_id}" placeholder="Выберите регион">
    </div>

    <div class="form-group" id="key_city">
        <input type="hidden" name="city" id="city" style="width:100%" value="{$location.city_id}" placeholder="Выберите город">
    </div>

</form>

<div class="form-group">
    <button type="submit" style="width:100%;" class="btn btn-info" id="form_btn">Найти</button>
</div>

<div class="form-group" style="text-align: center;">
    <a href="/school/registration">Добавить организацию</a>
</div>

<script>
{if isset($rubric)}
    r_id_data = {ldelim} id: {$rubric.sr_id}, text: '{$rubric.title}' {rdelim};
{/if}
{if isset($subject)}
    s_id_data = {ldelim} id: {$subject.ss_id}, text: '{$subject.subject}' {rdelim};
{/if}

{if isset($location.country_id)}
    country_data = {ldelim} id: {$location.country_id}, text: '{$location.country}' {rdelim};
{/if}
{if isset($location.region_id)}
    region_data = {ldelim} id: {$location.region_id}, text: '{$location.region}' {rdelim};
{/if}
{if isset($location.city_id)}
    city_data = {ldelim} id: {$location.city_id}, text: '{$location.city}' {rdelim};
{/if}
</script>