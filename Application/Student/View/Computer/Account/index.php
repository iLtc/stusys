<extend name="Public:templet" />
<block name="title">我的账户</block>
<block name="main">
    <legend id="info">账户信息</legend>
    <blockquote>
        <p>姓名：<?=$student['name']?></p>
        <p>性别：<?php if($student['sex'] == 'F') echo '女';else echo '男';?></p>
        <p>学号：<?=$student['sid']?></p>
        <p>入学年份：<?=$student['year']?></p>
        <p>所在专业：<?=$student['major']?></p>
        <p>手机号码：<?=$student['phone']?>
            <?php if(!$student['phoneverified'])
                echo '（<a href="/Account-send.html?type=phone">立即校验</a>）';?></p>
        <p>邮箱地址：<?=$student['email']?>
            <?php if(!$student['emailverified'])
                echo '（<a href="/Account-send.html?type=email">立即校验</a>）';?></p>
        <p>学生类型：<?=getTitle('student_type~'.$student['stutype'])?></p>
        <p>邮寄到付：<?php if($student['isaddress']) echo '是';else echo '否';?></p>
        <?php if($student['isaddress']){?>
            <p>邮寄地址：<?=$student['address']?></p>
        <?php }?>
        <a href="/Account-edit.html" class="btn btn-default">修改信息</a>
        <a href="/Account-password.html" class="btn btn-default">修改密码</a>
        <a href="/Account-log.html" class="btn btn-default">操作日志</a>
    </blockquote>
    <legend>保存信息</legend>
    <div class="alert alert-info">
        以下信息是在您填写申请时系统自动记录的，下次申请会自动填充，这些内容会随着您在申请时修改而修改
    </div>
    <blockquote>
        <?php $datas = json_decode($student['remember'], true);
        if(count($datas)<1) echo '<p>没有已保存的信息</p>';
        else foreach($datas as $data){
            echo '<p>'.$data['title'].':'.$data['value'].'</p>';
        }?>
    </blockquote>
    <legend id="auth">绑定账户</legend>
    <div class="alert alert-info">
        绑定社交账户可以使您的登陆更加便捷，请放心，我们不会用您的账号发布信息
    </div>
    <blockquote>
        <p>微博账户：
            <?php if(in_array('wb', $auth)) echo '已绑定（<a href="/Account-remove.html?name=wb" class="remove-auth">解除绑定</a>）';
            else echo '未绑定（<a href="/Sign-auth.html?name=wb" data-skip-pjax="true">立即绑定</a>）';
            ?>
        </p>
        <p>QQ账户：
            <?php if(in_array('qq', $auth)) echo '已绑定（<a href="/Account-remove.html?name=qq" class="remove-auth">解除绑定</a>）';
            else echo '未绑定（<a href="/Sign-auth.html?name=qq" data-skip-pjax="true">立即绑定</a>）';
            ?>
        </p>
    </blockquote>
</block>