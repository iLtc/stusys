<extend name="Public:templet" />
<block name="title">申请模块</block>
<block name="main">
    <a class="btn btn-primary" id="add-module" href="/Admin-Module-basic.html">添加模块</a>
    <table class="table table-hover table-striped">
        <thead>
        <tr>
            <th width="12%">模块名称</th>
            <th width="8%">模块状态</th>
            <th width="8%">是否打印</th>
            <th>适用学生</th>
            <th width="8%">模块排序</th>
            <th width="15%">模块操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($modules as $module){?>
            <tr>
                <td><?=$module['title']?></td>
                <td><?php if($module['status']) echo '<span class="label label-success">已启用</span>';
                    else echo '<span class="label label-warning">未启用</span>';?></td>
                <td><?php if($module['print']) echo '<span class="label label-success">是</span>';
                    else echo '<span class="label label-warning">否</span>';?></td>
                <td>
                    <?php
                    $typeArr = explode(',', $module['stutype']);
                    foreach($typeArr as $type) $stutype[] = $stutypes[$type];
                    if(!$stutype) echo '无';
                    else echo implode('，', $stutype);
                    unset($stutype);
                    ?>
                </td>
                <td><?=$module['sort']?></td>
                <td>
                    <a href="/Admin-Module-basic.html?mid=<?=$module['mid']?>" class="btn btn-primary btn-xs">设置</a>
                    <a href="/Admin-Module-form.html?mid=<?=$module['mid']?>" class="btn btn-default btn-xs">表单</a>
                    <a href="/Admin-Module-view.html?mid=<?=$module['mid']?>" class="btn btn-success btn-xs">模板</a>
                </td>
            </tr>
        <?php }?>
        </tbody>
    </table>
</block>