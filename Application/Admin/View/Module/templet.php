<extend name="Public:templet" />
<block name="title">编辑模板</block>
<block name="main">
    <form method="post" role="form" class="templet-form">
        <input type="text" class="form-control" id="title" name="title" value="<?=$templet['title']?>">
        <textarea class="form-control" id="content" name="content" rows="21"><?=htmlspecialchars($templet['content'])?></textarea>
        <input type="submit" class="btn btn-primary" id="btn-submit" value="保存">
    </form>
    <?php if($_GET['type'] == 'print' || $_GET['type'] == 'phone' || $_GET['type'] == 'email'){?>
        <div class="panel panel-default" style="margin-top: 10px;">
            <div class="panel-heading">变量列表</div>
            <div class="panel-body">
                <?php if($_GET['type'] == 'print'){?>
                    <div class="row">
                        <?php foreach($forms as $form){?>
                            <div class="col-md-4"><kbd>{$<?=$form['name']?>}</kbd> <?=$form['title']?></div>
                        <?php }?>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4"><kbd>{$student.name}</kbd> 学生姓名</div>
                        <div class="col-md-4"><kbd>{$student.sex}</kbd> 学生性别</div>
                        <div class="col-md-4"><kbd>{$student.phone}</kbd> 学生手机</div>
                        <div class="col-md-4"><kbd>{$student.email}</kbd> 学生邮箱</div>
                        <div class="col-md-4"><kbd>{$student.sid}</kbd> 学生学号</div>
                        <div class="col-md-4"><kbd>{$student.year}</kbd> 入学年份</div>
                        <div class="col-md-4"><kbd>{$student.major}</kbd> 所在专业</div>
                        <div class="col-md-4"><kbd>{$student.stutype}</kbd> 学生类型（详细）</div>
                        <div class="col-md-4"><kbd>{$student.stutype1}</kbd> 学生类型（大类）</div>
                        <div class="col-md-4"><kbd>{$student.address}</kbd> 到付地址</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-4"><kbd>{$system.date}</kbd> 当天日期</div>
                    </div>
                <?php }else{?>
                    <div class="row">
                        <div class="col-md-4"><kbd>{$name}</kbd> 学生姓名</div>
                        <div class="col-md-4"><kbd>{$time}</kbd> 申请日期</div>
                        <div class="col-md-4"><kbd>{$module_name}</kbd> 模块名称</div>
                    </div>
                <?php }?>
            </div>
        </div>
    <?php }?>



</block>
<block name="script">
    <script src="__PUBLIC__/kindeditor/kindeditor-min.js"></script>
    <script src="__PUBLIC__/kindeditor/lang/zh_CN.js"></script>
</block>