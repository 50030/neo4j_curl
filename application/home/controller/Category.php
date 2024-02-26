<?php
/**
 * 类别管理
 * 2019-12-09
 */
namespace app\home\controller;
use think\Facade\Config;
use think\Route;
use think\Db;
use think\Db\Where;
use think\Controller;
use think\facade\Session;

class Category extends Common {
	
	protected function _initialize(){
		parent::_initialize();
	}
	
	
	/**
	 * 类别列表
	 * 2019-12-09
	 */
	public function listCategory(){
		$selectCategory = Db::name('category')->where('delete_time', '=', 0)->order("orderno DESC, cat_id ASC")->select();
		$tree = $this->_dtreeCategory($selectCategory, $id=0, 0, $name="类别设置" , $openAll=0);  //列整棵树,默认不展开
		$this->assign("categoryTree",$tree);
		return view();
	}
    
    
    private function _dtreeCategory( $arr, $id, $pid, $name = "", $openAll = 1){
        $name   = $name . ':<a href="javascript: d.closeAll();">&nbsp;&nbsp;收起</a> | <a href="javascript: d.openAll();">展开</a>';
        $url_empty = '';
        $str    = '<script type="text/javascript">' . "\n";
        $jstree = "d = new dTree('d');d.add('$pid', '-1', '$name', '$url_empty', '', '', '../Public/images/arrow_5.gif');\n";
        if($_GET){
            foreach($_GET AS $k=>$v){
                if($k != 'id'){
                    $url_para .= "&" . $k . "=" . $v;
                }
            }
            $url_para = substr($url_para, 1);
        }
        
        foreach($arr AS $v){
            if($v['is_enable'] == 2){
            	$is_enable = '-<font color=red>(禁用)</font>';
            }elseif($v['is_enable'] != 1){
            	$is_enable = '-<font color=red>(未启用)</font>';
            }else{
            	$is_enable = '';
            }
            
            if(!empty($v['orderno'])){
            	$orderno = "({$v['orderno']})";
            }else{
            	$orderno = '';
            }
            
            if(!empty($v['cat_mark'])){
            	$cat_mark = "【{$v['cat_mark']}】";
            }else{
            	$cat_mark = '';
            }
            
            $jstree .= "d.add(";
            $jstree .= $v['cat_id'] . ',';
            $jstree .= $v['pid'] . ',';
            $jstree .= '\''. "<span style=\"background-color:#{$v['color']}\">&nbsp;&nbsp;&nbsp;&nbsp;</span>" . $v['cat_id'] . $v['cat_name'] . $orderno . $cat_mark . $is_enable . '\'' . ',';
            $jstree .= '\''.'editCategory?cat_id='.$v['cat_id'].'\'';     //URL地址
            $jstree .= ");\n";
        }
    
        $jstree .= "document.write(d);\n";
        if($openAll == 1){
            $jstree .= "d.openAll();\n";
        }
       
        return $str . $jstree . '</script>';
    }
    
    
    /**
     * 查找类别
     * 2023-06-07
     */
    public function searchCategory(){
    	if($_POST){
    		$searchCategory = input('post.cat_name', '', 'trim');
    		$selectCategory = Db::name('Category')->where('cat_name', 'LIKE', '%'.$searchCategory.'%')->select();
    		if($selectCategory){
    			$arrNew = [];
    			$arrNew['status'] = 200;
    			$arrNew['data'] = $selectCategory;
    			echo json_encode($arrNew);
    		}else{
    			echo json_encode(['status'=>400, 'msg'=>'没有找到']);
    		}
    		exit;
    	}
    	return view();
    }
    
    
    /**
     * jitTree可视化
     * 2023-06-09
     */
    public function jitTree(){
    	$catId = input('get.cat_id/d', '0', 'intval');
    	$this->assign("cat_id", $catId);
    	return view();
    }
    
    
    /**
     * jitTree可视化
     * 2023-06-09
     */
    public function jitTreeGetJson(){
    	$arrNew = [];
    	$catId = input('get.cat_id/d', 0, 'intval');

    	if(!$catId){
    		$catId = 90;
    	}
    	$findCat = Db::name('category')->where('cat_id', '=', $catId)->field("cat_id AS id, cat_name AS name")->find();
    	$selectSon = Db::name('category')->where('pid', '=', $catId)->order("orderno DESC")->field("cat_id AS id, cat_name AS name, pid")->select();
    	
    	$arrNew['id'] = $findCat['id'];
    	$arrNew['name'] = $findCat['name'];
    	
    	if($selectSon){
    		foreach($selectSon AS $k=>$v){
    			$selectSon2 = Db::name('category')->where('pid', '=', $v['id'])->order("orderno DESC")->select();
    			if($selectSon2){
    				foreach($selectSon2 AS $k2=>$v2){
    					$selectSon2[$k2]['children'] = [];
    				}
    			}
    			$selectSon[$k]['children'] = $selectSon2;
    		}
    	}
    	
    	$arrNew['children'] = $selectSon;
    	echo json_encode($arrNew);
    }
    
	
}