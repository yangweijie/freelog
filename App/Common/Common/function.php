<?php

	function datetime($str = 'now'){
	    return @date("Y-m-d H:i:s" ,strtotime( $str ));
	}

	//密码加密
	function password($password){
		$md5str=md5($password);
		$salt=get_password_salt($md5str);
		return hash('sha256',$md5str.$salt);
	}

	function get_password_salt($md5str,$d=1001){
		$crc32_value = floatval(sprintf("%u", crc32($md5str)));
		$crc32_value = ($crc32_value > PHP_INT_MAX) ?
			(($crc32_value - PHP_INT_MAX ) % $d + PHP_INT_MAX % $d) % $d : $crc32_value % $d;
		return $crc32_value;
	}

	/**
	 * 判断是否登录，如果登录了返回uid
	 */
	function is_login(){
		return session('?user')? session('user.uid'): 0;
	}

	/**
	 * 快速文件数据读取和保存 针对简单类型数据 字符串、数组
	 * @param string $name 缓存名称
	 * @param mixed $value 缓存值
	 * @param string $path 缓存路径
	 * @return mixed
	 */
	function d_f($name, $value, $path = DATA_PATH) {
	    static $_cache = array();
	    $filename = $path . $name . '.php';
	    if ('' !== $value) {
	        if (is_null($value)) {
	            // 删除缓存
	            // return false !== strpos($name,'*')?array_map("unlink", glob($filename)):unlink($filename);
	        } else {
	            // 缓存数据
	            $dir = dirname($filename);
	            // 目录不存在则创建
	            if (!is_dir($dir))
	                mkdir($dir, 0755, true);
	            $_cache[$name] = $value;
	            $content = strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>") . PHP_EOL;
	            return file_put_contents($filename, $content, FILE_APPEND);
	        }
	    }
	    if (isset($_cache[$name]))
	        return $_cache[$name];
	    // 获取缓存数据
	    if (is_file($filename)) {
	        $value = include $filename;
	        $_cache[$name] = $value;
	    } else {
	        $value = false;
	    }
	    return $value;
	}

	function friendly_datetime($datetime){
		return date('Y/m/d H:i:s A', strtotime($datetime));
	}

	/**
	 * 获取文档封面图片
	 * @param int $cover_id
	 * @param string $field
	 * @return 完整的数据  或者  指定的$field字段值
	 * @author huajie <banhuajie@163.com>
	 */
	function get_cover($cover_id, $field = 'path'){
	    if(empty($cover_id)){
	        return false;
	    }
	    $picture = M('Picture')->where(array('status'=>1))->getById($cover_id);
	    if($field == 'path'){
	        if(!empty($picture['url'])){
	            $picture['path'] = $picture['url'];
	        }else{
	            $picture['path'] = __ROOT__.$picture['path'];
	        }
	    }
	    return empty($field) ? $picture : $picture[$field];
	}

	/**
	 * 获取文档封面图片
	 * @param int $cover_id
	 * @param string $field
	 * @return 完整的数据  或者  指定的$field字段值
	 * @author huajie <banhuajie@163.com>
	 */
	function get_file($id, $field = 'path'){
	    if(empty($id)){
	        return false;
	    }
	    $file = M('File')->where(array('status'=>1))->getById($id);
	    if($field == 'path'){
	        if(!empty($file['url'])){
	            $file['path'] = $file['url'];
	        }else{
	            $file['path'] = __ROOT__.$file['path'];
	        }
	    }
	    return empty($field) ? $file : $file[$field];
	}

	/**
	 * 获取标签的显示
	 */
	function get_tag($tags, $link = true){
		if($link && $tags){
	        $tags = explode(',', $tags);
	        $link = array();
	        foreach ($tags as $value) {
	            $link[] = '<a href="'.U('/').'?tag='.$value.'"><span class="label label-info">'.$value.'</span></a>';
	        }
	        return join($link,',');
	    }else{
	        return $tags? $tags : '';
	    }
	}