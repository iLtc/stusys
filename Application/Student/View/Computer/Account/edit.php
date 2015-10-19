<extend name="Public:templet" />
<block name="title">修改信息</block>
<block name="main">
    <div class="alert alert-info">
        姓名、性别、学号等关键信息请联系辅导员修改
    </div>
    <form class="form-horizontal" method="post">
        <fieldset>
            <legend>修改信息</legend>
            <div class="control-group">
                <label class="control-label" for="password">当前密码[<a href="/Sign-forget.html">忘记</a>]</label>
                <div class="controls">
                    <input type="password" name="password" id="password">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="phone">手机号码</label>
                <div class="controls">
                    <input type="text" name="phone" id="phone" value="<?=$account['phone']?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="email">邮箱地址</label>
                <div class="controls">
                    <input type="text" name="email" id="email" value="<?=$account['email']?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="major">所在专业</label>
                <div class="controls">
                    <input name="major" type="text" id="major" value="<?=$account['major']?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="stutype">学生类型</label>
                <div class="controls">
                    <select name="stutype" id="stutype">
                        <?php foreach($student_type as $v=>$stutype){
                            $mail = ($v > 10) ? '（可邮寄到付）' : '';
                            $selected = ($account['stutype'] == $v) ? ' selected' : '';
                            echo "<option value=\"$v\"$selected>$stutype$mail</option>";
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div id="isaddressdiv"<?php if(!$account['isaddress']) echo ' style="display:none"'?>>
                <div class="control-group">
                    <label class="control-label">邮寄到付</label>
                    <div class="controls">
                        <label class="checkbox inline" for="isaddress">
                            <input name="isaddress" type="checkbox" id="isaddress" value="1"<?php if($account['isaddress']) echo ' checked'?>> 是
                        </label>
                    </div>
                </div>
                <div class="control-group" id="addressdiv"<?php if(!$account['isaddress']) echo ' style="display:none"'?>>
                    <label class="control-label" for="address">地址及邮编</label>
                    <div class="controls">
                        <textarea name="address" rows="5" id="address"><?=$account['address']?></textarea>
                    </div>
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