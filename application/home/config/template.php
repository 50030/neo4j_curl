<?php
/**
 * 自定义的模板路径
 * 2022-10-14
 */
if(input('theme')){
	$themeCookie = intval(input('theme'));
}elseif(isset($_COOKIE['themeCookie'])){
	$themeCookie = $_COOKIE['themeCookie'];
}else{
	$themeCookie = 0;
}

$themeCookie = intval($themeCookie);
setcookie('themeCookie', $themeCookie, time() + 60 * 60 * 24, '/');

$themeCookie = 1;  //暂时总是用1

if($themeCookie == 0){
	return [
	    'view_path'    => request()->env()['APP_PATH'] . request()->module() . '/template/normal/',
	];
}elseif($themeCookie == 1){
	return null;
}
