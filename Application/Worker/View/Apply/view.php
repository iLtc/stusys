<extend name="Public:templet" />
<block name="title">打印证明</block>
<block name="main">
    <div class="print-paper">
        <?=$content?>
        <hr>
        <div>
            <div style="width: 60%; float: left;">
                <p>您可以通过访问以下地址或扫描二维码来查看审核情况</p>
                <p><?=$url?><br>
                <p><img src="/System-Tool-qrcode.html?content=<?=urlencode($url)?>&md5=<?=mkConMd5($url)?>"></p>
            </div>
            <div style="float: right; width: 40%">
                <p class="text-right">申请编号：<?=$apply['code']?></p>
                <p class="text-right">来自园艺学院学生自助服务系统</p>
                <p><img src="__PUBLIC__/img/print_logo.jpg" style="max-width: 100%"></p>
            </div>
        </div>
    </div>

    <div style="padding-top: 20px; float:left;">
        <a href="#" id="print-now" data-confirm="Worker-Apply-viewconfirm.html?aid=<?=$apply['aid']?>" class="btn btn-primary print-btn">立即打印</a>
        <a href="/Worker-Apply-editview.html?aid=<?=$apply['aid']?>" class="btn btn-default print-btn" data-skip-pjax="true">在线修改</a>
        <a href="/Worker-Apply-viewdelete.html?aid=<?=$apply['aid']?>" id="refresh-now" class="btn btn-danger print-btn">重置证明</a>
        <a href="javascript:window.close()" class="btn btn-default print-btn">关闭页面</a>
    </div>

</block>