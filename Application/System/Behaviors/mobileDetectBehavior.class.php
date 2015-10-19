<?php
namespace System\Behaviors;
class mobileDetectBehavior extends \Think\Behavior{
    //行为执行入口
    public function run(&$param){
        include_once("./Public/include/Mobile_Detect.php");

        $detect = new \Mobile_Detect;
        if($detect->isMobile()) define('IS_MOBILE', true);
        else define('IS_MOBILE', false);
    }
}