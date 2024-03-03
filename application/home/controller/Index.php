<?php
namespace app\home\controller;

use think\Facade\Config;
use think\Route;
use think\Db;
use think\Db\Where;
use think\Controller;

use my\Neo4j;

class Index extends Common {
	private $neo4j;
	private $arrRelatives;
	
	
	protected function initialize(){
		parent::initialize();
		
    	$this->neo4j = new Neo4j();
    	$this->neo4j->host('localhost')
    		  ->port('7474')
    		  ->user('neo4j')
    		  ->password('neo4jneo4j')
    		  ->database('neo4j')
    		  ->connect();
    		  
		 $this->arrRelatives = ['HAS_FATHER', 'HAS_MOTHER', 'HAS_HUSBAND', 'HAS_WIFE', 'HAS_SON', 'HAS_DAUGHTER'];
	}
	
    public function index(){
        $this->assign("date", date("Y-m-d"));
        return view();
    }
    
    
    public function updatePerson(){
    	$select = Db::name('category')->where('cat_id', '>', 91)->order('cat_id ASC')->select();
    	//dump($select);
    	
    	foreach($select AS $k=>$v){
    		$id = $v['id2'];
    		$name = $v['cat_name'];
dump($v);
echo "<hr />";		
    		$findParent = db::name('category')->where('cat_id', '=', $v['pid'])->find();
dump($findParent);
echo "<hr />";
    		if($findParent){
	    		$fid = $v['pid2'];
	    		
	    		$start = strpos($findParent['cat_name'], '世');
	    		$end = strpos($findParent['cat_name'], '，');
	    		$fname = substr($findParent['cat_name'], $start + strlen('世'), $end - $start - strlen('世'));
	    		
	    		dump($v['cat_name']);
	    		dump($start);
	    		dump($end);
	    		dump($fname);
	    		echo "<hr />";
    		}else{
    			$fid = '';
    			$fname = '';
    		}
    		$mid = '';
    		$mname = '';
dump($fid);
dump($fname);
//exit;
    		db::name('category')->where('cat_id', '=', $v['cat_id'])->update(['fid' => $fid, 'fname' => $fname]);
    	}
    }
    
    
    public function updateGraph(){
    	$select = Db::name('category')->where('cat_id', '>', 89)->order('cat_id ASC')->select();
    	foreach($select AS $k=>$v){
    		$id = $v['id2'];
    		$name = $v['cat_name'];
    		$fid = $v['fid'];
    		$fname = $v['fname'];
    		

   		
    		
    		
	    	//$query = 'MERGE (n:person {name: $name, gender: $gender, ranking: $ranking, remark: $remark, orderno: $orderno, id: $id, fid: $fid, fname: $fname}) RETURN n';
	    	
	    	
	    	
	    	
	    	$params = [
	    			
	    			'id' => $id,
	    			'name' => $name,
	    			'fid' => $fid,
	    			'fname' => $fname,
	    			
	    			'gender' => 0,
	    			'ranking' => '',
	    			'remark' => '',
	    			'orderno' => 0,
	    		];
dump($query);
dump($params);
echo "<hr />";	
	    	//添加人丁
	    	//$result = $this->neo4j->send($query, $params);
	    	
	    	//添加关系
			$query = 'MATCH (a:person), (b:person) ';
			$query .= ' WHERE a.id = $id AND b.id = $skinship_id ';
			$query .= ' MERGE (a) - [r:HAS_FATHER] -> (b) ';
			$query .= ' RETURN a, r, b ';
			$params = [
				'id' => $id,
				'skinship_id' => $fid,
			];

dump($query);
dump($params);
echo "<hr />";	
echo "<hr />";	
			//$result = $this->neo4j->send($query, $params);
    	}
    }
    
    
    //更新有儿子
    public function updateHasSon(){
    	$select = Db::name('category')->where('cat_id', '>', 89)->order('cat_id DESC')->select();
    	foreach($select AS $k=>$v){
    		dump($v);
    		dump($v['id2']);
    		dump($v['fid']);
    		echo "<hr />";
    		$id = $v['fid'];
    		$skinship_id = $v['id2'];
	    	//添加关系
			$query = 'MATCH (a:person), (b:person) ';
			$query .= ' WHERE a.id = $id AND b.id = $skinship_id ';
			$query .= ' MERGE (a) - [r:HAS_SON] -> (b) ';
			$query .= ' RETURN a, r, b ';
			$params = [
				'id' => $id,
				'skinship_id' => $skinship_id,
			];

dump($query);
dump($params);
echo "<hr />";	
echo "<hr />";	
			//$result = $this->neo4j->send($query, $params);
    		
    	}
    }
    
    
    
