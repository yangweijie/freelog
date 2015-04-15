<?php
namespace Admin\Controller;
use Think\Controller;
class PostController extends CommonController {
	public function _empty($action = 'text'){
		if(!in_array($action, array('text', 'picture', 'video', 'music')))
			$this->error('错误的文章类型');
		/* 查询条件初始化 */
        $map = array();
        $map['type'] = $action;
        if($search = I('get.title','', 'trim')){
        	$map['_string'] = "`title` LIKE '%{$search}%' OR `description` LIKE '%{$search}' OR `tags` LIKE '%{$search}%'";
        }
        $this->meta_title = '文章管理';
        $this->_list(array('source' => 'Post', 'map' => $map, 'order' => '`id`', 'tpl'=>strtolower($action)));
	}
}