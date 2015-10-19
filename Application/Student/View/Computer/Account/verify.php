<extend name="Public:templet" />
<block name="title">输入校验码</block>
<block name="main">
    <?php if(I('send')){?>
        <div class="alert alert-info">
            校验码已发送，如果您在3分钟内没有收到，请点击
            <a class="btn btn-primary btn-mini" href="/Account-send.html?type=<?=$type?>">重新获取校验码</a>
        </div>
    <?php }?>
    <form class="form-horizontal" method="post">
        <fieldset>
            <legend>输入校验码</legend>
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
                <label class="control-label" for="verify">校验码</label>
                <div class="controls">
                    <input name="verify" type="text" id="verify">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input type="submit" class="btn btn-primary" id="login-btn" value="校验">
                </div>
            </div>
        </fieldset>
    </form>
</block>