<?php
define("WEB_PATH", str_replace(DIRECTORY_SEPARATOR, '/',str_replace('conf', '', dirname(__FILE__))));
define("WEB_URL", 'http://'.$_SERVER['HTTP_HOST']."/");
?>