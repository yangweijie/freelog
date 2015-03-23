<?php
namespace Home\Controller;
use Think\Controller;
class PostController extends Controller {

	public function parseVideo(){
        require './urlParse.php';
        $urlParse = new \urlParse();
        $url = I('post.url');
        $return = $urlParse->setvideo($url, '');
        if ($return['error'])
            $this->error($return['error']);
        else {
        	slog('in');
        	slog($return);
            $return['video_id'] = 0;
            $return['video_url'] = $return['id'] ? $return['id'] : $return['pid'];
            unset($return['id']);
            $this->assign($return);
            $this->assign('type', 'url');
            $return['tpl'] = $this->fetch('Post/video_extra_form');
            slog($return);
            $this->success('', '', $return);
        }
	}

    public function afterUpload(){
        $this->assign('type', 'upload');
        $this->display('video_extra_form');
    }
}