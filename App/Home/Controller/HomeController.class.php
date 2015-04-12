<?php
namespace Home\Controller;
use Think\Controller;
class HomeController extends Controller{
	protected function _initialize(){
		/* 读取站点配置 */
        $config = S('DB_CONFIG_DATA');
        if (!$config) {
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
            S('DB_CONFIG_DATA', $config);
        }
		C($config); //添加配置
	}

	public function success($message='', $jumpUrl='', $ajax=false){
		if(empty($ajax)){
			$ajax = array('code'=>200);
		}else{
			$ajax = array_merge($ajax, array('code'=>200));
		}
		parent::success($message, $jumpUrl, $ajax);
	}

	public function error($message='', $jumpUrl='', $ajax=false){
		if(empty($ajax)){
			$ajax = array('code'=>404);
		}else{
			$ajax = array_merge($ajax, array('code'=>404));
		}
		parent::error($message, $jumpUrl, $ajax);
	}
}