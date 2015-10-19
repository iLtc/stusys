<extend name="Public:templet" />
<block name="title"><?=$templete['title']?></block>
<block name="main">
    <h1><?=$templete['title']?></h1>
    <?=$templete['content']?>
    <div class="text-center">
        <a href="__APP__/Apply-form.html?type=<?=$module['type']?>" class="btn btn-primary">了解上述说明</a>
    </div>
</block>