<?php
/**
 * 函数说明：获取配置文件中的配置信息
 * @param string $name
 * @param string $value
 * @return multitype:|NULL|string
 */
function C($name=null, $value=null) {
    static $_config = array();
    if (empty($name))   return $_config;
    if (is_string($name)) {
        if (!strpos($name, '.')) {
            $name = strtolower($name);
            if (is_null($value))
                return isset($_config[$name]) ? $_config[$name] : null;
            $_config[$name] = $value;
            return;
        }
        // 二维数组设置和获取支持
        $name = explode('.', $name);
        $name[0]   =  strtolower($name[0]);
        if (is_null($value))
            return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : null;
        $_config[$name[0]][$name[1]] = $value;
        return;
    }
    // 批量设置
    if (is_array($name)){
        return $_config = array_merge($_config, array_change_key_case($name));
    }
    return null;
}

/**
 * 函数说明:初始化一个Model类的对象
 * @param string $class
 * @return boolean|Ambigous <unknown>
 */
function M($calss = '') {
    static $_model  = array();
    $model = $calss.'Model';
    if (!class_exists($model)){
    	return false;
    }
    if (!isset($_model[$model])){
    	$_model[$model] = new $model();
    }
    return $_model[$model];
}

/**
 * 函数说明：初始化一个Action类的对象
 * @param string $class
 * @return boolean|Ambigous <unknown>
 */
function A($class = ''){
	static $_action	= array();
	$action			= $class.'Act';
	if(!class_exists($action)){
		return false;
	}
	if(!isset($_action[$action])){
		$_action[$action]	= new $action();
	}
	return $_action[$action];
}
?>