<?php 
/*
   Author:  Beatrice björn
   For: Webbutvecklingsprogramet - Webbutveckling III - Projekt - API för restaurang
   Last updated : 2022-08-21 
*/

//auto includes all the classes
    spl_autoload_register(function($class_name){
        include '../classes/' . $class_name . '.class.php';
    });

//devmode is set to true whilst developing and false before publishing publishing
    $devmode = false;
//If in devmode, error messages are activated to assist with troubelshooting. 
//If in devmode a connection is made to the local database and 
//if devmode is set to false the conection is made to miuns database. 
    if($devmode){
        error_reporting(-1);
        ini_set("display_errors", 1);

        define("DBHOST", "localhost");
        define("DBUSER", "restaurant");
        define("DBPASS", "password");
        define("DBDATABASE", "restaurant");
    }else{
        define("DBHOST", "studentmysql.miun.se");
        define("DBUSER", "bebj2100");
        define("DBPASS", "5wqnN9VDz9");
        define("DBDATABASE", "bebj2100");
    }
