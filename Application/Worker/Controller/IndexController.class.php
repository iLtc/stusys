<?php
namespace Worker\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        redirect('Worker-Apply.html');
    }
}