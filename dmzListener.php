<?php

    require_once('/home/aadarsh/Desktop/git/rabbitmqphp_example/path.inc');
    require_once('/home/aadarsh/Desktop/git/rabbitmqphp_example/get_host_info.inc');
    require_once('/home/aadarsh/Desktop/git/rabbitmqphp_example/rabbitMQLib.inc');
    include '/home/aadarsh/Desktop/pokeApi.php';



    function requestProcessor($request){
        echo "Recieved Request".PHP_EOL;
        echo $request['type'];
        var_dump($request);

        if (!isset($request['type'])){
            return array('message'=>'Error: Message type not set');
        }

        if($request['type'] == "Search") //search for pokemon
        {
            if(($request['pokemonNum'] == "na") && ($request['name'] == "na"))
            { //if true - check type
                if($request['pokeType'] == "na")
                {  //if true - check ability
                    if($request['ability'] == "na")
                    {
                        //something is wrong, shouldn't get this far
                        //may throw an error here?
                        $rspMessage = "No Search Param - Error";
                    }
                    else
                    {
                        //api call with ability
                        $rspMessage = searchAbility($request['ability'], global $noDdosCounter);
                        $temp = json_decode($rspMessage);
                        global $noDdosCounter += $temp -> ddos;
                    }
                }
                else
                {
                    //api call with type
                    $rspMessage = searchType($request['pokeType'], global $noDdosCounter);
                    $temp = json_decode($rspMessage);
                    global $noDdosCounter += $temp -> ddos;
                }
            }
            else
            {
                //api call with name/pokedex number
                if($request['pokemonNum'] != "na"){
                    $rspMessage = searchdexName($request['pokemonNum'], global $noDdosCounter);
                    $temp = json_decode($rspMessage);
                    global $noDdosCounter += $temp -> ddos;
                }
                else{
                    $rspMessage = searchdexName($request['name'], global $noDdosCounter);
                    $temp = json_decode($rspMessage);
                    global $noDdosCounter += $temp -> ddos;
                }
            }
        }
        
        return $rspMessage;

    }

    $noDdosCounter = 0;
    $server = new rabbitMQServer('/home/aadarsh/Desktop/git/rabbitmqphp_example/rabbitMQ_db.ini', 'testServer');


    $server->process_requests('requestProcessor');

//    $returnedJson = json_decode(testCall());
//    $exampleAb = $returnedJson -> ab;
//    $exampleN = $returnedJson -> n;
    //this works ^ calls the function in pokeApi.php

?>

