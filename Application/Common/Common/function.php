<?php
/*
 * 加/解密函数
 */
function authCode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    if($key == '') $key = C('authcode');
    $ckey_length = 4;
    $key = md5($key ? $key : UC_KEY);
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

/*
 * 不编码中文的Json转换(先将汉字urlencode,Json转换后再urldecode)
 */
function urlencodeArray($array){
    if(is_array($array)){
        foreach($array as $index=>$value){
            $array[$index] = urlencodeArray($value);
        }
    }else{
        $array = str_replace('"', "'", $array);
        $array = urlencode($array);
    }
    return $array;
}
function json($array){
    $array = urlencodeArray($array);
    $temp = json_encode($array);
    return urldecode($temp);
}

/*
 * 读取用户信息
 */
function deAccountCookie(){
    if(cookie('account') != '' && $temp = explode("\t", authCode(cookie('account')))){
        $user = array(
            'uid' => $temp[0],
            'name' => $temp[1],
            'stutype' => $temp[2]
        );
        return $user;
    }else{
        return false;
    }
}

/*
 * 读取工作人员信息
 */
function deWorkerCookie(){
    if(cookie('worker') != '' && $temp = explode("\t", authCode(cookie('worker')))){
        $user = array(
            'wid' => $temp[0],
            'username' => $temp[1],
            'name' => $temp[2],
            'isadmin' => $temp[3]
        );
        return $user;
    }else{
        return false;
    }
}

/*
 * 判断用户是否已登录，未登录可以接受自动跳转
 */
function isLogin($redirect = false){
    if(deAccountCookie() || deWorkerCookie()) return true;
    else{
        if(!$redirect) return false;
        else{
            redirect('Sign-agreement.html');
        }
    }
}

function isWorker(){
    if(deWorkerCookie()) return true;
    else redirect('Sign-agreement.html');
}

function isAdmin(){
    if(($worker = deWorkerCookie()) && $worker['isadmin']) return true;
    else redirect('Sign-agreement.html');
}

/*
 * 获取指定模板
 */
function getTemplet($name){
    $fullname = $name;
    $name = explode('-', $name);
    $where = array(
        'module' => $name[0],
        'type' => $name[1],
        'name' => $name[2]
    );
    $templet = M('system_templet')->where($where)->cache('templet_'.$fullname)->find();
    if(!$templet) return false;
    else{
        return array(
            'title'=>$templet['title'],
            'content'=>$templet['content']
        );
    }
}

/*
* 检测 pjax 请求
*/
function is_pjax_request(){
    return (isset($_SERVER['HTTP_X_PJAX']) && $_SERVER['HTTP_X_PJAX'] == 'true');
}

/*
 *产生MD5码
 */
function randString($l = 32){
    $chars = '2345678abcdefhjkmnprstuvwxyzABCDEFGHJKLMNPQRTUVWXY';
    $str = '';
    for ( $i = 0; $i < $l; $i++ ) {
        $str .= $chars[ mt_rand(0, strlen($chars) - 1) ];
    }
    return $str;
}

function makePasswd($password){
    return crypt($password, '$6$'.randString(16).'$');
}

function checkPasswd($test, $true){
    return crypt($test, substr($true, 0, 20)) === $true;
}

/*
 * 读取配置参数
 */
function getConfig($name){
    $value = M('system_config')->where(array('name'=>$name))->cache('config_'.$name)->getField('value');
    return $value;
}

/*
 * 缩短网址
 */
function short_url($link){
    //TODO: 考虑多链接的情况
    $url = 'http://api.t.sina.com.cn/short_url/shorten.json?url_long='.urlencode($link).'&source='.getConfig('weibo_appkey');
    $result = json_decode(curlGet($url), true);
    return $result[0]['url_short'];
}

/*
 * curl POST请求
 */
function curlPost($url, $post){
    $ch = curl_init();//初始化curl

    curl_setopt($ch,CURLOPT_URL, $url);//抓取指定网页
    curl_setopt($ch, CURLOPT_HEADER, 0);//设置header
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
    curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $data = curl_exec($ch);//运行curl
    curl_getinfo($ch,CURLINFO_HTTP_CODE); //我知道HTTPSTAT码哦～
    curl_close($ch);

    return $data;
}

/*
 * curl GET请求
 */
function curlGet($url){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $output = curl_exec($ch);
    curl_close($ch);
    return $output;
}


function userLog($type, $target, $user, $reason = ''){
    $target = explode('~', $target);
    $user = explode('~', $user);
    $logData = array(
        'type'=>$type,
        'reason'=>$reason,
        'target'=>$target[0],
        'targetId'=>$target[1],
        'user'=>$user[0],
        'uid'=>$user[1],
        'uid'=>$user[1],
        'action_path'=>MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,
        'request_method'=>REQUEST_METHOD,
        'request'=>json($_REQUEST),
        'time'=>time(),
        'ip'=>get_client_ip()
    );

    M('user_logs')->add($logData);
}

/*
 * 系统日志
 */
function systemLog($info, $data='', $level = 'Notice'){
    if(is_array($data)) $data = json($data);
    $action_path = MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME;
    $request_method = REQUEST_METHOD;
    $request = json($_REQUEST);

    $logData = array(
        'level'=>$level,
        'info'=>$info,
        'data'=>$data,
        'action_path'=>$action_path,
        'request_method'=>$request_method,
        'request'=>$request,
        'time'=>time(),
        'ip'=>get_client_ip()
    );

    M('system_logs')->add($logData);
}

