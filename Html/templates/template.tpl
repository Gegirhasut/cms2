<!DOCTYPE html>
<html lang="en">
{include file="units/head.tpl"}
<body>

<div id="overlay"></div>

<!-- Fixed navbar -->
{include file="units/menu_top.tpl"}

<!-- Begin page content -->
<div class="container main_container">
    {include file="pages/$page.tpl"}

    {include file="units/footer.tpl"}
</div>

</body>
</html>