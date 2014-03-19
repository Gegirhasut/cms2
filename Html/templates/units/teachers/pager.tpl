{if $pages gt 2}
    <ul class="pagination">
        {if !isset($prev_page)}
            <li class="disabled"><a href="#">&laquo;</a></li>
        {else}
            <li><a href="?page={$prev_page}">&laquo;</a></li>
        {/if}

        {section name=i start=1 loop=$pages step=1}
            {if $smarty.section.i.index eq $cur_page}
                <li class="active"><a href="#">{$smarty.section.i.index}</a></li>
            {else}
                <li><a href="?page={$smarty.section.i.index}">{$smarty.section.i.index}</a></li>
            {/if}
        {/section}

        {if !isset($next_page)}
            <li class="disabled"><a href="#">&raquo;</a></li>
        {else}
            <li><a href="?page={$next_page}">&raquo;</a></li>
        {/if}
    </ul>
{/if}