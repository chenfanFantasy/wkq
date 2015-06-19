<?php
class UserView extends BaseView {
	public function __construct(){
		parent::__construct();
	}
	
	public function view_myInfo(){
		$res	= A('User')->act_getInfo();
		print_r($res);
	}
	
	//加载用户注册页面
	public function view_userRegist(){
		$this->smarty->assign("title","威客圈注册");
		$this->smarty->display("userRegist.htm");
	}
}

?>