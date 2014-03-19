<link href="/Libs/Bootstrap-3.1.0/css/select2.css" rel="stylesheet"/>
<script src="/Libs/Bootstrap-3.1.0/js/select2.js"></script>
<script type="text/javascript" src="/js/app/personal-study.js"></script>
<script type="text/javascript" src="/js/app/location.js"></script>
<script type="text/javascript" src="/js/app/bootstrap-form.js"></script>

<form class="form-horizontal" role="form" id="form" action="/search">
    <div class="form-group">
        <b>Предмет обучения</b>
    </div>

    <div class="form-group" id="key_r_id">
        <input type="hidden" name="r_id" id="r_id" style="width:100%" value="{$subject.r_id}" placeholder="Выберите рубрику">
    </div>

    <div class="form-group" id="key_s_id">
        <input type="hidden" name="s_id" id="s_id" style="width:100%" value="{$subject.s_id}" placeholder="Выберите предмет">
    </div>

    <div class="form-group">
        <b>Место жительства</b>
    </div>

    <div class="form-group" id="key_country">
        <input type="hidden" name="country" id="country" style="width:100%" value="{$city.country_id}" placeholder="Выберите страну">
    </div>

    <div class="form-group" id="key_region">
        <input type="hidden" name="region" id="region" style="width:100%" value="{$city.region_id}" placeholder="Выберите регион">
    </div>

    <div class="form-group" id="key_city">
        <input type="hidden" name="city" id="city" style="width:100%" value="{$city.city_id}" placeholder="Выберите город">
    </div>

    <div class="form-group">
        <b>Стоимость обучения (в рублях)</b>
    </div>

    <div class="form-group" id="key_range">
        <div class="row">
            <div class="col-md-6">
                <input type="text" class="form-control" id="from" name="from" value="{$from}" placeholder="От">
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control" id="to" name="to" value="{$to}" placeholder="До">
            </div>
        </div>
    </div>
</form>

<div class="form-group">
    <button type="submit" style="width:100%;" class="btn btn-info" id="form_btn">Найти</button>
</div>

<script>
{if isset($subject)}
    r_id_data = {ldelim} id: {$subject.r_id}, text: '{$subject.title}' {rdelim};
    s_id_data = {ldelim} id: {$subject.s_id}, text: '{$subject.subject}' {rdelim};
{/if}

{if isset($city)}
    country_data = {ldelim} id: {$city.country_id}, text: '{$city.country}' {rdelim};
    region_data = {ldelim} id: {$city.region_id}, text: '{$city.region}' {rdelim};
    city_data = {ldelim} id: {$city.city_id}, text: '{$city.city}' {rdelim};
{/if}
</script>