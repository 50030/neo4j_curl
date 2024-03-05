<?php
namespace app\home\controller;

use think\Facade\Config;
use think\Route;
use think\Db;
use think\Db\Where;
use think\Controller;

use my\Neo4j;


class Test2  extends Common {
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

	
	
    
    //更新名字、世代、后裔
    public function updateThree(){
    	//添加世代
    	$select = db::name('category')->where('cat_id', '>', 89)->limit(300)->select();
    	foreach($select AS $k=>$v){
    		$one = strpos($v['cat_name'], '世');
    		$generation = substr($v['cat_name'], 0, $one + strlen('世'));
    		dump($v);
    		dump($one);
    		dump($generation);
    		echo "<hr />";
    		
    		$two = strpos($v['cat_name'], '，'); //十三世郑长清，郑九如次子
    		$name = substr($v['cat_name'], strlen($generation), $two - strlen($generation));
    		dump($two);
    		dump($name);
    		echo "<hr />";
    		
    		$offspring = substr($v['cat_name'], strlen($generation) + strlen($name) + strlen('，') + strlen($v['fname']));
    		dump($offspring);
    		echo "<hr />";
    		//$three = strpos($v['cat_name', $v['fname']]);
    		
    		$arrNew = ['generation' => $generation, 'name' => $name, 'offspring' => $offspring];
    		db::name('category')->where('cat_id', '=', $v['cat_id'])->update($arrNew);
    		
    		
    	}
    	
    }
    
    
    public function addPersonGraph(){
    	$select = db::name('category')->where('cat_id', '>', 89)->limit(300)->select();
    	//dump($select);exit;
    	foreach($select AS $k=>$v){
    		/*$query = 'MERGE (n:person {id: $id, name: $name, fid: $fid, fname: $fname, generation: $generation, offspring: $offspring, ranking: $ranking, mid: $mid, mname: $mname }) RETURN n';
	    	
	    	$params = [
	    			'id' => $v['id2'],
	    			'name' => $v['name'],
	    			'fid' => $v['fid'],
	    			'fname' => $v['fname'],
	    			'generation' => $v['generation'],
	    			'offspring' => $v['offspring'],
	    			
	    			'ranking' => '',
	    			'mid' => 0,
	    			'mname' => '',
	    		];
dump($query);
dump($params);
echo "<hr />";
		
	    	//添加人丁
	    	$result = $this->neo4j->send($query, $params);*/
	    	
	    	//添加关系
			$query = 'MATCH (a:person), (b:person) ';
			$query .= ' WHERE a.id = $id AND b.id = $skinship_id ';
			$query .= ' MERGE (a) - [r:HAS_FATHER] -> (b) ';
			$query .= ' RETURN a, r, b ';
			$params = [
				'id' => $v['id2'],
				'skinship_id' => $v['fid'],
			];

			$result = $this->neo4j->send($query, $params);
    	}
    }
    
    
    public function addRelationship(){
    	
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
	    	
	    	$query = 'MERGE (n:person {id: $id, fid: $fid, fname: $fname, name: $name, gender: $gender, ranking: $ranking, remark: $remark, orderno: $orderno }) RETURN n';
	    	
	    	
	    	
	    	
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
	    	$result = $this->neo4j->send($query, $params);
	    	
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
			$result = $this->neo4j->send($query, $params);
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
			$result = $this->neo4j->send($query, $params);
    		
    	}
    }
    
    
	
	
}
