<extend name="Public:templet" />
<block name="title">表单项目</block>
<block name="main">
    <legend>表单项目：<?=$selectModule['title']?></legend>
    <a class="btn btn-primary" href="/Admin-Module-edit.html?mid=<?=$selectModule['mid']?>">添加项目</a>
    <a class="btn btn-default" href="/Admin-Module.html">返回</a>
    <?php if(count($lists) < 1) echo '<p>表单项目为空，请添加</p>';
    else{?>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>项目编号</th>
                <th>项目名称</th>
                <th>英文名称</th>
                <th>项目类型</th>
                <th>项目值</th>
                <th>项目规则</th>
                <th>项目排序</th>
                <th>项目操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($lists as $list){?>
                <tr>
                    <td><?=$list['fid']?></td>
                    <td><?=$list['title']?></td>
                    <td><?=$list['name']?></td>
                    <td><?=getTitle('form~'.$list['type'])?></td>
                    <td>
                        <?php
                        if($list['value']) echo $list['value'];
                        else echo '-';
                        ?>
                    </td>
                    <td>
                        <?php
                        if($list['rule']) echo $list['rule'];
                        else echo '-';
                        ?>
                    </td>
                    <td><?=$list['sort']?></td>
                    <td>
                        <a href="/Admin-Module-edit.html?mid=<?=$selectModule['mid']?>&fid=<?=$list['fid']?>" class="btn btn-primary btn-xs">编辑</a>
                        <a href="/Admin-Module-delete.html?mid=<?=$selectModule['mid']?>&fid=<?=$list['fid']?>" class="btn btn-danger btn-xs">删除</a>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    <?php }?>
</block>