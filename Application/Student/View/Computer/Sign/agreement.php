<extend name="Public:templet" />
<block name="title">使用协议</block>
<block name="main">
    <h1><?=$templet['title']?></h1>
    <?=$templet['content']?>
    <p><strong>点击下面的按钮则表示您同意上述协议</strong></p>
    <div class="text-center">
        <a href="/Sign-register.html" class="btn btn-primary">注册/登陆</a>
        <a href="/Sign-auth.html?name=wb" data-skip-pjax="true"><img src="__PUBLIC__/img/weibo.png" title="用微博账号登陆" alt="微博"></a>
        <a href="/Sign-auth.html?name=qq" data-skip-pjax="true"><img src="__PUBLIC__/img/qq.png" title="用QQ账号登陆" alt="QQ"></a>
    </div>
</block>