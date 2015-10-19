<?php
namespace Worker\Controller;
use Think\Controller;
class AccountController extends Controller {
    public function __construct(){
        parent::__construct();

        if(ACTION_NAME != 'login'){
            $publicHead = workerHead();
            $this->publicHead = $publicHead;
            $this->assign('publicHead', $publicHead);
        }
    }

    public function login(){
        $where['username'] = I('username');
        $where['status'] = 1;
        $user = M('worker')->where($where)->find();
        if(!$user){
            $this->error('用户不存在');
        }
        if(!checkPasswd(I('password'), $user['password'])) $this->error('密码不正确');

        $this->setcookie($user['wid']."\t".$user['username']."\t".$user['name']."\t".$user['isadmin']);
        $this->success('登陆成功', '/Worker.html');
        exit();
    }

    public function index(){
        $worker = getWorkerData();

        $this->assign('worker', $worker);
        $this->display();
    }

    public function log(){
        $page = ($_GET['page']) ? I('page') : 1;
        $db = M('user_logs');
        $where = array(
            'user' => 'worker',
            'uid' => $this->publicHead['account']['wid']
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

    public function password(){
        if(IS_GET) $this->display();
        else{
            $worker = getWorkerData();

            if(!checkPasswd(I('oldpassword'), $worker['password'])) $this->error('旧密码错误');
            if($_POST['password'] == '') $this->error('新密码不能为空');
            if($_POST['password'] != $_POST['repassword']) $this->error('两次输入的密码不一致');

            $password = makePasswd(I('password'));
            M('worker')->where(array('wid'=>$worker['wid']))->setField('password', $password);

            S('worker_'.$worker['wid'], null);
            $this->success('修改成功', '/Worker-Account.html');
        }
    }

    private function setcookie($string){
        cookie('worker', authCode($string, 'ENCODE'));
    }


}