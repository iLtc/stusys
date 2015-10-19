<?php
namespace System\Controller;
use Think\Controller;
class TaskController extends Controller {
    public function email(){
        $md5 = I('md5');
        unset($_POST['md5']);
        checkMd5($_POST, $md5);

        $address = I('address');
        $title = I('title');
        $content = htmlspecialchars_decode(I('content'));

        $api_url = 'https://sendcloud.sohu.com/webapi/mail.send.json';
        $api_request = array(
            'api_user' => getConfig('sendcloud_user'),
            'api_key' => getConfig('sendcloud_key'),
            'to' => $address,
            'subject' => $title,
            'html' => $content,
            'from' => 'no_reply@iltc.io',
            'fromname' => '华农园艺学生自助服务系统'
        );

        $ret = curlPost($api_url, $api_request);
        systemLog('sendEmail', $ret);

        return $ret;
    }

    public function phone(){
        $md5 = I('md5');
        unset($_POST['md5']);
        checkMd5($_POST, $md5);

        $address = I('address');
        $content = htmlspecialchars_decode(I('content'));

        $api_url = 'http://sms3.mobset.com/SDK/Sms_Send.asp';
        $api_request = array(
            'CorpID' => getConfig('sms_corpid'),
            'LoginName' => getConfig('sms_loginname'),
            'Passwd' => getConfig('sms_passwd'),
            'send_no' => $address,
            'msg' => iconv("UTF-8","gbk//TRANSLIT",$content)
        );

        $ret = curlGet($api_url.'?'.http_build_query($api_request));
        systemLog('sendPhone', $ret);

        return $ret;
    }

    public function callback(){
        systemLog('taskError', '', 'Error');
    }

    public function clean(){
        $time = time();
        M('account_verify')->where(array('expire'=>array('lt', $time)))->delete();
        M('account_fail')->where(array('expire'=>array('lt', $time)))->delete();

        systemLog('taskClean');
    }

    public function backup(){
        $dbList = array('account','account_auth','apply','apply_form','file_class','file_list','module','name_title',
            'system_config','system_templet','worker');
        $unset_i = array_rand($dbList, 1);
        foreach($unset_i as $i) unset($dbList[$i]);

        $dj = new \SaeDeferredJob();

        //添加任务
        foreach($dbList as $db) $dj->addTask("export", "mysql", "backup", date('Ymd')."-".$db.".zip", "app_hort", $db, "", true);
    }

}