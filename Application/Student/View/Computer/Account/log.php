<extend name="Public:templet" />
<block name="title">操作日志</block>
<block name="main">
    <table class="table table-striped table-hover">
        <thead>
        <tr>
            <th>日志编号</th>
            <th>操作类型</th>
            <th>操作时间</th>
            <th>操作IP</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($logs as $log){?>
            <tr>
                <td><?=$log['id']?></td>
                <td><?=getTitle('log~'.$log['type'])?></td>
                <td><?=date('Y-m-d H:i:s', $log['time'])?></td>
                <td class="ip"><a href="http://www.ip138.com/ips138.asp?ip=<?=$log['ip']?>&action=2" target="_blank"><?=$log['ip']?></a></td>
            </tr>
        <?php }?>
        </tbody>
    </table>
    <?php if($pages != 1){?>
        <ul class="pager">
            <?php if($page > 1){?>
                <li class="previous">
                    <a href="/Account-log.html?page=<?=$page-1?>">上一页</a>
                </li>
            <?php }?>
            <?php if($page < $pages){?>
                <li class="next">
                    <a href="/Account-log.html?page=<?=$page+1?>">下一页</a>
                </li>
            <?php }?>
        </ul>
    <?php }?>
</block>