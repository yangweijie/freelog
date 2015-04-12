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

    public function index(){
    	$wechatauth = new WechatAuth(C('WEIXIN.APPID'), C('WEIXIN.SECRET'));
        $result = $wechatauth->getServerIp();
    	slog($result);
    	$this->assign('ip', $result);
    	$this->display();
    }
}