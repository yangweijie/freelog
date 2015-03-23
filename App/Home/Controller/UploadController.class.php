<?php
namespace Home\Controller;
// use Think\Controller;
class UploadController extends HomeController {

	public function ueditor(){
        $data = new \Org\Util\Ueditor();
        die($data->output());
    }

    public function plupload(){
    	$data = new \Org\Util\Ueditor();
        $json = $data->output();
        $result = json_decode($json, 1);
        if('SUCCESS' == $result['state']){
        	$output = array(
        		'ok'=>1,
        		'path'=>$result['url'],
    		);
        }else{
        	$output = array(
        		'ok'=>0,
        		'code'=>$result['state'],
    		);
        }
        die(json_encode($output));
    }

    public function ajaxUpload($params = array('model'=>'File','field'=>'file')) {
        $result = $this->upload($params);
        if ($result['status']) {
            $result['info'] = '上传成功';
        } else {
            $result['info'] = '上传失败'.$result['info'];
        }
        $this->ajaxReturn($result);
    }

    protected function upload($params) {
        /* 返回标准数据 */
        $return = array('status' => 1, 'info' => '上传成功', 'data' => '');
        $model = $params['model'] == 'Picture'? 'Picture' : 'File';
        /* 调用文件上传组件上传文件 */
        $table = D($model);
        $driver = C("{$model}_UPLOAD_DRIVER");
        d_f('upload', $driver);
        $upload_config = C("{$model}_UPLOAD");
        d_f('upload', $upload_config);
        if(isset($params['rootPath']))
            $upload_config['rootPath'] = $params['rootPath'];
        $info = $table->upload($_FILES, $upload_config, $driver, C("UPLOAD_{$driver}_CONFIG"));
        d_f('upload', $info);
        /* 记录图片信息 */
        if ($info) {
            $return['status'] = 1;
            $return = array_merge($info[$params['field']], $return);
            if (method_exists($this, 'after_upload')) {
                $this->after_upload(CONTROLLER_NAME, $info, $result);
            }
        } else {
            $return['status'] = 0;
            $return['info'] = $table->getError();
        }

        d_f('upload', $return);
        return $return;
    }
}