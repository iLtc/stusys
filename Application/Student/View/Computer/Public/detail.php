<extend name="Public:templet" />
<block name="title">申请详情</block>
<block name="main">

    <p><strong>申请编号：</strong><?=$apply['code']?></p>
    <p><strong>申请类型：</strong><?=$moduleArray[$apply['type']]?></p>
    <p><strong>处理状态：</strong><?=getTitle('apply_status~'.$apply['status'])?></p>
    <p><strong>申请时间：</strong><?=date('Y-m-d H:i:s', $apply['creattime'])?></p>
    <p><strong>最后处理时间：</strong><?=date('Y-m-d H:i:s', $apply['dealtime'])?></p>
    <hr>
    <blockquote class="block">
        <?php
        $temp = json_decode(str_replace("\r\n", '', $apply['data']), true);
        foreach($temp as $data){
            if($data['upload'] != true){
                echo "<p><strong>$data[title]：</strong>$data[value]</p>";
            }else{
                echo "<p><strong>$data[title]：</strong><br>";
                if($data['value']){
                    $uploads = explode(',', $data['value']);
                    foreach($uploads as $upload){
                        $url = $upload;
                        echo "<a href='$url' data-lightbox='upload'><img src='$url!style1' class='img-polaroid' alt='附件'></a>";
                    }
                    echo '</p>';
                }else{
                    echo '无</p>';
                }
            }
        }
        ?>
    </blockquote>
    <hr>
    <blockquote id="log" data-code="<?=I('code')?>" class="block">
        <img src="__PUBLIC__/img/loading.gif" alt="加载中" style="height: 30px">
    </blockquote>
</block>