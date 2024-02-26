<?php

namespace my\getContents;
    /**
     * 抓取
     * 2023-04-24
     */
    class getContents{
    
    public function getContents($url){
    	
    	$i = 1;
    	while($i <= 3){
	    	$result = @file_get_contents($url);
	    	$arr = json_decode($result, true);
	    	
	    	$time = time();
	    	$rand = rand(2,5);
	    	while(($time + $rand) > time()){
		    	//起到延时的作用，sleep是页面延迟，不是执行代码延迟。
		    }
   
	    	if(isset($arr['result']) && $arr['result'] === 0 && isset($arr['data'][0])){		
	    		//插入到会员信息表
	    		foreach($arr['data'] AS $k=>$v){
	    			if($v == NULL){
	    				$arr['data'][$k] = '';
	    			}
	    		}
	    		return $arr;
	    	}else{
	    		return NULL;
	    	}
	    	
	    	$i++;
	    }
	    return NULL;
    }
    
}    