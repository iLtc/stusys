<?php
namespace Admin\Controller;
use Think\Controller;
class FileController extends AdminController {
    public function index(){
        $file = getFileList();
        $this->assign('file', $file);
        $this->assign('base_url', getConfig('qiniu_url'));

        $this->display();
    }

    public function addClass(){
        if(IS_GET){
            $this->display();
        }else{
            $name = I('name');
            if($name == '') $this->error('请填写“分类名称”');

            $db = M('file_class');
            if($db->where(array('name'=>$name))->find()) $this->error('分类名称“'.$name.'”已存在');

            $db->create();
            $fcid = $db->add();

            S('file_class', null);

            $this->success('“'.$name.'”添加成功!', 'Admin-File-upload.html?fcid='.$fcid);
        }
    }

    public function editClass(){
        $db = M('File_class');
        $fcid = I('fcid');

        $fileClass = $db->where(array('fcid'=>$fcid))->find();
        if(!$fileClass) $this->error('所选分类不存在');

        if(IS_GET){
            $this->assign('fileClass', $fileClass);
            $this->display();
        }else{
            $name = I('name');
            if($name == '') $this->error('请填写“分类名称”');

            $check = array(
                'name'=>$name,
                'fcid'=>array('NEQ', $fcid)
            );
            if($db->where($check)->find()) $this->error('分类名称“'.$name.'”已存在');

            $db->create();
            $db->save();

            S('file_class', null);

            $this->success('“'.$name.'”编辑成功!', 'Admin-File.html');
        }
    }

    public function delClass(){
        $fcid = I('fcid');

        M('File_class')->where(array('fcid'=>$fcid))->delete();
        M('File_list')->where(array('fcid'=>$fcid))->delete();

        S('file_class', null); S('file_list', null);

        $this->success('删除成功');
    }

    public function upload(){
        $fcid = I('fcid');
        if(!($fcname = M('file_class')->where(array('fcid'=>$fcid))->getField('name'))) $this->error('分类不存在或已经被删除');

        if(IS_GET){
            $this->assign('fcname', $fcname);
            $this->display();
        }else{
            if(I('name') == '') $this->error('请填写“文件名称”');

            $db = M('file_list');
            $db->create();
            $db->add();

            S('file_list', null);

            $this->success('“'.I('name').'”添加成功!', 'Admin-File.html');
        }
    }

    public function edit(){
        $db = M('File_list');
        $fid = I('fid');

        $file = $db->where(array('fid'=>$fid))->find();
        if(!$file) $this->error('所选文件不存在');

        if(IS_GET){
            $this->assign('file', $file);
            $this->display();
        }else{
            $name = I('name');
            if($name == '') $this->error('请填写“文件名称”');

            $db->create();
            $db->save();

            S('file_list', null);

            $this->success('“'.$name.'”编辑成功!', 'Admin-File.html');
        }
    }

    public function del(){
        $fid = I('fid');

        M('File_list')->where(array('fid'=>$fid))->delete();

        S('file_list', null);

        $this->success('删除成功');
    }
}