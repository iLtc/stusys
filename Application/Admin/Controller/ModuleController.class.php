<?php
namespace Admin\Controller;
use Think\Controller;
class ModuleController extends AdminController {
    public function __construct(){
        parent::__construct();

        $this->moduleDb = M('module');
        $this->templetDb = M('system_templet');
        $mid = I('get.mid');
        if($mid){
            $this->selectModule = $this->moduleDb->where(array('mid'=>$mid))->find();
            if(!$this->selectModule) $this->error('所选的模块不存在');
            $this->assign('selectModule', $this->selectModule);
        }
    }

    public function index(){
        $modules = $this->moduleDb->order('status DESC, sort DESC')->select();
        $student_type = M('name_title')->where(array('type'=>'student_type'))->cache('student_type')->getField('value, title');
        $this->assign('modules', $modules);
        $this->assign('stutypes', $student_type);

        $this->display();
    }

    public function basic(){
        if(IS_GET){
            $student_type = M('name_title')->where(array('type'=>'student_type'))->cache('student_type')->getField('value, title');
            $this->assign('stutypes', $student_type);

            $this->display();
        }else{
            $name = I('name');
            $title = I('title');
            $tip = I('tip');
            $stutype = implode(',', I('stutype'));
            $status = I('status');
            $print = I('print');
            $sort = I('sort');

            if($this->selectModule){//修改
                if(!$title || !$tip || !$stutype) $this->error('请完整填写表单');
                if($this->moduleDb->where(array('title'=>$title, 'mid'=>array('NEQ', $this->selectModule['mid'])))->find())
                    $this->error('“模块名称”已存在');

                $data = $this->selectModule;
            }else{//新建
                if(!$name || !$title || !$tip || !$stutype) $this->error('请完整填写表单');
                if($this->moduleDb->where(array('type'=>$name))->find()) $this->error('“英文名称”已存在');
                if($this->moduleDb->where(array('title'=>$title))->find()) $this->error('“模块名称”已存在');

                $data['type'] = $name;
            }

            $data['title'] = $title;
            $data['tip'] = $tip;
            $data['stutype'] = $stutype;
            $data['status'] = $status;
            $data['print'] = $print;
            $data['sort'] = $sort;

            S('module_list', null);
            S('module_array', null);

            if($this->selectModule){//修改
                $this->moduleDb->save($data);

                S('module_'.$data['type'], null);
                $this->success('修改成功', '/Admin-Module.html');
            }else{
                $mid = $this->moduleDb->add($data);

                $templet = array(
                    'module' => 'apply',
                    'type' => 'agreement',
                    'name' => $name,
                    'title' => '【'.$title.'】申请说明'
                );
                $this->templetDb->add($templet);
                $templet['type'] = 'print';
                $templet['title'] = '【'.$title.'】打印模板';
                $this->templetDb->add($templet);
                $templet['type'] = 'phone';
                $templet['title'] = '【'.$title.'】审核通过短信';
                $this->templetDb->add($templet);
                $templet['type'] = 'email';
                $templet['title'] = '【'.$title.'】审核通过邮件';
                $this->templetDb->add($templet);

                $this->success('添加成功', '/Admin-Module.html');
            }
        }
    }

    public function view(){
        $templet['agreement'] = getTemplet('apply-agreement-'.$this->selectModule['type']);
        if($this->selectModule['print']) $templet['print'] = getTemplet('apply-print-'.$this->selectModule['type']);
        $templet['email'] = getTemplet('apply-email-'.$this->selectModule['type']);
        $templet['phone'] = getTemplet('apply-phone-'.$this->selectModule['type']);
        $this->assign('templets', $templet);

        $this->display();
    }

    public function templet(){
        $type = I('get.type');
        $typeList = array('agreement', 'print', 'phone', 'email');
        if(!in_array($type, $typeList)) $this->error('模板类型错误');

        $where = array(
            'module' => 'apply',
            'type' => $type,
            'name' => $this->selectModule['type']
        );
        $templet = $this->templetDb->where($where)->find();

        if(IS_GET){
            if($type == 'agreement' || $type == 'email') $templet['content'] = simpleHtmlDe($templet['content']);
            $this->assign('templet', $templet);

            $forms = getFormList($this->selectModule['type']);
            $this->assign('forms', $forms);

            $this->display();
        }else{
            $templet['title'] = I('title');
            $content = htmlspecialchars_decode(I('content'));

            if($type == 'agreement' || $type == 'email') $content = simpleHtmlEn($content);
            $templet['content'] = $content;

            if($templet['title'] == '') $this->error('标题不能为空');
            if($templet['content'] == '') $this->error('内容不能为空');

            $this->templetDb->save($templet);
            S('templet_'.$templet['module'].'-'.$templet['type'].'-'.$templet['name'], null);
            $this->success('保存成功！', '/Admin-Module-view.html?mid='.$this->selectModule['mid'].'#'.$type);
        }
    }

    public function form(){
        $lists = getFormList($this->selectModule['type']);

        $this->assign('lists', $lists);
        $this->display();
    }

    public function edit(){
        $db = M('apply_form');
        $fid = I('get.fid');
        if($fid && !($form = $db->where(array('fid'=>$fid, 'module'=>$this->selectModule['type']))->find())) $this->error('项目不存在');

        if(IS_GET){
            $form_type = M('name_title')->where(array('type'=>'form'))->cache('form_type')->getField('value, title');
            $this->assign('types', $form_type);

            if($form){
                $form['value'] = str_replace(',', "\n", $form['value']);
                $form['rule'] = str_replace(',', "\n", $form['rule']);
            }
            $this->assign('form', $form);

            $this->display();
        }else{

            $name = I('name');
            $title = I('title');
            $tip = I('tip');
            $type = I('type');
            $value = I('value');
            $rule = I('rule');
            $sort = I('sort');

            $value = str_replace("\r\n", ',', trim($value));
            $rule = str_replace("\r\n", ',', trim($rule));

            if($form){//修改
                if(!$title) $this->error('请完整填写表单');
                if($db->where(array('title'=>$title,'module'=>$this->selectModule['type'], 'fid'=>array('NEQ', $form['fid'])))->find())
                    $this->error('“项目名称”已存在');
            }else{//新建
                if(!$name || !$title) $this->error('请完整填写表单');
                if($db->where(array('name'=>$name, 'module'=>$this->selectModule['type']))->find()) $this->error('“英文名称”已存在');
                if($db->where(array('title'=>$title, 'module'=>$this->selectModule['type']))->find()) $this->error('“项目名称”已存在');

                $form['name'] = $name;
                $form['module'] = $this->selectModule['type'];
            }

            $form['title'] = $title;
            $form['tip'] = $tip;
            $form['type'] = $type;
            $form['value'] = $value;
            $form['rule'] = $rule;
            $form['sort'] = $sort;

            S('form_list_'.$this->selectModule['type'], null);
            if($fid){//修改
                $db->save($form);

                $this->success('修改成功', '/Admin-Module-form.html?mid='.$this->selectModule['mid']);
            }else{
                $db->add($form);

                $this->success('添加成功', '/Admin-Module-form.html?mid='.$this->selectModule['mid']);
            }
        }
    }

    public function delete(){
        $db = M('apply_form');
        $fid = I('fid');

        $form = $db->where(array('fid'=>$fid, 'module'=>$this->selectModule['type']))->find();

        if(!$form) $this->error('项目不存在或者已删除');

        $db->where(array('fid'=>$fid, 'module'=>$this->selectModule['type']))->delete();
        S('form_list_'.$this->selectModule['type'], null);

        $this->success('已删除');
    }
}