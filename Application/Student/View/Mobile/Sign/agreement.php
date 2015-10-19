<extend name="./Application/Student/View/Mobile/Public/templet.php" />
<block name="title">使用协议</block>
<block name="main">
    <div data-role="page">
        <div data-role="header">
            <h1>使用协议</h1>
        </div><!-- /header -->
        <div role="main" class="ui-content">
            <div data-role="collapsible">
                <h4><?=$templet['title']?></h4>
                <?=$templet['content']?>
            </div>
            <p>点击下面的按钮则表示您同意上述协议</p>
            <a href="/Sign-register.html" class="ui-btn ui-corner-all">注册</a>
            <a href="/Sign-login.html" class="ui-btn ui-corner-all">登陆</a>
        </div>
    </div><!-- /page -->


    <div class="text-center">
        <a href="/Sign-register.html" class="btn btn-primary">注册/登陆</a>
        <a href="/Sign-auth.html?name=wb" data-skip-pjax="true"><img src="__PUBLIC__/img/weibo.png" title="用微博账号登陆" alt="微博"></a>
        <a href="/Sign-auth.html?name=qq" data-skip-pjax="true"><img src="__PUBLIC__/img/qq.png" title="用QQ账号登陆" alt="QQ"></a>
    </div>
</block>