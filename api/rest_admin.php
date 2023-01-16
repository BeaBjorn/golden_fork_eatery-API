<?php
/*
   Author:  Beatrice björn
   For: Webbutvecklingsprogramet - Webbutveckling III - Projekt - API för restaurang
   Last updated : 2022-08-21 
*/
?>

<?php
//Includes the files config.php and head.php
include("config.php");
include("head.php");

//Checks if username has been sent
if(isset($_GET['username'])) {
    $username = $_GET['username'];
}

//Creates an instance of the class "Admin"
$admins = new Admin();

//Checks what method is being used and stores it in a variable called "method"
$method = $_SERVER['REQUEST_METHOD'];

//If another method than POST is being used an error message will be sent stating that POST is te only method allowed
//If another method is used the script will stop running
if($method != "POST") {
    http_response_code(405); //Method not allowed
    $response = array("message" => "Only POST methods allowed ");
    echo json_encode($response);
    exit;
}

//Translates to json-data
$data = json_decode(file_get_contents("php://input"), true);

//Checks that username and password has been sent, if not an error message will be displayed
if(isset($data["username"]) && isset($data["password"])) {
    $username = $data["username"];
    $password = $data["password"];
} else {
    http_response_code(400); //Bad request
    $response = array("message" => "Submit username and password");
    echo json_encode($response);
    exit;
}

//Hard coded username and password that is being compared to the values entered in the form
//If username or password is incorrect an error message stating this will show on the screen
if($username === "admin" && $password === "password") {
    $response = array("message" => "Logget in as : ", "user" => true);
    http_response_code(200); //Ok
}else{
    $response = array("message" => "Wrong username or password");
    http_response_code(401); //Unauthorized
}

//Returns response to user
echo json_encode($response);
