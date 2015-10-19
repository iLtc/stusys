<?php
namespace System\Controller;
use Think\Controller;
class UploadController extends Controller {
    public function qiniu(){
        $data = array(
            'scope' => getConfig('qiniu_bucket'),
            'deadline' => time() + 3600
        );

        $encodedPutPolicy = $this->urlsafe_base64_encode(json_encode($data));

        $encodedSign = $this->urlsafe_base64_encode(hash_hmac("sha1", $encodedPutPolicy, getConfig('qiniu_secrectKey'), true));

        $display = array('uptoken'=>getConfig('qiniu_accessKey').':'.$encodedSign.':'.$encodedPutPolicy);
        echo json_encode($display);
    }

    private function urlsafe_base64_encode($str){
        $find = array('+', '/');
        $replace = array('-', '_');
        return str_replace($find, $replace, base64_encode($str));
    }
}