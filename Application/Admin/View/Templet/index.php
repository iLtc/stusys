<extend name="Public:templet" />
<block name="title">模板管理</block>
<block name="main">
    <legend>账户-协议</legend>
    <?php foreach($templets['account-agreement'] as $templet){?>
        <div class="panel panel-default">
            <div class="panel-heading pointer" data-tid="<?=$templet['tid']?>" id="<?=$templet['tid']?>"><?=$templet['title']?></div>
            <div class="panel-body" id="body-<?=$templet['tid']?>">
                <?=$templet['content']?>
            </div>
            <div class="panel-footer" id="footer-<?=$templet['tid']?>">
                <a href="/Admin-Templet-edit.html?tid=<?=$templet['tid']?>" class="btn btn-primary">修改</a>
            </div>
        </div>
    <?php }?>

    <legend>系统-内容</legend>
    <?php foreach($templets['system-content'] as $templet){?>
        <div class="panel panel-default">
            <div class="panel-heading pointer" data-tid="<?=$templet['tid']?>" id="<?=$templet['tid']?>"><?=$templet['title']?></div>
            <div class="panel-body" id="body-<?=$templet['tid']?>">
                <?=$templet['content']?>
            </div>
            <div class="panel-footer" id="footer-<?=$templet['tid']?>">
                <a href="/Admin-Templet-edit.html?tid=<?=$templet['tid']?>" class="btn btn-primary">修改</a>
            </div>
        </div>
    <?php }?>

    <legend>系统-邮件</legend>
    <?php foreach($templets['system-email'] as $templet){?>
        <div class="panel panel-default">
            <div class="panel-heading pointer" data-tid="<?=$templet['tid']?>" id="<?=$templet['tid']?>"><?=$templet['title']?></div>
            <div class="panel-body" id="body-<?=$templet['tid']?>">
                <?=$templet['content']?>
            </div>
            <div class="panel-footer" id="footer-<?=$templet['tid']?>">
                <a href="/Admin-Templet-edit.html?tid=<?=$templet['tid']?>" class="btn btn-primary">修改</a>
            </div>
        </div>
    <?php }?>

    <legend>系统-短信</legend>
    <?php foreach($templets['system-phone'] as $templet){?>
        <div class="panel panel-default">
            <div class="panel-heading pointer" data-tid="<?=$templet['tid']?>" id="<?=$templet['tid']?>"><?=$templet['title']?></div>
            <div class="panel-body" id="body-<?=$templet['tid']?>">
                <?=$templet['content']?>
            </div>
            <div class="panel-footer" id="footer-<?=$templet['tid']?>">
                <a href="/Admin-Templet-edit.html?tid=<?=$templet['tid']?>" class="btn btn-primary">修改</a>
            </div>
        </div>
    <?php }?>
</block>