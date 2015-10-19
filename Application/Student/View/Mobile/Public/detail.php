<extend name="./Application/Student/View/Mobile/Public/templet.php" />
<block name="title">申请详情</block>
<block name="main">
    <div data-role="page">
        <div data-role="header">
            <h1>申请详情</h1>
        </div><!-- /header -->

        <div role="main" class="ui-content">
            <div data-role="collapsible" data-collapsed="false" data-inset="false">
                <h4>基本信息</h4>
                <p><strong>申请编号：</strong><?=$apply['code']?></p>
                <p><strong>申请类型：</strong><?=$moduleArray[$apply['type']]?></p>
                <p><strong>处理状态：</strong><?=getTitle('apply_status~'.$apply['status'])?></p>
                <p><strong>申请时间：</strong><?=date('Y-m-d H:i:s', $apply['creattime'])?></p>
                <p><strong>最后处理时间：</strong><?=date('Y-m-d H:i:s', $apply['dealtime'])?></p>
            </div>

            <div data-role="collapsible" data-collapsed="false" data-inset="false">
                <h4>申请详情</h4>
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
            </div>
        </div>

    </div>
</block>