function getFileList(){
    $file_class = M('file_class')->order('`sort` DESC')->cache('file_class')->select();

    if(S('file_list')){
        $file_list = S('file_list');
    }else{
        $db = M('file_list');
        foreach($file_class as $class){
            $file_list[$class['fcid']] = $db->where(array('fcid'=>$class['fcid']))->order('`sort` DESC')->select();
        }
        S('file_list', $file_list);
    }

    return array(
        'class' => $file_class,
        'list' => $file_list
    );
}

function getModuleList(){
    return M('module')->where(array('status'=>1))->order('`sort` DESC')->cache('module_list')->select();
}

function getModule($type){
    return M('module')->where(array('type'=>$type))->cache('module_'.$type)->find();
}

function getModuleArray(){
    return M('module')->order('`sort` DESC')->cache('module_array')->getField('type, title');
}

function getStatusArray(){
    return M('name_title')->where(array('type'=>'apply_status'))->cache('status_array')->getField('value, title');
}

function getStuArray(){
    return M('name_title')->where(array('type'=>'student_type'))->cache('stu_array')->getField('value, title');
}

function getFormList($type){
    return M('apply_form')->where(array('module'=>$type))->order('`sort` DESC, fid ASC')->cache('form_list_'.$type)->select();
}

function sendEmail($address, $title, $content, $force = false){
    if(!$force){
        if(!M('account')->where(array('email'=>$address))->getField('emailverified')){
            systemLog('email_no_verify', array($address, $title, $content));
            return false;
        }
    }

    $data = array(
        'address' => $address,
        'title' => $title,
        'content' => $content
    );

    addTask('email', $data, $force);
}

function sendPhone($address, $content, $force = false){
    if(!$force){
        if(!M('account')->where(array('phone'=>$address))->getField('phoneverified')){
            systemLog('phone_no_verify', array($address, $content));
            return false;
        }
    }

    $data = array(
        'address' => $address,
        'content' => $content.'－'.getConfig('sms_name')
    );

    addTask('phone', $data, $force);
}

function mkConMd5($data){
    return md5(json($data).C('authcode'));
}

function checkMd5($data, $md5){
    if(mkConMd5($data) == $md5)
        return true;
    else{
        systemLog('md5CheckError', array($md5, mkConMd5($data)), 'Error');
        die('Access Denied');
    }
}

function addTask($type, $data, $prior = false){
    if(isSae()){
        $data['md5'] = mkConMd5($data);

        $queue = new SaeTaskQueue('send');
        $queue->addTask("/System-Task-$type.html", http_build_query($data), $prior);
        $ret = $queue->push();

        if($ret === false)
            systemLog('addTaskFail', array($type, $data, $prior, $queue->errno(), $queue->errmsg()), 'Error');
    }else{
            systemLog('addTaskFail', 'not in sae');
    }
}

/*
 * 替换信息
 */
function replace($name, $replace){
    $templet = getTemplet($name);
    foreach($replace as $index => $value){
        if(is_array($value)){
            foreach($value as $i => $v) $templet['content'] = str_replace('{$'.$index.'.'.$i.'}', $v, $templet['content']);
        }else $templet['content'] = str_replace('{$'.$index.'}', $value, $templet['content']);
    }
    return $templet;
}

function getStudentData($uid = ''){
    if($uid == ''){
        $account = deAccountCookie();
        $uid = $account['uid'];
    }

    return M('account')->where(array('uid'=>$uid))->cache('student_'.$uid)->find();
}

function getWorkerData($wid = ''){
    if($wid == ''){
        $account = deWorkerCookie();
        $wid = $account['wid'];
    }

    return M('worker')->where(array('wid'=>$wid))->cache('worker_'.$wid)->find();
}

function getTitle($code){
    $name = explode('~', $code);
    $where = array(
        'type' => $name[0],
        'value' => $name[1]
    );

    $title = M('name_title')->where($where)->cache('title_'.$code)->getField('title');

    if($title) return $title;
    else return '未知操作';
}

function isSae(){
    return C('IS_SAE');
}

/*
 * 检查Email格式
 */
function checkEmail($email){
    $atIndex = strrpos($email, "@");
    if (is_bool($atIndex) && !$atIndex){
        return false;
    }else{
        $domain = substr($email, $atIndex+1);
        $local = substr($email, 0, $atIndex);
        $localLen = strlen($local);
        $domainLen = strlen($domain);
        if ($localLen < 1 || $localLen > 64){
            // local part length exceeded
            return false;
        }else if ($domainLen < 1 || $domainLen > 255){
            // domain part length exceeded
            return false;
        }else if ($local[0] == '.' || $local[$localLen-1] == '.'){
            // local part starts or ends with '.'
            return false;
        }else if (preg_match('/\\.\\./', $local)){
            // local part has two consecutive dots
            return false;
        }else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain)){
            // character not valid in domain part
            return false;
        }else if (preg_match('/\\.\\./', $domain)){
            // domain part has two consecutive dots
            return false;
        }else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
            str_replace("\\\\","",$local))){
            // character not valid in local part unless
            // local part is quoted
            if (!preg_match('/^"(\\\\"|[^"])+"$/',
                str_replace("\\\\","",$local))){
                return false;
            }
        }
        if (!checkdnsrr($domain,"MX")){
            // domain not found in DNS
            return false;
        }
    }
    return true;
}

