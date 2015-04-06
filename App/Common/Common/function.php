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

	function get_nickname_by_uid ($uid = 0){
		return 0 == intval($uid) ? '系统发布': M('Member')->getFieldById($uid, 'nickname');
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
	            $link[] = '<a href="'. U('/') . '?tag='.$value.'"><span class="label label-info">' . $value . '</span></a>';
	        }
	        return join($link,',');
	    }else{
	        return $tags? $tags : '';
	    }
	}

	/**
	 * 网站上文件模拟上传，避免重复，且可以统一管理
	 * @param $local_file string 本地文件绝对路径，
	 * @param $model string  Picture 或 File 走哪个模型 对应图片 和普通文件
	 * @param $save_path string 保存的目标路径，尽量和项目中2种文件一致，当然支持自定义
	 * @return array 成功返回array('status'=>1, 'id'=>1, 'path'=>'./Uploads/picture/2015_04_05_09_45_00.png') 类似地址， 失败status=0, error=失败原因
	 */
	function local_upload($local_file, $model = 'Pictrue', $saveroot = './Uploads/picture/'){
        if (!$local_file)
            return array('status'=>0, 'error'=>'文件路径为空');
		$md5 = md5_file($local_file);
        if($record = M($model)->where("md5 = '{$md5}'")->find()){
            return array('status'=>1, 'id'=>$record['id'], 'path'=>$record['path']);
        }
        $upload_config = C(strtoupper($model).'_UPLOAD');
        $ext_arr = explode(',', $upload_config['exts']);
        $ext = strtolower(end(explode('.', $local_file)));
        if (!in_array($ext, $ext_arr))
            return array('status'=>0, 'error'=>"非法后缀{$ext}");

        $filename = uniqid();
        if($upload_config['autoSub']){
            $rule = $upload_config['subName'];
            $name = '';
            if(is_array($rule)){ //数组规则
                $func     = $rule[0];
                $param    = (array)$rule[1];
                foreach ($param as &$value) {
                   $value = str_replace('__FILE__', $filename, $value);
                }
                $name = call_user_func_array($func, $param);
            } elseif (is_string($rule)){ //字符串规则
                if(function_exists($rule)){
                    $name = call_user_func($rule);
                } else {
                    $name = $rule;
                }
            }
            $savepath .= $name.'/';
        }
        $savepath = $saveroot. $savepath;
        if (!is_dir($savepath)){
        	if(!mkdir($savepath, 0777))
            	return array('status'=>0, 'error'=>"创建保存目录{$savepath}失败");
        }
        if (!is_readable($savepath)){
            chmod($savepath, 0777);
        }

        $filename = $savepath . $filename . '.' . $ext;

        ob_start();
        readfile($local_file);
        $file = ob_get_contents();
        ob_end_clean();
        $size = strlen($file);
        slog($filename);
        $fp2 = @fopen($filename, "a");
        if(false === fwrite($fp2, $file)){
        	return array('status'=>0, 'error'=>'写入目标文件失败');
        }
        fclose($fp2);
        $data = array(
        	'name'		  => end(explode('/', $local_file)),
            'path'        => str_replace('./', '/', $filename),
            'md5'         => $md5,
            'sha1'        => sha1($filename),
            'status'      => 1,
            'create_time' => NOW_TIME,
        );
        $id = M($model)->add($data);
        slog($local_file);
        @unlink($local_file);
        if(false === $id){
        	@unlink($filename);
        	return array('status'=>0, 'error'=>'保存上传文件记录失败');
        }else{
        	return array('status'=>1, 'id'=>$id, 'path'=>$data['path']);
        }
	}