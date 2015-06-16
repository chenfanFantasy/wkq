<?php
if(!defined("WEB_PATH")){
	exit;
}
return array(
		
		//日志相关
		"LOG_PATH"	    	=>	WEB_PATH."log/",	//文件日志目录
		"IS_AUTH_ON"		=> false,		//前台是否需要验证
		"BACK_IS_AUTH_ON"	=> false,	//后台是否需要验证
		//数据接口相关
		"DATAGATE"		=>	"db",		//	数据接口层 cache, db, socket
		"DB_TYPE"		=>	"mysql",	//	mysql	mssql	postsql	mongodb
		"CACHEGROUP"	=>	"news",
		"DB_PREFIX"		=>	"wkq_",
		"DB_CONFIG"		=>	array(
				"master1"	=>	array("localhost","root","123456","3306","wkq_system")//主DB
		),
		"IS_AUTH_MODULE"	=> array("login/login"),
		"BACK_IS_AUTH_MODULE"	=> array("admin/login"),
);
?>