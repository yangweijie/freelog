<?php
namespace Home\Controller;
// use Think\Controller;
class EmptyController extends HomeController{

	public function _empty($action){
		$resource = strtolower(CONTROLLER_NAME);
		$this->assign('type', $resource);
		if(in_array($resource, array('text', 'picture', 'music', 'video'))){
			if(in_array($action, array('new', 'edit'))){
				if('edit' == $action){
					$id = intval(I('id'));
					if($post = M('post')->find($id))
						$this->assign('post', $post);
					else
						$this->error('错误的记录');
				}
				$this->display('Post/'.$resource);
			}else{
				$this->error('错误的请求');
			}
		}else{
			$this->error('错误的请求');
		}
	}
}