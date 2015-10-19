<?php
namespace System\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        redirect('/Account-agreement.html');
    }

    public function edit(){
        $p = (isset($_GET['p'])) ? I('p') : 1;
        $db = M('apply');

        $count = $db->count();
        if($count <= ($p - 1) * 10) die('程序执行完毕');

        $applies = $db->page($p, 10)->select();

        foreach($applies as $apply){
            if(strlen($apply['code']) < 10){
                $code = date('Ymd', $apply['creattime']).sprintf("%07d", $apply['aid']).$apply['code'];
                $db->where(array('aid'=>$apply['aid']))->setField('code', $code);
            }
        }

        $this->success('已完成 '. $p*10 .'/'.$count, 'System-Index-edit?p='. ($p + 1));
    }
}