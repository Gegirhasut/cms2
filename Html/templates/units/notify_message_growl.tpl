{if isset($cabinet_message) && !empty($cabinet_message)}
    <script src="/Libs/Bootstrap-3.1.0/js/jquery.bootstrap-growl.min.js"></script>
    <script>
        {foreach from=$cabinet_message item=message}
        $.bootstrapGrowl("{$message}", {ldelim}
            type: 'success',
            align: 'center',
            offset: {ldelim} from: 'top', amount: '50' {rdelim},
            width: 'auto',
            delay: 5000,
            allow_dismiss: true
            {rdelim});
        {/foreach}
    </script>
{/if}