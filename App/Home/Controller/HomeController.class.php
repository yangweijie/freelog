<?php
namespace Home\Controller;
use Think\Controller;
class HomeController extends Controller{
	protected function _initialize(){
		/* 读取站点配置 */
		$map = array('status' => 1);
		$configModel = D('Config');
		$data = $configModel->where($map)->field('type,name,value')->select();
		$config = array();
		if ($data && is_array($data)) {
			foreach ($data as $value) {
				$config[$value['name']] = $configModel->parse($value['type'], $value['value']);
			}
		}
		C($config); //添加配置
	}
}