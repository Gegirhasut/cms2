<!DOCTYPE html>
<html lang="en">
{include file="units/head.tpl"}
<body>
{include file="units/google.tpl"}
<div id="overlay"></div>

<!-- Fixed navbar -->
{include file="units/menu_top.tpl"}

<!-- Begin page content -->
<div class="container main_container">
    {include file="pages/$page.tpl"}

    {include file="units/footer.tpl"}
</div>
{include file="units/yandex.tpl"}
</body>
</html>