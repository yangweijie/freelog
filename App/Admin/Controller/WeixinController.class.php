<?php
namespace Admin\Controller;
use Think\Controller;
use Com\Wechat;
use Com\WechatAuth;

class WeixinController extends CommonController {

    //初始化方法
    protected function _initialize() {
    	if(!C('WEIXIN.APPID')){
    		$this->error('请先配置好微信');
    	}
    }

    //首页
    public function index(){
    	$wechatauth = new WechatAuth(C('WEIXIN.APPID'), C('WEIXIN.SECRET'), C(''));
    	$access_token = $wechatauth->getAccessToken();
        $result = $wechatauth->getServerIp($access_token);
        if(isset($result['errcode']))
        	$this->error($result['errmsg']);
    	slog($result);
    	$this->assign('ip', $result['ip_list']);
    	$this->display();
    }

    //菜单
    public function menu(){
        $this->display();
    }

}