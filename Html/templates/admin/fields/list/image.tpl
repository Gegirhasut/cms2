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