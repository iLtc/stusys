<?php
namespace System\Behaviors;
class httpsBehavior extends \Think\Behavior{
    //行为执行入口
    public function run(&$param){
        if (C('IS_SAE') == true && CONTROLLER_NAME != 'Task' && $_SERVER['HTTPS'] != "on") {
            $xredir = "https://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
            header("Location: " . $xredir);
            exit;
        }
    }
}