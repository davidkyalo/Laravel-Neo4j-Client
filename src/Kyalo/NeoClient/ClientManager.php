<?php namespace Kyalo\NeoClient;

use Neoxygen\NeoClient\ClientBuilder;

class ClientManager {


	protected $builder;
	protected $defaultConnectionAlias;

	public function __construct(){
		$this->buildConnections();
	}

	public function __get($property){
		if($property == 'db'){
			return $this->db();
		}
	}
	protected function buildConnections(){
		$connections = $this->getConfig('connections', []);
		$builder = $this->getBuilder();
		foreach ($connections as $alias => $config) {
			$builder->addConnection(
				$alias == $this->getDefaultConnectionAlias() ? 'default' : $alias, 
				$config['scheme'], $config['host'], 
				$config['port'], $config['auth'], 
				$config['user'], $config['password']);
		}
		if($timeout = $this->getConfig('connection_timeout', null))
			$builder->setDefaultTimeout($timeout);

		if($autoformat = $this->getConfig('auto_format_response', false))
			$builder->setAutoFormatResponse($autoformat);

		$builder->build();
	}

	protected function getConfig($option = null, $default = null){
		if(is_null($option)) 
			return config('neoclient', []);
		return config('neoclient.'.$option, $default);
	}

	protected function getDefaultConnectionAlias(){
		if(!$this->defaultConnectionAlias)
			$this->defaultConnectionAlias = $this->getConfig('default_connection', 'local');
		return $this->defaultConnectionAlias;
	}
	
	public function getBuilder(){
		if(!$this->builder)
			$this->builder = ClientBuilder::create();
		return $this->builder; 
	}

	protected function getAlias($alias = null){
		return is_null($alias) || $alias == $this->getDefaultConnectionAlias()
		 		? 'default' : $alias; 
	}

	public function db($alias = null){
		$alias = $this->getAlias($alias);		
		return $this->getBuilder()->getRoot($alias);
	}

}