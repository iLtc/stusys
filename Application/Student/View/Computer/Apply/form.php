<extend name="Public:templet" />
<block name="title">开始申请【<?=$module['title']?>】</block>
<block name="main">
    <form method="post" class="form-horizontal" enctype="multipart/form-data" id="applyform">
        <fieldset>
            <legend>开始申请【<?=$module['title']?>】</legend>
            <?php
            foreach($list as $data){
                echo '<div class="control-group">';
                echo "<label class=\"control-label\" for=\"$data[name]\">$data[title]</label>";
                echo '<div class="controls">';
                switch($data['type']){
                    case 'radio':
                        $data['value'] = explode(',', $data['value']);
                        foreach($data['value'] as $value){
                            echo "<label class=\"radio inline\"><input type=\"radio\" name=\"$data[name]\" value=\"$value\" /> $value</label>";
                        }
                        break;
                    case 'textarea':
                        echo "<textarea name=\"$data[name]\" id=\"$data[name]\" rows=\"7\"></textarea>";
                        break;
                    case 'select':
                        $data['value'] = explode(',', $data['value']);
                        echo "<select name=\"$data[name]\" id=\"$data[name]\">";
                        echo '<option value="请选择..." selected>请选择...</option>';
                        foreach($data['value'] as $value){
                            echo "<option value=\"$value\">$value</option>";
                        }
                        echo '</select>';
                        break;
                    case 'upload':
                        echo "<input type='button' value='选择文件……' data-name='$data[name]' id='$data[name]_btn' class='show-uploader-btn btn btn-default'>";
                        echo "<p id='$data[name]_error'>糟糕！您的浏览器不支持上传功能，请尝试换用其他浏览器</p>";
                        echo "<div id='$data[name]_queue'></div>";
                        echo "<div style='padding-top: 10px; width: 300px; display: none;' id='$data[name]_line1'><div class='progress progress-striped active'><div id='$data[name]_line2' class='bar' style='width: 15%;'></div></div></div>";
                        echo "<div id='$data[name]_img'></div>";
                        echo "<input name=\"$data[name]\" type=\"hidden\" id=\"$data[name]\">";
                        break;
					case 'datepicker':
						echo "<input type=\"text\" name=\"$data[name]\" id=\"$data[name]\" class=\"datepicker\">";
						//echo "<input type=\"hidden\" name=\"$data[name]\" id=\"$data[name]\">";
						break;
                    default:
                        echo "<input type=\"text\" name=\"$data[name]\" id=\"$data[name]\">";
                }
                if($data['tip']) echo '<span class="help-block">'.$data['tip'].'</span>';
                echo '</div></div>';
            }
            ?>
            <input type="hidden" id="apply_form_name" name="apply_form_name" value="<?=$module['type']?>">
            <div class="form-actions">
                <input type="submit" id="applysubmit" value="提交" class="btn btn-primary" />
            </div>
        </fieldset>
    </form>
    <input type="hidden" id="qiniu-url" value="<?=getConfig('qiniu_url')?>">
	<input type="hidden" id="uid" value="<?=$publicHead['account']['uid']?>">
</block>
<block name="script">
    <script>
        var <?=$module['type']?>_script = function(){
            $("#applyform").validator({
				showOk: "",
				//debug: 1,
                rules: {
                    selected: function(el, param, field){
                        if(el.value == '请选择...') return false;
                        else return true;
                    },
                    pass: function(el, param, field){
                        return true;
                    },
					number: function(el){
						if(isNaN(el.value) || el.value < 0){
							return '请输入正数';
						}else return true;
					},
                    idcard:[/^(\d{15}$|^\d{18}$|^\d{17}(\d|X|x))$/, '身份证号码格式不正确'],
                    datepicker:[/^(\d{4}年\d{2}月\d{2}日)$/, '请按 XXXX年XX月XX日 的格式填写']
                },
                messages: {
                    selected: '请选择'
                },
                fields: {
                    <?php foreach($list as $data) echo $data[name].':"'.$data['rule'].'",';?>
                },
                valid: function(form){
                    var me = this;

                    // 提交表单之前，hold住表单，防止重复提交
                    me.holdSubmit();

                    submitForm($("#applyform"));
                }
            });
        }
    </script>
</block>