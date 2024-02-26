<?php
/**
 * 作者：郑爱军 
 * QQ：125315695
 * 日期：2012-05-20
 */
class cat_tree_select {
    
    
    public   $cat_id;        //字段id
    public   $pid;           //字段,类名
    public   $cat_name;      //字段,父id
    
    private  $count;         //类别总计有几个
    private  $str;           //原始下拉列表
    private  $arr;           //原始全部类别，数组
    private  $sub_arr;       //当前类的全部子类，包括自己
    private  $str_map;       //关系图谱
    private  $arr_useable;   //可用的数组
    
    
    public function  __construct($arr_cat, $cat_id='cat_id', $pid='pid', $cat_name='cat_name'){
    	$this->cat_id = $cat_id;
    	$this->pid = $pid;
    	$this->cat_name = $cat_name;
    	$this->arr = array();
    	$this->arr_useable = array();
    	foreach($arr_cat as $v){
    		$this->arr[] = array($v[$this->cat_id],$v[$this->cat_name],$v[$this->pid]);  //调整一下全部类别
    	}
    	$this->count = count($this->arr);   
        $this->str = "";  //原始下拉列表的字符串。
    	$this->sub_arr = array();  
    	
    	$this->str_map = "";  //关系图谱
    }
    

	//最终返回的下拉选择字符串-------
    public function category_box($index){ 
    	/******************第一次生成字符串**********************/
    	$str = $this->category_list(0,0); //从头一个类别开始，生成全部类别，构建原始下拉列表
    	
    	//找出唯一父类，并激活它-----------------------
    	for($i=0; $i<$this->count; $i++):               
	      	if($this->arr[$i][0]==$index):  
	      	   $parent_id = $this->arr[$i][2];  //获取父id
	      	   for($j=0; $j<$this->count; $j++):
	      	      if($this->arr[$j][0] == $parent_id):  //如果它的id = 父id
	      	         //$replace  = '<option value="'.$this->arr[$j][0].'">';
	      	         //$replace2 = '<option value="'.$this->arr[$j][0].'" selected="selected">';  //找出唯一的父类   
	      	         $replace  = '<option value="'.$this->arr[$j][0].'"';
	      	         $replace2 = '<option value="'.$this->arr[$j][0].'" selected="selected"';  //找出唯一的父类   	         
	      	         break;
	      	      endif;
	      	   endfor;
	        endif;    	
    	endfor;	
    	if(isset($replace)){  
        	$str = str_replace($replace, $replace2, $str);  //替换后，激活唯一的父类
    	}
    	//找出唯一父类，并激活它************************
    	    	
       //找出当前类，及其子类，使其变为不可用-----------------
  	   if(!empty($index)): //添加新类别时，$index将为0，所以应去除不算
		    $this->self_disable($index); //把自己disable     
		    $this->sub_disable($index);  //把自己下层disable
	    	for($i=0; $i<$this->count; $i++):
	    		if(isset($this->sub_arr[$i][1])){
	    			$str = str_replace($this->sub_arr[$i][0], $this->sub_arr[$i][1], $str);  //大于等于的都换
	    		}
	    	endfor;	      	   	
  	   endif;    
  	   //找出当前类，及其子类，使其变为不可用******************
      	              
       return $str; //返回最后组合完成的<option></option>字符串
       
    }//最终返回的下拉选择字符串********
    
    
    
    //构建下拉列表----------------
    public function category_list($m, $pid){ //m第一次自动为0 , $pid是父类id，跟$this->pid无关，$this->pid 是表示父类别名称是pid
    	$n = str_pad('', $m, '-', STR_PAD_RIGHT);
    	$n = str_replace("-", '|  ', $n);  
    	for($i=0; $i<$this->count; $i++):            //先全部连接成字符串，以后再替换 selected
	         if($this->arr[$i][2]==$pid):
	         	if($m == 0){
	            	$this->str .= "<option value=\"".$this->arr[$i][0]."\" style='color:#E74955; font-weight:bold;'>".$n.'|--'.$this->arr[$i][1]."</option>\n";
	         	}else{
	         		$this->str .= "<option value=\"".$this->arr[$i][0]."\">".$n.'|--'.$this->arr[$i][1]."</option>\n"; 
	         	}
	            $this->category_list($m+1,$this->arr[$i][0]);          //递归   
	          endif; 
    	endfor; 
    	
    	return $this->str;
    }
    //构建下拉列表****************
    
    
    
