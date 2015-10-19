<?php
if(count($logs)<1) echo '没有历史记录';
else foreach($logs as $log){
    $user = $users[$log['user'].'~'.$log['uid']];
    //$id = ($user['sid']) ? $user['sid'] : $user['wid'];

    echo '<p><strong>'.$user['name'].'</strong> 于 <strong>'.date('Y-m-d H:i', $log['time']).'</strong> 进行 <strong>'.getTitle('log~'.$log['type']).'</strong> 操作';
    if($log['reason']) echo ', 原因：'.$log['reason'];
    echo "</p>";
}