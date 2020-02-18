<?php

require_once('/home/aadarsh/Desktop/git/rabbitmqphp_example/path.inc');
require_once('/home/aadarsh/Desktop/git/rabbitmqphp_example/get_host_info.inc');
require_once('/home/aadarsh/Desktop/git/rabbitmqphp_example/rabbitMQLib.inc');


function requestProcessor($request){
	echo "Recieved Request".PHP_EOL;
	echo $request['type'];
	var_dump($request);

	if (!isset($request['type'])){
		return array('message'=>'Error: Message type not set');
	}

	switch($request['type']){

		case "test":
			$rspMessage = "Inside switch case as expected";
			break;
	}

	echo var_dump($rspMessage);
	return $rspMessage;

}


$server = new rabbitMQServer('/home/aadarsh/Desktop/git/rabbitmqphp_example/rabbitMQ_db.ini', 'testServer');


$server->process_requests('requestProcessor');  




?>



