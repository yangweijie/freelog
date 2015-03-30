<?php
namespace Home\Controller;
class IndexController extends HomeController {

	public function index($page = 1){
		$this->lists($page);
		$this->display();
	}

    public function lists($page = 1){
    	$map = array();
    	$list_row = I('r', 10);
    	$postModel = D('Post');

    	//tag搜索
    	$tags = I('get.tag');
        if($tags){
            $ids = $postModel->where("tags LIKE '{$tags}'")->getField('id', true);
            $this->assign('title', "标签 <i>{$tags}</i>下的文章");
            if(!empty($ids))
            	$map['id'] = array('in',$ids);
        }

        //关键词搜搜
    	if(I('get.kw')){
            $kw = trim(I('get.kw'));
            $map['title'] = array('like',"%{$kw}%");
            $like_id = $postModel->where("content LIKE '%{$kw}%' OR description LIKE '%{$kw}%'")->getField('id', true);
            if($like_id)
                $map['id'] = array('in', $like_id);
        }

        //归档搜索
        if(isset($_GET['year']) && isset($_GET['month'])){
	        $year = CONTROLLER_NAME;
	        $month = ACTION_NAME;
	        $map['_string'] = "`deadline` LIKE binary('{$year}-{$month}%')";
        }

    	$this->assign('list', $postModel->where($map)->page($page, $list_row)->order('`deadline` DESC')->select());

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
		$list = $postModel->order('`deadline` DESC,`id` DESC')->select();
		$date = $time = array();
		foreach ($list as $key => $value) {
			if($value['deadline'])
				$time[] = date('F Y', strtotime($value['deadline']));
		}
		$time = array_unique($time);
		foreach ($time as $key => $value) {
			$date[] = array(
				'text'=> $value,
				'link'=> date('Y/m', strtotime($value))
			);
		}
		$this->assign('archive', $date);
    }

	//归档
    public function archive($year, $month){
        $_GET['month'] = $month;
        $_GET['year'] = $year;
        $this->assign('title', "{$year}年{$month}月的文章");
        $this->assign('year', $year);
        $this->assign('month', $month);
        $this->lists(I('get.page', 1));
        $this->display('Index/index');
    }

    //搜索
    public function search(){
        $kw = I('get.kw');
        if(!$kw)
            $this->error('请输入关键字');
        $this->assign('title', "包含关键字 {$kw} 的文章");
        $this->assign('kw', $kw);
        $this->lists(I('get.page', 1));
        $this->display('Index/index');
    }
}