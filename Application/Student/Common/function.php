<?php
/*
 * 检测输入的验证码是否正确，$code为用户输入的验证码字符串
 */
function check_verify($code, $id = 0){
    $verify = new \Think\Verify();
    return $verify->check($code, $id);
}

/*
 * 公共头部处理
 */
function studentHead(){
    $return = array(
        'account' => getStudentData()
    );
    return $return;
}




function add_fail($type, $uid = ''){
    if($uid == ''){
        $account = deAccountCookie();
        $uid = $account['uid'];
    }

    $data = array(
        'uid' => $uid,
        'type' => $type,
        'expire' => time()+86400
    );
    M('account_fail')->add($data);
}

function count_fail($type, $uid = ''){
    if($uid == ''){
        $account = deAccountCookie();
        $uid = $account['uid'];
    }

    $data = array(
        'uid' => $uid,
        'type' => $type,
    );
    return M('account_fail')->where($data)->count();
}