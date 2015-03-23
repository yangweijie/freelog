<?php

	function datetime($str = 'now'){
	    return @date("Y-m-d H:i:s" ,strtotime( $str ));
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