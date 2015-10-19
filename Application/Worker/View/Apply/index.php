<extend name="Public:templet" />
<block name="title">申请管理</block>
<block name="main">
    <?php if(!$_GET['uid']){?>
        <div class="row">
            <div class="col-md-9">
                <ul class="nav nav-pills">
                    <?php $stutype = ($_GET['stutype']) ? I('stutype') : 'all';?>
                    <li role="presentation" id="status-0"><a href="/Worker-Apply.html?status=0&stutype=<?=$stutype?>">待审核</a></li>
                    <li role="presentation" id="status-1"><a href="/Worker-Apply.html?status=1&stutype=<?=$stutype?>">待打印</a></li>
                    <li role="presentation" id="status-all"><a href="/Worker-Apply.html?status=all&stutype=<?=$stutype?>">所有</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <div class="dropdown">
                    <?php
                    $status = (isset($_GET['status'])) ? I('status') : '0';
                    ?>
                    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                        <?=($stutype == 'all') ? '所有学生类型' : getTitle('student_type~'.$stutype)?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="/Worker-Apply.html?status=<?=$status?>">所有学生类型</a></li>
                        <?php foreach($stuArray as $i=>$v){?>
                            <li role="presentation"><a role="menuitem" tabindex="-1" href="/Worker-Apply.html?stutype=<?=$i?>&status=<?=$status?>"><?=$v?></a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
            <div class="col-md-1 text-right">

                <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#filter">筛选</a>
            </div>
        </div>
        <hr>
    <?php }?>
    <?php if(count($applies) < 1) echo '没有符合当前筛选条件的证明';
    else{?>
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>申请编号</th>
                <th>申请类型</th>
                <th>学生姓名</th>
                <th>学生类型</th>
                <th>申请时间</th>
                <th>申请状态</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($applies as $apply){?>
                <tr>
                    <td><?=$apply['code']?></td>
                    <td><?=$moduleArray[$apply['type']]?></td>
                    <td><a href="/Worker-Student-detail.html?uid=<?=$apply['uid']?>" target="_blank" data-skip-pjax="true"><?=$apply['name']?></a></td>
                    <td><?=getTitle('student_type~'.$apply['stutype'])?></td>
                    <td><?=date('Y-m-d', $apply['creattime'])?></td>
                    <td><?=getTitle('apply_status~'.$apply['status'])?></td>
                    <td>
                        <?php switch($apply['status']){
                            case 0:
                                echo '<a class="btn btn-primary btn-xs" href="/Worker-Apply-verify.html?aid='.$apply['aid'].'" target="_blank" data-skip-pjax="true">审核</a>';
                                break;

                            case 1:
                                echo '<a class="btn btn-success btn-xs" href="/Worker-Apply-view.html?aid='.$apply['aid'].'" target="_blank" data-skip-pjax="true">打印</a>&nbsp;';

                            default:
                                echo '<a class="btn btn-default btn-xs" href="/Worker-Apply-detail.html?aid='.$apply['aid'].'" target="_blank" data-skip-pjax="true">查看</a>';
                        }?>
                    </td>
                </tr>
            <?php }?>
            </tbody>
        </table>
        <?php if($pages != 1){
            unset($_GET['page'], $_GET['_pjax']);
            $url = '/Worker-Apply.html?'.http_build_query($_GET).'&page=';
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
    <!-- Filter -->
    <div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="filterLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="filterLabel">筛选申请</h4>
                </div>
                <form class="form-horizontal" id="filter-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="aid" class="col-sm-3 control-label">申请编号</label>
                            <div class="col-sm-7">
                                <input id="aid" name="aid" type="text" class="form-control" placeholder="支持模糊搜索" value="<?=I('aid')?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="status" class="col-sm-3 control-label">申请状态</label>
                            <div class="col-sm-7">
                                <select name="status" id="status" class="form-control">
                                    <option value="all">所有状态</option>
                                    <?php
                                    $now = isset($_GET['status']) ? I('status') : 0;
                                    foreach($statusArray as $i => $v){
                                        $selected = ($i == $now && $now != 'all') ? ' selected' : '';
                                    ?>
                                        <option value="<?=$i?>"<?=$selected?>><?=$v?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-sm-3 control-label">申请类型</label>
                            <div class="col-sm-7">
                                <select name="type" id="type" class="form-control">
                                    <option value="all">所有类型</option>
                                    <?php
                                    $now = I('type');
                                    foreach($moduleArray as $i=>$v){
                                        $selected = ($i == $now) ? ' selected' : '';
                                        ?>
                                        <option value="<?=$i?>"<?=$selected?>><?=$v?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="time" class="col-sm-3 control-label">申请时间</label>
                            <div class="col-sm-3">
                                <input id="fromDate" name="form" type="text" class="form-control" placeholder="YYYY-MM-DD" value="<?=I('from')?>">
                            </div>
                            <div class="col-sm-3">
                                <input id="toDate" name="to" type="text" class="form-control" placeholder="YYYY-MM-DD" value="<?=I('to')?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="stutype" class="col-sm-3 control-label">学生类型</label>
                            <div class="col-sm-7">
                                <select name="stutype" id="stutype" class="form-control">
                                    <option value="all">所有类型</option>
                                    <?php
                                    $now = I('stutype');
                                    foreach($stuArray as $i=>$v){
                                        $selected = ($i == $now) ? ' selected' : '';
                                        ?>
                                        <option value="<?=$i?>"<?=$selected?>><?=$v?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" value="筛选">
                    </div>
                </form>
            </div>
        </div>
    </div>
</block>