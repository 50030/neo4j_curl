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
	
	
	public function statements(){
			$commit = $this->uri . '/db/' . $this->database . '/tx/commit';
			
			$arr['statement'] = $this->query;
			$arr['parameters'] = $this->params;
			
			$arr2['statements'] = [$arr];
			//JSON_UNESCAPED_UNICODE 不要转换中文
			//JSON_UNESCAPED_SLASHES 原样，不要转换符号：",[,],'等
			//JSON_PRETTY_PRINT  美化字符串
			
			$statements = json_encode($arr2, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 
			echo $statements;
			exit;
	}
	
	
	public function send($query = null, $params = null){
			if($query !== null){
				$this->query = $query;
			}
			if($params !== null){
				$this->params = $params;
			}
			
			//处理字符串
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
			
			//是用post提交
			curl_setopt($curl, CURLOPT_POST, true);
			
			//提交接口的参数
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
					//'data' => $body['results'][0]['data'],
					'data' => $body['results'],
				];
			}
			return $result;
	}
}