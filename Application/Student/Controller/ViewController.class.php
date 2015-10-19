<?php
namespace Student\Controller;
use Think\Controller;
class ViewController extends Controller {
    public function exce(){
        $w['type'] = 'exce';
        $w['status'] = array('in', '1,2');
        $w['creattime'] = array('GT', time() - 1296000);
        $applies = M('apply')->where($w)->order('creattime DESC')->select();

        $logDb = M('user_logs');
        $where = array(
            'target' => 'apply',
            'type' => 'pass_apply'
        );
        foreach($applies as $i => $apply){
            if(!isset($students[$apply['uid']])) $students[$apply['uid']] = getStudentData($apply['uid']);

            $where['targetId'] = $apply['aid'];
            $log = $logDb->where($where)->find();
            $applies[$i]['wid'] = $log['uid'];

            if(!isset($workers[$log['uid']])) $workers[$log['uid']] = getWorkerData($log['uid']);

            $applies[$i]['data'] = json_decode($apply['data'], true);
        }
        $actionData = array(
            'applies' => $applies,
            'students' => $students,
            'workers' => $workers
        );

        $this->assign($actionData);
        $this->display();
    }
}
