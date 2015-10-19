<extend name="Public:templet" />
<block name="title">系统参数</block>
<block name="main">
    <form class="form-horizontal" role="form" method="post">
        <?php foreach($configs as $config){?>
            <div class="form-group">
                <label for="name" class="col-sm-3 control-label"><?=$config['title']?></label>
                <div class="col-sm-3">
                    <?php switch($config['type']){
                        case 'password':
                            echo "<input type='password' class='form-control' id='$config[name]' name='$config[name]' value='$config[value]'>";
                            break;

                        case 'checkbox':
                            $checked = $config['value'] ? 'checked' : '';
                            echo "<div class='checkbox'><label><input type='checkbox' id='$config[name]' name='$config[name]' $checked></label></div>";
                            break;

                        default:
                            echo "<input type='text' class='form-control' id='$config[name]' name='$config[name]' value='$config[value]'>";
                    }?>
                </div>
            </div>
        <?php } ?>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-3">
                <input type="submit" class="btn btn-primary" value="保存" id="submit-btn">
            </div>
        </div>
    </form>
</block>