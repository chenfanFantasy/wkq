<?php

/**
 * 函数说明：数组转化成set条件
 * @param array $arr
 * @return string
 */
function array2sql($arr){
	$arr_aql	= array();
	foreach ($arr as $key => $val){
		if(empty($key)){
			continue;
		}
		$key		= trim($key);
		$arr_aql[]	= "`$key`='$val'";
	}
	return implode(',', $arr_aql);
} 

/**
 * 函数说明：数组转换成查询语句
 * @param array $arr
 * @return string
 */
function array3where($arr){
	$arr_where	= array();
	foreach ($arr as $key => $val){
		if(empty($key)){
			continue;
		}
		$key			= trim($key);
		$arr_where[]	= "`$key` = '$val'";
	}
	return implode(' AND ', $arr_where);
}
/**
 * 函数说明：表名加单引号
 * @param string $table
 * @return string
 */
function tableToSqlTable($table){
	return ' `'.$table.'` ';
}

/**
 * 函数说明：获取请求IP
 * @return string 用户IP地址
 */
function get_ip() {
	if (isset($_SERVER)) {
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
			$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
		} elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
			$realip = $_SERVER["HTTP_CLIENT_IP"];
		} else {
			$realip = $_SERVER["REMOTE_ADDR"];
		}
	} else {
		if (getenv('HTTP_X_FORWARDED_FOR')) {
			$realip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif (getenv('HTTP_CLIENT_IP')) {
			$realip = getenv('HTTP_CLIENT_IP');
		} else {
			$realip = getenv('REMOTE_ADDR');
		}
	}
	$realip_arr = explode(',', $realip);
	$realip = (isset($realip_arr[0]) && $realip_arr[0] != 'unknown') ? $realip_arr[0] : '0.0.0.0';
	return $realip;
}

/**
 * 函数说明：简单的重定向函数
 * @param string  需要跳转的链接地址
 */
function redirect_to($location = '') {
	if ($location != NULL) {
		header("Location: {$location}");
		exit;
	}
}

/**
 * 函数说明：将数组转换成json数据并解决中文乱码问题
 * @param array   $arr
 */
function jsonCN_encode($arr) {
	$na		= array();
	foreach ($arr as $key => $value) {
		$na[$key] = urlencode($value);
	}
	return urldecode(json_encode($na));
}

/**
 * 函数说明：运行脚本
 * @param string $paramStr
 * @return boolean
 */
function getExec($paramStr = '') {
	if (PHP_OS == "WINNT") {
		exec("start /b php.exe " . $paramStr);
		return true;
	} else {
		exec("/opt/php/bin/php " . $paramStr . " &> /dev/null &", $out, $status);
		if ($status == 0)
			return true;
		return false;
	}
}

/**
 * 读取文件内容
 * @param string $file
 * @return boolean|string
 */
function read_file($file){
	if(!is_file($file)){
		return false;
	}
	return file_get_contents($file);
}

/**
 * 函数说明：读取文件内容和清空文件内容
 * @param string $file
 * @return boolean|string
 */
function read_and_empty_file($file){
	if(!is_file($file)){
		return false;
	}
	$cotent	= file_get_contents($file);
	if(!($handle	= fopen($file, 'w'))){
		return false;
	}
	return $cotent;
}

/**
 * 函数说明：写文件，覆盖式
 * @param string $file
 * @param string $data
 * @return boolean
 */
function write_w_file($file, $data){
	if(!is_file($file)){
		return false;
	}
	if(empty($data)){
		return false;
	}
	$handle	= fopen($file, 'w');
	if($handle){
		flock($handle, LOCK_EX);//取得独占锁定
		if(fwrite($handle, $data) === false){
			return false;
		}
		flock($handle, LOCK_UN);//要释放锁定（无论共享或独占
		fclose($handle);
		return true;
	} else {
		return false;
	}
}

/**
 * 函数说明：写文件，追加式
 * @param string $file
 * @param string $data
 * @return boolean
 */
function write_a_file($file, $data){
	if(!is_file($file)){
		return false;
	}
	if(empty($data)){
		return false;
	}
	$handle	= fopen($file, 'a');
	if($handle){
		flock($handle, LOCK_EX);//取得独占锁定
		if(fwrite($handle, $data) === false){
			return false;
		}
		flock($handle, LOCK_UN);//要释放锁定（无论共享或独占
		fclose($handle);
		return true;
	} else {
		return false;
	}
}

/**
 * 函数说明：创建路径
 * @param string $path
 */
function mkdirs($path) {
	$path_out = preg_replace('/[^\/.]+\/?$/', '', $path);
	if (!is_dir($path_out)) {
		mkdirs($path_out);
	}
	mkdir($path);
}

