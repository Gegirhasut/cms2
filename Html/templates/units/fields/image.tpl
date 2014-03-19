<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.0/css/jasny-bootstrap.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.0/js/jasny-bootstrap.min.js"></script>

<div id="small_image_{$key}">
    <div id="loading"><img src="/images/app/loading.gif"></div>
    {if $form.value[$key] neq ''}
        <img src="/{$form.model->images.small_path}{$form.value[$key]}" />
    {else}
        {$field.placeholder}
        <br><br>
    {/if}
    <input type="hidden" name="{$key}" value="{$form.value[$key]}">
</div>

<div id="remove_{$key}" {if $form.value[$key] eq ''}style="display: none;"{/if} onclick="deleteImage('{$key}')">
    <img src="/images/app/deletered.png" style="width: 50px;padding-left: 20px;cursor:pointer;" />
    Удалить миниатюру
</div>

<script src="/js/app/upload/ajaxfileupload.js"></script>
<script src="/js/app/upload/upload.js"></script>
<script src="/js/app/jquery.Jcrop.js"></script>
<link href="/css/app/jquery.Jcrop.css" rel="stylesheet">

<form name="form" action="" method="POST" enctype="multipart/form-data">
<div class="fileinput fileinput-new" data-provides="fileinput">
    <div class="input-group">
        <div class="form-control" data-trigger="fileinput"><i class="glyphicon glyphicon-file fileinput-exists"></i> <span class="fileinput-filename"></span></div>
        <span class="input-group-addon btn btn-default btn-file"><span class="fileinput-new">Выбрать файл</span><span class="fileinput-exists">Изменить</span><input type="file" id="fileToUpload" name="fileToUpload"></span>
        <a href="#" class="input-group-addon btn btn-info fileinput-exists" data-dismiss="fileinput">Удалить</a>
    </div>
</div>
</form>
<button class="button" onclick="return ajaxFileUpload('fileToUpload', '{$form.class}', '{$key}', '/api/');"> Загрузить картинку </button>