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
        'file',
        'config',
    );

    public function _initialize(){
        $this->resource_name = strtolower(CONTROLLER_NAME);
        $this->messages = array(
            'get'    => 'get',
            'put'    => 'update',
            'post'   => 'add',
            'delete' => 'delete',
        );
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

    public function _empty($name){
        $table = $this->resource_name;
        if(!in_array($table, $this->otherResource)){
            //先判断表存不存在
            if(!M()->query("SHOW TABLES LIKE '".C('DB_PREFIX')."{$table}'")){
               $this->response(array('code'=>404, 'message'=> "Resource '{$this->resource_name}' doesn't exist"), $this->defaultType, 404);
            }
        }else{
            if(method_exists($this, $table))
                $this->$table($name);
        }

        // $model = new PostModel();
        $model = D(ucfirst($table));
        $result = true;
        $data = array();
        $code = 404;
        $url = '';
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
                $puts = $model->create(I('put.'));
                if(false === $puts){
                    $result = false;
                    $data = $model->getError();
                }else{
                    $id = intval($name);
                    if($find = $model->find($id)){
                        $result = false !== $model->save($puts);
                        $code = $result? 200: 404;
                    }else{
                        $result = false;
                        $data = "record not found";
                        $code = 412;
                    }
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
                slog($id);
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
            $this->success($data, $code, $url);
        }else{
            $this->error($data, $code, $url);
        }
    }

    public function config($name = 0){
        $model = D('Config');
        $result = true;
        $data = array();
        $code = 404;
        $url = '';
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
            case 'put':
                if('save' == $name){
                    // 批量更新资源
                    $config = I('put.config');
                    if(empty($config)){
                        $result = false;
                        $data = '表单为空';
                    }else{
                        if($config && is_array($config)){
                            foreach ($config as $name => $value) {
                                $map = array('name' => $name);
                                $model->where($map)->setField('value', $value);
                            }
                        }
                        S('DB_CONFIG_DATA',null);
                        $code = 200;
                    }
                }else{
                    $puts = $model->create(I('put.'));
                    if(false === $puts){
                        $result = false;
                        $data = $model->getError();
                    }else{
                        $id = $puts['id'];
                        if($find = $model->find($id)){
                            $result = false !== $model->save($puts);
                            $code = $result? 200: 404;
                        }else{
                            $result = false;
                            $data = "record not found";
                            $code = 412;
                        }
                    }
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
                        $url = '/admin.php/Config/index';
                    }
                }
                break;
            case 'delete':// 删除资源
                // parse_str(file_get_contents('php://input'), $_DELETE);
                // slog($_DELETE);
                $id = array_unique((array)I('get.id',0));
                slog($id);
                if ( empty($id) ) {
                    $code = 404;
                    $data = '请选择要操作的数据';
                }else{
                    $code = 200;
                    $map = array('id' => array('in', $id) );
                    if(M('Config')->where($map)->delete()){
                        S('DB_CONFIG_DATA',null);
                        //记录行为
                        $url = '/admin.php/Config/index';
                        $data = '删除成功';
                    } else {
                        $code = 412;
                        $result = false;
                        $data = '删除失败！';
                    }
                }
                break;
        }
        if($result){
            $this->success($data, $code, $url);
        }else{
            $this->error($data, $code, $url);
        }
    }

    public function success($data, $code=200, $url=''){
        $response = array(
            'code'=>$code,
            'data'=>$data,
            'info'=>"{$this->resource_name} {$this->messages[$this->_method]} succeed"
        );
        if($url)
            $response['url'] = $url;
        $this->response($response, $this->defaultType, $code);
    }

    public function error($data, $code=404, $url=''){
          $response = array(
            'code'=>$code,
            'info'=>"{$this->resource_name} {$this->messages[$this->_method]} failed"
        );
        if($data)
            $response['info'] .= ". reason: {$data}";
        if($url)
            $response['url'] = $url;
        $this->response($response, $this->defaultType, $code);
    }
}
