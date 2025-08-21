<?php

namespace api_server2;

use DI\Container;

//use Psr\Container\ContainerInterface;

class ServiceContainer extends Container{
	private array $services = [];
	
	public function set(string $name, mixed $factory): void{
		$this->services[$name] = $factory;
	}
	
	public function get(string $name): mixed{
		if(!array_key_exists($name, $this->services)){
				throw new \RuntimeException("$name container entry is not defined");
		}
		//Lazy instantiation
		if (is_callable($this->services[$name])){
				$this->services[$name] = $this->services[$name]();
		}
		return $this->services[$name];
	}
}
?>

