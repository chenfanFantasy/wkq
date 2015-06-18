<?php
class OpenApiAct extends CommonAct {
	
	public function __construct(){
		parent::__construct();
	}
	
	//获取淘宝用户信誉信息
	public function act_getInfo(){
		$nickName = $this->act_requestGetParam("userName");
		if(empty($nickName)){
			self::$errMsg['10000'] = "绑定账号不能为空";
			return false;
		}
		$res = GetTaoBaoUserInfoModel::getUserInfo($nickName);
		var_dump($res);
		exit;
	}
}

?>