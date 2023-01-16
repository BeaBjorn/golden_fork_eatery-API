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

//creates an instance of the class "Main"
$mains = new Main();

//A switch statement that uses the request method through the variable "$method"
switch($method) {
    //The GET method is used to collect information from the database
    case 'GET':
    //An if-statement that checks if an id is set, if there is an id the method "getMainById" is used 
    //to collect a specific post from the table alcohol in the database.
    //And if an id is not present the method "getMains" is used to collect all information from the database table
        if(isset($id)){
            $response = $mains->getMainById($id);
        }else{
            $response = $mains->getMains();
        }
    //An if-statement that checks weather there are any infromation stored in the database. If there isn't any infromation
    //an error message will be displayed and the response code 404 (not found) will be sent.
    //If there is information in the database the response code is 200 wich menas "ok"
        if(count($response) === 0){
            $response = array("message" => "There is nothing stored in the database");
            http_response_code(404);
        }else{
            http_response_code(200); 
        }

        break;


    // The POST method is used to insert information in the database
    case 'POST':

    //Turn json-data recieved into an object
        $data = json_decode(file_get_contents("php://input"), true);
    
    
    //the set method "setMain" is used to ensure all the fileds in the form is filled out.
    //If the first if-statement is false the response code will be 400 and the message "All fields must be filled in!" will show.
        if($mains->setMain($data['mainName'], $data['mainDescription'], $data['mainPrice'])){
    //An if-statement with the method "addMain", if all works the response code will be 201 and the main will be added to the database.
    //If something goes wrong the response code will be 500 wich stands for internal error and a message will show stating that something 
    //went wrong          
            if($mains->addMain($data['mainName'], $data['mainDescription'], $data['mainPrice'])){
            $response = array("message" => "The main has been added");
            http_response_code(201);
            }else{
                $response = array("message" => "Something went wrong, the dish has not been added!");
                http_response_code(500);
            }
        }else{
            $response = array("message" => "All fields must be filled in!");
            http_response_code(400);
        }

        break;

    //The PUT method is used to update data in the database    
    case 'PUT':
    //Turn json-data recieved into an object
        $data = json_decode(file_get_contents("php://input"), true);
    //the set method "setMainAndId" is used to ensure all the fileds in the form is filled out.
    //If the first if-statement is false the response code will be 400 and the message "All fields must be fille in!" will show.
        if($mains->setMainAndId($data['id'], $data['mainName'], $data['mainDescription'], $data['mainPrice'])){
    //An if-statement with the method "updateMain", if all works the response code will be 201 and the main will be updated in the database.
    //If something goes wrong the response code will be 500 wich stands for internal error         
            if($mains->updateMain($data['id'], $data['mainName'], $data['mainDescription'], $data['mainPrice'])){
            
                $response = array("message" => "The main has been updated!");
                http_response_code(200);
            }else{
                $response = array("message" => "Something went wrong, the dish has not been updated");
                http_response_code(500);
            }
        }else{
            $response = array("message" => "All fields must be filled in!");
            http_response_code(400);
        }
        break;

    // the DELETE method is used to delete data from the database. An if-statement is used to cjheck weather an id has been sent or not. 
    //If there is no id present in the url the response code will be 400 and the user will be sked to enter an id
    //If there is an id present the main will be deletet from the database    
    case 'DELETE':
        if(!isset($id)) {
            http_response_code(400);
            $response = array("message" => "Submit an id!");  
        } else {
            if($mains->deleteMain($id)){
                http_response_code(200);
                $response = array("message" => "The main has been deleted!");
            }
        }
        break;    
}
//Returns response to user
echo json_encode($response);