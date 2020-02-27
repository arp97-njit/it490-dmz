<?php

    //Author: Aadarsh Patel
    //layer: dmz
    //File: pokeApi.php
    //Desc: calls poke api

    ini_set('display_errors',1); error_reporting(E_ALL);
    
//TODO:
    //check pokemon being returned and check their name with api, if the id of that pokemon is above 151, ignore it and break the loop bc everything below is going to not be in acceptable range of pokedex
    
//    $retrieveQuestionJson = json_decode($question_output);
//    $rowArray = $retrieveQuestionJson -> rowArray;
//    $inputArray = [];  //test cases  - to input into given function
//    $outputArray = [];  //test case answers - should match to
//
//    foreach($rowArray as $cases){
//        $testInput = $cases -> testCase;
//        array_push($inputArray, $testInput);
//        $testOutput = $cases -> answer;
//        array_push($outputArray, $testOutput);
//    }
    
    function searchdexName($dexOrName){ //given dex # or name of pokemon
        $rtnJson = new stdclass;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon/$dexOrName");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $api_output = curl_exec($ch);
            $pokemonInfo = json_decode($api_output);

            $rtnJson -> abilityName=$pokemonInfo -> abilities[0] -> ability -> name;
            $rtnJson -> pokemonName=$pokemonInfo -> name;
            $x = json_encode($rtnJson);
        
            curl_close($ch);
            return $x;
    }


    function searchAbility($abilityParam){ //given ability of pokemon
            $rtnJson = new stdclass;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/ability/$abilityParam");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $api_output = curl_exec($ch);
            $pokemonInfo = json_decode($api_output);

            $rtnJson -> n=$pokemonInfo -> pokemon;
            $x = json_encode($rtnJson);

            curl_close($ch);
            return $x;
    }
    
    function ModifiedSearchdexName($dexOrName){ //given dex # or name of pokemon
            $rtnJson = new stdclass;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon/$dexOrName");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $api_output = curl_exec($ch);
            $pokemonInfo = json_decode($api_output);

            $rtnName = $pokemonInfo -> name;
        
            curl_close($ch);
            return $rtnName;
    }


    function searchType($typeParam){  //given typing of pokemon
            $rtnJson = new stdclass;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/type/$typeParam");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $api_output = curl_exec($ch);
            $pokemonInfo = json_decode($api_output);

            //used to find what pokemon are of a given type in our valid range
            $wholePokemonList = $pokemonInfo -> pokemon;
            $pokemonToCheck = [];
            foreach($wholePokemonList as $index){
                $urlOfPoke = $index -> pokemon -> url;
                $urlArray = explode("/", $urlOfPoke);
                $tempNum = -1;
                foreach($urlArray as $piece){
                    if(((int)$piece)){
                        $tempNum = (int)$piece;
                        array_push($pokemonToCheck, (int)$piece);
                    }
                }
                if ($tempNum > 152){
                    break; //exit loop bc everything else is not in valid range of our dex
                }
            }
            //finished populating list of pokemon that are valid
            //$pokemonToCheck - has this list ^
            $pokemonChecked = [];
            $noDdosCounter = 1;
            foreach($pokemonToCheck as $num){
                if($noDdosCounter == 90){  //can call api max 100 times in 1 minute per IP address
                    echo "I'm tired, time for a nap";
                    sleep(60);
                }
                $tempString = ModifiedSearchdexName($num);
                $noDdosCounter++;
                array_push($pokemonChecked, $tempString);
            }
            
            $rtnJson -> search="type";  //db can check this to know what type of search was performed and how to handle it
            $rtnJson -> pokemonNames=$pokemonChecked;
            $x = json_encode($rtnJson);

            curl_close($ch);
            return $x;
    }

    echo searchType("water");


?>





