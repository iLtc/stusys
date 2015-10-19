<extend name="Public:templet" />
<block name="title">编辑模块</block>
<block name="main">
    <div class="alert alert-info" role="alert">为避免系统混乱，已添加的模块只能设为“未启用”，不能删除</div>
    <form class="form-horizontal" role="form" method="post">
        <fieldset>
            <legend>
                基本信息：<?php if($selectModule) echo $selectModule['title']; else echo '新模块';?>
            </legend>
            <div class="form-group">
                <label for="title" class="col-sm-1 control-label">模块名称</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="title" name="title" maxlength="21" value="<?php if($selectModule) echo $selectModule['title']?>">
                </div>
            </div>
            <div class="form-group">
                <label for="name" class="col-sm-1 control-label">英文名称</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="name" name="name" maxlength="21" value="<?php if($selectModule) echo $selectModule['type']?>" <?php if($selectModule) echo 'disabled';?>>
                    <span class="help-block">用于模块识别，一经设置不能修改</span>
                </div>
            </div>
            <div class="form-group">
                <label for="tip" class="col-sm-1 control-label">模块介绍</label>
                <div class="col-sm-3">
                    <textarea name="tip" id="tip" class="form-control"><?php if($selectModule) echo $selectModule['tip']?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="stutype" class="col-sm-1 control-label">适用学生</label>
                <div class="col-sm-11">
                    <?php
                    if($selectModule) $typeArr = explode(',', $selectModule['stutype']);
                    foreach($stutypes as $i => $v){
                        $checked = ($selectModule && in_array($i, $typeArr)) ? 'checked' : '';
                    ?>
                        <label class="checkbox-inline">
                            <input type="checkbox" name="stutype[]" value="<?=$i?>" <?=$checked?>> <?=$v?>
                        </label>
                    <?php }?>
                </div>
            </div>
            <div class="form-group">
                <label for="status" class="col-sm-1 control-label">是否启用</label>
                <div class="col-sm-11">
                    <label class="checkbox-inline">
                        <input type="checkbox" id="status" name="status" value="1" <?php if(!$selectModule) echo 'disabled'; elseif($selectModule['status']) echo ' checked'?>>
                        已启用<?php if(!$selectModule) echo '（请完成所有配置后再启用模块）';?>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="print" class="col-sm-1 control-label">是否打印</label>
                <div class="col-sm-11">
                    <label class="checkbox-inline">
                        <input type="checkbox" id="print" name="print" value="1" <?php if($selectModule['print']) echo ' checked'?>>
                        是
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label for="rank" class="col-sm-1 control-label">模块排序</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="sort" name="sort" value="<?php if($selectModule) echo $selectModule['sort']; else echo 0;?>" maxlength="11">
                    <span class="help-block">数值越高，排序越靠前，默认为0</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-3">
                    <input type="submit" class="btn btn-primary" value="<?php if($selectModule) echo '修改'; else echo '添加';?>" id="submit-btn">
                    <a class="btn btn-default" href="/Admin-Module.html">返回</a>
                </div>
            </div>
        </fieldset>
    </form>
</block>