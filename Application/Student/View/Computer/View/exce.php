<extend name="Public:templet" />
<block name="title">请假记录</block>
<block name="main">
    <div class="alert alert-info" role="alert">
        此处仅显示两周内申请的请假记录，超过两周的记录请联系辅导员查询<br>
        请使用<code>ctrl + F</code>快捷键来搜索记录
    </div>
    <table class="table table-striped table-hover">
        <tr>
            <th scope="col">学生姓名</th>
            <th scope="col">学生学号</th>
            <th scope="col">请假类别</th>
            <th scope="col">上课时间</th>
            <th scope="col">课程名称</th>
            <th scope="col">申请时间</th>
            <th scope="col">申请状态</th>
            <th scope="col">批准人</th>
        </tr>
        <?php
        foreach($applies as $apply){?>
            <tr>
                <td><?=$students[$apply['uid']]['name']?></td>
                <td><?=$students[$apply['uid']]['sid']?></td>
                <td><?=$apply['data']['excetype']['value']?></td>
                <td><?=$apply['data']['date']['value'].' '.$apply['data']['course']['value']?></td>
                <td><?=$apply['data']['coursename']['value']?></td>
                <td><?=date('Y年m月d日', $apply['creattime'])?></td>
                <td><?=getTitle('apply_status~'.$apply['status'])?></td>
                <td><?=$workers[$apply['wid']]['name']?></td>
            </tr>
        <?php }?>
    </table>
</block>