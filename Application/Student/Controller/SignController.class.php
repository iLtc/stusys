<?php
namespace Student\Controller;
use Think\Controller;
class SignController extends Controller {
    public function __construct(){
        parent::__construct();
        $publicHead = studentHead();
        $this->publicHead = $publicHead;
        $this->assign('publicHead', $publicHead);
    }

    public function agreement(){
        $templet = getTemplet('account-agreement-agreement');
        $this->assign('templet', $templet);
        $this->display();
    }

    public function register(){
        if(IS_GET){
            if(isLogin(false)){
                redirect('/Sign-logout.html');
            }

            $student_type = M('name_title')->where(array('type'=>'student_type'))->cache('student_type')->getField('value, title');
            $this->assign('student_type', $student_type);
            $this->assign('auth', I('auth'));

            $this->display();
        }else{//TODO:完善验证
            $auth = I('get.auth');
            $systemAccount = A('System/Account');

            $notNull = array('year', 'name', 'sid', 'phone', 'email', 'major');
            $mustNum = array('year', 'sid', 'phone');

            if(!auth){
                $notNull[] = 'password';
                $notNull[] = 'repassword';
            }

            foreach($notNull as $index){
                if($_POST[$index] == '') $this->error('请填写所有空格');
            }
            foreach($mustNum as $index){
                if(!is_numeric($_POST[$index])) $this->error('“入学年份”、“电话”和“学号”应为数字');
            }
            if(!check_verify($_POST['code'], 'reg')) $this->error('验证码不正确');
            if(!checkEmail($_POST['email'])) $this->error('电子邮箱格式不正确');
            $systemAccount->unique('email', $_POST['email'], 1);
            if(strlen($_POST['phone']) !== 11) $this->error('请填写11位手机号码');
            $systemAccount->unique('phone', $_POST['phone'], 1);
            if($_POST['password'] != $_POST['repassword']) $this->error('两次填写的密码不一致');
            $sidLength = strlen($_POST['sid']);
            if($sidLength < 9 || $sidLength > 13) $this->error('学号位数不正确');
            $systemAccount->unique('sid', $_POST['sid'], 1);
            if(strlen($_POST['year']) !== 4) $this->error('入学年份应为4位');

            $db = M('account');
            $db->create();

            if($auth) $db->password = makePasswd(randString(32));
            else $db->password = makePasswd($db->password);

            $uid = $db->add();
            $this->setcookie($uid, I('name'), I('stutype'));

            $this->finishpendingauth('', $uid);
            userLog('user_register', 'student~'.$uid, 'student~'.$uid);
            $this->success('注册成功', '/Sign-finish.html');
        }
    }

    public function finish(){
        isLogin(true);
        $this->display();
    }

    public function login(){
        if(!IS_POST){
            $this->error('非法请求');
        }else{
            if($_POST['username'] == '' || $_POST['password'] == '' || $_POST['code'] == '') $this->error('请填写所有空格');

            if(!check_verify($_POST['code'], 'login')) $this->error('验证码不正确');

            $username = I('username');
            if(is_numeric($username)){
                if(strlen($username) == 11) $where['phone'] = $username;
                else $where['sid'] = $username;
            }else $where['email'] = $username;

            $user = M('account')->where($where)->find();
            if(!$user){
                A('Worker/Account')->login();
            }
            if(!checkPasswd(I('password'), $user['password'])) $this->error('密码不正确');

            $this->setcookie($user['uid'], $user['name'], $user['stutype']);

            $this->finishpendingauth('', $user['uid']);
            userLog('user_login', 'student~'.$user['uid'], 'student~'.$user['uid']);
            $this->success('登陆成功', '/Student.html');
        }
    }

    public function logout(){
        cookie('account', NULL);
        cookie('worker', NULL);
        redirect('/Sign-register.html');
    }

    public function forget(){
        if(IS_GET) $this->display();
        else{
            if(!check_verify(I('code'))) $this->error('验证码不正确');

            $where = array(
                'name' => I('name'),
                'sid' => I('sid')
            );

            $target = I('target');
            if(is_numeric($target)) $where['phone'] = $target;
            else $where['email'] = $target;
            $type = is_numeric($target) ? 'phone' : 'email';
            $typeC = ($type == 'phone') ? '手机号码' : '邮箱地址';

            $db = M('account');

            $account = $db->where($where)->find();
            if(!$account) $this->error('匹配不到该用户', '/Sign-forget.html?error=user');
            if(!$account[$type.'verified']) $this->error('该'.$typeC.'没有通过校验', '/Sign-forget.html?error='.$type);

            $password = randString(7);
            $db->where(array('uid'=>$account['uid']))->setField('password', makePasswd($password));

            $replace = array(
                'name' => $account['name'],
                'password' => $password
            );
            $templet = replace('System-'.$type.'-forget', $replace);

            if($type == 'phone') sendPhone($account['phone'], $templet['content'], true);
            else sendEmail($account['email'], $templet['title'], $templet['content'], true);

            S('student_'.$account['uid'], null);
            $this->success('新密码发送成功', '/Sign-register.html?send=1');
        }
    }

