<?php
/*
   Author:  Beatrice björn
   For: Webbutvecklingsprogramet - Webbutveckling III - Projekt - API för restaurang
   Last updated : 2022-08-21 
*/

//setting for what domains can access the API all domains can access this API  
header('Access-Control-Allow-Origin: *');
//sets the request format to json
header('Content-Type: application/json');
//sets the allowed methods to be used to CRUD (Create, Read, Update, Delete)
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
//Setting for what headers are allowed during access from client side
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

//Stores the request methos used in a viriable called "method
$method = $_SERVER['REQUEST_METHOD'];

//if an id has been sent in the url it gets stored in the variable "id"
if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
?>