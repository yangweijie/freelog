<?php

	function datetime($str = 'now'){
	    return @date("Y-m-d H:i:s" ,strtotime( $str ));
	}