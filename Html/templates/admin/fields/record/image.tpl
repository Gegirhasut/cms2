<form name="form" action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td><input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input"></td>
            <td><button class="button" id="buttonUpload" onclick="return ajaxFileUpload('fileToUpload', '{$class}', '{$key}', '/admin/api/');"> Загрузить файл </button></td>
        </tr>
    </table>
</form>
<br>

<div id="small_image_{$key}">
    {if $values[$key] eq ''}
        нет
    {/if}
</div>

{if $values[$key] neq ''}
    <script>
        addPreviewValue('{$object->images.small_path}/{$values[$key]}', '{$key}', '{$values[$key]}');
    </script>
{/if}

<div id="remove" {if $values[$key] eq ''}style="display: none;"{/if}>
    <img src="/images/app/deletered.png" style="width: 30px;cursor:pointer;" onclick="deleteImage('{$key}')" />
    Удалить
</div>