<?php
class UserView extends BaseView {
	public function __construct(){
		parent::__construct();
	}
	
	public function view_myInfo(){
		$res	= A('User')->act_getInfo();
		print_r($res);
	}
}

?>