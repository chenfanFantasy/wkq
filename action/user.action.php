<?php
class UserAct extends CommonAct {
	
	public function __construct(){
		parent::__construct();
	} 
	
	public function act_getInfo(){
		return M('user')->getDatas();
	}
}

?>