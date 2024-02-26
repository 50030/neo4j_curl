<?php
namespace app\mmm\controller;

use think\Facade\Config;
use think\Route;
use think\Db;
use think\Db\Where;
use think\Controller;

class Index extends Common {
	protected function initialize(){
		parent::initialize();
	}
	
    public function index(){
        $this->assign("date", date("Y-m-d"));
        return view();
    }
    
}
