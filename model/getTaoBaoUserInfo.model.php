<?php
class GetTaoBaoUserInfoModel extends CommonModel {
	
	public function __construct(){
		parent::__construct();
	}
	
	/**
	 * 根据账号名称获取用户信誉值和相关信息
	 * @param string $nickName
	 * @return array
	 */
	public static function getUserInfo($nickName){
		$res = array(
				"accountRank"=>0,
				"accountWeekCredit" =>0,
				"accountMonthCredit"=>0,
				"accountIsRealName"=>1,
				"accountRegisterTime"=>0,
				"accountName"=>$nickName,
		);
		$randTime = time()*1000+rand(0, 1000);
		$url = "http://cha.rzwb.net/ajax/get/rate/?_=".$randTime."&username={$nickName}";
		$data= array();
		$httpCode = 0;
		$errCode  = 0;
		$errInfo  = '';
		$header['Accept'] 		= "text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8";
		$header['User-Agent'] 	= 'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36';
		$result = curlPostData($url, $data, $httpCode,$header,$errCode,$errInfo);
		if($httpCode==200){
			$result = trim($result);
			if($result=="您所查询的帐号不存在"){
				self::$errMsg['10000'] = "您所查询的帐号不存在";
				return $res;
			} else {
				//解析返回的数据
				$resStr = array();
				$doc = new DOMDocument();
				$searchPage = mb_convert_encoding($result, 'HTML-ENTITIES', "UTF-8"); 
				@$doc->loadHTML($searchPage);
				$htmlDocLis = $doc->getElementsByTagName('li');
				foreach ($htmlDocLis as $htmlDocLi){
					$resStr[] =  preg_replace ( '/\s\s+/','',$htmlDocLi->nodeValue);
				}
				foreach ($resStr as $v){
					$r[] = explode('：',$v);
				}
				if($r[1][1]!="未认证"){
					$res['accountIsRealName'] = 2;//是否实名认证
				}
				$res['accountRegisterTime'] = $r[0][1];
				$url 		  = "http://yaochahao.com/ty.aspx";//采用post提交数据
				$key		  = "muijahkqjaklaiuxahqkiwuskahdkdnz";
				$iv 		  = "1234567812345678";
				$t			  = mcrypt_encrypt(MCRYPT_RIJNDAEL_128,$key,$nickName,MCRYPT_MODE_CBC,$iv);
				$data['nick'] = $nickName;
				$data['stype']= 13;
				$data['k']	  = base64_encode($t);
				$result 	  = curlPostData($url, $data, $httpCode,$header,$errCode,$errInfo);
				if($httpCode==200){
					$searchPage = mb_convert_encoding($result, 'HTML-ENTITIES', "UTF-8");
					$rk = self::tablesToArray($searchPage);
					$res['accountWeekCredit']  = $rk[1][1][1];//最近一周好评
					$res['accountMonthCredit'] = $rk[1][2][1];//最近一月好评
					$res['accountRank']		   = intval($rk[0][0][1]);//最近一月好评
					print_r($res);
					exit;	
				} else {
					echo '出错';
				}
			}
		} else {
			echo '出错';
			self::$errMsg['10002'] = $errInfo;
		}
	}
	
	/**
	 * 将html文档中的table中的数据转存到数组中
	 * @param string $htmlString
	 * @param array
	 */
	private static function tablesToArray ($htmlString) {
		$htmlDocDom = new DOMDocument();
		@$htmlDocDom->loadHTML($htmlString);
		$htmlDocDom->preserveWhiteSpace = false;
		$tableCounter = 0;
		$htmlDocTableArray = array();
		$htmlDocTables = $htmlDocDom->getElementsByTagName('table');
		foreach ($htmlDocTables as $htmlDocTable) {
			$htmlDocTableArray[$tableCounter] = array();
			$htmlDocRows	 = $htmlDocTable->getElementsByTagName('tr');
			$htmlDocRowCount = 0;
			foreach ($htmlDocRows as $htmlDocRow) {
				if (strlen($htmlDocRow->nodeValue) > 1)
				{
					$htmlDocColCount = 0;
					$htmlDocTableArray[$tableCounter][$htmlDocRowCount] = array();
					$htmlDocCols = $htmlDocRow->childNodes;//获取行下面所有的子节点
					foreach ($htmlDocCols as $htmlDocCol) {
						$htmlDocTableArray[$tableCounter][$htmlDocRowCount][] = $htmlDocCol->nodeValue;
						$htmlDocColCount++;
					}
					$htmlDocRowCount++;
				}
			}
			$tableCounter++;
		}
		return($htmlDocTableArray);
	}
}
?>