<extend name="Public:templet" />
<block name="title">系统注册</block>
<block name="main">
    <?php if($auth){
        $third = ($_GET['type'] == 'wb') ? '微博' : 'QQ';
        ?>
        <div class="alert alert-info">
            您已通过<?=$third?>账户“<?=I('nickname')?>”成功登陆本系统，但是此<?=$third?>账号未与本系统中的任何账号绑定，请填写注册信息或者登陆现有账号
        </div>
    <?php }?>
    <?php if($_GET['send']){?>
        <div class="alert alert-info">
            新密码已经发送，请凭新密码登陆后及时修改密码，如果超过3分钟没有收到请
            <a class="btn btn-primary btn-mini" href="/Sign-forget.html">点击这里重新获取</a>
        </div>
    <?php }?>
    <div id="login-left">
        <form method="post" class="form-horizontal" id="regform">
            <fieldset>
                <legend>还没有注册？请在这里注册</legend>
                <div class="control-group">
                    <label class="control-label" for="phone">手机号码</label>
                    <div class="controls">
                        <input name="phone" type="text" id="phone" maxlength="11">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="email">邮箱地址</label>
                    <div class="controls">
                        <input type="text" name="email" id="email">
                    </div>
                </div>
                <?php if(!$auth){?>
                    <div class="control-group">
                        <label class="control-label" for="password">密码</label>
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
                <?php }?>
                <div class="control-group">
                    <label class="control-label" for="name">真实姓名</label>
                    <div class="controls">
                        <input name="name" type="text" id="name" maxlength="7" value="<?php if($_GET['nickname']) echo I('nickname');?>">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">性别</label>
                    <div class="controls">
                        <label class="radio inline" for="sexM"><input type="radio" name="sex" id="sexM" value="M"> 男</label>
                        <label class="radio inline" for="sexF"><input type="radio" name="sex" id="sexF" value="F"> 女</label>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="sid">学号</label>
                    <div class="controls">
                        <input type="text" name="sid" id="sid" maxlength="13">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="year">入学年份</label>
                    <div class="controls">
                        <input name="year" type="text" id="year" maxlength="4">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="major">所在专业</label>
                    <div class="controls">
                        <input name="major" type="text" id="major">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="stutype">学生类型</label>
                    <div class="controls">
                        <select name="stutype" id="stutype">
                            <option value="0">请选择……</option>

                            <?php foreach($student_type as $v=>$stutype){
                                $mail = ($v > 10) ? '（可邮寄到付）' : '';
                                echo "<option value=\"$v\">$stutype$mail</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div id="isaddressdiv" style="display:none">
                    <div class="control-group">
                        <label class="control-label">邮寄到付</label>
                        <div class="controls">
                            <label class="checkbox inline" for="isaddress">
                                <input name="isaddress" type="checkbox" id="isaddress" value="1"> 是
                            </label>
                        </div>
                    </div>
                    <div class="control-group" id="addressdiv" style="display:none">
                        <label class="control-label" for="address">地址及邮编</label>
                        <div class="controls">
                            <textarea name="address" rows="5" id="address"></textarea>
                        </div>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="reg-code">验证码</label>
                    <div class="controls">
                        <input name="code" type="text" id="reg-code" maxlength="4">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <img id="reg-img" src="/Public-verifyImg.html?id=reg&<?=rand()?>" class="pointer code-img" title="点击刷新验证码" alt="点击刷新验证码" data-for="reg-code">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" class="btn btn-primary" value="注册">
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
    <div id="login-right">
        <form class="form-horizontal" method="post" action="/Sign-login.html" id="loginform">
            <fieldset>
                <legend>已经注册？请在这里登陆</legend>
                <div class="control-group">
                    <label class="control-label" for="username">用户名</label>
                    <div class="controls">
                        <input type="text" id="username" name="username" placeholder="邮箱/手机/学号">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="loginpassword">密码</label>
                    <div class="controls">
                        <input type="password" id="loginpassword" name="password">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="login-code">验证码</label>
                    <div class="controls">
                        <input name="code" type="text" id="login-code" maxlength="4">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <img id="login-img" src="/Public-verifyImg.html?id=login&<?=rand()?>" class="pointer code-img" title="点击刷新验证码" alt="点击刷新验证码" data-for="login-code">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <input type="submit" class="btn btn-primary" id="login-btn" value="登陆">
                        <a class="btn btn-default" href="/Sign-forget.html">忘记</a>
                        <a href="/Sign-auth.html?name=wb" data-skip-pjax="true"><img src="__PUBLIC__/img/weibo.png" title="用微博账号登陆" alt="微博"></a>
                        <a href="/Sign-auth.html?name=qq" data-skip-pjax="true"><img src="__PUBLIC__/img/qq.png" title="用QQ账号登陆" alt="QQ"></a>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</block>
