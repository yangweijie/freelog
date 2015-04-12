<?php
return array(
	//'配置项'=>'配置值'
    'TMPL_PARSE_STRING' => array(
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__BOWER__'=>__ROOT__. '/Public/bower_components',
        '__IMG__' => __ROOT__ . '/Public/images',
        '__CSS__' => __ROOT__ . '/Public/css',
        '__JS__' => __ROOT__ . '/Public/js',
    ),


    'SHOW_PAGE_TRACE'    => 1,
    /* SESSION配置 */
    'SESSION_PREFIX'     => 'admin', //session前缀
    'VAR_SESSION_ID'     => 'session_id',
    'DEFAULT_CONTROLLER' => 'System',

    /* 项目其他配置 */
    'FILE_SYSTEM_ENCODE' => IS_WIN ? 'GBK' : 'UTF-8',
    'USER_AUTH_KEY' => 'admin_user',
    'USER_AUTH_SIGN_KEY' => 'admin_user_sign',
    'ADMIN'=>array(
    	'LOGIN_NAME' => 'freelog',
    	'PWD'        => '1e93a481041ecce1d27957fb9012d420', //jay2015 32位md5值
	),
);