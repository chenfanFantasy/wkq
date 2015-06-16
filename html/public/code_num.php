<?php
	session_start();
	getCode(4,60,20);
	function getCode($num,$w,$h) {
		$arry	= array('1', '2', '3', '4', '5', '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f', 'g',
						'h', 'i', 'g', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w',
						'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
						'N', 'O', 'P', 'Q', 'R', 'S', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', 't');
		$code 	= "";
		for ($i = 0; $i < $num; $i++) {
			$temp	= rand(0, 61);
			$code  .= $arry[$temp];
		}
		
		//将生成的验证码写入session，备验证时用
		$_SESSION["CODE_NUM"] = $code;
		//创建图片，定义颜色值
		header("Content-type: image/PNG");
		$im = imagecreate($w, $h);
		$black = imagecolorallocate($im, 16,142, 255);
		$gray = imagecolorallocate($im, 206, 228, 251);
		$bgcolor = imagecolorallocate($im, 255, 255, 255);
		//填充背景
		imagefill($im, 0, 0, $gray);
	
		//画边框
		imagerectangle($im, 0, 0, $w-1, $h-1, $black);
	
		//随机绘制两条虚线，起干扰作用
		
		//将数字随机显示在画布上,字符的水平间距和位置都按一定波动范围随机生成
		$strx = rand(3, 8);
		for ($i = 0; $i < $num; $i++) {
			$strpos = rand(1, 6);
			imagestring($im, 5, $strx, $strpos, substr($code, $i, 1), $black);
			$strx += rand(8, 12);
		}
		imagepng($im);//输出图片
		imagedestroy($im);//释放图片所占内存
	}
?>