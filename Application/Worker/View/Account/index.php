<extend name="Public:templet" />
<block name="title">账户信息</block>
<block name="main">
    <blockquote>
        <p>用户名：<?=$worker['username']?></p>
        <p>显示名：<?=$worker['name']?></p>
    </blockquote>
    <a href="/Worker-Account-log.html" class="btn btn-primary">操作日志</a>
    <a href="/Worker-Account-password.html" class="btn btn-info">修改密码</a>
</block>