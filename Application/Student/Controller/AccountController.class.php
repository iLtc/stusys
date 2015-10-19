<?php
namespace Student\Controller;
use Think\Controller;
class AccountController extends Controller {
    public function __construct(){
        parent::__construct();

        isLogin(true);
        $publicHead = studentHead();
        $this->publicHead = $publicHead;
        $this->assign('publicHead', $publicHead);
    }

    public function index(){
        $auth = M('account_auth')->where(array('uid'=>$this->publicHead['account']['uid']))->getField('name', true);

        $this->assign('student', getStudentData());
        $this->assign('auth', $auth);
        $this->display();
    }

    public function edit(){
        $account = getStudentData();
        if(IS_GET){
            $this->assign('account', $account);

            $student_type = M('name_title')->where(array('type'=>'student_type'))->getField('value, title');
            $this->assign('student_type', $student_type);

            $this->display();
        }else{
            if(!checkPasswd(I('password'), $account['password'])) $this->error('当前密码错误');

            if(I('phone') != $account['phone']){
                $account['phone'] = I('phone');
                $account['phoneverified'] = 0;
            }
            if(I('email') != $account['email']){
                $account['email'] = I('email');
                $account['emailverified'] = 0;
            }

            $account['stutype'] = I('stutype');
            $account['isaddress'] = I('isaddress');
            $account['address'] = I('address');
            $account['major'] = I('major');

            M('account')->save($account);
            $this->updateStudent($account['uid']);
            userLog('user_edit', 'student~'.$this->publicHead['account']['uid'], 'student~'.$this->publicHead['account']['uid']);
            $this->success('修改成功，请重新登录', '/Sign-logout.html');
        }
    }

    public function password(){
        if(IS_GET) $this->display();
        else{
            $account = getStudentData();

            if(!checkPasswd(I('oldpassword'), $account['password'])) $this->error('旧密码错误');
            if($_POST['password'] == '') $this->error('新密码不能为空');
            if($_POST['password'] != $_POST['repassword']) $this->error('两次输入的密码不一致');

            $password = makePasswd(I('password'));
            M('account')->where(array('uid'=>$account['uid']))->setField('password', $password);

            $this->updateStudent($account['uid']);
            userLog('user_password', 'student~'.$this->publicHead['account']['uid'], 'student~'.$this->publicHead['account']['uid']);
            $this->success('修改成功，请重新登录', '/Sign-logout.html');
        }
    }

    public function send(){
        $db = M('account_verify');
        $type = I('get.type');
        if($type != 'email' && $type != 'phone') $this->error('非法请求');
        $this->assign('type', $type);

        $student = getStudentData();
        if($student[$type.'verified']){
            redirect('/Account.html#info');
            exit;
        }
        $this->assign('target', $student[$type]);

        if(IS_GET){
            $this->display();
        }else{
            if(!check_verify(I('code'))) $this->error('验证码错误');

            $data = array(
                'uid' => $this->publicHead['account']['uid'],
                'type' =>$type
            );
            $count = $db->where($data)->count();
            if($count > 2) $this->error('您过去24小时内获取校验码次数过多，请24小时后再试');
            $last = $db->where($data)->order('vid DESC')->find();
            if($last['expire'] - 86400 + 180 > time())
                $this->error('您每3分钟只能获取一次校验码，请稍候再试');

            $data['code'] = rand(100000, 999999);
            $data['expire'] = time() + 86400;
            $db->add($data);

            if($type == 'email'){
                $replace = array(
                    'name' => $student['name'],
                    'code' => $data['code']
                );

                $templet = replace('system-email-verify', $replace);
                sendEmail($student['email'], $templet['title'], $templet['content'], true);
            }

            if($type == 'phone'){
                $replace = array(
                    'code' => $data['code']
                );

                $templet = replace('system-phone-verify', $replace);
                sendPhone($student['phone'], $templet['content'], true);
            }

            $this->success('校验码已发送', "/Account-verify.html?type=$type&send=1");
        }
    }

    public function verify(){
        $db = M('account_verify');
        $type = I('get.type');
        if($type != 'email' && $type != 'phone') $this->error('非法请求');
        $this->assign('type', $type);

        $student = getStudentData();
        if($student[$type.'verified']){
            redirect('/Account.html#info');
            exit;
        }
        $this->assign('target', $student[$type]);

        if(IS_GET){
            $this->display();
        }else{
            if(count_fail($type) > 7) $this->error('您在24小时内校验失败次数过多，请24小时后再试');
            $data = array(
                'uid' => $this->publicHead['account']['uid'],
                'type' => $type,
                'code' => I('verify')
            );
            $ret = $db->where($data)->find();

            if($ret){
                unset($data['code']);
                $db->where($data)->delete();

                M('account')->where(array('uid', $data['uid']))->setField($type.'verified', 1);
                $this->updateStudent();
                userLog('user_verify', 'student~'.$this->publicHead['account']['uid'], 'student~'.$this->publicHead['account']['uid']);
                $this->success('校验成功', '/Account.html#info');
            }else{
                add_fail($type);
                $this->error('校验失败，校验码不正确');
            }
        }
    }

    public function remove(){
        $name = I('name');

        $where = array(
            'uid' => $this->publicHead['account']['uid'],
            'name' => $name
        );
        M('account_auth')->where($where)->delete();

        $this->updateStudent($this->publicHead['account']['uid']);
        userLog('user_remove', 'student~'.$this->publicHead['account']['uid'], 'student~'.$this->publicHead['account']['uid']);
        $this->success('解除成功');
    }

    public function log(){
        $page = ($_GET['page']) ? I('page') : 1;
        $db = M('user_logs');
        $where = array(
            'user' => 'student',
            'uid' => $this->publicHead['account']['uid']
        );

        $count = $db->where($where)->count();
        $pages = ceil($count/15);
        if($page > $pages) $page = $pages;

        $logs = $db->where($where)->page($page, 15)->order('id DESC')->select();

        $this->assign('logs', $logs);
        $this->assign('page', $page);
        $this->assign('pages', $pages);

        $this->display();
    }

    private function updateStudent($uid = ''){
        if($uid == ''){
            $account = deAccountCookie();
            $uid = $account['uid'];
        }

        S('student_'.$uid, null);
    }
}
