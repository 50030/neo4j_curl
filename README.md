2024-02-26

关于用php curl做neo4j图数据库接口的说明：


==================================



各种软件使用的版本：

php 7.2.9nts

thinkphp 5.1

neo4j 5.1.16.0 community 



==============================================

为什么要搞这个东西。


问：为什么不用php高版本？
答：因为还不适应php高版本，另外，服务器环境用的是phpstudy，更改了php8以后，thinkphp5.1又使用不了。

问2：为什么用thinkphp5.1，而不用thinkphp8？
答：thinkphp太啰嗦，没完没了地升级，又没有多少有用的东西，所以就用了低版本的thinkphp。

问：为什么用neo4j 5.16.0 community 版？
答：因为neo4j图数据的desktop版本，是适合用于学习、浏览数据库，但desktop版是内置一个neo4j数据库服务器，不可以跟程序交互。
而neo4j community 版本（社区版），是免费的，而且是命令行下运行的服务，可以跟php程序交互。

问：为什么不用composer仓库中的neo4j插件，而要自己写一个neo4j接口类？
答：composer的插件太复杂，对php版本有要求，不适合我目前使用的php版本，一环套一环太多，非常难修改。
而且，composer中的neo4j插件实际就是两个，一个是laudis的graphaware，另一个是church的。
graphaware被改成了很多插件，实际就是一个东西，church的neo4j倒是独立写的。

church的neo4j已经很好了，简单而且容易看代码，但是，在跟neo4j数据库服务器交互的时候，必须加params参数，就算没有也要加一个无用的参数，觉得有些瑕疵。


问：为什么不用guzzle？
答：guzzle6跟guzzle7不一样，对PHP版本有要求，也有不适应我目前的PHP版本的情况。
而且，guzzle修改起来也麻烦。


问：为什么要自己写一个用php内置的curl发送交互的neo4j类？
答：自己写一个curl交互的类，就可以不受PHP版本的限制，也方便修改。

而且，neo4j的http API实际传参代码很少，只是要符合格式就行，所以自己写一个接口类，实际上整个类就几十行有效代码，容易看也容易修改。



====================================


使用方法：（针对thinkphp 5.1）

1、把neo4j接口类文件 Neo4j.php 放在域名根目录的 extends\my\Neo4j.php 中。

2、在控制器中使用Neo4j类：  use \my\Neo4j;

3、新建一个neo4j对象，用new Neo4j();

4、给neo4j对象设置图数据库的参数：
	服务器地址： 用host()方法
	服务端口：用post()方法
	服务器用户：用user()方法
	服务器密码：用password()方法
	数据库名：用database()方法
	
5、连接图数据库：用client()方法

6、设置查询字符串，用query()方法

7、设置查询参数，用params()方法

8、向图数据库提交查询，用send()方法

9、查询成功，返回数组结果



===================================================

代码例子：

文件位置：   域名/application/home/controller/Index.php


使用例子的代码：

<?php
namespace app\home\controller;

use think\Facade\Config;
use think\Route;
use think\Db;
use think\Db\Where;
use think\Controller;

use my\Neo4j;

class Index {
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
    	
    	var_dump($result); //返回查询结果数组
    }
    
}




=====================

neo4j图数据库的http接口说明的官方地址：
https://neo4j.com/docs/http-api



=============================

编写的curl图数据库接口文件：Neo4j.php的完整代码：

<?php
/**
 * neo4j图数据库http接口类
 * 2024-02-26
 * 郑爱军
 */
namespace my;

class Neo4j {
	private $host;
	private $port;
	private $user;
	private $password;
	
	private $database;
	
	private $uri;
	private $query;
	private $params;
	
	public function __construct(){
		
	}
	
	public function host($host = NULL){
		$this->host = $host;
		return $this;
	}
	
	public function port($port = NULL){
		$this->port = $port;
		return $this;
	}
	
	public function password($password = NULL){
		$this->password = $password;
		return $this;
	}
	
	public function user($user = NULL){
		$this->user = $user;
		return $this;
	}
	
	public function database($database){
		$this->database = $database;
		return $this;
	}
	
	public function connect(){
		$this->uri = 'http://'.$this->host;
		$this->uri = $this->uri . ':' . $this->port;
		
		$basic = base64_encode($this->user . ':' . $this->password);
		$basic = 'Basic ' . $basic;
		
		$this->headers = [
			'Accept: application/json; charset=UTF-8',
			'Content-Type: application/json',
			'Authorization: ' . $basic,
			//'Content-Length: ' . strlen($params),
			'X-Stream: true',
		];
		return $this;
	}
	
	public function query($query = NULL){
		$this->query = $query;
		return $this;
	}
	
	public function params($params = NULL){
		$this->params = $params;
		return $this;
	}
	
	
	public function send(){
			$commit = $this->uri . '/db/' . $this->database . '/tx/commit';
			
			$arr['statement'] = $this->query;
			$arr['parameters'] = $this->params;
			
			$arr2['statements'] = [$arr];
			
			//JSON_UNESCAPED_UNICODE 不要转换中文
			//JSON_UNESCAPED_SLASHES 原样，不要转换符号：",[,],'等
			//JSON_PRETTY_PRINT  美化字符串
			
			$statements = json_encode($arr2, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 
		
			
			//初始化
			$curl = curl_init();
			
			//设置提交的地址
			curl_setopt($curl, CURLOPT_URL, $commit);
			
			//返回是不显示头部信息
			curl_setopt($curl, CURLOPT_HEADER, false);
			
			//设置头信息
			curl_setopt($curl, CURLOPT_HTTPHEADER, $this->headers);
			//curl_setopt($curl,CURLOPT_HTTPHEADER, array('Authorization: ' . $basic, 'Accept: application/json; charset=UTF-8','Content-Type: application/json','Content-Length: ' . strlen($params),'X-Stream: true'));
			
			//禁止验证对等证书
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			
			//请求结果以字符串返回，不直接输出
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			
			//用POST请求
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
			
			//
			curl_setopt($curl, CURLOPT_POST, true);
			
			curl_setopt($curl, CURLOPT_POSTFIELDS, $statements);
			
			
			
			//执行请求
			$response = curl_exec($curl);              //返回application/json;charset=utf8格式的字符串
			//$result2 = json_decode($response, false);  //转为对象
			$body = json_decode($response, true);      //转为数组
			
			$content_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);  //返回的content_type类型，是：application/json;charset=utf-8
			$http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);   //返回的http状态码
			
			if(curl_errno($curl)){
				$result = [
					'msg' => curl_error($curl),
					'http_code' => $http_code,
					'content_type' => $content_type,
					'data' => NULL,
				];
			}else{
				$result = [
					'msg' => 'success',
					'http_code' => $http_code,
					'content_type' => $content_type,
					'data' => $body['results'][0]['data'],
				];
			}
			return $result;
	}
}

