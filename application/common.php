<?php
error_reporting(E_ALL ^ E_NOTICE);
use think\Db;


/**
 * CURL请求
 * @param $url 请求url地址
 * @param $method 请求方法 get post
 * @param null $postfields post数据数组
 * @param array $headers 请求header信息
 * @param bool|false $debug  调试开启 默认false
 * @return mixed
 */
function httpRequest($url, $method, $postfields = null, $headers = array(), $debug = false) {
    $method = strtoupper($method);
    $ci = curl_init();
    /* Curl settings */
    curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
    curl_setopt($ci, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0");
    curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60); /* 在发起连接前等待的时间，如果设置为0，则无限等待 */
    curl_setopt($ci, CURLOPT_TIMEOUT, 7); /* 设置cURL允许执行的最长秒数 */
    curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
    switch ($method) {
        case "POST":
            curl_setopt($ci, CURLOPT_POST, true);
            if (!empty($postfields)) {
                $tmpdatastr = is_array($postfields) ? http_build_query($postfields) : $postfields;
                curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
            }
            break;
        default:
            curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method); /* //设置请求方式 */
            break;
    }
    $ssl = preg_match('/^https:\/\//i',$url) ? TRUE : FALSE;
    curl_setopt($ci, CURLOPT_URL, $url);
    if($ssl){
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, FALSE); // 不从证书中检查SSL加密算法是否存在
    }
    //curl_setopt($ci, CURLOPT_HEADER, true); /*启用时会将头文件的信息作为数据流输出*/
    curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ci, CURLOPT_MAXREDIRS, 2);/*指定最多的HTTP重定向的数量，这个选项是和CURLOPT_FOLLOWLOCATION一起使用的*/
    curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ci, CURLINFO_HEADER_OUT, true);
    /*curl_setopt($ci, CURLOPT_COOKIE, $Cookiestr); * *COOKIE带过去** */
    $response = curl_exec($ci);
    $requestinfo = curl_getinfo($ci);
    $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
    if ($debug) {
        echo "=====post data======\r\n";
        var_dump($postfields);
        echo "=====info===== \r\n";
        print_r($requestinfo);
        echo "=====response=====\r\n";
        print_r($response);
    }
    curl_close($ci);
    return $response;
}


//获取指定长度的字符串
function getRandChar($length){
	$str = null;
	$strPol = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$max = strlen($strPol) - 1;
	for($i = 0; $i < $length; $i++){
		$str .= $strPol[rand(0, $max)];
	}
	return $str;
}


//获取随机数，随机取正反
function randBool(){
	//$rand = rand(0,1);
	$rand = date("d");
	$rand = $rand % 2;
	return $rand;
}


/**
 * 获取配置值，根据键
 * 军
 * 2019-07-29
 * 使用了静态变量，这样可以减少查询相同的配置项
 */
function getSet($key)
{
	static $config = array();
	if(!isset($config[$key])){
		$where[] = ['key', '=', $key];
		$find = Db::name('set')->where($where)->field('value')->find();
		$config[$key] = $find['value'];
	}
	return $config[$key];
}


/**
 * 各种日志，独立于系统日志
 * 2018-12-18
 */
function logUser($log, $uid, $status){
	$arrNew = array();
	$time = time();
	$arrNew['log'] = $log;
	$arrNew['uid'] = intval($uid);
	$arrNew['status'] = intval($status);
	$arrNew['create_time'] = $time;
	$arrNew['create_time2'] = date("Y-m-d H:i:s", $time);
	Db::name('Log_user')->insert($arrNew);
}


/**
 * 通知信息
 * 2019-11-08
 */
function logNotice($log){
	$arrNew = array();
	$time = time();
	$arrNew['log'] = $log;
	$arrNew['create_time'] = $time;
	$arrNew['create_time2'] = date("Y-m-d H:i:s", $time);
	$insert = Db::name('Log_notice')->insert($arrNew);
}


/**
 * 警告信息
 * 2019-11-08
 */
function logWarning($log){
	$arrNew = array();
	$time = time();
	$arrNew['log'] = $log;
	$arrNew['create_time'] = $time;
	$arrNew['create_time2'] = date("Y-m-d H:i:s", $time);
	$insert = Db::name('Log_warning')->insert($arrNew);
}


/**
 * 数据库错误信息
 * 2019-11-08
 */
function logDbError($log){
	$arrNew = array();
	$time = time();
	$arrNew['log'] = $log;
	$arrNew['create_time'] = $time;
	$arrNew['create_time2'] = date("Y-m-d H:i:s", $time);
	$insert = Db::name('Log_database_error')->insert($arrNew);
}



/**
 * 各种错误日志
 * 2018-12-19
 */
