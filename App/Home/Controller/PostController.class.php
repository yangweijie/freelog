<?php
namespace Home\Controller;
class PostController extends HomeController {

    public function _empty($action){
        $this->detail($action);
    }

    //详情
    public function detail($id){
        /* 标识正确性检测 */
        if(!($id && is_numeric($id))){
            $this->error('文章ID错误！');
        }

        /* 获取详细信息 */
        $Post = D('Post');
        $info = $Post->find($id);
        if(!$info){
            $this->error($Post->getError());
        }

        /* 更新浏览数 */
        $map = array('id' => $id);
        $Post->where($map)->setInc('views');

        /* 模板赋值并渲染模板 */
        $this->assign('post', $info);
        $this->display('Index/detail');
    }

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

    public function parseMusic(){
        $query_res = curl('http://tingapi.ting.baidu.com/v1/restserver/ting?method=baidu.ting.search.common&page_size=999', array('query'=>I('query')));
        $query = json_decode($query_res, 1);
        if(false !== $query){
            $this->ajaxReturn($query);
        }else{
            slog('curl失败');
            $this->error('查询失败');
        }
    }

    public function afterUpload(){
        $this->assign('type', 'upload');
        $this->display('video_extra_form');
    }
}