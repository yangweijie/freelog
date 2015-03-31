<?php
namespace Home\Controller;
class UserController extends HomeController{

	public function login($nickname = '', $pwd= ''){
		if(IS_POST){ //登录验证
			$uid = D('Member')->check($nickname, $pwd);
			if(0 < $uid){
				/* 登录用户 */
				$Member = D('Member');
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

}