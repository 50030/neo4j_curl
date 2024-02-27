<?php
namespace app\home\controller;

use think\Facade\Config;
use think\Route;
use think\Db;
use think\Db\Where;
use think\Controller;

use my\Neo4j;

// two
//use GuzzleHttp\Client;

// three
//use GraphAware\Neo4j\Client\ClientBuilder;


// four
//use Laudis\Neo4j\Authentication\Authenticate;
//use Laudis\Neo4j\ClientBuilder;

class Index extends Common {
	private $neo4j;
	
	
	protected function initialize(){
		parent::initialize();
		
    	$this->neo4j = new Neo4j();
    	$this->neo4j->host('localhost')
    		  ->port('7474')
    		  ->user('neo4j')
    		  ->password('neo4jneo4j')
    		  ->database('neo4j')
    		  ->connect();
	}
	
    public function index(){
        $this->assign("date", date("Y-m-d"));
        return view();
    }
    
    
    /**
     * test guzzle
     * 2024-02-24
     * 不用引入: require 'vendor/autoload.php'
     * 可以加载了。
     */
    public function two(){

		$client = new Client();
		$response = $client->request('GET', 'http://localhost:7474');
		
		echo $response->getBody();
    }
    
    
    public function three(){
    	$client = ClientBuilder::create()
    	->addConnection('default', 'http://neo4j:neo4jneo4j@localhost:7474')
    	//->addConnection('bolt', 'bolt://neo4j:neo4j@localhost:7687')
    	->build();
    	//dump($client);
    	$result = $client->run('create (n:person{name:"aa"}) return n');
    	dump($result);  //不行
    }
    
    
    public function four(){

		$client = ClientBuilder::create()
		    ->withDriver('bolt', 'bolt+s://neo4j:neo4jneo4j@localhost') // creates a bolt driver
		    ->withDriver('https', 'https://localhost', Authenticate::basic('neo4j', 'neo4jneo4j')) // creates an http driver
		    ->withDriver('neo4j', 'neo4j://localhost?database=my-database', Authenticate::oidc('token')) // creates an auto routed driver with an OpenID Connect token
		    ->withDefaultDriver('bolt')
		    ->build();
		    
		dump($client);
    }
    
    /**
     * my curl 
     * 2024-02-26
     */
    public function five(){
    	$neo4j = new Neo4j();
    	$neo4j->host('localhost')
    		  ->port('7474')
    		  ->user('neo4j')
    		  ->password('neo4jneo4j')
    		  ->database('neo4j')
    		  ->connect();
    		  
    	/*$query = 'MATCH (n) WHERE n.age = $age RETURN n';
    	$neo4j->query($query);
    	$params = array('age' => 54 );
    	$neo4j->params($params);*/
    	
    	$query = 'MATCH (n) RETURN n';
    	$neo4j->query($query);
    	
    	$params = array('name' => '郑爱军' );
    	$neo4j->params($params);
    	
    	$result = $neo4j->send();
    	
    	var_dump($result);
    }
    
    
    public function six(){
    	$id = Db::name('serial_id')->insertGetId(['name'=>'a']);
    	dump($id);
    }
    
    
    public function addPerson(){
    	if($_POST){
    		$name = input('post.name/s', '', 'trim');
    		$gender = input('post.gender/d', 0);   //1男，2女
    		$ranking = input('post.ranking/d', 0);  //排行
    		$remark = input('post.remark/s', '', 'trim'); //备注
    		$orderno = input('post.orderno/d', 0);   //排序
    		
    		$id = Db::name('serial_id')->insertGetId(['name'=>'a']);
    		$id = intval($id);
    		
    		
	    	$neo4j = new Neo4j();
	    	$neo4j->host('localhost')
	    		  ->port('7474')
	    		  ->user('neo4j')
	    		  ->password('neo4jneo4j')
	    		  ->database('neo4j')
	    		  ->connect();
	    		  
	    	//$query = 'MATCH (n) WHERE n.age = $age RETURN n';
	    	//$params = array('age' => 54 );
	    	/*$neo4j->query($query);
	    	$neo4j->params($params);*/
	    	
	    	$query = 'CREATE (n:person {name: $name, gender: $gender, ranking: $ranking, remark: $remark, orderno: $orderno, id: $id}) RETURN n';
	    	
	    	$params = [
	    			'name' => $name,
	    			'gender' => $gender,
	    			'ranking' => $ranking,
	    			'remark' => $remark,
	    			'orderno' => $orderno,
	    			'id' => $id,
	    		];
	    	/*$query = 'CREATE (n:person {name: $name}) RETURN n';
	    	
	    	$params = [
	    			'name' => $name,
	    		];*/
	    		
	    	$neo4j->query($query);
	    	$neo4j->params($params);
	    	
	    	
	    	$statements = $neo4j->getStatements();
	    	var_dump($statements);
	    	//exit;
	    	
	    	$result = $neo4j->send();
	    	
	    	var_dump($result);
    		exit;
    	}
    	return view();
    }
    
    
    /**
     * 查找人
     * 2024-02-27
     */
    public function searchSkinship(){
    	if($_POST){
	    	$searchKey = input('post.name/s', '', 'trim');
	    	$query = 'MATCH (n:person) WHERE n.name CONTAINS $search RETURN n.name AS name, n.gender AS gender, n.remark AS remark, n.ranking AS ranking, n.id AS id  ORDER BY n.orderno ASC';   //CONTAINS 相当于 LIKE查询
	    	$params = ['search' => $searchKey]; 
	    			 
	    	//$result = $this->neo4j->query($query)->params($params)->send();
	    	$result = $this->neo4j->send($query, $params);
echo "<pre>";
print_r($result);
exit;
	    	$arrNew = [];
	    	foreach($result['data'] AS $k=>$v){
	    		//$arr = $v['row'];
	    		$str = '';

	    		foreach($v['row'] AS $k2=>$v2){
	    			if($k2 == 0){
	    				$str .= $v2;
	    			}elseif($k2 == 1){
	    				$str .= '（' . $v2 . '）';
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
    
    
}
