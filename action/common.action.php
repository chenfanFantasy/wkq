<?php
/**
 * 类名：CommonAct
 * 功能：action公共操作函数
 * 版本：1.0
 * 日期：2015-3-9
 * 作者：杨友能
 */
class CommonAct {
	protected $page				= 0;
	protected $perpage			= 0;
	protected static $errMsg	= array();
	public  function __construct(){
		$this->page		= isset($_GET['page'])&&(intval($_GET['page']) > 0) ? intval($_GET['page']) : 1;
		$this->perpage	= isset($_GET['perpage'])&&(intval($_GET['perpage']) > 0) ? intval($_GET['perpage']) : 10;
	}
	
	/**
	 * 函数说明：获取请求的页码
	 * @return number
	 */
	public function act_getPage(){
		return $this->page;
	}
	
	/**
	 * 函数说明：获取分页数
	 * @return number
	 */
	public function act_getPerpage(){
		return $this->perpage;
	}
	
	/**
	 * @description 请求处理
	 * @param $_GET OR $_POST $name 接收POST,GET请求，不建议用$_REQUEST全局变量
	 * @param any $default_value 默认值，当请求不存在于初始默认的值
	 * @return string||int
	 */
	public function act_requestGetParam($name, $default_value = null) {
		$request = isset($_GET[$name]) ? $_GET[$name] : (isset($_POST[$name]) ? $_POST[$name] : $default_value);
		$request = strip_tags($request);
		return trim(mysql_real_escape_string($request));
	}
	
	/**
	 * 函数说明：过滤<script>脚本
	 * @param unknown $sring
	 * @return mixed
	 */
	public function act_filterScript($sring){
    	return preg_replace("/<script[^>]*>.*<\/script>/si", '', $sring);
    }
    
    public function act_getErrorMsg(){
    	$errMsgs = M('common')->getErrorMsg();
    	if (!empty($errMsgs)){
    		foreach ($errMsgs AS $code=>$errMsg){
    			if(!isset(self::$errMsg[$code])){
    				self::$errMsg[$code] = $errMsg;
    			}
    		}
    	}
    	return self::$errMsg;
    }
    
    public function act_getLastErrorMsg(){
    	$lastMsg	= array();
    	$errMsgs	= M('common')->getErrorMsg();
    	if (!empty($errMsgs)){
    		foreach ($errMsgs AS $code=>$errMsg){
    			if(!isset(self::$errMsg[$code])){
    				self::$errMsg[$code] = $errMsg;
    			}
    		}
    	}
    	foreach(self::$errMsg as $code=>$msg){
    		if($code!="200"){
    			return array($k,$v);
    		}
    		$lastMsg['errCode']	= $code;
    		$lastMsg['errMsg']	= $msg;
    	}
    	return $lastMsg;
    }
    
    public function act_pregMatchEmail($email){
    	$parten_email	= "/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/";
    	return preg_match($parten_email, $email);
    }
    
    public function act_peregMatchPwd($pwd){
    	$parten_pwd		= "/^(?!^\d+$)(?!^[a-zA-Z]+$)[0-9a-zA-Z]{8,}$/";
    	return preg_match($parten_pwd, $pwd);
    }
    
    /**
     * 函数说明：用户名加密
     * @param unknown $password
     * @return string
     */
    public function act_pwdToPwd($password){
    	return md5(md5($password));
    }
    
    public function act_adminPassToPass($password){
    	$password	= '#@^'.$password.'*#^';
    	return md5(md5($password));
    }
    
    
    public function act_getUserInfo($filed	= ' * '){
    	$user_id		= isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : (isset($_REQUEST['id']) ? trim($_REQUEST['id']) : 0);
    	$where	= '1';
    	if(!empty($user_id)){
    		$where	.= ' AND id = '.$user_id;
    	}
    	if($where == '1'){
    		self::$errMsg['10120']	= '用户ID为空！';
    		return false;
    	}
    	return M('User')->getDatas($filed, $where);
    }
    
    public function act_getSelfAdminInfo($filed	= ' * '){
    	$admin_id	= $_SESSION['admin_id'];
    	$where		= '1';
    	if(!empty($admin_id)){
    		$where	.= ' AND id = '.$admin_id;
    	}
    	if($where == '1'){
    		self::$errMsg['10120']	= '管理员ID为空！';
    		return false;
    	}
    	return M('User')->getDatas($filed, $where);
    }
}

?>