<extend name="Public:templet" />
<block name="title">审核申请</block>
<block name="main">
    <legend>审核申请（编号：<?=$apply['code']?>，类型：<?=$module['title']?>）</legend>
    <div class="row">
        <div class="col-md-6">
            <blockquote>
                <?php $listes = json_decode(str_replace("\r\n", '', $apply['data']), true);
                foreach($listes as $list){
                    if($list['upload']){
                        echo '<p>'.$list['title'].'：<br>';
                        if($list['value']){
                            $urls = explode(',', $list['value']);
                            foreach($urls as $url) echo '<a href="'.$url.'" data-lightbox="upload-'.$apply['aid'].'"><img src="'.$url.'!style1" alt="附件" class="img-thumbnail"></a>';
                            echo '</p>';
                        }else echo '无</p>';
                    }else{
                        echo '<p>'.$list['title'].'：'.$list['value'].'</p>';
                    }
                }
                ?>
            </blockquote>
        </div>
        <div class="col-md-6">
            <blockquote>
                <p>姓名：<?=$student['name']?></p>
                <p>性别：<?php if($student['sex'] == 'F') echo '女';else echo '男';?></p>
                <p>学号：<?=$student['sid']?></p>
                <p>入学年份：<?=$student['year']?></p>
                <p>所在专业：<?=$student['major']?></p>
                <p>手机号码：<?=$student['phone']?>
                    <?php if(!$student['phoneverified']) echo '（未校验）';?></p>
                <p>邮箱地址：<?=$student['email']?>
                    <?php if(!$student['emailverified']) echo '（未校验）';?></p>
                <p>学生类型：<?=getTitle('student_type~'.$student['stutype'])?></p>
                <p>邮寄到付：<?php if($student['isaddress']) echo '是';else echo '否';?></p>
                <?php if($student['isaddress']){?>
                    <p>邮寄地址：<?=$student['address']?></p>
                <?php }?>
                <?php $datas = json_decode($student['remember'], true);
                foreach($datas as $data){
                    echo '<p>'.$data['title'].':'.$data['value'].'</p>';
                }?>
                <a class="btn btn-info" href="/Worker-Student-detail.html?uid=<?=$apply['uid']?>">操作</a>
            </blockquote>
        </div>
    </div>

    <form method="post">
        <?php if($module['print']){$value='通过申请并打印';}else{$value='通过申请并关闭';}?>
        <input type="submit" name="type" class="btn btn-primary" value="<?=$value?>">
        <input type="button" name="type" class="btn btn-danger" value="拒绝申请" id="refuse-button">
        <a class="btn btn-default" href="/Worker-Apply-editapply.html?aid=<?=$apply['aid']?>">修改申请</a>
        <input type="hidden" name="type" id="type" value="pass">
    </form>
    <form method="post" style="margin-top: 10px;" id="refuse-form">
        <p><textarea name="reason" placeholder="拒绝理由" class="form-control"></textarea></p>
        <input type="hidden" name="type" id="type" value="refuse">
        <input type="submit" name="type" class="btn btn-danger" value="拒绝申请">
    </form>

    <div class="panel panel-default" style="margin-top: 10px;">
        <div class="panel-heading">操作历史</div>
        <div class="panel-body" id="log" data-code="<?=$apply['code']?>">
            <img src="__PUBLIC__/img/loading.gif" alt="加载中" style="height: 30px">
        </div>
    </div>
</block>