<?php
namespace Common\Model;
use Think\Model;

class MemberModel extends Model{

	public function check($nickname, $pwd){
		$member = $this->where("nickname = '{$nickname}'")->find();
		if($member){
			if(password($pwd) == $member['pwd']){
				return $member['id'];
			}else{
				return -2;
			}
		}else{
			return -1;
		}
	}

	public function login($uid, $nickname){
		$array = array(
			'uid' =>$uid,
			'nickname'=>$nickname
		);
		try {
			session('user', $array);
			return true;
		} catch (Exception $e) {
			$this->error = '未知错误';
			return false;
		}

	}
}