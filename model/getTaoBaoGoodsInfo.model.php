<?php
class GetTaoBaoGoodsInfoModel extends CommonModel {
	
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * 根据商品URL获取相应的商品信息
	 * @param string $url
	 * @return array
	 */
	public static function getGoodsInfo($url){
		$res = array(
				"title"	=>'',
				"url"	=>$url,
		);
		$data= array();
		$httpCode = 0;
		$errCode  = 0;
		$errInfo  = '';
		$header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/31.0.1650.57 Safari/537.36';
		//此处需要根据URL判断是否淘宝还是天猫商品
		if(preg_match('/item.taobao.com/', $url)){
			$header[] = "Host: item.taobao.com";
		}
		if(preg_match('/detail.tmall.com/', $url)){
			$header[] = "Host: detail.tmall.com";
		}
		$result   = curlGetData($url, $data, $httpCode,$header,$errCode,$errInfo);
		if($httpCode==200){
			$result = trim($result);
			$searchPage = mb_convert_encoding($result, "HTML-ENTITIES","GBK");
			//解析返回的数据
			$resStr = array();
			$doc = new DOMDocument();
			@$doc->loadHTML($searchPage);
			$htmlDocTitles = $doc->getElementsByTagName('title');
			foreach ($htmlDocTitles as $htmlDocTitle){
				$resStr[] =  preg_replace ( '/\s\s+/','',$htmlDocTitle->nodeValue);
			}
			$res['title'] = $resStr[0];
			print_r($res);
			exit;
		} else {
			$searchPage = mb_convert_encoding($result, "HTML-ENTITIES","GBK");
			var_dump($result);
			echo "{$httpCode}===自行获取出现未知错误，请自行复制粘贴商品名称!{$errInfo}";
			exit;
		}
	}
}
?>