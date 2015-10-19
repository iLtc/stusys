<extend name="Public:templet" />
<block name="title">文件下载</block>
<block name="main">
    <?php foreach($file['class'] as $class){
        if($file['list'][$class['fcid']] == '') continue;
    ?>
        <div class="file span3">
            <h4><?=$class['name']?></h4>
            <?php foreach($file['list'][$class['fcid']] as $list){?>
                <p><a href="<?=$list['url']?>"><?=$list['name']?></a></p>
            <?php }?>
        </div>

    <?php }?>
</block>