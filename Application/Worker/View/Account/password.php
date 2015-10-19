<extend name="Public:templet" />
<block name="title">修改密码</block>
<block name="main">
    <form method="post" class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="oldpassword">旧密码</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" name="oldpassword" id="oldpassword">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="password">新密码</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" name="password" id="password">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="password">重复密码</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" name="repassword" id="repassword">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-primary" value="修改">
            </div>
        </div>
    </form>
</block>