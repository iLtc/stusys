<extend name="Public:templet" />
<block name="title">编辑项目</block>
<block name="main">
    <form class="form-horizontal" role="form" method="post">
        <fieldset>
            <legend>
                编辑项目：<?php if($form) echo $form['title']; else echo '新项目';?>
            </legend>
            <div class="form-group">
                <label for="title" class="col-sm-2 control-label">项目名称</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="title" name="title" maxlength="21" value="<?php if($form) echo $form['title']?>">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">英文名称</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="name" name="name" maxlength="21" value="<?php if($form) echo $form['name']?>" <?php if($form) echo 'disabled';?>>
                    <span class="help-block">用于项目识别，一经设置不能修改</span>
                </div>
            </div>
            <div class="form-group">
                <label for="tip" class="col-sm-2 control-label">项目提示</label>
                <div class="col-sm-4">
                    <textarea name="tip" id="tip" class="form-control"><?php if($form) echo $form['tip']?></textarea>
                    <span class="help-block">选中一个项目时展示在其后面的提示，可不填</span>
                </div>
            </div>
            <div class="form-group">
                <label for="type" class="col-sm-2 control-label">项目类型</label>
                <div class="col-sm-4">
                    <select name="type" id="type" class="form-control">
                        <?php foreach($types as $i => $v){
                            $selected = ($form && $form['type'] == $i) ? 'selected' : '';
                            ?>
                            <option value="<?=$i?>" <?=$selected?>><?=$v?></option>
                        <?php }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="value" class="col-sm-2 control-label">项目值（选项）</label>
                <div class="col-sm-4">
                    <textarea class="form-control" id="value" name="value" rows="7"><?php if($form) echo $form['value']?></textarea>
                    <span class="help-block">类型为下拉列表、单选按钮和组合表单时必填，内容为各选项或子表单项目编号，每行一个</span>
                </div>
            </div>
            <div class="form-group">
                <label for="rule" class="col-sm-2 control-label">项目规则</label>
                <div class="col-sm-4">
                    <textarea class="form-control" id="rule" name="rule" rows="7"><?php if($form) echo $form['rule']?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="rank" class="col-sm-2 control-label">项目排序</label>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="sort" name="sort" value="<?php if($form) echo $form['sort']; else echo 0;?>" maxlength="11">
                    <span class="help-block">数值越高，排序越靠前，默认为0</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <input type="submit" class="btn btn-primary" value="<?php if($form) echo '修改'; else echo '添加';?>" id="submit-btn">
                    <a class="btn btn-default" href="/Admin-Module-form.html?mid=<?=$selectModule['mid']?>">返回</a>
                </div>
            </div>
        </fieldset>
    </form>
</block>