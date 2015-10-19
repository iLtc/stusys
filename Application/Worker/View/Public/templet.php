<?php if(!is_pjax_request()){?>
<!DOCTYPE html>
    <html lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <link href="__PUBLIC__/bootstrap3/css/bootstrap.min.css" rel="stylesheet">
        <link href="__PUBLIC__/bootstrap3/css/bootstrap-theme.min.css" rel="stylesheet">
        <link href="__PUBLIC__/nprogress/nprogress.css" rel="stylesheet">
        <link href="__PUBLIC__/messenger/css/messenger.css" rel="stylesheet">
        <link href="__PUBLIC__/messenger/css/messenger-theme-future.css" rel="stylesheet">
        <link href="__PUBLIC__/lightbox/css/lightbox.css" rel="stylesheet">
        <link href="__PUBLIC__/jquery-ui/jquery-ui.min.css" rel="stylesheet">
        <link href="__PUBLIC__/css/worker.css" rel="stylesheet">
<?php }?>
    <title><block name="title"></block> | 工作平台 | 学生自助服务系统</title>
    <block name="style"></block>
<?php if(!is_pjax_request()){?>
        <script src="https://lib.sinaapp.com/js/jquery/1.10.2/jquery-1.10.2.min.js"></script>
    </head>
    <body>
    <nav class="navbar navbar-static-top navbar-default" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">工作平台</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav" id="navs">
                    <li id="nav-Apply"><a href="/Worker-Apply.html">申请管理</a></li>
                    <li id="nav-Student"><a href="/Worker-Student.html">学生管理</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li id="nav-Account"><a href="/Worker-Account.html"><?=$publicHead['account']['name']?></a></li>
                    <?php if($publicHead['account']['isadmin']){?><li><a href="/Admin.html" data-skip-pjax="true">管理平台</a></li><?php }?>
                    <li><a href="/Sign-logout.html" data-skip-pjax="true">退出</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container" id="container">
<?php }?>
<block name="main"></block>
<input type="hidden" value="<?=CONTROLLER_NAME?>" id="controller">
<input type="hidden" value="<?=ACTION_NAME?>" id="action">
<input type="hidden" value="__SELF__" id="self">
<?php if(!is_pjax_request()){?>
    </div> <!-- /container -->
    <script src="__PUBLIC__/bootstrap3/js/bootstrap.min.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="__PUBLIC__/js/html5shiv.js"></script>
    <script src="__PUBLIC__/js/respond.min.js"></script>
    <![endif]-->
    <script src="__PUBLIC__/js/jquery.pjax.js"></script>
    <script src="__PUBLIC__/nprogress/nprogress.js"></script>
    <script src="__PUBLIC__/messenger/js/messenger.min.js"></script>
    <script src="__PUBLIC__/messenger/js/messenger-theme-future.js"></script>
    <script src="__PUBLIC__/lightbox/js/lightbox.js"></script>
    <script src="__PUBLIC__/jquery-ui/jquery-ui.min.js"></script>
    <script src="__PUBLIC__/jquery-ui/datepicker-zh-TW.js"></script>
    <script src="__PUBLIC__/js/public.js"></script>
    <script src="__PUBLIC__/js/worker.js"></script>
    <div style="display: none"><script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1254479398'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/stat.php%3Fid%3D1254479398' type='text/javascript'%3E%3C/script%3E"));</script></div>
<?php }?>
    <block name="script"></block>
<?php if(!is_pjax_request()){?>
    </body>
</html>
<?php }?>
