<extend name="Public:templet" />
<block name="title">预览模板</block>
<block name="main">
    <legend>【<?=$selectModule['title']?>】模板 [<a href="/Admin-Module.html">返回</a>]</legend>
    <?php foreach($templets as $i => $templet){?>
        <div class="panel panel-default">
            <div class="panel-heading pointer" data-tid="<?=$i?>" id="<?=$i?>"><?=$templet['title']?></div>
            <div class="panel-body" id="body-<?=$i?>">
                <?=$templet['content']?>
            </div>
            <div class="panel-footer" id="footer-<?=$i?>">
                <a href="/Admin-Module-templet.html?mid=<?=$selectModule['mid']?>&type=<?=$i?>" data-skip-pjax="true" class="btn btn-primary">修改</a>
            </div>
        </div>
    <?php }?>
</block>