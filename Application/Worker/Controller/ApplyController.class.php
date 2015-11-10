<?php
namespace Worker\Controller;
use Think\Controller;
class ApplyController extends Controller {
    public function __construct(){
        parent::__construct();
        $publicHead = workerHead();
        $this->publicHead = $publicHead;
        $this->assign('publicHead', $publicHead);

        $this->assign('moduleArray', getModuleArray());
    }

    public function index(){
        $page = ($_GET['page']) ? I('page') : 1;
        $db = M('apply');

        $uid = I('uid');
        $aid = I('aid');
        $status = ($_GET['status']) ? I('status') : 0;
        $type = ($_GET['type']) ? I('type') : 'all';
        $stutype = ($_GET['stutype']) ? I('stutype') : 'all';
        $fromDate = I('from');
        $toDate = I('to');

        if($fromDate != ''){
            $fromDate = explode('-', $fromDate);
            $from = mktime(0, 0, 0, $fromDate[1], $fromDate[2], $fromDate[0]);

            $toDate = explode('-', $toDate);
            $to = mktime(23, 59, 59, $toDate[1], $toDate[2], $toDate[0]);
        }

        if($uid){
            $where['apply.uid'] = $uid;
        }else{
            if($aid) $where['code'] = array('like', '%'.$aid.'%');
            if($status !== 'all') $where['status'] = $status;
            if($type !== 'all') $where['type'] = $type;
            if($stutype !== 'all') $where['account.stutype'] = $stutype;
            if($fromDate !== '')
                $where['creattime'] = array(array('gt', $from),array('lt', $to));
        }


        $count = $db->join('account ON apply.uid = account.uid')->where($where)->order('aid DESC')->count();
        $pages = ceil($count/15);
        if($page > $pages) $page = $pages;

        $applies = $db->join('account ON apply.uid = account.uid')->where($where)->page($page, 15)->order('aid DESC')->select();

        $this->assign('applies', $applies);

        $this->assign('statusArray', getStatusArray());
        $this->assign('stuArray', getStuArray());


        $this->assign('page', $page);
        $this->assign('pages', $pages);

        $this->display();
    }

    public function verify(){
        $aid = I('get.aid');
        $db = M('apply');
        $apply = $db->where(array('status'=>0, 'aid'=>$aid))->find();
        if(!$apply) $this->error('申请不存在或状态不为“待审核”');
        $module = getModule($apply['type']);

        if(IS_GET){
            $this->assign('apply', $apply);
            $this->assign('student', getStudentData($apply['uid']));
            $this->assign('module', $module);

            $this->display();
        }else{
            //$type = (strpos($_POST['type'], '通过') !== false) ? 1 : 0;
            $type = ($_POST['type'] == 'pass') ? 1 : 0;
            $reason = I('reason');
            $send = 1;
            //$print = I('print') ? 1 : 0;

            $apply['send'] = $send;
            $apply['dealtime'] = time();
            if($type == 1){
                if($module['print'] == 0) $apply['status'] = 2;
                else $apply['status'] = 1;
            }else{
                $apply['status'] = -2;
                if(!$reason) $this->error('请填写拒绝理由');
            }
            $db->save($apply);

            if($apply['status'] == 1 || $apply['status'] == 2) $log_type = 'pass_apply';
            else $log_type = 'refuse_apply';
            userLog($log_type, 'apply~'.$aid, 'worker~'.$this->publicHead['account']['wid'], $reason);

            //发送通知
            $student = getStudentData($apply['uid']);
            $replace = array(
                'name' => $student['name'],
                'time' => date('m月d日', $apply['creattime']),
                'module_name' => $module['title'],
                'reason' => $reason
            );
            if($type == 1){
                if($module['print'] == 0) $this->sendFinish($module['type'], $replace, $student); //通过申请但不用打印，发送通知
            }else{
                $templet = replace('system-email-refuse', $replace);
                sendEmail($student['email'], $templet['title'], $templet['content']);

                if($send){
                    $templet = replace('system-phone-refuse', $replace);
                    sendPhone($student['phone'], $templet['content']);
                }
            }

            if($type == 0 || !$module['print']){
                $redirect = 'javascript:window.close()';
            }else{
                $redirect = 'Worker-Apply-view.html?aid='.$apply['aid'];
            }
			
			//处理志愿时
			/*if($apply['type'] == 'volunteertime'){
				if($type == 1){
					$listes = json_decode(str_replace("\r\n", '', $apply['data']), true);
					$number = $listes['number']['value'];					
					if($number > 0) $this->volunteertime('add', $apply['aid'], $apply['uid'], $number);
					else $this->error('统计志愿时异常');
				}else{
					$this->volunteertime('del', $apply['aid'], $apply['uid']);
				}
			}*/

            $this->success('处理成功', $redirect);
        }
    }

