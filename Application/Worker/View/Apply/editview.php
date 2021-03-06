<extend name="Public:templet" />
<block name="title">编辑打印内容</block>
<block name="main">
    <form method="post">
        <textarea id="editor" name="content" style="width:100%; height:500px;">
            <?=htmlspecialchars($content)?>
        </textarea>
        <input type="submit" class="btn btn-primary" value="保存并预览" id="btn-edit">
        <a href="/Worker-Apply-editview2nd.html?aid=<?=I('aid')?>" id="btn-edit" class="btn btn-default">新版编辑器</a>
    </form>

</block>
<block name="script">
    <script src="__PUBLIC__/kindeditor/kindeditor-min.js"></script>
    <script src="__PUBLIC__/kindeditor/lang/zh_CN.js"></script>
</block>