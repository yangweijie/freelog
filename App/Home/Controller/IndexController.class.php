<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
    	$this->assign('list', D('Post')->select());
    	$this->display();
    }
}