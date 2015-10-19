<extend name="Public:templet" />
<block name="title">工作人员</block>
<block name="main">
    <a href="/Admin-Worker-edit.html" class="btn btn-primary">添加人员</a>
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th>登陆名</th>
            <th>显示名</th>
            <th>管理员</th>
            <th>状态</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($workers as $worker){?>
            <tr>
                <td><?=$worker['username']?></td>
                <td><?=$worker['name']?></td>
                <td><?php if($worker['isadmin']) echo '是'; else echo '否';?></td>
                <td>
                    <?php
                    if($worker['status']) echo '<span class="label label-success">激活</span>'; else echo '<span class="label label-warning">禁止</span>';
                    ?>
                </td>
                <td><?php if($worker['wid'] != $publicHead['account']['wid']){?>
                        <a href="/Admin-Worker-edit.html?wid=<?=$worker['wid']?>" class="btn btn-default btn-xs">操作</a>
                    <?php }?>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</block>