function logError($log){
	$arrNew = array();
	$time = time();
	$arrNew['log'] = $log;
	$arrNew['create_time'] = $time;
	$arrNew['create_time2'] = date("Y-m-d H:i:s", $time);
	$insert = Db::name('Log_error')->insert($arrNew);
}


/**
 * 调试日志
 * 2019-02-15
 */
function logDebug($log){
	if(is_array($log)){
		$str = '';
		foreach($log AS $k=>$v){
			$str .= ", " . $k . "=>" . $v;
		}
		$log = $str;
	}
	$arrNew = [];
	$time = time();
	$arrNew['log'] = $log;
	$arrNew['create_time'] = $time;
	$arrNew['create_time2'] = date("Y-m-d H:i:s", $time);
	Db::name('Log_debug')->insert($arrNew);
}


//获取下层子类别，默认并包含自己，默认销毁静态变量，自动计算个数以减少输入参数------
function getSub($arr , $id , $self=true , $unset=true){
	// $arr 所有类别的二维数组
	// $curr 自己
	// $self 是否包含自己，true为包括自己，false为不包括自己
	// $unset 是否自动销毁递归循环的静态变量，true为自动销毁，false为不自动销毁
	// 返回的一维数组，是类似array(1,4,6,2,9)的所有下层子id的集合
	
	$len = count($arr); 
	$res = getSub2($arr , $id , $len);
	if($self==true){
		$res[] = $id;             // 添加自己
	}
	if($unset==true){
		getSub2(null,null,null);      // 销毁静态变量 static
	} 
	return $res;
}


function getSub2($arr , $id , $len){                
	static $temp_res = array();
	if(!empty($arr)){ 
		for($i=0;$i<($len);$i++){  
		   if($arr[$i]['pid']==$id){                         // $arr[$i][0]=id , $arr[$i][1]=pid 
		   	  $temp_res[] = $arr[$i]['id'];                     //$arr_res[]会自动创建数组，而且没有调用函数的负担,不要用array_push()
		   	  getSub2($arr, $arr[$i]['id'],$len);        //递归,检查
		   }
		}   
		return $temp_res;
	}else{
		$temp_res = NULL;  //如果数组为空则销毁静态变量
		return NULL;       //返回一个空的
	}
}
//获取下层子类别，默认并包含自己，默认销毁静态变量，自动计算个数以减少输入参数******

