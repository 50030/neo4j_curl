<?php
/**
 * 2019-12-09
 */
namespace app\home\controller;
use think\Facade\Config;
use think\Route;
use think\Db;
use think\Db\Where;
use think\Controller;
use think\facade\Session;
use think\facade\Cookie;

class Common extends Controller {
	protected $encodeKey;
	protected $arrCatGroup;
	
	
	protected function initialize(){
		$this->encodeKey = config('encodeKey');
		$this->assign("__MODULE__", request()->module());
		$this->assign("__CONTROLLER__", request()->controller());
		$this->assign("__ACTION__", request()->action());
	}
	
	/**
	 * 类别组
	 * 军
	 * 2017-10-11
	 */
	private function _categoryGroup($mark){
		$find = Db::name('Category_group')->where('mark', '=', $mark)->find();
		$this->arrCatGroup = $find;
	}
	
	
	/**
	 * 生成类别树
	 * 军
	 * 2017-10-11
	 */
	protected function catTree($mark, $cat_id=0){
		$this->_categoryGroup($mark);
		$where = [];
		$where[] = ['cat_id', 'IN', $this->arrCatGroup['cat_group']];
		//$where[] = ['cat_id', '<>', $this->arrCatGroup['root_cat_id']];
		$where[] = ['is_enable', '=', 1];
		$where[] = ['delete_time', '=', 0];

		$arr = Db::name('Category')->where($where)->order("orderno DESC, cat_id ASC")->select();
		if(count($arr)>0){
            foreach($arr AS $k=>$v){
                if($v['pid'] == 0){
                    $pid = $v['cat_id'];
                }
            }
            
            /*$findRootCatPid = Db::name('Category')->where('cat_id', '=', $this->arrCatGroup['root_cat_id'])->find();
            if($findRootCatPid){
            	$rootCatPid = intval($findRootCatPid['pid']);
            }else{
            	$rootCatPid = 0;
            }*/
            $rootCatPid = $this->arrCatGroup['root_cat_id'];
            
            require_once("./myLibrary/class/cat_tree_select.class.php");
            $selectCat = new \cat_tree_select( $arr, 'cat_id', 'pid', 'cat_name' );
            $catOption = $selectCat->option_select_self(0, $rootCatPid, $cat_id);
            $this->assign("catOption", $catOption);
        }
	}
	
}