<img id="loading" src="/images/admin/loading.gif" style="display:none;">
<form name="form" action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td><input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input"></td>
            <td><button class="button" id="buttonUpload" onclick="return ajaxFileUpload('fileToUpload', '{$class}', '{$key}');"> Загрузить файл </button></td>
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