/**
* 字符串加密以及解密函数
*
* @param string $string 原文或者密文
* @param string $operation 操作(ENCODE | DECODE), 默认为 DECODE
* @param string $key 密钥
* @param int $expiry 密文有效期, 加密时候有效， 单位 秒，0 为永久有效
* @return string 处理后的 原文或者 经过 base64_encode 处理后的密文
*
* @example
* $a = authcode('abc', 'ENCODE', 'key');
* $b = authcode($a, 'DECODE', 'key');  // $b(abc)
* 
* $a = authcode('abc', 'ENCODE', 'key', 3600);
* $b = authcode('abc', 'DECODE', 'key'); // 在一个小时内，$b(abc)，否则 $b 为空
*/

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0){
    $ckey_length = 4;    // 随机密钥长度 取值 0-32;
                // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
                // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
                // 当此值为 0 时，则不产生随机密钥
    $key = md5($key ? $key : 'wed500_com_fjdskajfkdjfkd_KEY');
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

function get_client_ip(){
	if($_SERVER['REMOTE_ADDR']){
		$ip = $_SERVER['REMOTE_ADDR'];
	}elseif(getenv('REMOTE_ADDR')){
		$ip = getenv('REMOTE_ADDR');
	}elseif(getenv('HTTP_CLIENT_IP')){
		$ip = getenv('HTTP_CLIENT_IP');
	}else{
		$ip = 'unknown';
	}
	return $ip;
}




//创建目录----------- ThinkPHP 内置有 mk_dir(),效果一样
function mkdirs($path){  
	if(!is_readable($path)){
		mkdirs(dirname($path));
		if(!is_file($path)){
			mkdir($path,0777);
		}
	}
}// 创建目录*********


//也是删除整个目录树---------
function deltree($dir) {  
    if (!file_exists($dir)) return true;  
    if (!is_dir($dir) || is_link($dir)) return unlink($dir);  
    foreach (scandir($dir) as $item) {  
        if ($item == '.' || $item == '..') continue;  
        if (!deltree($dir . "/" . $item)) {  
            chmod($dir . "/" . $item, 0777);  
            if (!deltree($dir . "/" . $item)) return false;  
        }  
    }  
    return rmdir($dir);  
}//也是删除整个目录树***********


/* ============================== 新的写法，增加不补白、不剪切，自动根据新宽高来决定。总共 6 种情况 ========================
<?php

$source_file = isset($_GET['source_file']) ? $_GET['source_file'] : '';
$new_file = isset($_GET['new_file']) ? $_GET['new_file'] : '';
$width = isset($_GET['width']) ? $_GET['width'] : 100;
$height = isset($_GET['height']) ? $_GET['height'] : 100;
$handle = isset($_GET['handle']) ? $_GET['handle'] : 1;

create_spec_image($source_file, $new_file, $width, $height, $handle);*/

/**
 * 改变图片尺寸，可以支持jpg、png、gif；
 * 如果是jpg图片，则进行补白，如果是png图片，则补充透明部分；
 * 如果是gif图片，并且是动画图片，则生成不动的图片，但图片可用，不会变黑，也不会缺少。
 * author: 郑爱军
 * http://groupby.cn
 * QQ:125315695
 * 2016-05-09
 *
 * @param $source_file 原图片文件
 * @param $new_file 新图片文件
 * @param $newWidth 生成的宽度
 * @param $newHeight 生成的高度
 * @param $handle 操作类型：1为欠缺的部分进行补白；2为多出的部分剪切掉；3为不补白、也不剪切，自动根据新的宽高来决定。
 * @return 新生成的图片，总共出现 6 种情况。
 */

function create_spec_image($source_file, $new_file, $newWidth=100, $newHeight=100, $handle=3, $force=false){
	if(!file_exists($source_file)){
		return false;
	}
    $image_info = getimagesize($source_file);

    if($image_info === false){
        return false;
    }
    
    $srcWidth  = $image_info[0];
    $srcHeight = $image_info[1];
    $image_type = $image_info['mime'];
    
    if($srcWidth < $newWidth && $srcHeight < $newHeight && $force==false){
    	copy($source_file, $new_file);
    	return true;
    }
    
    if($handle == 1){
        //不够的部分补白。如果是jpg就加补白部分，如果是png就加透明部分。
        $space = 'white';
    }elseif($handle == 2){
        //多出的部分截取
        $space = 'cut';
    }elseif($handle == 3){
        $space = 'none';
    }else{
        $space = 'white';
    }
    
    //计算尺寸，开始================
    //第一种情况：不补白、也不剪切，根据宽高比决定。此时由新高度决定新图。
    if($srcWidth/$srcHeight >= $newWidth/$newHeight && $space == 'none'){
        
        $beginX = 0;
        $beginY = 0;
        $endX = $newWidth;
        $endY = $newWidth / $srcWidth * $srcHeight;
        
        $sourceX = 0;
        $sourceY = 0;
        $sourceH = $srcHeight;
        $sourceW = $srcWidth;
        
        $newHeight = $endY;

    //第二种情况：不补白、也不剪切，根据宽高比决定。此时由新宽度决定新图。       
    }elseif($srcWidth/$srcHeight < $newWidth/$newHeight && $space == 'none'){
        
        $beginX = 0;
        $beginY = 0;
        $endX = $newHeight / $srcHeight * $srcWidth;
        $endY = $newHeight;
        
        $sourceX = 0;
        $sourceY = 0;
        $sourceH = $srcHeight;
        $sourceW = $srcWidth;
        
        $newWidth = $endX;
        
    //第三种情况:原宽高比 > 新宽高比，不够的部分进行补白。如果是jpg就补白，如果是png就补透明。例如：即原来的横扁，新的方正。
    }elseif($srcWidth/$srcHeight >= $newWidth/$newHeight && $space=='white'){
        $beginX = 0;
        $beginY = ($newHeight - $newWidth/$srcWidth * $srcHeight)/2;
        if($beginY < 0){
            $beginY = 0;
        }
        $endX = $newWidth;
        $endY = $newWidth/$srcWidth * $srcHeight;
        
        $sourceX = 0;
        $sourceY = 0;
        $sourceH = $srcHeight;
        $sourceW = $srcWidth;
        
    //第四种情况:原宽高比 < 新宽高比，不够的部分进行补白。如果是jpg就补白，如果是png就补透明。例如：，即原来的长窄，新的方正。
    }elseif($srcWidth/$srcHeight < $newWidth/$newHeight && $space=='white'){
        $beginY = 0;
        $beginX = ($newWidth - $newHeight*$srcWidth / $srcHeight)/2;
        if($beginX < 0){
            $beginX = 0;
        }
        $endY = $newHeight;
        $endX = $newHeight*$srcWidth / $srcHeight;
        
        $sourceX = 0;
        $sourceY = 0;
        $sourceH = $srcHeight;
        $sourceW = $srcWidth;
    
        
    //第五种情况：原宽高比 > 新宽高比，则剪切上下部分。例如：原来的横扁，新的方正。
    }elseif($srcWidth/$srcHeight >= $newWidth/$newHeight && $space=='cut'){
        $beginX = 0;
        $beginY = 0;
        $endX = $newWidth;
        $endY = $newHeight;
        
        $sourceY = 0;
        $sourceX = ($srcWidth - $srcHeight * $newWidth/$newHeight)/2;
        if($sourceX < 0){
            $sourceX = 0;
        }
        $sourceH = $srcHeight;
        $sourceW = $srcHeight * $newWidth/$newHeight;
        
    //第六种情况：原宽高比 < 新宽高比，则剪切左右部分。例如：即原来的长窄，新的方正。
    }elseif($srcWidth/$srcHeight < $newWidth/$newHeight && $space=='cut'){
        $beginX = 0;
        $beginY = 0;
        $endX = $newWidth;
        $endY = $newHeight;
        
        $sourceX = 0;
        $sourceY = ($srcHeight - $srcWidth / $newWidth * $newHeight)/2;
        if($sourceY < 0){
            $sourceY = 0;
        }
        $sourceW = $srcWidth;
        $sourceH = $srcWidth / $newWidth * $newHeight;
    }
    //计算尺寸，结束================
    
    
    //生成图片，开始==============
    if($image_type == 'image/jpeg'){
        $srcImg = imagecreatefromjpeg($source_file);
        $created_image = imagecreatetruecolor($newWidth, $newHeight);
        $color = imagecolorallocate($created_image, 255, 255, 255);  //指定为白色
        imagefill($created_image, 0, 0, $color);                     //填充白色
        
        if(function_exists("imagecopyresampled")){
            imagecopyresampled($created_image, $srcImg, $beginX, $beginY, $sourceX, $sourceY,        $endX, $endY, $sourceW, $sourceH);
        }else{
            imagecopyresampled($created_image, $srcImg, $beginX, $beginY, $sourceX, $sourceY,        $endX, $endY, $sourceW, $sourceH);
        }
        //imageinterlace($created_image, $interlace=1); //渐进式显示。$interlace=0为基本形式，Baseline JPEG; $interlace=1为渐进式，Progressive JPEG
        imagejpeg($created_image, $new_file, 100);
        
    }elseif($image_type == 'image/png'){
        $srcImg = imagecreatefrompng($source_file);
        $created_image = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($created_image, false);
        $color = imagecolorallocatealpha($created_image, 0, 0, 0, 127);
        imagefill($created_image, 0, 0, $color);
        imagesavealpha($created_image, true);
        imagecopyresampled($created_image, $srcImg, $beginX, $beginY, $sourceX, $sourceY,        $endX, $endY, $sourceW, $sourceH);
        imagepng($created_image, $new_file);
        
    }elseif($image_type == 'image/gif'){
        $srcImg = imagecreatefromgif($source_file);
        $created_image = imagecreatetruecolor($newWidth, $newHeight);
        $color=imagecolorallocate($created_image,255,255,255);
        imagecolortransparent($created_image, $color);
        imagefill($created_image,0,0,$color);
        imagecopyresampled($created_image, $srcImg, $beginX, $beginY, $sourceX, $sourceY,        $endX, $endY, $sourceW, $sourceH);
        imagegif($created_image, $new_file, 100);
    }
    //生成图片，结束==============
    
    imagedestroy($created_image);
    imagedestroy($srcImg);

}

//模板自定义函数
/**
 * 在模板中是用<{:img_spec($img_path=图片路径, $width=200, $height=200, $handle=1)}>
 * $force 是否强制使用固定尺寸：false不强制，小图不放大，保持小图；true强制，小图会放大，分辨率会变低
 */
function img_spec($source_file, $w=200, $h=200, $handle=3, $force=false){
	if(!is_file(getcwd() . $source_file)){
		return 'not file exist.';
	}
	$file_info = pathinfo(getcwd() . $source_file);
	if(!$file_info){
		return 'not image info.';
	}
	$middleDir = substr($file_info['dirname'], strlen(getcwd().'/upload/image/'));
	$dirname = substr($file_info['dirname'], 0, strlen(getcwd().'/upload/')).'image_resize/'.$w.'x'.$h.'/'.$middleDir.'/'.$file_info['basename'];
	$new_dir = substr($dirname, 0, -strlen($file_info['basename']));
	if(!is_dir($new_dir)){
		mkdirs($new_dir);
	}
	$new_file = $new_dir.$file_info['basename'];
	if(!file_exists($new_file)){
		create_spec_image(getcwd() . $source_file, $new_file, $w, $h, $handle);
	}
	$show_file = '/upload/image_resize/' . $w.'x'.$h . '/' .$middleDir.'/'. $file_info['basename'];
	
	return $show_file;	
}