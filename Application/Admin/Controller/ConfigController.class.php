<?php
namespace Admin\Controller;
use Think\Controller;
class ConfigController extends AdminController {
    public function index(){
        $db = M('system_config');
        $configs = $db->select();
        if(IS_GET){

            $this->assign('configs', $configs);
            $this->display();
        }else{
            foreach($configs as $config){
                if($config['type'] == 'checkbox'){
                    $value = (I($config['name'])) ? 1 : 0;
                }elseif($config['type'] == 'json'){
                    $value = htmlspecialchars_decode(I($config['name']));
                }else{
                    $value = I($config['name']);
                }

                if($value != $config['value']){
                    $db->where(array('cid'=>$config['cid']))->setField('value', $value);
                    S('config_'.$config['name'], null);
                }
            }

            $this->success('保存成功');
        }
    }
}