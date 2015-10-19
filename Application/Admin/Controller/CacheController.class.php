<?php
namespace Admin\Controller;
use Think\Controller;
class CacheController extends AdminController {
    public function index(){
        if(IS_GET){
            $this->display();
        }else{
            $files = I('files');
            $files = explode("\r\n", $files);

            $type = I('type');
            $this->$type($files);
        }
    }

    private function qiniu($files){
        include_once("./Public/include/qiniu/rs.php");

        $bucket = getConfig('qiniu_bucket');
        $accessKey = getConfig('qiniu_accessKey');
        $secretKey = getConfig('qiniu_secrectKey');

        Qiniu_SetKeys($accessKey, $secretKey);
        $client = new \Qiniu_MacHttpClient(null);

        $ret = '';
        foreach($files as $file){
            $ret .= Qiniu_RS_Delete($client, $bucket, $file)."\n";
        }

        var_dump($ret);
    }
}