    public function editapply(){
        $aid = I('get.aid');
        $db = M('Apply');
        $apply = $db->where(array('aid'=>$aid))->find();
        if(!$apply) $this->error('申请不存在');

        if(IS_GET){
            $this->assign('apply', $apply);
            $this->display();
        }else{
            if(($reason = I('reason')) == '') $this->error('请填写原因');
            $datas = json_decode($apply['data'], true);
            foreach($datas as $i => $data){
                if($_POST[$i] != '' && $data['value'] != I($i)) $datas[$i]['value'] = I($i);
            }
            $db->where(array('aid'=>$aid))->setField('data', json($datas));

            userLog('edit_apply', 'apply~'.$aid, 'worker~'.$this->publicHead['account']['wid'], $reason);
			
			//处理志愿时
			/*if($apply['type'] == 'volunteertime'){
				$number = $datas['number']['value'];
				$this->volunteertime('edit', $apply['aid'], $apply['uid'], $number);
			}*/

            $redirect = ($apply['status'] == 0) ? '/Worker-Apply-verify.html?aid='.$aid : '/Worker-Apply-detail.html?aid='.$aid;
            $this->success('保存成功', $redirect);
        }
    }

    public function view(){
        $aid = I('aid');
        $apply = M('Apply')->where(array('aid'=>$aid))->find();
        if(!$apply) $this->error('申请不存在');
        $module = getModule($apply['type']);
        if(!$module['print']) $this->error('该模块不支持打印');

        $templet = $this->getview($aid);
        $this->assign('content', $templet);

        $url = 'https://stusys.sinaapp.com/d/'.$apply['code'];
        $this->assign('url', $url);

        $this->display();
    }

    public function viewconfirm(){
        $aid = I('aid');
        $db = M('apply');

        $apply = $db->where(array('aid'=>$aid))->find();

        if($apply['status'] != 1){
            userLog('print_apply', 'apply~'.$aid, 'worker~'.$this->publicHead['account']['wid']);
            $this->error('申请状态不为待打印');
        }

        $db->where(array('aid'=>$aid))->setField('status', 2);

        $student = getStudentData($apply['uid']);
        $moduleArray = getModuleArray();
        $replace = array(
            'name' => $student['name'],
            'time' => date('m月d日', $apply['creattime']),
            'module_name' => $moduleArray[$apply['type']]
        );

        $this->sendFinish($apply['type'], $replace, $student);

        userLog('print_apply', 'apply~'.$aid, 'worker~'.$this->publicHead['account']['wid']);
        $this->success('成功！');
    }

    public function viewdelete(){
        $aid = I('aid');

        M('apply_custom')->where(array('aid'=>$aid))->delete();

        $this->success('已重置');
    }

    public function editview(){
        $aid = I('get.aid');
        if(IS_GET){
            $templet = $this->getview($aid);

            $this->assign('content', $templet);
            $this->display();
        }else{
            $where = array(
                'aid' => $aid,
                'status' => array('in', array(1, 2))
            );
            $apply = M('apply')->where($where)->find();
            if(!$apply) $this->error('申请不存在或状态不为“已审核”');

            M('apply_custom')->where(array('aid'=>$aid))->setField('content', htmlspecialchars_decode(I('content')));

            userLog('edit_print', 'apply~'.$aid, 'worker~'.$this->publicHead['account']['wid']);
            $this->success('保存成功', 'Worker-Apply-view.html?aid='.$aid);
        }
    }
	
	public function editview2nd(){
        $aid = I('get.aid');
        $templet = $this->getview($aid);

        $this->assign('content', $templet);
        $this->display();
    }

