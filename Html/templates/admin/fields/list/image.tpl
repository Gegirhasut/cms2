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