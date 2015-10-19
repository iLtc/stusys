<?php
namespace System\Controller;
use Think\Controller;
class LogController extends Controller {
    public function apply(){
        $code = I('code');
        $apply = M('apply')->where(array('code' => $code))->find();

        if(!$apply) $this->error('申请不存在');

        $logs = $this->getLog('apply~'.$apply['aid']);

        $users = array();
        foreach($logs as $log){
            if(!is_array($users[$log['user'].'~'.$log['uid']])){
                $users[$log['user'].'~'.$log['uid']] = $this->getUser($log['user'].'~'.$log['uid']);
            }
        }

        $this->assign('logs', $logs);
        $this->assign('users', $users);
        $this->display();
    }

    private function getLog($name){
        $name = explode('~', $name);
        $where = array('target'=>$name[0], 'targetId'=>$name[1]);
        return M('user_logs')->where($where)->order('id DESC')->select();
    }

    private function getUser($name){
        $name = explode('~', $name);
        switch($name[0]){
            case 'student':
                return getStudentData($name[1]);

            case 'worker':
                return getWorkerData($name[1]);
        }
    }
}