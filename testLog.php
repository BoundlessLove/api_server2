
<?PHP
require __DIR__ . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;



$logger = new \Monolog\Logger('test'); 
$logger->pushHandler(new \Monolog\Handler\StreamHandler(__DIR__ . '/logs/app.log', \Monolog\Logger::DEBUG)); 
$logger->info('Test log entry'); 
