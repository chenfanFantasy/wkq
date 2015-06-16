<?php
error_reporting(E_ALL);
header("Content-type:text/html;charset:utf-8");
date_default_timezone_set("Asia/Shanghai");
include_once dirname(__DIR__)."/conf/define.php";
include_once WEB_PATH.'framework.php';
Core::getInstance();
$mod	=	isset($_REQUEST['mod']) ? $_REQUEST['mod']: "";
$act	=	isset($_REQUEST['act']) ? $_REQUEST['act']: "";
if(empty($mod)){
	redirect_to(WEB_URL."index.php?mod=index&act=index"); // 跳转到登陆页
	exit;
}
if(empty($act)){
	redirect_to(WEB_URL."index.php?mod=index&act=index"); // 跳转到登陆页
	exit;
}

if(!file_exists(WEB_PATH.'view/'.$mod.'.view.php')){
	redirect_to(WEB_URL."index.php?mod=index&act=index");
}
$modName	= ucfirst($mod."View");
$modClass	= new $modName();
$actName	= "view_".$act;
if(method_exists($modClass, $actName)){
	$ret	=	$modClass->$actName();
}else{
	redirect_to(WEB_URL."index.php?mod=public&act=showErr");
}
?>