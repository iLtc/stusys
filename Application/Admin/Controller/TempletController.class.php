<?php
namespace Admin\Controller;
use Think\Controller;
class TempletController extends AdminController {
    public function index(){
        $templets = M('system_templet')->where(array('module'=>array('NEQ', 'apply')))->order('tid')->select();
        foreach($templets as $templet){
            $templetArray[$templet['module'].'-'.$templet['type']][$templet['name']] = $templet;
        }

        $this->assign('templets', $templetArray);
        $this->display();
    }

    public function edit(){
        $db = M('system_templet');
        $tid = I('get.tid');

        $templet = $db->where(array('tid'=>$tid))->find();
        if(!$templet) $this->error('模板不存在');

        if(IS_GET){
            $content = $templet['content'];

            $content = simpleHtmlDe($content);

            $templet['content'] = $content;
            $this->assign('templet', $templet);
            $this->display();
        }else{
            $templet['title'] = I('title');
            $content = I('content');

            if($templet['format'] == 'html') $content = simpleHtmlEn($content);
            $templet['content'] = $content;

            if($templet['title'] == '') $this->error('标题不能为空');
            if($templet['content'] == '') $this->error('内容不能为空');

            $db->save($templet);
            S('templet_'.$templet['module'].'-'.$templet['type'].'-'.$templet['name'], null);
            $this->success('保存成功！', '/Admin-Templet.html#'.$templet['tid']);
        }
    }
}