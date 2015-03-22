<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends Controller {

	public function ueditor(){
        $data = new \Org\Util\Ueditor();
        echo $data->output();
    }

    public function plupload(){
    	$data = new \Org\Util\Ueditor();
        $json = $data->output();
        $result = json_decode($json, 1);
        if('SUCCESS' == $result['state']){
        	$output = array(
        		'jsonrpc'=>'2.0',
        		'ok'=>1,
        		'path'=>$result['url'],
    		);
        }else{
        	$output = array(
        		'jsonrpc'=>'2.0',
        		'ok'=>0,
        		'code'=>$result['state'],
    		);
        }
        die(json_encode($output));
    }
}