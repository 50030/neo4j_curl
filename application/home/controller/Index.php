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
    
    
    /**
     * 编辑人
     * 2024-02-27
     */
    public function lists(){
    	if($_POST){
    		$id = input('post.id/d', 0);
    		$arrRelationship = [
    				/*'HAS_FATHER'   => '有父亲',
    				'HAS_MOTHER'   => '有母亲',
    				'HAS_SON'      => '有儿子',
    				'HAS_DAUGHTER' => '有女儿',
    				'HAS_HUSBAND'  => '有丈夫',
    				'HAS_WIFE'     => '有妻子',*/
    				'HAS_FATHER'   => '父',
    				'HAS_MOTHER'   => '母',
    				'HAS_SON'      => '子',
    				'HAS_DAUGHTER' => '女',
    				'HAS_HUSBAND'  => '夫',
    				'HAS_WIFE'     => '妻',
    			];
	    	$query = 'match (n:person) - [r] -> (n2:person) where (n.id = $id OR n2.id = $id2 ) ';
	    	$query .= ' return n.id AS id, n.generation AS generation, n.name AS name, n.offspring AS offspring ';
	    	$query .= ' ,type(r) AS type, n2.id AS id2 ';
	    	
	    	$params = [
	    		'id' => $id,
	    		'id2' => $id,
	    	];
	    	
	    	$result = $this->neo4j->send($query, $params);
	    	
	    	$arr = [];
	    	if(isset($result['data'][0]['data'])){
	    		$arr = $result['data'][0]['data'];
	    	}
	    	
			$arrNew = [];
	    	foreach($arr AS $k=>$v){
	    		unset($arr[$k]['meta']);
	    		
	    		$arrNew[$k]['id'] = $v['row'][0];
	    		$arrNew[$k]['generation'] = $v['row'][1];
	    		$arrNew[$k]['name'] = $v['row'][2];
	    		$arrNew[$k]['offspring'] = $v['row'][3];
	    		$arrNew[$k]['relationship'] = $v['row'][4];
	    		$arrNew[$k]['relationship_id'] = $v['row'][5];
	    		
	    		$arrNew[$k]['relationship'] = $arrRelationship[$arrNew[$k]['relationship']];
	    	}
	    	echo json_encode($arrNew, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
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
    		$generation = input('post.generation/s', '', 'trim');//世代
    		$name = input('post.name/s', '', 'trim');            //名字
    		$offspring = input('post.offspring/s', '', 'trim');  //亲属
    		$ranking = input('post.ranking/d', 0);  //排行
    		
    		$skinship = input('post.skinship/s', '', 'trim'); //有亲属，有关系
    		$skinship_id = input('post.skinship_id/d', 0);    //关系人id
    		
    		$id = Db::name('serial_id')->insertGetId(['name'=>'a']);
    		$id = intval($id);
    		
	    	$query = 'MERGE (n:person {generation: $generation, name: $name, offspring: $offspring, ranking: $ranking, id: $id}) RETURN n';
	    	$params = [
	    			'generation' => $generation,
	    			'name' => $name,
	    			'offspring' => $offspring,
	    			'ranking' => $ranking,
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
    			
    			//有父亲
    			if($skinship == 'HAS_FATHER'){
    				$query = 'MATCH (n:person) WHERE id = $id SET fid = $skinship_id RETURN n';
    				$params = [
    					'id' => $id,
    					'fid' => $skinship_id,
    				];
    				
    				$result = $this->neo4j->send($query, $params);
    			//有母亲
    			}elseif($skinship == 'HAS_MOTHER'){
    				$query = 'MATCH (n:person) WHERE id = $id SET mid = $skinship_id RETURN n';
    				$params = [
    					'id' => $id,
    					'mid' => $skinship_id,
    				];
    				
    				$result = $this->neo4j->send($query, $params);
    			}
    		}
    			
			$this->redirect('lists');
			exit;
    	}
    	return view();
    }
    
    
    /**
     * 编辑人
     * 2024-02-27
     */
    public function editPerson(){
    	if($_POST){
    		$id = input('post.id/d', 0);
    		$generation = input('post.generation/s', '', 'trim');//世代
    		$name = input('post.name/s', '', 'trim');            //名字
    		$offspring = input('post.offspring/s', '', 'trim');  //亲属
    		$ranking = input('post.ranking/d', 0);  //排行
    		
    		$skinship = input('post.skinship/s', '', 'trim'); //有亲属，有关系
    		$skinship_id = input('post.skinship_id/d', 0);    //关系人id
    		
    		$query = 'MATCH (n:person) WHERE n.id = $id ';
    		$query .= ' SET n.generation = $generation, n.name = $name, n.offspring = $offspring, n.ranking = $ranking ';
    		$params = [
	    			'generation' => $generation,
	    			'name' => $name,
	    			'offspring' => $offspring,
	    			'ranking' => $ranking,
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
    			
    			//有父亲
    			if($skinship == 'HAS_FATHER'){
    				$query = 'MATCH (n:person) WHERE id = $id SET fid = $skinship_id RETURN n';
    				$params = [
    					'id' => $id,
    					'fid' => $skinship_id,
    				];
    				
    				$result = $this->neo4j->send($query, $params);
    			//有母亲
    			}elseif($skinship == 'HAS_MOTHER'){
    				$query = 'MATCH (n:person) WHERE id = $id SET mid = $skinship_id RETURN n';
    				$params = [
    					'id' => $id,
    					'mid' => $skinship_id,
    				];
    				
    				$result = $this->neo4j->send($query, $params);
    			}
    		}
    		
			$this->redirect('lists');
			exit;
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
	    	$query = 'MATCH (n:person) WHERE n.name CONTAINS $search RETURN n.generation AS generation, n.name AS name, n.offspring AS offspring, n.ranking AS ranking, n.id AS id  ORDER BY n.id ASC';   //CONTAINS 相当于 LIKE查询
	    	$params = ['search' => $searchKey]; 

	    	$result = $this->neo4j->send($query, $params);

	    	foreach($result['data'][0]['data'] AS $k=>$v){
            	$arrCombine[$k] = array_combine($result['data'][0]['columns'], $result['data'][0]['data'][$k]['row']);
		    	$str = 'id: ' . $arrCombine[$k]['id'] . '，' . $arrCombine[$k]['generation'] . ' ' . $arrCombine[$k]['name'] . ' ' . $arrCombine[$k]['offspring'] . '，排行：' . $arrCombine[$k]['ranking'];
	    		$arrNew[] = ['id' => $arrCombine[$k]['id'], 'str' => $str];
	    	}
    		
			echo json_encode(['status' => 200, 'data' => $arrNew], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
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
