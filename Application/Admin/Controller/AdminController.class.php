<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends Controller {
    public function __construct(){
        parent::__construct();

        isAdmin();

        $publicHead = array(
            'account' => deWorkerCookie()
        );
        $this->publicHead = $publicHead;
        $this->assign('publicHead', $publicHead);
    }
}