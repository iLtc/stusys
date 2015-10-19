<extend name="Public:templet" />
<block name="title">修改申请</block>
<block name="main">
    <form class="form-horizontal" role="form" method="post">
        <fieldset>
            <legend>修改申请（编号：<?=$apply['aid']?>，类型：<?=$moduleArray[$apply['type']]?>）</legend>
            <?php
            $datas = json_decode(str_replace("\r\n", '', $apply['data']), true);
            foreach($datas as $i => $data){
                if(mb_strlen($data['value'],'utf-8')>15){
                    $input = "<textarea class='form-control' id='$i' name='$i' rows='7'>$data[value]</textarea>";
                }else{
                    $input = "<input type='text' class='form-control' id='$i' name='$i' value='$data[value]'>";
                }
                echo <<<EOF
    <div class="form-group">
        <label for="$i" class="col-sm-2 control-label">$data[title]</label>
            <div class="col-sm-3">
                $input
            </div>
        </div>
EOF;
            }
            ?>
            <div class="form-group">
                <label for="reason" class="col-sm-2 control-label">操作原因</label>
                <div class="col-sm-3">
                    <textarea id="reason" name="reason" class="form-control" rows="3"></textarea>
                    <span id="helpBlock" class="help-block">请在此处备注您操作的原因</span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-3">
                    <input type="submit" class="btn btn-primary" value="保存" id="submit-btn">
                </div>
            </div>
        </fieldset>
    </form>
</block>