    public function auth(){
        $name = I('name');

        $state = randString(32);
        session('state', $state);
        switch($name){
            case 'wb':
                $url = 'https://api.weibo.com/oauth2/authorize?response_type=code&client_id='.getConfig('weibo_appkey').'&redirect_uri='.urlencode('https://stusys.sinaapp.com/Sign-callback.html?name=wb').'&state='.$state;
                break;

            case 'qq':
                $url = 'https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id='.getConfig('qq_id').'&redirect_uri='.urlencode('https://stusys.sinaapp.com/Sign-callback.html?name=qq').'&state='.$state;
                break;

            default:
                $this->error('非法请求');
        }
        redirect($url);
    }

    public function callback(){
        $name = I('name');
        $state = I('state');
        $code = I('code');

        if($state != session('state')){
            $this->error('请求超时', '/');
        }else{
            session('state', NULL);
        }

        switch($name){
            case 'wb':
                $url = 'https://api.weibo.com/oauth2/access_token';
                $request = array(
                    'grant_type' => 'authorization_code',
                    'client_id' => getConfig('weibo_appkey'),
                    'client_secret' => getConfig('weibo_secret'),
                    'code' => $code,
                    'redirect_uri' => 'https://stusys.sinaapp.com/Sign-callback.html?name=wb'
                );
                break;

            case 'qq':
                $url = 'https://graph.qq.com/oauth2.0/token';
                $request = array(
                    'grant_type' => 'authorization_code',
                    'client_id' => getConfig('qq_id'),
                    'client_secret' => getConfig('qq_key'),
                    'code' => $code,
                    'redirect_uri' => 'https://stusys.sinaapp.com/Sign-callback.html?name=qq'
                );
                break;

            default:
                $this->error('非法请求');
        }

        $access_token_result = curlPost($url, http_build_query($request));

        $request = '';
        switch($name){
            case 'wb':
                $access_token_result = json_decode($access_token_result, true);
                $url = 'https://api.weibo.com/oauth2/get_token_info';
                $request['access_token'] = $access_token_result['access_token'];
                break;

            case 'qq':
                parse_str($access_token_result, $access_token_result);
                $url = 'https://graph.qq.com/oauth2.0/me';
                $request['access_token'] = $access_token_result['access_token'];
                break;
        }
        $user_id_result = curlPost($url, http_build_query($request));

        switch($name){
            case 'wb':
                $user_id_result = json_decode($user_id_result, true);
                $auth = array(
                    'oid' => $user_id_result['uid'],
                    'name' => 'wb'
                );
                break;

            case 'qq':
                $lpos = strpos($user_id_result, "(");
                $rpos = strrpos($user_id_result, ")");
                $user_id_result = substr($user_id_result, $lpos+1, $rpos-$lpos-1);
                $user_id_result = json_decode($user_id_result, true);
                $auth = array(
                    'oid' => $user_id_result['openid'],
                    'name' => 'qq'
                );
                break;
        }


        $ret = M('account_auth')->where($auth)->find();
        if($ret){//已绑定
            if(isLogin(false)){//已登陆
                if($ret['uid'] == $this->publicHead['account']['uid']){//已绑定
                    redirect('/Account.html#auth');
                }else{//已绑定其他账号
                    $this->error('该微博/QQ账号已与其他账号绑定，请重试');
                }
            }else{//未登录，进行登陆
                $student = getStudentData($ret['uid']);
                $this->setcookie($student['uid'], $student['name'], $student['stutype']);
                $this->finishpendingauth();
                userLog('user_login', 'student~'.$ret['uid'], 'student~'.$ret['uid']);
                redirect('/Student.html');
            }
        }else{//未绑定
            if(isLogin(false)){//已登陆，进行绑定
                $this->finishpendingauth($auth);
                redirect('/Account.html#auth');
            }else{//未登录，获取用户昵称，保存Cookie并提示
                switch($name){
                    case 'wb':
                        $url = 'https://api.weibo.com/2/users/show.json';
                        $request['uid'] = $user_id_result['uid'];
                        break;

                    case 'qq':
                        $url = 'https://graph.qq.com/user/get_user_info';
                        $request['oauth_consumer_key'] = getConfig('qq_id');
                        $request['openid'] = $user_id_result['openid'];
                        break;
                }

                $user_info_result = json_decode(curlGet($url.'?'.http_build_query($request)), true);

                switch($name){
                    case 'wb':
                        $nickname = $user_info_result['screen_name'];
                        break;

                    case 'qq':
                        $nickname = $user_info_result['nickname'];
                        break;
                }

                cookie('auth', authCode($auth['name'].'_'.$auth['oid'], 'ENCODE'));
                redirect('/Sign-register.html?auth=1&nickname='.$nickname.'&type='.$name);
            }
        }
    }

    private function finishpendingauth($auth = '', $uid = ''){
        if($auth == '')
            if(cookie('auth')){
                $tmp = explode('_', authCode(cookie('auth')));
                cookie('auth', NULL);
                $auth = array(
                    'name' => $tmp[0],
                    'oid' => $tmp[1]
                );
            }
        if($uid == '') $uid = $this->publicHead['account']['uid'];

        if($auth != '' && $uid != ''){
            $auth['uid'] = $uid;
            M('account_auth')->add($auth);
            userLog('user_auth', 'student~'.$uid, 'student~'.$uid);
        }
    }

    private function setcookie($uid, $name, $stutype){
        cookie('account', authCode($uid."\t".$name."\t".$stutype, 'ENCODE'));
    }
}