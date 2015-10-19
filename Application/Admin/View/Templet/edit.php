<extend name="Public:templet" />
<block name="title">模板管理</block>
<block name="main">
        <form method="post" role="form" class="templet-form">
            <input type="text" class="form-control" id="title" name="title" value="<?=$templet['title']?>">
            <textarea class="form-control" id="content" name="content" rows="21"><?=$templet['content']?></textarea>
            <input type="submit" class="btn btn-primary" id="btn-submit" value="保存">
        </form>
</block>