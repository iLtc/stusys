<?php if(!is_pjax_request()){?>
    <!DOCTYPE html>
    <html lang="zh-CN">
    <head>
        <meta property="qc:admins" content="415627573453136316110063757317652571345260454" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
        <link href="https://lib.sinaapp.com/js/bootstrap/2.3.2/css/bootstrap.min.css" rel="stylesheet">
        <link href="__PUBLIC__/nprogress/nprogress.css" rel="stylesheet">
        <link href="__PUBLIC__/messenger/css/messenger.css" rel="stylesheet">
        <link href="__PUBLIC__/messenger/css/messenger-theme-future.css" rel="stylesheet">
        <link href="__PUBLIC__/validator/jquery.validator.css" rel="stylesheet">
        <link href="__PUBLIC__/lightbox/css/lightbox.css" rel="stylesheet">
		<link href="__PUBLIC__/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <link href="__PUBLIC__/css/student-computer.css" rel="stylesheet">
<?php }?>
        <title><block name="title"></block> | 学生自助服务系统 | 园艺学院</title>
        <block name="style"></block>
<?php if(!is_pjax_request()){?>
        <script src="https://lib.sinaapp.com/js/jquery/1.10.2/jquery-1.10.2.min.js"></script>
    </head>
    <body>
    <div id="header">
        <?php if($publicHead['account']['uid'] != ''){ ?>
            <div id="account">
                <strong><a href="/Account.html"><?=$publicHead['account']['name']?></a></strong>
                <a href="/Sign-logout.html" data-skip-pjax="true">退出</a>
            </div>
        <?php } ?>
        <ul>
            <?php if($publicHead['account']['uid'] != ''){ ?>
                <li><a href="/Apply.html">开始申请</a></li>
                <li><a href="/Apply-history.html">申请历史</a></li>
                <li><a href="/Account.html">我的账户</a></li>
            <?php }else{?>
                <li><a href="/Sign-agreement.html">使用协议</a></li>
            <?php }?>
            <li><a href="/Public-file.html">文件下载</a></li>
            <li><a href="/Public-content.html?id=about">关于系统</a></li>
            <li><a href="/Public-content.html?id=contact">联系我们</a></li>
        </ul>
    </div>
    <div id="container" class="row">
<?php }?>
<block name="main"></block>
<input type="hidden" value="<?=CONTROLLER_NAME?>" id="controller">
<input type="hidden" value="<?=ACTION_NAME?>" id="action">
<input type="hidden" value="__SELF__" id="self">
<?php if(!is_pjax_request()){?>
    </div>
    <div id="foot">
        <div class="foot_info1">
            <p>版权所有 &copy; 华南农业大学园艺学院 / 联系电话：020-85280227</p>
            <p>地址：广州市天河区五山路483号园艺学院 / 邮政编码：510642</p>
        </div>
        <div class="foot_info2">
            <p>华农园艺学生自助服务系统 V2.0</p>
            <p>
				<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1254479398'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/stat.php%3Fid%3D1254479398' type='text/javascript'%3E%3C/script%3E"));</script>
				|
				<a href="/Public-feedback.html">问题反馈</a>
				</p>
            <!--<p><strong>电脑版</strong> | <a>手机版</a></p>-->
        </div>
    </div>

    <script src="https://lib.sinaapp.com/js/bootstrap/2.3.2/js/bootstrap.min.js"></script>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="__PUBLIC__/js/html5shiv.js"></script>
    <![endif]-->
    <script src="__PUBLIC__/js/jquery.pjax.js"></script>
    <script src="__PUBLIC__/nprogress/nprogress.js"></script>
    <script src="__PUBLIC__/validator/jquery.validator.js"></script>
    <script src="__PUBLIC__/validator/local/zh-CN.js"></script>
    <script src="__PUBLIC__/messenger/js/messenger.min.js"></script>
    <script src="__PUBLIC__/messenger/js/messenger-theme-future.js"></script>
    <script src="__PUBLIC__/plupload/plupload.full.min.js"></script>
    <script src="__PUBLIC__/js/qiniu.min.js"></script>
    <script src="__PUBLIC__/lightbox/js/lightbox.js"></script>
	<script src="__PUBLIC__/datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="__PUBLIC__/datepicker/locales/bootstrap-datepicker.zh-CN.min.js"></script>	
    <script src="__PUBLIC__/js/public.js"></script>
    <script src="__PUBLIC__/js/student-computer.js"></script>
<?php }?>
    <block name="script"></block>
<?php if(!is_pjax_request()){?>
    </body>
    </html>
<?php }?>
