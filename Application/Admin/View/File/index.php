<extend name="Public:templet" />
<block name="title">文件下载</block>
<block name="main">
    <a class="btn btn-primary" id="add-class" href="Admin-File-addClass.html">添加分类</a>
    <?php foreach($file['class'] as $class){?>
        <div class="panel panel-default">
            <div class="panel-heading pointer class-head" data-fcid="<?=$class['fcid']?>"><strong><?=$class['name']?></strong> 排序:<?=$class['sort']?></div>
            <div class="panel-body" id="body-<?=$class['fcid']?>">
                <p>
                    <a class="btn btn-primary" href="Admin-File-upload.html?fcid=<?=$class['fcid']?>">上传文件</a>
                    <a class="btn btn-default" href="Admin-File-editClass.html?fcid=<?=$class['fcid']?>">编辑分类</a>
                    <a class="btn btn-danger btn-delete" href="Admin-File-delClass.html?fcid=<?=$class['fcid']?>">删除分类</a>
                </p>
            </div>
            <!-- List group -->
            <ul class="list-group" id="list-<?=$class['fcid']?>">
                <?php if($file['list'][$class['fcid']] == ''){?>
                    <li class="list-group-item">没有文件</li>
                <?php }else foreach($file['list'][$class['fcid']] as $list){?>
                    <li class="list-group-item">
                        <a href="<?=$list['url']?>" target="_blank"><?=$list['name']?></a> 排序：<?=$list['sort']?>
                        [<a href="Admin-File-edit.html?fid=<?=$list['fid']?>">修改</a>]
                        [<a href="Admin-File-del.html?fid=<?=$list['fid']?>" class="btn-delete">删除</a>]</li>
                <?php }?>
            </ul>
        </div>
    <?php }?>
</block>