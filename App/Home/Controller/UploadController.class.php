<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {

	public function ueditor(){
        $data = new \Org\Util\Ueditor();
        echo $data->output();
    }
}