/**
 * 函数说明：验证电话格式
 * @param string  $value
 * @return  bool
 */
function validate_phone($value) {
	return preg_match('/^\d{5,11}$|^(\+|\d)((\d{1,4})(\s|-)\d{1,11})*\d$/', $value);
}

/**
 * 函数说明：函数说明验证日期是否合法
 * @param date    $date
 * @return bool
 */
function validate_date($date) {
	return preg_match("/^20[0-9]{2}-[0-1][0-9]-[0-3][0-9]$/", $date) > 0;
}

/**
 * 函数说明：验证日期和时间是否合法
 * @param datetime $datetime
 * @return bool
 */
function validate_datetime($datetime) {
	return preg_match("/^20[0-9]{2}-[0-1][0-9]-[0-3][0-9]\s[0-2][0-9]:[0-5][0-9]:[0-5][0-9]$/", $datetime) > 0;
}

/**
 * 函数说明：验证email
 * @param string  $emial
 * @return  bool
 */
function validate_email($email) {
	return preg_match('/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/', $email);
}

/**
 * 函数说明：验证字母数字-组合  12122-1212-3r
 * @param string  $value
 * @return  bool
 */
function validate_numTchar($value) {
	return preg_match('/^[a-z0-9A-Z]+([a-z0-9A-Z]+-[a-z0-9A-Z]*)*[a-z0-9A-Z]$/', $value);
}

/**
 * 函数说明：验证字母数字大写字母  3J447573WK9855335
 * @param string  $value
 * @return  bool
 */
function validate_numUpchar($value) {
	return preg_match('/^[0-9A-Z]*[0-9A-Z]$/', $value);
}

/**
 * 驼峰类命名方式转化为下划线命名方式
 *
 * @param string  $hname
 * @return string
 * @author lzx
 */
function hump2underline($hname) {
	return str_replace(
			array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"), array("_a", "_b", "_c", "_d", "_e", "_f", "_g", "_h", "_i", "_j", "_k", "_l", "_m", "_n", "_o", "_p", "_q", "_r", "_s", "_t", "_u", "_v", "_w", "_x", "_y", "_z"), $hname);
}

//增加CURL方式的post提交数据方法
function curlPostData($url,$data,&$httpCode,$header=array(),&$errCode=0,&$errMsg=''){
	$url 	= preg_replace( '/(?:^[\'"]+|[\'"\/]+$)/', '', $url );
	$hander = curl_init();
	curl_setopt($hander,CURLOPT_URL,$url);
	curl_setopt($hander,CURLOPT_HEADER,0);
	curl_setopt($hander,CURLOPT_HTTPHEADER,$header);
	curl_setopt($hander,CURLOPT_FOLLOWLOCATION,1);
	curl_setopt($hander,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($hander,CURLOPT_POST, 1);
	curl_setopt($hander,CURLOPT_POSTFIELDS, $data);
	curl_setopt($hander,CURLOPT_RETURNTRANSFER,true);//以数据流的方式返回数据,当为false是直接显示出来
	curl_setopt($hander,CURLOPT_TIMEOUT,60);
	$cnt	= 0;
	while($cnt < 3 && ($result=curl_exec($hander))===FALSE) $cnt++;
	$httpCode		= curl_getinfo($hander, CURLINFO_HTTP_CODE);
	if(curl_errno($hander)){
		$errCode	= curl_errno($hander);
		$errMsg		= curl_error($hander);
	}
	curl_close($hander);
	return $result;
}

//增加CURL方式的get提交数据方法
function curlGetData($url,$data,&$httpCode,$header=array(),&$errCode=0,&$errMsg=''){
	$url 	= preg_replace( '/(?:^[\'"]+|[\'"\/]+$)/', '', $url);
	$hander = curl_init();
	curl_setopt($hander,CURLOPT_URL,$url);
	curl_setopt($hander,CURLOPT_HEADER,0);
	curl_setopt($hander,CURLOPT_HTTPHEADER,$header);
	curl_setopt($hander,CURLOPT_FOLLOWLOCATION,true);
	curl_setopt($hander,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($hander, CURLOPT_AUTOREFERER, true);
	curl_setopt($hander,CURLOPT_RETURNTRANSFER,true);//以数据流的方式返回数据,当为false是直接显示出来
	curl_setopt($hander,CURLOPT_TIMEOUT,60);
	$cnt	= 0;
	while($cnt < 3 && ($result=curl_exec($hander))===FALSE) $cnt++;
	$httpCode		= curl_getinfo($hander, CURLINFO_HTTP_CODE);
	if(curl_errno($hander)){
		$errCode	= curl_errno($hander);
		$errMsg		= curl_error($hander);
	}
	curl_close($hander);
	return $result;
}
?>