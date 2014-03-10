<form name="form" action="" method="POST" enctype="multipart/form-data">
    <table>
        <tr>
            <td><input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input"></td>
            <td><button class="button" id="buttonUpload" onclick="return ajaxFileUpload('fileToUpload', '{$class}', '{$key}', '/admin/api/');"> Загрузить файл </button></td>
        </tr>
    </table>
</form>
<br>

{include file="admin/fields/list/image.tpl"}