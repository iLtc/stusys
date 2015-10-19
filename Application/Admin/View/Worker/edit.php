<extend name="Public:templet" />
<block name="title">编辑人员</block>
<block name="main">
    <div class="alert alert-info" role="alert">为避免系统混乱，已添加的工作人员只能设为“禁止”，不能删除</div>
    <form class="form-horizontal" role="form" method="post">
        <fieldset>
            <legend>
                编辑人员：<?php if($worker) echo $worker['name']; else echo '新人员';?>
            </legend>
            <div class="form-group">
                <label for="username" class="col-sm-1 control-label">用户名</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="username" name="username" maxlength="21" value="<?php if($worker) echo $worker['username']?>" <?php if($worker) echo 'disabled';?>>
                    <span class="help-block">用于登陆，一经设置不能修改</span>
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-1 control-label">显示名</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="name" name="name" maxlength="21" value="<?php if($worker) echo $worker['name']?>">
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-sm-1 control-label">密码</label>
                <div class="col-sm-3">
                    <input type="password" class="form-control" id="password" name="password" >
                    <?php if($worker){?><span class="help-block">如果不修改请留空</span><?php }?>
                </div>
            </div>
            <div class="form-group">
                <label for="isadmin" class="col-sm-1 control-label">管理员</label>
                <div class="col-sm-11">
                    <label class="checkbox-inline">
                        <input type="checkbox" id="isadmin" name="isadmin" value="1" <?php if($worker['isadmin']) echo ' checked'?>> 是
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="status" class="col-sm-1 control-label">状态</label>
                <div class="col-sm-11">
                    <label class="checkbox-inline">
                        <input type="checkbox" id="status" name="status" value="1" <?php if($worker['status']) echo ' checked'?>> 激活
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-3">
                    <input type="submit" class="btn btn-primary" value="<?php if($worker) echo '修改'; else echo '添加';?>" id="submit-btn">
                    <a class="btn btn-default" href="/Admin-Worker.html">返回</a>
                </div>
            </div>
        </fieldset>
    </form>
</block>