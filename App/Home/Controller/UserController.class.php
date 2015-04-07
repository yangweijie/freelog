<?php
namespace Home\Controller;
class UserController extends HomeController{

	public function login($nickname = '', $pwd= ''){
		if(IS_POST){ //登录验证
			$Member = D('Member');
			$uid = $Member->checkLogin($nickname, $pwd);

			if(0 < $uid){
				//登录用户
				if($Member->login($uid, $nickname)){
					$this->success('登录成功！',U('/mine'));
				} else {
					$this->error($Member->getError());
				}

			} else { //登录失败
				switch($uid) {
					case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
					case -2: $error = '密码错误！'; break;
					default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
				}
				$this->error($error);
			}

		} else { //显示登录表单
			$this->display();
		}
	}

	//注册
	public function reg($nickname = '', $pwd = ''){
		if(IS_POST){ //注册用户
			$Member = D('Member');
			$data = $Member->create(array('nickname'=>$nickname, 'pwd'=>$pwd));
			if($data){
				$Member->startTrans();
				if($Member->add()){
					if($Member->login($uid, $nickname)){
						$Member->commit();
						$this->success('注册成功',U('/mine'));
					} else {
						$Member->rollback();
						$this->error($Member->getError());
					}
				}else{
					$Member->rollback();
					$this->error($Member->getError());
				}
			}else{
				$this->error($Member->getError());
			}
		} else { //显示登录表单
			$this->display();
		}
	}

	public function profile(){
		$uid = is_login();
		$info = M('Member')->find($uid);
		$oauths = D('Sns')->extendOauth($uid);
		$this->assign('oauths', $oauths);
		$this->assign('info', $info);
		$this->display();
	}

	//登录地址
	public function oauth($type = null){
		empty($type) && $this->error('参数错误');

		//加载ThinkOauth类并实例化一个对象
		$name = ucfirst(strtolower($type)) . 'SDK';
    	$names ="Common\OauthSDK\sdk"."\\".$name;
		$oauth = new $names();

		//跳转到授权页面
		redirect($oauth->getRequestCodeURL());
	}

	//授权回调地址
	public function callback($type = null, $code = null){
		(empty($type) || empty($code)) && $this->error('参数错误1');

		//加载ThinkOauth类并实例化一个对象
		$name = ucfirst(strtolower($type)) . 'SDK';
    	$names = "Common\OauthSDK\sdk"."\\".$name;
		$oauth = new $names();
		//腾讯微博需传递的额外参数
		$extend = null;
		// if($type == 'tencent'){
		// 	$extend = array('openid' => $this->$_GET('openid'), 'openkey' => $this->$_GET('openkey'));
		// }

		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $oauth->getAccessToken($code , $extend);

		//获取当前登录用户信息
		if(is_array($token)){
			$uid = is_login();
			$oauth = new \Common\Controller\TypeEvent();
			$user_info = $oauth->$type($token);
			$token['member_id'] = $uid;
			$token['type'] = strtolower($user_info['type']);
			if($exist = M('Sns')->where("member_id={$uid} AND type='{$token['type']}'")->find()){
				$token['update_time'] = NOW_TIME;
				$token['id'] = $exist['id'];
			}else{
				$token['create_time'] = $token['update_time'] = NOW_TIME;
			}
			$token['status'] = 1;
			D('Sns')->add(M('Sns')->create($token), true);
			$this->success('绑定成功', 'user/profile');
		}
	}

	public function unbindOauth($id){
		if($sns = M('Sns')->find($id)){
			$data = array();
			$name = ucfirst($sns['type']) . 'SDK';
	    	$names = "Common\OauthSDK\sdk"."\\".$name;
			$oauth = new $names($sns['access_token']);
			switch ($sns['type']) {
				case 'sina':
					$data['ret'] = !$oauth->call('OAuth2/revokeoauth2');
					break;
				default:
					$this->error('错误的第三方登录接口类型');
					break;
			}
			if($data['ret'] == 0){

			}else{
				$this->error("解除{$sns['name']}授权失败");
			}
			M('Sns')->delete($id);
		}else{
			$this->error('尚未绑定，无需解绑');
		}
	}

	public function logout(){
		session('user', NULL);
		$this->success('登出成功', '/');
	}

	//登录成功，微信用户信息
    public function weixin($token){
        $weixin   = \ThinkOauth::getInstance('weixin', $token);
        $data = $weixin->call('sns/userinfo');

        if($data['ret'] == 0){
            $userInfo['type'] = 'WEIXIN';
            $userInfo['name'] = $data['nickname'];
            $userInfo['nick'] = $data['nickname'];
            $userInfo['head'] = $data['headimgurl'];
            return $userInfo;
        } else {
            throw_exception("获取微信用户信息失败：{$data['errmsg']}");
        }
    }

}