    /**
     * 编辑人
     * 2024-02-27
     */
    public function lists(){
    	if($_POST){
    		$arrRelationship = [
    				'HAS_FATHER'   => '有父亲',
    				'HAS_MOTHER'   => '有母亲',
    				'HAS_SON'      => '有儿子',
    				'HAS_DAUGHTER' => '有女儿',
    				'HAS_HUSBAND'  => '有丈夫',
    				'HAS_WIFE'     => '有妻子',
    			];
	    	//$query = 'MATCH (n:person) - [r] -> (n2:person) WHERE n.name CONTAINS $search AND n.id > 30 return n.id, n2.id, type(r), n.name, n.remark, n.ranking ORDER by n.id ASC';
	    	$query = 'match (n:person) -[r] -> (n2:person) where n.name CONTAINS $search AND n.id > 30 return n.id, n.fid ,type(r), n2.id';
	    	
	    	$params = [
	    		'search' => '本'
	    	];
	    	
	    	$result = $this->neo4j->send($query, $params);
	    	$result = $this->neo4j->send($query);
	    	$arr = $result['data'][0]['data'];

	    	foreach($arr AS $k=>$v){
	    		unset($arr[$k]['meta']);
	    		
	    		$arr[$k]['row'][6] = '';
	    		foreach($arrRelationship AS $k2=>$v2){
	    			if($arr[$k]['row'][2] == $k2){
	    				$arr[$k]['row'][6] = $v2;
	    			}
	    		}
	    	}
echo "<pre>";
print_r($arr);
exit;
	    	echo json_encode($arr, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	    	exit;
    	}
    	return view();
    }
    
    
    
    /**
     * 添加人丁
     * 2024-02-27
     */
    public function addPerson(){
    	if($_POST){
    		$name = input('post.name/s', '', 'trim');
    		$gender = input('post.gender/d', 0);   //1男，2女
    		$ranking = input('post.ranking/s', '', 'trim');  //排行
    		$remark = input('post.remark/s', '', 'trim'); //备注
    		$orderno = input('post.orderno/d', 0);   //排序
    		
    		$skinship = input('post.skinship/s', '', 'trim'); //有亲属，有关系
    		$skinship_id = input('post.skinship_id/d', 0);    //关系人id
    		
    		$id = Db::name('serial_id')->insertGetId(['name'=>'a']);
    		$id = intval($id);
    		
	    	$query = 'MERGE (n:person {name: $name, gender: $gender, ranking: $ranking, remark: $remark, orderno: $orderno, id: $id}) RETURN n';
	    	$params = [
	    			'name' => $name,
	    			'gender' => $gender,
	    			'ranking' => $ranking,
	    			'remark' => $remark,
	    			'orderno' => $orderno,
	    			'id' => $id,
	    		];
	    	
	    	//添加人丁
	    	$result = $this->neo4j->send($query, $params);
	    	
	    	//添加关系
	    	$isIn = in_array($skinship, $this->arrRelatives);
	    	
    		if(!empty($skinship_id) && !empty($skinship) && $isIn !== false){
    			$query = 'MATCH (a:person), (b:person) ';
    			$query .= ' WHERE a.id = $id AND b.id = $skinship_id ';
    			$query .= ' MERGE (a) - [r:' . $skinship . '] -> (b) ';
    			$query .= ' RETURN a, r, b ';
    			$params = [
    				'id' => $id,
    				'skinship_id' => $skinship_id,
    			];

    			$result = $this->neo4j->send($query, $params);
    			$this->redirect('lists');
    			exit;
    		}
    	}
    	return view();
    }
    
    
    /**
     * 编辑人
     * 2024-02-27
     */
    public function editPerson(){
    	if($_POST){
    		$name = input('post.name/s', '', 'trim');
    		$gender = input('post.gender/d', 0);   //1男，2女
    		$ranking = input('post.ranking/s', '', 'trim');  //排行
    		$remark = input('post.remark/s', '', 'trim'); //备注
    		$orderno = input('post.orderno/d', 0);   //排序
    		$id = input('post.id/d', 0);
    		
    		$skinship = input('post.skinship/s', '', 'trim'); //有亲属，有关系
    		$skinship_id = input('post.skinship_id/d', 0);    //关系人id
    		
    		$query = 'MATCH (n:person) WHERE n.id = $id ';
    		$query .= ' SET n.name = $name, n.gender = $gender, n.ranking = $ranking, n.remark = $remark, n.orderno = $orderno ';
    		$params = [
	    			'name' => $name,
	    			'gender' => $gender,
	    			'ranking' => $ranking,
	    			'remark' => $remark,
	    			'orderno' => $orderno,
	    			'id' => $id,
	    		];
	    		
	    	//更新
	    	$result = $this->neo4j->send($query, $params);
	    	
	    	//添加关系
	    	$isIn = in_array($skinship, $this->arrRelatives);
	    	
    		if(!empty($skinship_id) && !empty($skinship) && $isIn !== false){
    			$query = 'MATCH (a:person), (b:person) ';
    			$query .= ' WHERE a.id = $id AND b.id = $skinship_id ';
    			$query .= ' MERGE (a) - [r:' . $skinship . ' ] -> (b) ';
    			$query .= ' RETURN a, r.name, b ';
    			$params = [
    				'id' => $id,
    				'skinship_id' => $skinship_id,
    			];

    			$result = $this->neo4j->send($query, $params);
    			$this->redirect('lists');
    			exit;
    		}
    	}
    	
    	$id = intval($_GET['id']);
    	$query = 'MATCH (n:person) WHERE n.id = $id RETURN n';
    	$params = [
    		'id' => $id,
    	]; 
    	
    	$result = $this->neo4j->send($query, $params);
    	if(isset($result['data'][0]['data'])){
    		$arr = $result['data'][0]['data'][0]['row'][0];
    	}

    	$this->assign('edit', $arr);
    	return view();
    }
    
    
    /**
     * 查找人，用于添加关系
     * 2024-02-27
     */
    public function searchSkinship(){
    	if($_POST){
	    	$searchKey = input('post.name/s', '', 'trim');
	    	$query = 'MATCH (n:person) WHERE n.name CONTAINS $search RETURN n.name AS name, n.gender AS gender, n.remark AS remark, n.ranking AS ranking, n.id AS id  ORDER BY n.orderno ASC';   //CONTAINS 相当于 LIKE查询
	    	$params = ['search' => $searchKey]; 

	    	$result = $this->neo4j->send($query, $params);

	    	$arrNew = [];
	    	foreach($result['data'][0]['data'] AS $k=>$v){
	    		$str = '';

	    		foreach($v['row'] AS $k2=>$v2){
	    			if($k2 == 0){
	    				$str .= $v2;
	    			}elseif($k2 == 1){
	    				if($v2 == 1){
	    					$str .= '（男）';
	    				}elseif($v2 == 2){
	    					$str .= '（女）';
	    				}else{
	    					$str .= '（'.$v2.'）';
	    				}
	    			}elseif($k2 == 2){
	    				$str .= '' . $v2;
	    			}elseif($k2 == 3){
	    				$str .= '， 排行：' . $v2;
	    			}elseif($k2 == 4){
	    				$str = 'id：' . $v2 . '， ' . $str;
	    			}
	    		}
	    		$arrNew[] = ['id' => $v2, 'str' => $str];
	    	}
			echo json_encode(['status' => 200, 'data' => $arrNew]);
			exit;
    	}
    	return view();
    }
    
    
    
    /**
     * 测试cytoscape.js
     * 2024-02-28
     */
    public function cytoscape(){
    	return view();
    }
    
    
}