    public function detail(){
        $aid = I('get.aid');
        $db = M('apply');
        $where = array(
            'status'=>array('NEQ', 0),
            'aid'=>$aid
        );
        $apply = $db->where($where)->find();
        if(!$apply) $this->error('申请不存在或状态是“待审核”');

        if(IS_GET){
            $statusList = M('name_title')->where(array('type'=>'apply_status'))->select();

            $this->assign('apply', $apply);
            $this->assign('statusList', $statusList);
            $this->assign('student', getStudentData($apply['uid']));
            $this->assign('module', getModule($apply['type']));

            $this->display();
        }else{
            if(($reason = I('reason')) == '') $this->error('请填写原因');
            $status = I('status');

            $db->where(array('aid'=>$aid))->setField('status', $status);

            userLog('change_status', 'apply~'.$aid, 'worker~'.$this->publicHead['account']['wid'], $reason);
			
			//处理志愿时
			/*if($apply['type'] == 'volunteertime'){
				if($status > 0){
					$listes = json_decode(str_replace("\r\n", '', $apply['data']), true);
					$number = $listes['number']['value'];					
					if($number > 0) $this->volunteertime('add', $apply['aid'], $apply['uid'], $number);
					else $this->error('统计志愿时异常');
				}else{
					$this->volunteertime('del', $apply['aid'], $apply['uid']);
				}
			}*/

            $redirect = ($status == 0) ? '/Worker-Apply-verify.html?aid='.$aid : '/Worker-Apply-detail.html?aid='.$aid;
            $this->success('修改成功', $redirect);
        }
    }
	
	private function getview($aid){
        $customDb = M('apply_custom');
        $where = array(
            'aid' => $aid,
            'status' => array('in', array(1, 2))
        );
        $apply = M('apply')->where($where)->find();
        if(!$apply) $this->error('申请不存在或状态不为“已审核”');
        $this->assign('apply', $apply);

        $custom = $customDb->where(array('aid'=>$aid))->getField('content');
        if(!$custom){
            //各种替换文本
            $apply_data = json_decode(str_replace("\r\n", '', $apply['data']), true);
            foreach($apply_data as $i => $data){
                $replace[$i] = $data['value'];
            }
            $replace['student'] = getStudentData($apply['uid']);

            switch($replace['student']['stutype']){
                case 1:
                case 2:
                case 3:
                case 4: $replace['student']['stutype1'] = '本科生'; break;

                case 11: $replace['student']['stutype1'] = '本科应届毕业生'; break;
                case 12: $replace['student']['stutype1'] = '硕士生'; break;
                case 13: $replace['student']['stutype1'] = '博士生'; break;
                default: $replace['student']['stutype1'] = '暂缓就业生';
            }
            $replace['student']['stutype'] = getTitle('student_type~'.$replace['student']['stutype']);
            $replace['student']['sex'] = ($replace['student']['sex'] == 'M') ? '男' : '女';
            $replace['system']['date'] = date('Y年n月j日');

            $templet = replace('apply-print-'.$apply['type'], $replace);
            $custom = $templet['content'];

            $save = array('aid'=>$aid, 'content' => $custom);
            $customDb->add($save);
        }

        return $custom;
    }
	
	private function sendFinish($type, $replace, $student){
        $templet = replace('apply-email-'.$type, $replace);
        sendEmail($student['email'], $templet['title'], $templet['content']);

        $templet = replace('apply-phone-'.$type, $replace);
        sendPhone($student['phone'], $templet['content']);
    }
	
	//志愿时处理专用
	/*
	private function volunteertime($type, $aid, $uid, $number = 0){
		$db = D('volunteertime');
		
		switch($type){
			case 'add':
				$data = $db->where(array('aid'=>$aid, 'uid'=>$uid))->getFielf();
				if($data){
					$data['number'] = $number;
					$data['time'] = time();
					$db->save($data);
				}else{
					$data = array(
						'aid' => $aid,
						'uid' => $uid,
						'number' => $number,
						'time' => time()
					);
					$db->add($data);
				}
				
				break;
			
			case 'edit':
				$data = $db->where(array('aid'=>$aid, 'uid'=>$uid))->getFielf();
				if($data){
					$data['number'] = $number;
					$data['time'] = time();
					$db->save($data);
				}
				break;
			
			case 'del':
				$data = $db->where(array('aid'=>$aid, 'uid'=>$uid))->delete();
				break;
			
			default:
				$this->error('处理志愿时统计遇到异常');
		}
	}*/
}