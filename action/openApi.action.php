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
	

	//获取淘宝商品信息
	public function act_getGoodsInfo(){
		$url	 = $this->act_requestGetParam("url");
		$id	 	 = $this->act_requestGetParam("id");
		if(empty($url)){
			self::$errMsg['10000'] = "获取商品的URL不能为空";
			return false;
		}
		if(empty($id)){
			self::$errMsg['10001'] = "获取商品的ID不能为空";
			return false;
		}
		$url	= $url.'&id='.$id;
		$res = GetTaoBaoGoodsInfoModel::getGoodsInfo($url);
		var_dump($res);
		exit;
	}
}

?>