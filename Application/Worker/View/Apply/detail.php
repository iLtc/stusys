<extend name="Public:templet" xmlns="http://www.w3.org/1999/html"/>
<block name="title">查看申请</block>
<block name="main">
    <legend>查看申请（编号：<?=$apply['code']?>，类型：<?=$moduleArray[$apply['type']]?>，状态：<?=getTitle('apply_status~'.$apply['status'])?>）</legend>
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
    <?php if(($apply['status'] == 1 || $apply['status'] == 2) && $module['print'] == 1){?>
        <a class="btn btn-success" href="/Worker-Apply-view.html?aid=<?=$apply['aid']?>">打印证明</a>
    <?php }?>
    <a class="btn btn-default" href="/Worker-Apply-editapply.html?aid=<?=$apply['aid']?>">修改申请</a>
    <input type="button" class="btn btn-warning" value="修改状态" data-toggle="modal" data-target="#change">
    <div class="panel panel-default" style="margin-top: 10px;">
        <div class="panel-heading">操作历史</div>
        <div class="panel-body" id="log" data-code="<?=$apply['code']?>">
            <img src="__PUBLIC__/img/loading.gif" alt="加载中" style="height: 30px">
        </div>
    </div>
    <!-- Modal -->
    <div class="modal" id="change" tabindex="-1" role="dialog" aria-labelledby="changeLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="changeLabel">修改状态</h4>
                </div>
                <form class="form-horizontal">
                    <div class="modal-body">
                        <div class="alert alert-info" role="alert"><strong>注意</strong> 在此处进行的修改不会通知学生</div>
                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">修改状态</label>
                            <div class="col-sm-7">
                                <select name="status" id="status" class="form-control">
                                    <?php foreach($statusList as $status){
                                        $selected = ($status['value'] == $apply['status']) ? ' selected' : '';
                                    ?>
                                        <option value="<?=$status['value']?>"<?=$selected?>><?=$status['title']?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="reason" class="col-sm-3 control-label">操作原因</label>
                            <div class="col-sm-7">
                                <textarea id="reason" name="reason" class="form-control" rows="7"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="修改">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="取消">
                    </div>
                </form>
            </div>
        </div>
    </div>
</block>