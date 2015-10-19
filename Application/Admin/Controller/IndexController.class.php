<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends AdminController {
    public function index(){
        redirect('/Admin-Module.html');
    }
}