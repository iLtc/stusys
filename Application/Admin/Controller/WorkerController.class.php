<?php
namespace Admin\Controller;
use Think\Controller;
class WorkerController extends AdminController {
    public function index(){
        $workers = D('Worker')->select();
        $this->assign('workers', $workers);

        $this->display();
    }

    public function edit(){
        $db = D('Worker');
        $wid = I('get.wid');
        if($wid && !($worker = $db->where(array('wid'=>$wid))->find())) $this->error('工作人员不存在');
        if($worker['wid'] == $this->publicHead['account']['wid']) $this->error('不能修改自己');

        if(IS_GET){
            $this->assign('worker', $worker);
            $this->display();
        }else{
            $name = I('name');
            $username = I('username');
            $password = I('password');
            $isadmin = I('isadmin');
            $staus = I('status');

            if($worker){//修改
                if(!$name) $this->error('请完整填写表单');
            }else{//新建
                if(!$name || !$username || !$password) $this->error('请完整填写表单');

                $worker['username'] = $username;
            }

            $worker['name'] = $name;
            if($password) $worker['password'] = makePasswd($password);
            $worker['isadmin'] = $isadmin;
            $worker['status'] = $staus;

            if($wid){//修改
                $db->save($worker);

                $this->success('修改成功', '/Admin-Worker.html');
            }else{
                $db->add($worker);

                $this->success('添加成功', '/Admin-Worker.html');
            }
        }
    }
}