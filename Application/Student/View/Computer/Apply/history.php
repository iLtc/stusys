<extend name="Public:templet" />
<block name="title">申请历史</block>
<block name="main">
    <?php if(count($history)<1){?>
        <p>您还没有进行过申请，请点击下面的按钮开始申请</p>
        <p><a class="btn btn-primary" href="/Apply.html">开始申请</a></p>
    <?php }else{?>
        <table class="table table-striped table-hover">
            <tr>
                <th scope="col">申请编号</th>
                <th scope="col">申请类型</th>
                <th scope="col">处理状态</th>
                <th scope="col">申请时间</th>
                <th scope="col">最后响应时间</th>
                <th scope="col">操作</th>
            </tr>
            <?php
            foreach($history as $data){?>
                <tr>
                    <td><?=$data['code']?></td>
                    <td><?=$moduleArray[$data['type']]?></td>
                    <td><?=getTitle('apply_status~'.$data['status'])?></td>
                    <td><?=date('Y年m月d日', $data['creattime'])?></td>
                    <td><?=date('Y年m月d日', $data['dealtime'])?></td>
                    <td>
                        <a href="Public-detail.html?code=<?=$data['code']?>" class="btn btn-mini">查看</a>
                        <?php if($data['status'] == 0){?>
                            <a href="Apply-cancel.html?aid=<?=$data['aid']?>" class="btn btn-mini btn-danger btn-cancel">撤销</a>
                        <?php }?>
                    </td>
                </tr>
            <?php }?>
        </table>
    <?php }?>
</block>