<?php

// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2012 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: yangweijie@topthink.net <www.thinkphp.cn>
// +----------------------------------------------------------------------

namespace Admin\Controller;

use Think\Controller;
use Think\Model as MODEL;
use Com\Page;

class CommonController extends Controller {

    //初始化方法
    protected function _initialize() {
        is_login() || $this->redirect('System/login');
        /* 读取数据库中的配置 */
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

    protected function _list($params) {
        extract($params);
        if (!isset($map))
            $map = array();
        if (!isset($parameter))
            $parameter = array();
        if (!isset($list))
            $list = array();
        if (!isset($params['source'])) {
            $this->error('错误的数据');
        } else {
            $params = array(
                'source' => $source,
                'map' => $map,
                'parameter' => $parameter,
                'listvar' => $list,
                'order' => isset($order) ? $order : '',
            );
            if (I('listRows'))
                $params['listRows'] = I('listRows');

            $this->page($params);
            if (!isset($tpl))
                $tpl = '';
            $this->display($tpl);
        }
    }

    /**
     * 通用分页列表数据集获取方法
     *
     *  可以通过url参数传递where条件,例如:  index.html?name=asdfasdfasdfddds
     *  可以通过url空值排序字段和方式,例如: index.html?_field=id&_order=asc
     *  可以通过url参数r指定每页数据条数,例如: index.html?r=5
     *
     * @param sting|Model  $model   模型名或模型实例
     * @param array        $where   where查询条件(优先级: $where>$_REQUEST>模型设定)
     * @param array|string $order   排序条件,传入null时使用sql默认排序或模型属性(优先级最高);
     *                              请求参数中如果指定了_order和_field则据此排序(优先级第二);
     *                              否则使用$order参数(如果$order参数,且模型也没有设定过order,则取主键降序);
     *
     * @param array        $base    基本的查询条件
     * @param boolean      $field   单表模型用不到该参数,要用在多表join时为field()方法指定参数
     * @author 朱亚杰 <xcoolcc@gmail.com>
     *
     * @return array|false
     * 返回数据集
     */
    protected function lists ($model,$where=array(),$order='',$base = array(),$field=true){
        $options = array();
        $REQUEST = (array)I('request.');
        if(is_string($model)){
            $model = M($model);
        }

        $OPT = new \ReflectionProperty($model,'options');
        $OPT->setAccessible(true);

        $pk = $model->getPk();
        if($order === null){
            //order置空
        }else if ( isset($REQUEST['_order']) && isset($REQUEST['_field']) && in_array(strtolower($REQUEST['_order']),array('desc','asc')) ) {
            $options['order'] = '`'.$REQUEST['_field'].'` '.$REQUEST['_order'];
        }elseif( $order === '' && empty($options['order']) && !empty($pk) ){
            $options['order'] = $pk.' desc';
        }elseif($order){
            $options['order'] = $order;
        }
        unset($REQUEST['_order'],$REQUEST['_field']);

        $options['where'] = array_filter(array_merge( (array)$base, /*$REQUEST,*/ (array)$where ),function($val){
            if($val === '' || $val === null){
                return false;
            }else{
                return true;
            }
        });

        if( empty($options['where'])){
            unset($options['where']);
        }
        $options      =   array_merge( (array)$OPT->getValue($model), $options );
        $total        =   $model->where($options['where'])->count();

        if( isset($REQUEST['r']) ){
            $listRows = (int)$REQUEST['r'];
        }else{
            $listRows = C('LIST_ROWS') > 0 ? C('LIST_ROWS') : 10;
        }
        $page = new Page($total, $listRows, $REQUEST);
        if($total>$listRows){
            $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        }
        $p =$page->show();
        $this->assign('_page', $p? $p: '');
        $this->assign('_total',$total);
        $options['limit'] = $page->firstRow.','.$page->listRows;

        $model->setProperty('options',$options);

        return $model->field($field)->select();
    }

    protected function _edit() {
        $model = $_GET['model'] ? $_GET['model'] : CONTROLLER_NAME;
        $map = array(D($model)->getPk() => urldecode($_GET['id']));
        $record = D($model)->where($map)->find();
        if ($record) {
            $this->assign('record', $record);
            if (IS_AJAX) {
                exit($this->fetch());
            } else {
                $this->display();
            }
        } else {
            exit('错误的数据');
        }
    }

    //editble ajax更新方法
    public function ajaxUpdate() {
        $_POST = array(
            'id' => I('pk'),
            I('name') => I('value')
        );
        $this->update();
    }

    public function editbleAjaxGet($model, $field) {
        $list = D($model)->field($field)->select();
        exit(json_encode($list));
    }

    /**
     * 分页函数 支持数据库查询分页和数组分页 数据库分页直接传数据表名称
     * @access public
     * @param mixed  $source 分页用数据源，可以是数组或数据表
     * @param array  $map数据源为数据表的时候的查询条件
     * @param string $parameter  分页跳转的参数
     * @param string $listvar    赋给模板遍历的变量名 默认list
     * @param int    $listRows  每页显示记录数 默认20
     */
    protected function page($param) {
        extract($param);
        if (!isset($group))
            $group = array();
        $flag = !is_array($source);
        $listvar = $listvar ? $listvar : 'list';
        if (!isset($listRows))
            $listRows = C('LIST_ROWS');
        //总记录数
        if ($flag) {//字符串
            if (!isset($count))
                $count = '*';
            $totalRows = D($source)->where($map)->count($count);
        }else {
            $totalRows = ($source) ? count($source) : 1;
        }
        //创建分页对象
        $p = new Page($totalRows, $listRows, $parameter);
        //抽取数据
        if ($flag) {
            $voList = D($source)->where($map)->group($group)->order($order)->limit($p->firstRow . ',' . $p->listRows)->select();
            trace(D($source)->_sql(), 'sql');
        } else {
            $voList = array_slice($source, $p->firstRow, $p->listRows);
        }
        $pages = array(
            'theme' => '%UP_PAGE% %LINK_PAGE% %DOWN_PAGE%',
        ); //要ajax分页配置PAGE中必须theme带%ajax%，其他字符串替换统一在配置文件中设置，
        foreach ($pages as $key => $value) {
            $p->setConfig($key, $value); // 'theme'=>'%upPage% %linkPage% %downPage% %ajax%'; 要带 %ajax%
        }
        //分页显示
        $page = $p->show();
        //模板赋值
        $this->assign($listvar, $voList);
        $this->assign("_page", $page);
        $this->assign('count', $totalRows);
        $varPage = C('VAR_PAGE') ? C('VAR_PAGE') : 'p';
        $this->assign('currentPage', !empty($_GET[$varPage]) ? intval($_GET[$varPage]) : 1);
        $this->assign('listRows', $listRows);
        return $voList;
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
