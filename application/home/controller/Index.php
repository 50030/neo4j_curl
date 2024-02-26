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
	protected function initialize(){
		parent::initialize();
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
    
}
