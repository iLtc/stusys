<extend name="Public:templet" />
<block name="title">获取校验码</block>
<block name="main">
    <form class="form-horizontal" method="post">
        <fieldset>
            <legend>获取校验码</legend>
            <div class="control-group">
                <label class="control-label" for="target">
                    <?php if($type == 'email') echo '邮箱地址'; else echo'手机号码'?>
                    [<a href="/Account-edit.html">修改</a>]
                </label>
                <div class="controls">
                    <input type="text" id="target" value="<?=$target?>" disabled>
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
                    <input type="submit" class="btn btn-primary" id="login-btn" value="获取校验码">
                    <a href="/Account-verify.html?type=<?=$type?>&step=1" class="btn btn-default">已有校验码</a>
                </div>
            </div>
        </fieldset>
    </form>
</block>