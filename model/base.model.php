<?php
/**
 * 类名：BaseModel
 * 功能：数据库操作语句基类
 * 版本：1.0
 * 日期：2015-3-6
 * 作者：杨友能
 */
defined('WEB_PATH') ? '' : exit;
class BaseModel {
	protected 		 	$dbConn			= '';
	protected			$options		= array();
	private		static $_sql			= array();
	protected	static $errMsg  		= array();
	public		static $tablePrefix		= '';
	protected			$cache			= '';
	public		static $lastInsertId	= 0;
	private		static $transaction		= 0;
	public 		static $changetablePrefix= '';  //支持更换表前缀
	
	public function __construct(){
		if(!is_object($this->dbConn)){
			$this->initDB();
		}
	}
	
	/**
	 * 函数说明：数据库连接
	 */
	private function initDB(){
		global $dbConn;
		$this->dbConn	= $dbConn;
		$this->dbConn->query("set names 'utf8'");
	}
	
	/**
	 * 函数说明：魔法函数
	 * @param string $method
	 * @param array $args
	 * @return BaseModel
	 */
	public function __call($method,$args){ 
		$allowFun	= array('sql', 'sort', 'limit', 'page', 'perpage', 'key');
		$method		= strtolower($method);
		if(in_array($method, $allowFun, true)){
			$this->options[$method]	= $args[0];
			return $this;
		} else if(1){
			return false;
		}
	}
	
	/**
	 * 函数说明：获取数据
	 * @param array $source
	 * @param number $cacheTime
	 * @return array
	 */
	protected  function select($source = array('mysql'), $cacheTime = 900){
		$sql		= isset($this->options['sql'])		? $this->options['sql'] : '';
		$sort		= isset($this->options['sort'])		? $this->options['sort'] : '';
		$page		= isset($this->options['page'])		? $this->options['page'] : 1;
		$perpage	= isset($this->options['perpage'])	? $this->options['perpage'] : 10;
		$limit		= isset($this->options['limit'])	? $this->options['limit'] : '';
		if(empty($sql)){
			self::$errMsg['10010']	= 'select语句为空！';
			return array();
		}
		self::$_sql[]	= $sql;
		if(preg_match("/^\s*select/i", $sql) > 0 && $limit !== '*'){
			$limit		= intval($limit) > 0 ? intval($limit) : ($page-1)*$perpage.", $perpage";
			$limit		= ' LIMIT '.($limit);
		} else {
			$limit		= '';
		}
		$sql			= "{$sql} {$sort} {$limit}";
		$cacheKey		= 'sql_select_'.md5($sql);
		if(in_array('mysql', $source)){
			$res		= $this->dbConn->query($sql);
			$mysqlData	= $this->dbConn->fetch_array_all($res);//理解-----------------
			if(in_array('cache', $source)){
				$this->cache->set($cacheKey, json_encode($mysqlData), $cacheTime);
			}
			self::$errMsg["200"]	= '执行成功';
			return  $mysqlData;
		}
		return array();
	}
	
	/**
	 * 函数说明：插入数据
	 * @return boolean
	 */
	protected function insert(){
		$sql		= isset($this->options['sql'])		? $this->options['sql'] : '';
		if(empty($sql)){
			self::$errMsg['10010']	= 'insert语句为空！';
			return false;
		}
		self::$_sql[]	= $sql;
		$res			= $this->dbConn->query($sql);
		if($res){
			self::$lastInsertId		= mysql_insert_id();
			return true;
		} else {
			self::$errMsg['10011']	= '插入数据失败';
			return false;
		}
	}
	
	/**
	 * 函数说明：更新数据
	 * @return boolean
	 */
	protected function update(){
		$sql		= isset($this->options['sql'])		? $this->options['sql'] : '';
		if(empty($sql)){
			self::$errMsg['10010']	= 'update语句为空！';
			return false;
		}
		self::$_sql[]	= $sql;
		return $this->dbConn->query($sql);
	}
	
	/**
	 * 函数说明：删除数据
	 * @return boolean
	 */
	protected function delete(){
		$sql		= isset($this->options['sql'])		? $this->options['sql'] : '';
		if(empty($sql)){
			self::$errMsg['10010']	= 'delete语句为空！';
			return false;
		}
		if (preg_match("/^\s*update.*is_delete\s*=\s*1/i", $sql)==0){
			self::$errMsg['10012'] = "delete语句有错！";
			return false;
		}
		self::$_sql[]	= $sql;
		$res			= $this->dbConn->query($sql);
		if($res){
			return true;
		} else {
			self::$errMsg['10014'] = "删除数据失败！";
			return true;
		}
	}
	
	/**
	 * 函数说明：获取数量
	 * @param array $source
	 * @param number $cacheTime
	 * @return number
	 */
	protected function count($source = array('mysql'), $cacheTime = 900){
		$sql		= isset($this->options['sql'])		? $this->options['sql'] : '';
		if(empty($sql)){
			self::$errMsg['10010']	= 'count语句为空！';
			return 0;
		}
		self::$_sql[]	= $sql;
		$cacheKey		= 'sql_count_'.md5($sql);
		if(in_array('mysql', $source)){
			$res		= $this->dbConn->query($sql);
			$mysqlData	= $this->dbConn->fetch_array_all($res);//理解-----------------
			if(in_array('cache', $source)){
				$this->cache->set($cacheKey, json_encode($mysqlData), $cacheTime);
			}
			self::$errMsg['200']	= '执行成功';
			return  $mysqlData;
		}
		return 0;
	}
	
	/**
	 * 跟进类名转化为表名
	 * @return string 数据表名
	 * @author yyn
	 */
	protected function getTableName(){
		$tablePrefix =   empty(self::$changetablePrefix) ? C('DB_PREFIX') : self::$changetablePrefix;
		$tableMod    =   hump2underline(lcfirst(str_replace('Model', '', get_class($this))));
		$table       =   $tablePrefix.$tableMod;
		return $table;
	}
	
	/**
	 * 函数说明：获取最后一次插入数据行的ID
	 * @return number
	 */
	public function getLastInsetId(){
		return self::$lastInsertId;
	}
	
	/**
	 * 函数说明：获取最后一次执行的sql语句
	 * @return string
	 */
	public function getLastRunSql(){
		return array_pop(self::$_sql);
	}
	
	/**
	 * 函数说明：获取执行的所有sql语句
	 * @return array:
	 */
	public function getAllRunSql(){
		return self::$_sql;
	}
 }

?>