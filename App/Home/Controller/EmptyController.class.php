<?php
namespace Home\Controller;
use Think\Controller;
class EmptyController extends Controller{

	public function _empty($action){
		switch (strtolower(CONTROLLER_NAME)) {
			case 'text':
				if('new' == $action)
					$this->display('Post/text');
				break;
		}
	}
}