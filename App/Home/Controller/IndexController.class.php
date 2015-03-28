<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index($page = 1){
    	$map = array();
    	$list_row = I('r', 1);
    	$this->assign('list', D('Post')->page($page, $list_row)->select());
		/* 分页 */
		$total = M('Post')->where($map)->count();
		$page = new \Think\Page($total, $list_row);
		$page->rollPage = 5;
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('theme','<div class="pager">%UP_PAGE% %DOWN_PAGE%</div>');

		$p = $page->show();
		$this->assign('_page', $p? $p: '');
    	$this->display();
    }
}