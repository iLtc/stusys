<extend name="Public:templet" />
<block name="title">添加分类</block>
<block name="main">
    <form class="form-horizontal" role="form" method="post">
        <fieldset>
            <legend>添加分类</legend>
            <div class="form-group">
                <label for="name" class="col-sm-1 control-label">分类名称</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="name" name="name" maxlength="21">
                </div>
            </div>
            <div class="form-group">
                <label for="rank" class="col-sm-1 control-label">分类排序</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="sort" name="sort" value="0" maxlength="11">
                    <span class="help-block">数值越高，排序越靠前，默认为0</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-3">
                    <input type="submit" class="btn btn-primary" value="新建" id="submit-btn">
                    <a class="btn btn-default" href="Admin-File.html">返回</a>
                </div>
            </div>
        </fieldset>
    </form>
</block>