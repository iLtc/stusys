<extend name="Public:templet" />
<block name="title">编辑打印内容</block>
<block name="style">
    <link rel="stylesheet" type="text/css" href="__PUBLIC__/simditor/styles/simditor.css" />
    <link rel="stylesheet" href="__PUBLIC__/simditor/styles/simditor-html.css" media="screen" charset="utf-8" />
</block>
<block name="main">
    <form method="post" action="/Worker-Apply-editview.html?aid=<?=I('aid')?>">
        <textarea id="editor" name="content" style="width:100%; height:500px;">
            <?=htmlspecialchars($content)?>
        </textarea>
        <input type="submit" class="btn btn-primary" value="保存并预览" id="btn-edit">
    </form>

</block>
