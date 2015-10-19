<?php
namespace Student\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        if(isLogin(true)){
            if(deWorkerCookie()) redirect('/Worker.html');
            else redirect('/Apply-history.html');
        }
    }
}
