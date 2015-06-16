<?php
/**
 * 类名：CommonModel :: BaseModel
 * 功能：公共数据库层操作函数
 * 版本：1.0
 * 日期：2015-3-7
 * 作者：杨友能
 */
class CommonModel extends BaseModel{
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * 函数说明：插入数据
	 * @param string $table
	 * @param array $data
	 * @return boolean
	 */
	public function insertData($data){
		$sql	= "INSERT INTO ".tableToSqlTable($this->getTableName())." SET ".array2sql($data);
		//echo $sql;
		return $this->sql($sql)->insert();
	}
	
	/**
	 * 函数说明：根据id更新数据
	 * @param atring $table
	 * @param string|int $id
	 * @param array $data
	 * @return boolean
	 */
	public function updateData($id, $data){
		if(empty($id)){
			self::$errMsg['10021']	= '更新的主键为空！';
		}
		$sql	= "UPDATE ".tableToSqlTable($this->getTableName())." SET ".array2sql($data)." WHERE id = ".$id;
		return $this->sql($sql)->update();
	}
	
	/**
	 * 函数说明：根据条件组更新信息
	 * @param string $table
	 * @param string|array $whereArr
	 * @param array $data
	 * @return array
	 */
	public function updataDataWhere($whereArr, $data){
		$where	= '1';
		if(empty($whereArr)){
			$where	= '1';
		} else if(is_array($whereArr)){
			$where	= array3where($whereArr);
		} else {
			$where	= $whereArr;
		}
		if(strpos($where, "is_delete") === false){
			$where	.= " AND is_delete = 0";
		}
		$sql	= "UPDATE ".tableToSqlTable($this->getTableName())." SET ".array2sql($data)." WHERE ".$where;
		return $this->sql($sql)->update();
	}
	
	/**
	 * 函数说明：删除数据
	 * @param string $table
	 * @param string|int $id
	 * @return boolean
	 */
	public function deleteData($id){
		if(empty($id)){
			self::$errMsg['10021']	= '删除数据的主键为空！';
		}
		$sql	= "UPDATE ".tableToSqlTable($this->getTableName())." SET is_delete = 1 WHERE id = ".$id;
		return $this->sql($sql)->delete();
	}
	
	/**
	 * 函数说明：查询数据（不分页）
	 * @param string $table
	 * @param string|array $filedArr
	 * @param string|array $whereArr
	 * @param string $sort
	 * @param string $limit
	 * @return array 
	 */
	public function getAllDatas($filedArr = '*',$whereArr = '1', $sort = 'ORDER BY id DESC', $limit = ' * '){
		$filed	= '';
		$where	= '1';
		if(empty($filedArr)){
			$filed	= '*';
		} else if(is_array($filedArr)){
			$filed	= '`'.implode('`,`', $filedArr).'`';
		} else {
			$filed	= $filedArr;
		}
		if(empty($whereArr)){
			$where	= '1';
		} else if(is_array($whereArr)){
			$where	= array3where($whereArr);
		} else {
			$where	= $whereArr;
		}
		if(strpos($where, "is_delete") === false){
			$where	.= " AND is_delete = 0";
		}
		$sql	= "SELECT ".$filed." FROM ".tableToSqlTable($this->getTableName())." WHERE ".$where;
		//echo $sql;
		return $this->sql($sql)->limit($limit)->sort($sort)->select(array('mysql'));
	}
	
	/**
	 * 函数说明：查询数据（分页查询）
	 * @param string $table
	 * @param string|array $filedArr
	 * @param string|array $whereArr
	 * @param string $sort
	 * @param string $page
	 * @param string $perpage
	 * @return array
	 */
	public function getDatas($filedArr = '*', $whereArr = '1', $sort = 'ORDER BY id DESC', $page = '1', $perpage = '10'){
		$filed	= '';
		$where	= '1';
		if(empty($filedArr)){
			$filed	= '*';
		} else if(is_array($filedArr)){
			$filed	= '`'.implode('`,`', $filedArr).'`';
		} else {
			$filed	= $filedArr;
		}
		if(empty($whereArr)){
			$where	= '1';
		} else if(is_array($whereArr)){
			$where	= array3where($whereArr);
		} else {
			$where	= $whereArr;
		}
		if(strpos($where, "is_delete") === false){
			$where	.= " AND is_delete = 0";
		}
		$sql	= "SELECT ".$filed." FROM ".tableToSqlTable($this->getTableName())." WHERE ".$where;
		return $this->sql($sql)->sort($sort)->limit('')->page($page)->perpage($perpage)->select(array('mysql'));
	}
	
	/**
	 * 函数说：获取符合查询条件的数量
	 * @param string $table
	 * @param string|array $whereArr
	 * @return number
	 */
	public function getCount($whereArr = '1'){
		$res	= $this->getAllDatas(' COUNT(*) AS count ', $whereArr);
		if(empty($res)){
			return 0;
		} else {
			return $res[0]['count'];
		}
	}
	
	/**
	 * 函数说明：获取错误信息
	 */
	public function getErrorMsg(){
		return self::$errMsg;
	}
	
	/**
	 * 函数说明：获取表的前缀
	 * @return string
	 */
	public function getTablePrefix(){
		return self::tablePrefix;
	}
}
?>