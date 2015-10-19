<?php
namespace Student\Controller;
use Think\Controller;
class PublicController extends Controller {
    public function __construct(){
        parent::__construct();
        $publicHead = studentHead();
        $this->publicHead = $publicHead;
        $this->assign('publicHead', $publicHead);
    }

    public function file(){
        $this->assign('file', getFileList());
        $this->display();
    }

    public function content(){
        $templet = getTemplet('system-content-'.I('id'));
        if(!$templet) {
            echo '内容不存在！';
            return;
        }
        $this->assign('templet', $templet);
        $this->display();
    }

    public function detail(){
        $code = I('code');
        $template = (IS_MOBILE == true) ? 'Mobile' : 'Computer';
        $db = M('apply');

        if(!is_numeric($code)){
            $temp = explode('~',$code);
            $time = $db->where(array('aid'=>$temp[0]))->getField('creattime');

            $code = date('Ymd', $time).sprintf("%07d", $temp[0]).$temp[1];
        }


        $apply = $db->where(array('code'=>$code))->find();
        if(!$apply) $this->theme($template)->display('unfind');
        else{
            $this->assign('apply', $apply);
            $this->assign('moduleArray', getModuleArray());
            $this->theme($template)->display();
        }
    }

    public function upload(){
        $dir = I('dir') ? I('dir') : 'default';
        $config = array(
            'autoSub' => false,
            'savePath' => $dir.'/'.date('Ym').'/',
        );
        $qiniuConfig = array(
            'secrectKey'     => getConfig('qiniu_secrectKey'),
            'accessKey'      => getConfig('qiniu_accessKey'),
            'bucket'         => getConfig('qiniu_bucket'), //空间名称
        );
        $upload = new \Think\Upload($config,'Qiniu',$qiniuConfig);// 实例化上传类
        $info   =   $upload->uploadOne($_FILES['Filedata']);
        echo getConfig('qiniu_url').$info['name'];
        exit;
    }

    public function editor_upload(){
        $dir = I('get.dir');
        $config = array(
            'autoSub' => false,
            'savePath' => $dir.'/'.date('Ym').'/',
        );
        $qiniuConfig = array(
            'secrectKey'     => getConfig('qiniu_secrectKey'),
            'accessKey'      => getConfig('qiniu_accessKey'),
            'bucket'         => getConfig('qiniu_bucket'), //空间名称
        );
        $upload = new \Think\Upload($config,'Qiniu',$qiniuConfig);// 实例化上传类
        $info   =   $upload->uploadOne($_FILES['imgFile']);

        $return = array(
            'error' => 0,
            'url' => getConfig('qiniu_url').$info['name']
        );

        $this->ajaxReturn($return);
    }

    public function verifyImg(){
        $id = I('id');
        if(!$id) $id = '0';

        $config = array(
            'codeSet' => '02345689',
            'imageW' => 218,
            'length' => 4, // 验证码位数
        );

        $Verify = new \Think\Verify($config);
        $Verify->entry($id);
    }
}
