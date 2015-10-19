<extend name="Public:templet" />
<block name="title">修改密码</block>
<block name="main">
    <form class="form-horizontal" method="post">
        <fieldset>
            <legend>修改密码</legend>
            <div class="control-group">
                <label class="control-label" for="oldpassword">当前密码[<a href="/Sign-forget.html">忘记</a>]</label>
                <div class="controls">
                    <input type="password" name="oldpassword" id="oldpassword">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="password">新密码</label>
                <div class="controls">
                    <input type="password" name="password" id="password">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="repassword">重复密码</label>
                <div class="controls">
                    <input type="password" name="repassword" id="repassword">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <input type="submit" class="btn btn-primary" id="login-btn" value="修改">
                    <a href="/Account.html" class="btn btn-default">返回</a>
                </div>
            </div>
        </fieldset>
    </form>
</block>