<?php
namespace Admin\Controller;
use Think\Controller;

class TagsController extends CommonController {

    //首页
    public function index(){
    	/* 查询条件初始化 */
        $map = array();
        $map  = array('status' => 1);
        if(isset($_GET['title'])){
            $map['title'] = array('like', '%'.(string)I('title').'%');
        }

        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->meta_title = '标签';
        $this->_list(array('source' => 'Tags', 'map' => $map, 'order' => '`id`'));
    }

}