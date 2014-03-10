<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Администрирование сайта</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap-theme.min.css">
    <!-- Custom styles for this template -->
    <link href="/css/app/sticky-footer-navbar.css" rel="stylesheet">
    <link href="/css/admin/main.css" rel="stylesheet">
    <link href="/css/app/jquery.Jcrop.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="/js/admin/admin.js"></script>
    <script src="/js/app/upload/upload.js"></script>
    <script src="/js/app/upload/ajaxfileupload.js"></script>
    <script src="/js/app/jquery.Jcrop.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>

<div id="image_preview_window">
    <div id="outer">
        Загрузка картинки. Выделите область на картинке.
        <div id="image_preview">

        </div>
        <div>Миниатюра</div>
        <div id="image_crop" style="overflow:hidden;margin-top:5px;border: 1px solid grey;">
        </div>
        <button id="submit" onclick="createCropImage('{$class}')">Создать миниатюру</button>
        <button onclick="cancelUpload('{$class}')">Отменить</button>
    </div>
</div>
<div id="overlay"></div>

<div {if $menu eq true}id="wrap"{/if}>

    {if $menu eq true}
        <!-- Fixed navbar -->
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container" style="width:100%;">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/admin/">Админка</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        {foreach from=$menu item=m key=mv}
                            {if isset($m.dropdown)}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">{$mv} <b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        {foreach from=$m.dropdown item=sm key=smv}
                                            <li {if $sm.object eq $object}class="active"{/if}><a href="{$sm.url}">{$smv}</a></li>
                                        {/foreach}
                                    </ul>
                                </li>
                            {else}
                                <li {if $m.object eq $object}class="active"{/if}><a href="{$m.url}">{$mv}</a></li>
                            {/if}
                        {/foreach}
                    </ul>
                </div>
            </div>
        </div>
    {/if}

    <!-- Begin page content -->
    <div class="container" style="width:100%;">
        {include file="admin/pages/$page.tpl"}
    </div>
</div>

{if $menu eq true}
    <div id="footer">
        <div class="container" style="width:100%;">
            <p class="text-muted"><a href="/admin/logout">Выход</a></p>
        </div>
    </div>
{/if}

</body>
</html>