<?php

    //Author: Aadarsh Patel
    //layer: dmz
    //File: pokeApi.php
    //Desc: calls poke api

    ini_set('display_errors',1); error_reporting(E_ALL);
    
//TODO:
    //check pokemon being returned and check their name with api, if the id of that pokemon is above 151, ignore it and break the loop bc everything below is going to not be in acceptable range of pokedex
    
    function searchdexName($dexName){
        $rtnJson = new stdclass;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/pokemon/$dexName");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $api_output = curl_exec($ch);
            $pokemonInfo = json_decode($api_output);

            $rtnJson -> abilityName=$pokemonInfo -> abilities[0] -> ability -> name;
            $rtnJson -> pokemonName=$pokemonInfo -> name;
            $x = json_encode($rtnJson);

            curl_close($ch);
            return $x;
    }


    function searchAbility($abilityParam){
            $rtnJson = new stdclass;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/ability/$abilityParam");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $api_output = curl_exec($ch);
    //echo var_dump($api_output);
            $pokemonInfo = json_decode($api_output);


            $rtnJson -> n=$pokemonInfo -> pokemon;
            $x = json_encode($rtnJson);

            curl_close($ch);
            return $x;
    }


    function searchType($typeParam){
            $rtnJson = new stdclass;
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, "https://pokeapi.co/api/v2/type/$typeParam");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $api_output = curl_exec($ch);
    //echo var_dump($api_output);
            $pokemonInfo = json_decode($api_output);


            $rtnJson -> n=$pokemonInfo -> name;
            $x = json_encode($rtnJson);

            curl_close($ch);
            return $x;
    }

    echo searchAbility(4);


?>





