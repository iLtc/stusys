<?php
namespace System\Controller;
use Think\Controller;
class AccountController extends Controller {
    public function unique($name='', $value='', $tmp=''){
        if($name == '') $name = I('name');
        if($value == '') $value = I('value');
        $where[$name] = $value;

        if($name == 'email' && !checkEmail($value)) $this->error('邮件格式错误');

        if(M('account')->where(array($name => $value))->select()){
            $account = getStudentData();
            if($account[$name] != $value){
                if($tmp == '') $this->error('已存在，请尝试登陆');
                else $this->error('部分信息已存在，请尝试登陆');
            }
        }

        if($tmp == '') $this->success('ok');
        else return true;
    }
}