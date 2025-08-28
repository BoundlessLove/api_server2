<?php
namespace api_server2;
class Logger {
	public function log($message) {
		echo "[LOG]:" . $message . PHP_EOL;
	}
}
?>
