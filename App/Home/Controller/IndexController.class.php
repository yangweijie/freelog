<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index($page = 1){
    	$map = array();
    	$list_row = I('r', 1);
    	$postModel = D('Post');
    	//tag搜索
    	$tags = I('get.tag');
        if($tags){
            $ids = $postModel->where("tags LIKE '{$tags}'")->getField('id', true);
            $map['id'] = array('in',$ids);
        }

    	$this->assign('list', $postModel->where($map)->page($page, $list_row)->select());

		/* 分页 */
		$total = $postModel->where($map)->count();
		$page = new \Think\Page($total, $list_row);
		$page->rollPage = 5;
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$page->setConfig('theme','<div class="pager">%UP_PAGE% %DOWN_PAGE%</div>');
		$p = $page->show();
		$this->assign('_page', $p? $p: '');

		//tag列表
		$this->assign('tags', M('Tags')->order('count DESC')->select());

		//获取归档
    	$this->display();
    }
}