<extend name="Public:templet" />
<block name="title">编辑分类</block>
<block name="main">
    <form class="form-horizontal" role="form" method="post">
        <fieldset>
            <legend>编辑分类：<?=$fileClass['name']?></legend>
            <div class="form-group">
                <label for="name" class="col-sm-1 control-label">分类名称</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="name" name="name" maxlength="21" value="<?=$fileClass['name']?>">
                </div>
            </div>
            <div class="form-group">
                <label for="rank" class="col-sm-1 control-label">分类排序</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="sort" name="sort" value="<?=$fileClass['sort']?>" maxlength="11">
                    <span class="help-block">数值越高，排序越靠前，默认为0</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-3">
                    <input type="hidden" name="fcid" value="<?=$fileClass['fcid']?>">
                    <input type="submit" class="btn btn-primary" value="保存" id="submit-btn">
                    <a class="btn btn-default" href="Admin-File.html">返回</a>
                </div>
            </div>
        </fieldset>
    </form>
</block>