<extend name="Public:templet" />
<block name="title">学生信息</block>
<block name="main">
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
    </blockquote>
    <a class="btn btn-default" href="/Worker-Apply.html?uid=<?=$student['uid']?>">申请历史</a>
    <a class="btn btn-warning" href="/Worker-Student-edit.html?uid=<?=$student['uid']?>">修改信息</a>
    <a class="btn btn-info" data-toggle="modal" data-target="#send" href="#">发送通知</a>
    <!-- Send -->
    <div class="modal fade" id="send" tabindex="-1" role="dialog" aria-labelledby="sendLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="sendLabel">发送通知</h4>
                </div>
                <form class="form-horizontal" method="post" action="/Worker-Student-send.html?uid=<?=$student['uid']?>">
                    <div class="modal-body">
                        <div class="alert alert-info" role="alert"><strong>注意</strong> 没有完成校验的渠道也可以接收通知</div>
                        <div class="form-group">
                            <label for="send" class="col-sm-3 control-label">发送到</label>
                            <div class="col-sm-7">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="phone" name="phone">
                                        <?=$student['phone']?>
                                        <?php if(!$student['phoneverified']) echo '（未校验）';?>
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" id="email" name="email">
                                        <?=$student['email']?>
                                        <?php if(!$student['emailverified']) echo '（未校验）';?>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content" class="col-sm-3 control-label">通知内容</label>
                        <div class="col-sm-7">
                            <textarea id="content" name="content" class="form-control" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="发送">
                    </div>
                </form>
            </div>
        </div>
    </div>
</block>