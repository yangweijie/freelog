<?php
namespace Admin\Controller;
use Think\Controller;

class ResourceController extends CommonController {

    //标签
    public function tags(){
    	/* 查询条件初始化 */
        $map = array('status' => 1);
        if(isset($_GET['title'])){
            $map['title'] = array('like', '%'.(string)I('title').'%');
        }

        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->meta_title = '标签';
        $this->_list(array('source' => 'Tags', 'map' => $map, 'order' => '`id`'));
    }

    //图片
    public function pics(){
        /* 查询条件初始化 */
        $map = array('status' => 1);
        if(isset($_GET['title'])){
            $map['title'] = array('like', '%'.(string)I('title').'%');
        }

        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->meta_title = '标签';
        $this->_list(array('source' => 'Picture', 'map' => $map, 'order' => '`id`'));
    }

    public function files(){
        /* 查询条件初始化 */
        $map = array('status' => 1);
        if(isset($_GET['title'])){
            $map['title'] = array('like', '%'.(string)I('title').'%');
        }

        // 记录当前列表页的cookie
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->meta_title = '标签';
        $this->_list(array('source' => 'File', 'map' => $map, 'order' => '`id`'));
    }

}