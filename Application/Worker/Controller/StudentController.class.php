<?php
namespace Worker\Controller;
use Think\Controller;
class StudentController extends Controller {
    public function __construct(){
        parent::__construct();
        $publicHead = workerHead();
        $this->publicHead = $publicHead;
        $this->assign('publicHead', $publicHead);
    }

    public function index(){
        $page = ($_GET['page']) ? I('page') : 1;
        $db = M('Account');
        $search = I('search');
        if($search){
            if(is_numeric($search)){
                $where['sid'] = array('like', '%'.$search.'%');
                $where['phone'] = array('like', '%'.$search.'%');
                $where['_logic'] = 'OR';
            }else{
                $where['name'] = array('like', '%'.$search.'%');
                $where['email'] = array('like', '%'.$search.'%');
                $where['_logic'] = 'OR';
            }
        }

        $count = $db->where($where)->order('uid ASC')->count();
        $pages = ceil($count/15);
        if($page > $pages) $page = $pages;


        $students = $db->where($where)->page($page, 15)->order('uid ASC')->select();

        $this->assign('students', $students);
        $this->assign('page', $page);
        $this->assign('pages', $pages);
        $this->display();
    }

    public function detail(){
        $uid = I('uid');

        $student = getStudentData($uid);
        if(!$student) $this->error('学生不存在');

        $this->assign('student', $student);
        $this->display();
    }

    public function edit(){
        $uid = I('get.uid');

        $student = getStudentData($uid);
        if(!$student) $this->error('学生不存在');

        if(IS_GET){
            $this->assign('student', $student);

            $student_type = M('name_title')->where(array('type'=>'student_type'))->cache('student_type')->getField('value, title');
            $this->assign('student_type', $student_type);

            $this->display();
        }else{
            if(($reason = I('reason')) == '') $this->error('请填写原因');

            $student['phoneverified'] = I('phoneverified');
            $student['emailverified'] = I('emailverified');
            $student['isaddress'] = I('isaddress');

            if($_POST['password'] != '') $student['password'] = crypt(I('password'), '$6$'.randString(16).'$');

            unset($_POST['password'], $_POST['phoneverified'], $_POST['emailverified'], $_POST['isaddress']);

            foreach($_POST as $i => $v){
                if($_POST[$i] != '') $student[$i] = $v;
            }

            M('account')->save($student);
            S('student_'.$student['uid'], null);

            userLog('edit_student', 'student~'.$student['uid'], 'worker~'.$this->publicHead['account']['wid'], $reason);

            $this->success('修改成功', '/Worker-Student-detail.html?uid='.$student['uid']);
        }
    }

    public function send(){
        $uid = I('get.uid');

        $student = getStudentData($uid);
        if(!$student) $this->error('学生不存在');

        if(!$_POST['phone'] && !$_POST['email']) $this->error('请选择一个发送渠道');
        if(!$_POST['content']) $this->error('请填写通知内容');

        $replace = array(
            'name' => $student['name'],
            'worker' => $this->publicHead['account']['name'],
            'content' => I('content')
        );

        if($_POST['phone']){
            $templet = replace('system-phone-send', $replace);
            sendPhone($student['phone'], $templet['content'], true);
        }
        if($_POST['email']){
            $templet = replace('system-email-send', $replace);
            sendEmail($student['email'], $templet['title'], $templet['content'], true);
        }

        userLog('send_content', 'student~'.$student['uid'], 'worker~'.$this->publicHead['account']['wid'], I('content'));

        $this->success('发送成功');
    }
}