<?php
/**
 * 类名：BaseView
 * 功能：view层公共操作函数，权限验证
 * 版本：1.0
 * 日期：2015-3-11
 * 作者：杨友能
 */
class BaseView {
	protected $smarty		= '';
	protected $page			= '';
	protected $loginName	= '';
	protected $loginEmail	= '';
	protected $loginID		= '';
	
	
	public  function __construct(){
		
		$mod	= $_REQUEST['mod'];
		$act	= $_REQUEST['act'];
		session_start();
		####################  smarty初始化 start ####################
		require_once(WEB_PATH . 'lib/template/smarty/Smarty.class.php');
		$this->smarty = new Smarty;
		$this->smarty->template_dir = WEB_PATH . 'html/template/fonttemplate' . DIRECTORY_SEPARATOR; //模板文件目录
		$this->smarty->compile_dir = WEB_PATH . 'smarty/templates_c' . DIRECTORY_SEPARATOR; //编译后文件目录
		$this->smarty->config_dir = WEB_PATH . 'smarty/configs' . DIRECTORY_SEPARATOR; //配置文件目录
		$this->smarty->cache_dir = WEB_PATH . 'smarty/cache' . DIRECTORY_SEPARATOR; //缓存文件目录
		$this->smarty->debugging = false;
		$this->smarty->caching = false;
		$this->smarty->cache_lifetime = 120;
		####################  smarty初始化  end ####################
		if(C("IS_AUTH_ON") === true){
			if(self::checkModuleAuth($mod, $act)){
				if(!isset($_SESSION['user_name']) || empty($_SESSION['user_id'])){
					redirect_to("index.php?mod=login&act=login");
				} else {
					$this->loginEmail	= isset($_SESSION['user_email'])	? $_SESSION['user_email']	: '';
					$this->loginID		= isset($_SESSION['user_id'])		? $_SESSION['user_id']		: 0;
					$this->loginName	= isset($_SESSION['user_name'])		? $_SESSION['user_name']	: '';
				}
			}
		}
		//设置get post提交过来的数据
		if(isset($_GET)){
			foreach ($_GET as $key => $val){
				$this->smarty->assign('g_'.$key, $val);
			}
		}
		if(isset($_POST)){
			foreach ($_POST as $key => $val){
				$this->smarty->assign('p_'.$key, $val);
			}
		}
		
		//初始化当前页码
		$this->page	= isset($_GET['page']) && intval($_GET['page']) > 0 ? intval($_GET['page']) : 1;
		//设置用户信息，
		$this->smarty->assign("page", $this->page);
		$this->smarty->assign("login_name", $this->loginName);
		$this->smarty->assign('login_id', $this->loginID);
		$this->smarty->assign('login_email', $this->loginEmail);
	}
	
	/**
	 * 函数说明：验证模块是否需要验证
	 * @param string $mod
	 * @param string $act
	 * @return boolean
	 */
	protected function checkModuleAuth($mod, $act){
		$arrModule	= explode(',', C("IS_AUTH_MODULE"));
		if(in_array($mod.'/'.$act, $arrModule)){
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * 函数说明：404页面跳转
	 * @param string $message
	 * @param string $jumpUrl
	 * @param number $waitSecond
	 */
	protected function error_404Jump($message, $jumpUrl = '', $waitSecond = 3) {
		@header("http/1.1 404 not found");
		@header("status: 404 not found");
		$this->smarty->assign('jumpUrl_index', $jumpUrl); //**add by yyn**//
		$this->smarty->assign('error', $message); // 提示信息
		//发生错误时候默认停留3秒
		$this->smarty->assign('waitSecond', $waitSecond);
		// 默认发生错误的话自动返回上页
		$this->smarty->assign('jumpUrl_back', "javascript:history.back(-1);"); //**add by yyn**//
		$this->smarty->display('404.html');
	}
	
	/**
	 * 函数说明：获取返回的错误码和错误信息
	 * @param unknown $data
	 * @param string $isAuto
	 */
	protected function	ajaxReturn($data, $isAuto = true){
		header('Content-Type:application/json; charset=utf-8');
		$res	= array();
		if($isAuto){
			$errMsg	= A("Common")->act_getErrorMsg();
			if(empty($errMsg)){
				$errMsg['200']	= "执行成功！";
			}
		}
		foreach ($errMsg as $key => $val){
			if($key != "200"){
				$res['errCode']	= $key;
				$res['errMsg']	= $val;
				break;
			}
			$res['errCode']	= $key;
			$res['errMsg']	= $val;
		}
		$res['data']	= $data;
		die(json_encode($res));
	}
}

?>