<extend name="Public:templet" />
<block name="title">学生管理</block>
<block name="main">
    <div class="row">
        <div class="col-md-6">
            <?php if(I('search')){echo '<p>搜索：'.I('search').'</p>';}?>
        </div>
        <div class="col-md-6 text-right">
            <a class="btn btn-primary" data-toggle="modal" data-target="#search" href="#">搜索</a>
        </div>
    </div>
    <hr>
    <?php if(count($students) < 1) echo '没有符合当前条件的学生';
    else{?>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>姓名</th>
                <th>性别</th>
                <th>学号</th>
                <th>类型</th>
                <th>入学年份</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($students as $student){?>
                <tr>
                    <td><?=$student['name']?></td>
                    <td><?php if($student['sex'] == 'F') echo '女';else echo '男';?></td>
                    <td><?=$student['sid']?></td>
                    <td><?=getTitle('student_type~'.$student['stutype'])?></td>
                    <td><?=$student['year']?></td>
                    <td>
                        <a class="btn btn-primary btn-xs" href="/Worker-Student-detail.html?uid=<?=$student['uid']?>" data-skip-pjax="true" target="_blank">详情</a>
                        <a class="btn btn-default btn-xs" href="/Worker-Apply.html?uid=<?=$student['uid']?>" data-skip-pjax="true" target="_blank">历史</a>
                        <a class="btn btn-info btn-xs" href="/Worker-Student-detail.html?uid=<?=$student['uid']?>#send" data-skip-pjax="true" target="_blank">通知</a>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
        <?php if($pages != 1){
            unset($_GET['page'], $_GET['_pjax']);
            $url = '/Worker-Student.html?'.http_build_query($_GET).'&page=';
            ?>
            <nav class="text-center">
                <ul class="pagination">
                    <?php if($page > 1){?>
                        <li>
                            <a href="<?=$url.($page-1)?>" aria-label="Previous">
                                <span aria-hidden="true">上一页</span>
                            </a>
                        </li>
                    <?php }?>
                    <?php
                    if($page < 4) $from = 1;
                    else $from = $page - 3;
                    if($pages - $page < 4) $to = $pages;
                    else $to = $page + 3;

                    for($i=$from; $i<=$to; $i++){?>
                        <li <?php if($page == $i) echo ' class="active"'?>><a href="<?=$url.$i?>"><?=$i?></a></li>
                    <?php }?>
                    <?php if($page < $pages){?>
                        <li>
                            <a href="<?=$url.($page+1)?>" aria-label="Next">
                                <span aria-hidden="true">下一页</span>
                            </a>
                        </li>
                    <?php }?>
                </ul>
            </nav>
        <?php }?>
    <?php }?>
    <!-- Search -->
    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="searchLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="searchLabel">搜索学生</h4>
                </div>
                <form class="form-horizontal" id="search-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="search" class="col-sm-3 control-label">关键字</label>
                            <div class="col-sm-7">
                                <input id="keyword" name="search" type="text" class="form-control" placeholder="姓名/学号/手机/邮箱，支持模糊搜索" value="<?=I('search')?>">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="搜索">
                    </div>
                </form>
            </div>
        </div>
    </div>
</block>