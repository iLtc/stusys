<?php
namespace System\Controller;
use Think\Controller;
class ToolController extends Controller {
    public function qrcode(){
        include_once("./Public/include/phpqrcode.php");

        $content = I('content');
        $md5 = I('md5');
        checkMd5($content, $md5);

        \QRcode::png($content, false, QR_ECLEVEL_L, 3, 0);
    }
}