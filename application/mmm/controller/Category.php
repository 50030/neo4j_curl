<?php
/**
 * 类别管理
 * 2019-12-09
 */
namespace app\mmm\controller;
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
     * 添加类别2019-12-09
     */
    public function addCategory(){
    	
    	if($_POST){
    		$arrNew = [];
    		$catMark = input('post.cat_mark/s', '', 'trim');
    		
    		$arrNew['pid'] = input('post.pid/d');
    		$arrNew['cat_name'] = input('post.cat_name/s', '', 'trim');
    		$arrNew['orderno'] = input('post.orderno/d');
    		$arrNew['is_enable'] = input('post.is_enable/d');
    		$catMark = input('post.cat_mark/s', '', 'trim');
    		$arrNew['cat_mark'] = $catMark;
    		$arrNew['remark'] = input('post.remark/s', '', 'trim');
    		$arrNew['color'] = input('post.color/s', '', 'trim');
    		
    		//检查类别标识，是否有重名
    		if($catMark !== ''){
    			$findCatMark = Db::name('Category')->where('cat_mark', '=', $catMark)->find();
    			if($findCatMark){
		    		echo json_encode(['status'=>400, 'msg'=>'标识有重名，请更改类别标识']);
		    		exit;
    			}
    		}
    		
    		Db::startTrans();
    		try {
    			Db::name('category')->insert($arrNew);
    			Db::name('category_group')->where("1")->update(['rebuild'=>2]);
	    		Db::commit();
	    		echo json_encode(['status'=>200]);
	    		exit;
    		} catch (\Exception $e){
    			Db::rollback();
	    		echo json_encode(['status'=>400, 'msg'=>'数据库操作失败'.Db::getLastSql()]);
	    		exit;
    		}
    	}
    	
		$selectCategory = Db::name('category')->where('delete_time', '=', 0)->order("orderno DESC, cat_id ASC")->select();
		
		require_once("./myLibrary/class/cat_tree_select.class.php");
		$temp = new \cat_tree_select($selectCategory, 'cat_id', 'pid', 'cat_name');
		$select_option = $temp->category_box($cat_id=0);
		$this->assign("select_option",$select_option);
		
		return view();
    }
    
    
    /**
     * 编辑类别
     * 2019-12-09
     */
    public function editCategory(){
    	
    	if($_POST){
    		$cat_id = input('post.cat_id', 0, 'intval');
    		
    		$pid = input('post.pid', 0, 'intval');
    		$cat_name = input('post.cat_name', '', 'trim');
    		$orderno = input('post.orderno', 0, 'intval');
    		$is_enable = input('post.is_enable', 0, 'intval');
    		$cat_mark = input('post.cat_mark', '', 'trim');
    		$remark = input('post.remark', '', 'trim');
    		
    		
    		//检查类别标识，是否有重名
    		if($cat_mark !== ''){
    			$find_cat_mark = Db::name('Category')->where("cat_mark='$cat_mark' AND cat_id!='$cat_id'")->find();
    			if($find_cat_mark){
		    		echo json_encode(['status'=>400, 'msg'=>'标识有重名，请更改类别标识']);
		    		exit;
    			}
    		}
    		
    		$arrNew = array();
    		
    		$arrNew['pid'] = $pid;
    		$arrNew['cat_name'] = $cat_name;
    		$arrNew['orderno'] = $orderno;
    		$arrNew['is_enable'] = $is_enable;
    		$arrNew['cat_mark'] = $cat_mark;
    		$arrNew['remark'] = $remark;
    		$arrNew['color'] = input('post.color', '', 'trim,htmlspecialchars');
    		
    		
    		Db::startTrans();
    		try {
    			Db::name('Category')->where("cat_id='$cat_id'")->limit(1)->update($arrNew);
    			Db::name('category_group')->where('1')->update(['rebuild'=>2]);
    			Db::commit();
	    		echo json_encode(['status'=>200]);
	    		exit;
    		} catch (\Exception $e){
    			Db::rollback();
	    		echo json_encode(['status'=>400, 'msg'=>'数据库操作失败']);
	    		exit;
    		}
    	}
    	
    	$cat_id = input('get.cat_id', 0, 'intval');
    	$find = Db::name('Category')->where("cat_id='$cat_id'")->find();
    	$this->assign("edit", $find);
    	
    	
		$sql = "SELECT * FROM ".config('database.prefix')."category WHERE delete_time=0 ORDER BY orderno DESC, cat_id ASC";
		$temp = DB::query($sql); 
		require_once("./myLibrary/class/cat_tree_select.class.php");
		$temp = new \cat_tree_select($temp,'cat_id','pid','cat_name');
		$select_option = $temp->category_box($cat_id);
		$this->assign("select_option",$select_option);
		
    	return view();
    }
    
    
    /**
     * 删除类别
     * 军
     * 2017-10-03
     */
    public function delCategory(){
    	$cat_id = input('post.cat_id', 0, 'intval');
    	
		$find_child = Db::name('Category')->where("pid='$cat_id' AND delete_time=0")->find();
		if($find_child){
    		echo json_encode(['status'=>400, 'msg'=>'有子类别，不可以删除，必须先移除子菜单']);
    		exit;
		}
		
		Db::startTrans();
		try {
			Db::name("Category")->where("cat_id='$cat_id'")->limit(1)->update(array("delete_time"=>time()));
			Db::commit();
    		echo json_encode(['status'=>200]);
    		exit;
		} catch (\Exception $e){
			Db::rollback();
    		echo json_encode(['status'=>400, 'msg'=>'删除类别失败']);
    		exit;
		}
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