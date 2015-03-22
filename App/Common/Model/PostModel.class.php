<?php
namespace Common\Model;
Use Think\Model;

class PostModel extends Model{

	protected $_auto = array (
		array('status','1'),  // 新增的时候把status字段设置为1
		array('create_at','datetime', self::MODEL_INSERT, 'function'), // 对create_at字段在更新的时候写入当前时间戳
		array('deadline','getDeadline', self::MODEL_INSERT, 'callback'), // 对name字段在新增的时候回调getName方法
		array('update_at','datetime', self::MODEL_BOTH, 'function'), // 对update_at字段在更新的时候写入当前时间戳
        array('content', 'encode', self::MODEL_BOTH, 'callback'), //对内容字段 根据type选择进行json_encode
		array('view', 0, self::MODEL_INSERT),
        array('comment', 0, self::MODEL_INSERT),
	);

	protected $_validate = array(
		array('verify','require','验证码必须！'), //默认情况下用正则进行验证
		array('name','','帐号名称已经存在！',0,'unique',1), // 在新增的时候验证name字段是否唯一
		array('value',array(1,2,3),'值的范围不正确！',2,'in'), // 当值不为空的时候判断是否在一个范围内
		array('repassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
		array('password','checkPwd','密码格式不正确',0,'function'), // 自定义函数验证密码格式
	);

    //截止日期处理
	public function getDeadline($deadline){
		if('now' == I('request.create_time_choose')){
			return datetime('now');
		}else{
			return datetime($deadline);
		}
	}

    //内容字段加密
    public function encode($content){
        if(in_array(I('post.type'), array('picture', 'music')))
            return json_encode($content);
        else
            return $content;
    }

	// 新增数据前的回调方法
    protected function _after_insert(&$data,$options) {
    	$this->_after_update($data, $options);
    }

    // 更新成功后的回调方法
    protected function _after_update($data,$options) {
        //处理标签
        $tags = $data['tags'];
        $tags = explode(',', $tags);
        if($tags === FALSE){
            $tags = array();
        }
        $tagsModel = M('Tags');
        if($_POST['id']){
            //更新时候先将原有标签统计减去1
            $orignal_tags = $this->getFieldById('tags', $data['id']);
            if($orignal_tags)
                $tagsModel->where(array('title'=>array('in', $orignal_tags)))->setDec('count');
        }

        foreach ($tags as $value) {
            if($tagsModel->where("title = '{$value}'")->find())
                $tagsModel->where("title = '{$value}'")->setInc('count');
            else
                if($value)
                    $tagsModel->add(array('title'=>$value, 'count'=>1));
        }
    }
}