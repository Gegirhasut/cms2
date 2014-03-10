<div id="small_image_{$key}">
    <div id="loading"><img src="/images/app/loading.gif"></div>
    {if $form.value[$key] neq ''}
        <img src="/{$form.model->images.small_path}{$form.value[$key]}" />
    {else}
        {$field.placeholder}
    {/if}
    <input type="hidden" name="{$key}" value="{$form.value[$key]}">
</div>

<div id="remove" {if $form.value[$key] eq ''}style="display: none;"{/if}>
    <img src="/images/app/deletered.png" style="width: 50px;padding-left: 20px;cursor:pointer;" onclick="deleteImage('{$key}')" />
    Удалить
</div>

<script src="/js/app/upload/ajaxfileupload.js"></script>
<script src="/js/app/upload/upload.js"></script>
<script src="/js/app/jquery.Jcrop.js"></script>
<link href="/css/app/jquery.Jcrop.css" rel="stylesheet">

<form name="form" action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td><input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input"></td>
            <td><button class="button" id="buttonUpload" onclick="return ajaxFileUpload('fileToUpload', '{$form.class}', '{$key}', '/api/');"> Загрузить картинку </button></td>
        </tr>
    </table>
</form>