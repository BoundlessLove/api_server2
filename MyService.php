<?php

namespace api_server2;

use Psr\Log\LoggerInterface;
/*
 * This class can instantiate and manage multiple objects created at startup, to offer services during duration of entire project.
 * */
class MyService {
	private $logger;
	
	public function __construct(LoggerInterface $logger){
			$this->logger = $logger;
	}
	
	public function doSomething() {
			$this->logger->info("API called: doSomething()");
			echo "Action completed!";
	}
	
}
