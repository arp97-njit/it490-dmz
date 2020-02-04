<?php
    
    //Requried files

    //    require_once('~/Desktop/git/rabbitmqphp_example/path.inc');
    //    require_once('~/Desktop/git/rabbitmqphp_example/get_host_info.inc');
    //    require_once('~/Desktop/git/rabbitmqphp_example/rabbitMQLib.inc');
        
        
      //https://www.rabbitmq.com/tutorials/tutorial-one-php.html
        
    //producer - sending request

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

$msg = new AMQPMessage('Hello World!');
$channel->basic_publish($msg, '', 'hello');

echo " [x] Sent 'Hello World!'\n";

$channel->close();
$connection->close();
?>
