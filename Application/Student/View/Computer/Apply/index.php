<extend name="Public:templet" />
<block name="title">选择项目</block>
<block name="main">
    <?php if(!$verify[0] && !$verify[1]){?>
        <div class="alert alert-error">
            <h4>未完成校验</h4>
            您的手机和邮箱均没有完成校验，不能进行申请！请至少校验一个渠道，以便及时接收审核结果。
            <a class="btn btn-primary btn-mini" href="/Account.html#info">立即校验</a>
        </div>
    <?php }else{?>
        <h1>请选择一个申请项目</h1>
        <div id="module-container">
            <?php foreach($modules as $module){
                $allow = explode(',', $module['stutype']);
                if(!in_array($publicHead['account']['stutype'], $allow)) continue;
            ?>
                <div class="span3">
                    <blockquote class="apply-module">
                        <strong><a href="Apply-agreement.html?type=<?=$module['type']?>"><?=$module['title']?></a></strong>
                        <small><?=$module['tip']?></small>
                    </blockquote></div>
            <?php }?>
        </div>
    <?php }?>
</block>