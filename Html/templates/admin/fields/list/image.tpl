<div id="small_image_{$key}_{$values[$identity]}">
    {if $values[$key] eq ''}
        нет
    {/if}
</div>

{if $values[$key] neq ''}
    <script>
        addPreviewValue('{$object->images.small_path}{$values[$key]}', '{$key}_{$values[$identity]}', '{$values[$key]}');
    </script>
{/if}