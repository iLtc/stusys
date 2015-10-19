<extend name="Public:templet" />
<block name="title">学生信息</block>
<block name="main">
    <form method="post" class="form-horizontal">
        <div class="form-group">
            <label class="col-sm-2 control-label" for="phone">手机号码</label>
            <div class="col-sm-3">
                <input name="phone" class="form-control" type="text" id="phone" maxlength="11" value="<?=$student['phone']?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">手机校验</label>
            <div class="col-sm-3">
                <label class="checkbox-inline" for="phoneverified">
                    <input name="phoneverified" type="checkbox" id="phoneverified" value="1"<?php if($student['phoneverified'] == 1) echo ' checked';?>> 是
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="email">邮箱地址</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="email" id="email" value="<?=$student['email']?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">邮箱校验</label>
            <div class="col-sm-3">
                <label class="checkbox-inline" for="emailverified">
                    <input name="emailverified" type="checkbox" id="emailverified" value="1"<?php if($student['emailverified'] == 1) echo ' checked';?>> 是
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="password">密码</label>
            <div class="col-sm-3">
                <input type="password" class="form-control" name="password" id="password">
                <span id="helpBlock" class="help-block">若不修改请留空</span>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="name">姓名</label>
            <div class="col-sm-3">
                <input name="name" class="form-control" type="text" id="name" maxlength="7" value="<?=$student['name']?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">性别</label>
            <div class="col-sm-3">
                <label class="radio-inline" for="sexM">
                    <input type="radio" name="sex" id="sexM" value="M"<?php if($student['sex'] == 'M') echo ' checked';?>> 男
                </label>
                <label class="radio-inline" for="sexF">
                    <input type="radio" name="sex" id="sexF" value="F"<?php if($student['sex'] == 'F') echo ' checked';?>> 女
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="sid">学号</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="sid" id="sid" maxlength="13" value="<?=$student['sid']?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="major">所在专业</label>
            <div class="col-sm-3">
                <input type="text" class="form-control" name="major" id="major" value="<?=$student['major']?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="year">入学年份</label>
            <div class="col-sm-3">
                <input name="year" class="form-control" type="text" id="year" maxlength="4" value="<?=$student['year']?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="stutype">学生类型</label>
            <div class="col-sm-3">
                <select name="stutype" id="stutype" class="form-control">
                    <?php foreach($student_type as $v=>$stutype){
                        $mail = ($v > 10) ? '（可邮寄到付）' : '';
                        $selected = ($student['stutype'] == $v) ? ' selected' : '';
                        echo "<option value=\"$v\"$selected>$stutype$mail</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">邮寄到付</label>
            <div class="col-sm-3">
                <label class="checkbox-inline" for="isaddress">
                    <input name="isaddress" type="checkbox" id="isaddress" value="1"<?php if($student['isaddress'] == 1) echo ' checked';?>> 是
                </label>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label" for="address">地址及邮编</label>
            <div class="col-sm-3">
                <textarea name="address" class="form-control" rows="5" id="address"><?=$student['address']?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="reason" class="col-sm-2 control-label">操作原因</label>
            <div class="col-sm-3">
                <textarea id="reason" name="reason" class="form-control" rows="3"></textarea>
                <span id="helpBlock" class="help-block">请在此处备注您操作的原因</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" class="btn btn-primary" value="修改">
            </div>
        </div>
    </form>
</block>