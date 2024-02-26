<?php
/**
 * 从数组生成树形结构
 * 可指定自身主键key,父级关联key，层级key,更加灵活。
 */
class tree {
    public $key;//主键id
    public $pkey;//父级id
    public $lvkey;//系统自动添加的，代表层级的数组key
    public $list;//原始数组，二维
    public $tree;//树形数组
    
    function __construct($list,$key='id',$pkey='pid',$lvkey='lv'){
        $this->list=!empty($list)?$list:array();
        $this->key=$key;
        $this->pkey=$pkey;
        $this->lvkey=$lvkey;
        $this->tree=array();
        $this->GetTree();
    }
    
    
    
    /**
     * 将原始数组按树型结构排序
     * @staticvar int $lv 这是一个用于记录当前单元所处层级的静态变量，顶层单元从1开始
     * @param type $pid 指定从哪个父级id开始
     * @return bool
     */
    function GetTree($pid=0){
        if(empty($this->list)){
            return "";
        }
        static $lv=0;
        $lv++;
        foreach($this->list as $k=>$v){
            if(!isset($v[$this->key]) || !isset($v[$this->pkey])){
                continue;
            }
            if($v[$this->pkey]==$pid){
                $v[$this->lvkey]=$lv;
                $this->tree[$v[$this->key]]=$v;
                if($pid>0){
                	$this->tree[$pid]['is_parent'] = true;
                }
                $this->GetTree($v[$this->key]);
            }
        }
        $lv--;
        return true;
    }
}
    
    
    
/**
 * 使用例子：
 * <?php
$list=array(
0=>array('id'=>1,'title'=>'11111','pid'=>0),
1=>array('id'=>2,'title'=>'12222','pid'=>0),
2=>array('id'=>3,'title'=>'33111','pid'=>1),
3=>array('id'=>4,'title'=>'34444','pid'=>2),
);


require("tree_class.php");

$tree = new tree($list, 'id', 'pid', 'lv');

//echo "<pre>";
//print_r($tree->tree);

echo "<select>";
foreach($tree->tree as $k=>$v){
    	$n = str_pad('', $v['lv'], '-', STR_PAD_RIGHT);
    	$n = str_replace("-", "|-- ", $n);  
	echo "<option>{$n} {$v['title']}</option>";
}
echo "</select>";
 */