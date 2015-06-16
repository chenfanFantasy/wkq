<?php
class Core{
	private static $classFile;
	private static $_instance = array();
	private function __construct(){
		date_default_timezone_set("Asia/shanghai");
		
		if(!defined("WEB_PATH")){
			define("WEB_PATH", str_replace(DIRECTORY_SEPARATOR, '/', dirname(__FILE__).DIRECTORY_SEPARATOR));
		}
		
		include WEB_PATH.'lib/common.php';
		C(include WEB_PATH.'conf/common.php');	//加载文件配置
		include	WEB_PATH."lib/php-export-data.class.php";	//excel
		include	WEB_PATH."lib/log.php";
		include	WEB_PATH."lib/functions.php";
		include	WEB_PATH."lib/page.php";
		include	WEB_PATH."lib/template.php";		//PHPLIB 的模板类
		include	WEB_PATH."lib/cache/cache.php";		//memcache缓存
		include WEB_PATH."lib/cache/file_cache.php";//文件缓存
		
		//数据库链接配置
		if(C('DATAGATE') == 'db'){
			$db	= C('DB_TYPE');
			include	WEB_PATH."lib/db/".$db.".php";	//db直连
			if($db	== 'mysql'){
				global $dbConn;
				$db_config	= C('DB_CONFIG');
				$dbConn	= new mysql();
				$dbConn->connect($db_config["master1"][0],$db_config["master1"][1],$db_config["master1"][2]);
				$dbConn->select_db($db_config["master1"][4]);
			}
			if($db == 'mongodb'){
			}
		}
		//print_r($dbConn);
		//初始化memcache类
		global $memc_obj,$redis_obj, $file_cache;
		$memc_obj 	= new Cache(C('CACHEGROUP'));
		$file_cache	= new FileCache();
		//自动加载类
		spl_autoload_register(array('Core', 'autoload'));
		
		
	}
	
	/**
	 * 函数说明：自动加载对应的view、action、model文件
	 * @param string $class
	 * @throws Exception
	 */
	public function autoload($class){
		//加载act
		if(substr($class, -3) == "Act"){
			$name = preg_replace("/Act/","",$class);
			$fileName = lcfirst($name).".action.php";
			Core::getFile($fileName,WEB_PATH."action/");
			if(empty(Core::$classFile)){
				throw new Exception("action no exits");
			}
			include_once Core::$classFile;
		}
	
		if(substr($class, -5) == "Model"){
			$name = preg_replace("/Model/","",$class);
			$fileName = lcfirst($name).".model.php";
			Core::getFile($fileName,WEB_PATH."model/");
			if(empty(Core::$classFile)){
				throw new Exception("action no exits");
			}
			include_once Core::$classFile;
		}
	
		if(substr($class, -4) == "View"){
			$name = preg_replace("/View/","",$class);
			$fileName = lcfirst($name).".view.php";
			Core::getFile($fileName,WEB_PATH."view/");
			if(empty(Core::$classFile)){
				throw new Exception("action no exits");
			}
			include_once Core::$classFile;
		}
	}
	
	/**
	 * 函数说明：获取文件的路径
	 * @param string $fileName
	 * @param string $path
	 */
	public static function getFile($fileName,$path){
		if ($handle = @opendir($path)) {
			while(false !== ($file = @readdir($handle))) {
				if(is_dir($path.$file) && ($file != "." && $file != "..")){
					Core::getFile($fileName,$path.$file."/");
				}else{
					if($file==$fileName){
						Core::$classFile	=	$path.$file;
					}
				}
			}
		}
		@closedir($handle);
	}
	
	public static function getInstance(){
		if(!(self::$_instance instanceof self)){
			self::$_instance	= new Core();
		}
		return self::$_instance;
	}
}

?>