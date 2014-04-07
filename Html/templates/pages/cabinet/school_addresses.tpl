<script src="/js/app/location-search.js"></script>

<div class="row">
    <div class="col-md-4">
        <div class="row">
            <div class="col-md-10 col-md-offset-3">
                <p>Добавьте адрес Вашей оргаизации</p>
            </div>
        </div>

        {include file="units/form.tpl"}

        {include file="units/notify_message.tpl"}

    </div>
    <div class="col-md-8">
        <div class="form-group" id="key_{$key}">
            <div class="col-sm-12">
                {include file='units/fields/yandexmap.tpl'}
            </div>
        </div>
    </div>

</div>

{include file='units/schools/addresses.tpl'}