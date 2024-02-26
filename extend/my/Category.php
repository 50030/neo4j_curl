<?php
/**
 * 类别
 * 2019-12-18
 */
namespace my;

class CategoryGroup
{
	//private $mark;
	private $categoryGroup;
	private $rootCatId;
	
	/**
	 * 类别组
	 * 军
	 * 2017-10-11
	 */
	private function _getCategoryGroup($mark){
		
		$find = Db::name('Category_group')->where('mark', '=', $mark)->find();
		
		$this->$categoryGroup = $find['cat_group'];
		$this->rootCatId = $find['root_cat_id'];
	}
	
	
	/**
	 * 生成类别树
	 * 军
	 * 2017-10-11
	 */
	public static function getCatTree($mark, $cat_id=0){
		$this->_getCategoryGroup($mark);
		$where = [];
		$where[] = ['cat_id', 'IN', $this->categoryGroup];
		$where[] = ['is_enable', '=', 1];
		$where[] = ['delete_time', '=', 0];
		$arr = Db::name('Category')->where($where)->order("orderno DESC, cat_id ASC")->select();
		if(count($arr)>0){
            foreach($arr AS $k=>$v){
                if($v['pid'] == 0){
                    $pid = $v['cat_id'];
                }
            }
            
            $find_root_cat_pid = Db::name('Category')->where('cat_id', '=', $this->rootCatId)->find();
            $root_cat_pid = intval($find_root_cat_pid['pid']);
            
            require_cache("./myLibrary/class/cat_tree_select.class.php");
            $catSelect = new \cat_tree_select( $arr, 'cat_id', 'pid', 'cat_name' );
            $catBox = $catSelect->option_select_self(0, $root_cat_pid, $cat_id ? $cat_id : $this->rootCatId);
            return $catBox;
            /*$this->assign("cat_box", $cat_box);
            
            //应用于查询
            if(isset($_GET['search_cat_id'])){
                $search_cat_id = intval($_GET['search_cat_id']);
            }else{
                $search_cat_id = 0;
            }
            $search_cat_select = new \cat_tree_select($arr, 'cat_id', 'pid', 'cat_name');
            $search_cat_box = $search_cat_select->option_select_self(0, $pid=$root_cat_pid, $search_cat_id);
            $this->assign("search_cat_box", $search_cat_box);
            unset($cat_select);*/
        }
	}
	
	
}