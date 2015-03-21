<?php
namespace Api\Controller;
use Think\Controller\RestController;
class EmptyController extends RestController{

    protected $allowMethod    = array('get','post','put','delete'); // REST允许的请求类型列表
    protected $allowType      = array('json');                      // REST允许请求的资源类型列表
    protected $defaultType    = 'json';
    protected $allowOutputType = array(
        'json' => 'application/json',
    );

    protected $otherResource = array(
        'pic',
        'file'
    );

    public function _initialize(){
        $this->resource_name = strtolower(CONTROLLER_NAME);
        $this->messages = array(
            'get'    => 'get',
            'put'    => 'update',
            'post'   => 'add',
            'delete' => 'delete',
        );
    }

    public function _empty($name){
        $table = $this->resource_name;
        if(!in_array($this->otherResource, $table)){
            //先判断表存不存在
            if(!M()->query("SHOW TABLES LIKE '".C('DB_PREFIX')."{$table}'")){
               $this->response(array('code'=>404, 'message'=> "Resource '{$this->resource_name}' doesn't exist"), $this->defaultType, 404);
            }
        }
        // $model = new PostModel();
        $model = D(ucfirst($table));
        $result = true;
        $code = 404;
        switch ($this->_method){
            case 'head':
                break;
            case 'option':
                break;
            case 'get': // 列出资源
                if('list' == $name){
                    $data = $model->select();
                }else{
                    $id = intval($name);
                    $data = $model->find($id);
                }
                if($model->getError() || $model->getDbError()){
                    $result = false;
                }else{
                    $code = 200;
                }
                break;
            case 'put': // 更新资源
                $puts = $model->create();
                if(false == $puts){
                    $result = false;
                    $data = $model->getError();
                }
                $id = intval($name);
                if($find = $model->find($id)){
                    $result = false == $model->save($puts);
                    $code = $result? 200: 404;
                }else{
                    $result = false;
                    $data = "record not found";
                    $code = 412;
                }
                break;
            case 'post': // 新增资源
                $posts = $model->create();
                if(false == $posts){
                    $data = $model->getError();
                    $result = false;
                }else{
                    $id = $model->add();
                    if(!$id){
                        $result = false;
                    }else{
                        $code = 201;
                        $data = $id;
                    }
                }
                break;
            case 'delete':// 删除资源
                $id = intval($name);
                if($find = $model->find($id)){
                    $result = $model->delete($id);
                    $code = $result? 200: 404;
                }else{
                    $result = false;
                    $data = "record not found";
                    $code = 412;
                }
                break;
        }
        if($result){
            $this->success($data, $code);
        }else{
            $this->success($data, $code);
        }
    }

    public function success($data, $code=200){
        $response = array(
            'code'=>$code,
            'data'=>$data,
            'message'=>"{$this->resource_name} {$this->messages[$this->_method]} succeed"
        );
        $this->response($response, $this->defaultType, $code);
    }

    public function error($data, $code=404){
          $response = array(
            'code'=>$code,
            'message'=>"{$this->resource_name} {$this->messages[$this->_method]} failed"
        );
        if($data)
            $response['message'] .= ". reason: {$data}";
        $this->response($response, $this->defaultType, $code);
    }
}
