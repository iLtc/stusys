<extend name="Public:templet" />
<block name="title">缓存清理</block>
<block name="main">
    <form class="form-horizontal" role="form" method="post">
        <div class="form-group">
            <label for="files" class="col-sm-2 control-label">文件列表</label>
            <div class="col-sm-3">
                <textarea name="files" id="files" class='form-control' rows="7"><?php echo <<<EOF
Public/js/admin.js
Public/js/public.js
Public/js/student-computer.js
Public/js/worker.js
Public/css/admin.css
Public/css/student-computer.css
Public/css/worker.css
EOF;
 ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-3">
                <input type="hidden" name="type" value="qiniu">
                <input type="submit" class="btn btn-primary" value="清理" id="submit-btn">
            </div>
        </div>
    </form>
</block>