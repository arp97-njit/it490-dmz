<?php
    
    //Requried files

    //    require_once('~/Desktop/git/rabbitmqphp_example/path.inc');
    //    require_once('~/Desktop/git/rabbitmqphp_example/get_host_info.inc');
    //    require_once('~/Desktop/git/rabbitmqphp_example/rabbitMQLib.inc');
        
        
    //https://www.rabbitmq.com/tutorials/tutorial-one-php.html
        
    //consumer - waiting for request

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('hello', false, false, false, false);

echo " [*] Waiting for messages. To exit press CTRL+C\n";

$callback = function ($msg) {
    echo ' [x] Received ', $msg->body, "\n";
};

$channel->basic_consume('hello', '', false, true, false, false, $callback);

while ($channel->is_consuming()) {
    $channel->wait();
}

$channel->close();
$connection->close();
?>
