<?php
namespace Student\Controller;
use Think\Controller;
class ApplyController extends Controller {
    public function __construct(){
        parent::__construct();

        isLogin(true);

        $publicHead = studentHead();
        $this->publicHead = $publicHead;
        $this->assign('publicHead', $publicHead);

        if(ACTION_NAME == 'agreement' || ACTION_NAME == 'form'){
            $this->module = getModule(I('get.type'));
            if(!$this->module) $this->error('模块不存在');
        }
    }

    public function index(){
        $this->assign('modules', getModuleList());

        $student = getStudentData();
        $verify = array($student['phoneverified'], $student['emailverified']);
        $this->assign('verify', $verify);
        $this->display();
    }

    public function agreement(){
        $this->assign('templete', getTemplet('apply-agreement-'.$this->module['type']));
        $this->display();
    }

    public function form(){
        $list = getFormList($this->module['type']);

        $db = M('Apply');

        if(IS_GET){
            $this->assign('list', $list);
            $this->display();
        }else{
            //TODO:完善前端各种规则
            foreach($list as $data){
                $rule = explode(';', $data['rule']);
                if($data['type'] == 'upload') $save[$data['name']]['upload'] = true;
                for($i=0; $i<count($rule); $i++){
                    if($rule[$i] != ''){
                        switch($data['rule']){
                            case 'required':
                                if($_REQUEST[$data['name']] == '') $this->error('请填写“'.$data['title'].'”');
                                break;
                            case 'selcted':
                                if($_REQUEST[$data['name']] == '请选择...') $this->error('请选择“'.$data['title'].'”');
                                break;
                        }
                    }
                }
                $save[$data['name']]['title'] = $data['title'];
                $save[$data['name']]['value'] = str_replace("\r\n", '', $_REQUEST[$data['name']]);
            }

            $dbSave = array(
                'data' => json($save),
                'uid' => $this->publicHead['account']['uid'],
                'type' => I('get.type'),
                'creattime' => time(),
                'dealtime' => time(),
                'code' => rand(100000, 999999)
            );

            $aid = $db->add($dbSave);

            $applyid = date('Ymd').sprintf("%07d", $aid).rand(100000, 999999);
            $db->where(array('aid'=>$aid))->setField('code', $applyid);

            userLog('submit_apply', 'apply~'.$aid, 'student~'.$this->publicHead['account']['uid']);

            $replace = array(
                'name' => $this->publicHead['account']['name'],
                'module_name' => $this->module['title']
            );

            $templet = replace('system-email-receipt', $replace);
            sendEmail($this->publicHead['account']['email'], $templet['title'], $templet['content']);

            $this->success('申请已提交，请等待审核……', '/Apply-history.html');
        }
    }

    public function history(){
        $history = M('Apply')->where('uid = '.$this->publicHead['account']['uid'])->order('aid desc')->select();
        $this->assign('history', $history);
        $this->assign('moduleArray', getModuleArray());
        $this->display();
    }

    public function cancel(){
        $aid = I('aid');
        $db = M('Apply');

        $apply = $db->where(array('aid'=>$aid))->find();
        if($apply['status'] != -3 && $apply['status'] != 0) $this->error('当前状态不能撤销');

        $apply = $db->where(array('aid'=>$aid))->setField('status', -1);

        userLog('cancel_apply', 'apply~'.$aid, 'student~'.$this->publicHead['account']['uid']);
        $this->success('撤销成功');

        //TODO:发送撤销通知
    }
}
