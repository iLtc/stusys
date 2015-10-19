<extend name="Public:templet" />
<block name="title">忘记密码</block>
<block name="main">
    <?php if($_GET['error']){?>
        <div class="alert alert-alert">
            <?php if($_GET['error'] == 'user'){?>
                <strong>匹配不到该用户</strong> 请输入正确的用户信息<br>
                <strong>微博或者QQ用户</strong> 可以先通过微博或者QQ账号登陆，核对信息后再在这里输入<br>
                <strong>向辅导员寻求帮助</strong> 如果确实无法输入正确的用户信息，请联系辅导员寻求帮助
            <?php }else{?>
                <strong>
                    该<?php if($_GET['error'] == 'phone') echo '手机号码';else echo '邮箱地址';?>没有通过校验
                </strong>
                您之前没有校验过该渠道，所以不能用它重置密码，请尝试使用<?php if($_GET['error'] == 'phone') echo '邮箱地址';else echo '手机号码';?>来重置密码<br>
                <strong>微博或者QQ用户</strong> 可以先通过微博或者QQ账号登陆，完成校验后再申请重置密码<br>
                <strong>向辅导员寻求帮助</strong> 如果确实无法校验渠道，请联系辅导员寻求帮助
            <?php }?>
        </div>
    <?php }else{?>
        <div class="alert alert-info">
            <strong>注意</strong> 此操作会将您的账户密码重置成随机密码并通过手机或者邮箱发送给您，请凭新密码登陆后及时修改密码<br>
            <strong>微博或者QQ用户</strong> 请使用该功能生成新密码
        </div>
    <?php }?>

    <form class="form-horizontal" method="post">
        <fieldset>
            <legend>忘记密码</legend>
            <div class="control-group">
                <label class="control-label" for="name">姓名</label>
                <div class="controls">
                    <input name="name" type="text" id="name" maxlength="7">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="sid">学号</label>
                <div class="controls">
                    <input type="text" name="sid" id="sid" maxlength="13">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="target">手机或者邮箱</label>
                <div class="controls">
                    <input name="target" type="text" id="target">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="code">验证码</label>
                <div class="controls">
                    <input name="code" type="text" id="code" maxlength="4">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <img id="code-img" src="/Public-verifyImg.html?<?=rand()?>" class="pointer code-img" title="点击刷新验证码" alt="点击刷新验证码" data-for="code">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input type="submit" class="btn btn-primary" id="login-btn" value="接收新密码">
                    <a href="/Sign-register.html" class="btn btn-default">返回</a>
                </div>
            </div>
        </fieldset>
    </form>
</block>