    //按顺序获取可用的，并返回数组----------------
    public function arr_useable($m, $pid=0){ //m第一次自动为0 , $pid是父类id，跟$this->pid无关，$this->pid 是表示父类别名称是pid
    	//$n = str_pad('', $m, '-', STR_PAD_RIGHT);
    	//$n = str_replace("-", '|  ', $n);  
    	
    	for($i=0; $i<$this->count; $i++):            //先全部连接成字符串，以后再替换 selected
	         if($this->arr[$i][2]==$pid): 	  
	            //$this->str .= "<option value=\"".$this->arr[$i][0]."\">".$n.'|--'.$this->arr[$i][1]."</option>\n"; 
	            $this->arr_useable[] = $this->arr[$i]; 
	            $this->arr_useable($m+1,$this->arr[$i][0]);          //递归   
	          endif; 
    	endfor; 
    	
    	return $this->arr_useable;
    }
    //按顺序获取可用的，并返回数组****************
    
    
    
    //构建下拉列表----------------
    public function option_select_self($m, $pid,$id){ //m第一次自动为0 , $pid是父类id，跟$this->pid无关，$this->pid 是表示父类别名称是pid
    	$n = str_pad('', $m, '-', STR_PAD_RIGHT);  
    	$n = str_replace("-", "|&nbsp;&nbsp;", $n);
    	for($i=0; $i<$this->count; $i++):        //先全部连接成字符串，以后再替换 selected
	         if($this->arr[$i][2]==$pid){	 
			     if($this->arr[$i][0]==$id){   
	            	$selected = ' selected="selected" ';
	             }else{
	             	$selected = '';
	             }
	            $this->str .= "<option value=\"{$this->arr[$i][0]}\"{$selected}>".$n.'|--'.$this->arr[$i][1]."</option>\n"; 
	            $this->option_select_self($m+1,$this->arr[$i][0],$id);          //递归   
	         }
    	endfor; 
    	
    	return $this->str; 
    }
    //构建下拉列表****************
    
    
    //找出自己，加入disable数组--------------
	private function self_disable($index){  
	  	      	for($i=0; $i<$this->count; $i++):               
		      	if($this->arr[$i][0]==$index): 
	                     $this->sub_arr[] = array("<option value=\"".$this->arr[$i][0]."\">" , "<option value=\"".$this->arr[$i][0]."\" disabled=\"disabled\">");
		      	         break;
		        endif;    	
	    	endfor;   
	 }
	 //找出自己，加入disable数组*************
  	
    
	//获取所有从属子类,加入disable数组--------
	private function sub_disable($index){ 
		for($i=0;$i<$this->count;$i++):
		   if($this->arr[$i][2]==$index):  //pid=id
		   	  $this->sub_arr[] = array("<option value=\"".$this->arr[$i][0]."\">", "<option value=\"".$this->arr[$i][0]."\"  disabled=\"disabled\">");
		   	  $this->sub_disable($this->arr[$i][0]);           //递归
		   endif;
		endfor;
	}    
  	//获取所有从属子类,加入disable数组********
  	
  	
  	//父类链函数--------------------------
	public function get_parents($id){
	    if (empty($id)){
	        return array();
	    }
	    $i = 0;
	    $arr_temp = array(); 
	    while(1){
		    foreach ($this->arr AS $v){
		        if ($id == $v[0]){                         // 0=id,1=name,2=pid
		            $id = $v[2];     //交换pid
		            $arr_temp[] = array($v[0],$v[1]);
		            $i=1;                                       //只当标志用
		            break;
		        }
		    }
		    if(0==$i || 0==$id)   break;                     //追溯到0==pid的时候退出。
	    }
	    
	    return $arr_temp;
	}
	
	    
    
    //构建关系图谱----------------
    public function show_map($m, $pid){ //m第一次自动为0 , $pid是父类id，跟$this->pid无关，$this->pid 是表示父类别名称是pid
    	$n = str_pad('', $m, '-', STR_PAD_RIGHT);
    	$n = str_replace("-", "|&nbsp;&nbsp;&nbsp;&nbsp;", $n);  
    	for($i=0; $i<$this->count; $i++):            //先全部连接成字符串，以后再替换 selected
	         if($this->arr[$i][2]==$pid): 	  
	            $this->str_map .= $n.'|----'."<span class=\"link_{$m}\">".$this->arr[$i][1]."</span><br /><br />"; 
	            $this->show_map($m+1,$this->arr[$i][0]);          //递归   
	          endif; 
    	endfor; 
    	
    	return $this->str_map;
    }
    //构建关系图谱****************
    
    
  	
  	
}//end class 
?>