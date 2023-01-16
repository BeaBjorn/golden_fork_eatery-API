<?php 
/*
   Author:  Beatrice björn
   For: Webbutvecklingsprogramet - Webbutveckling III - Projekt - API för restaurang
   Last updated : 2022-08-21 
*/
?>

<?php 
    //Class named "Account" with private properties
    class Appetizer{
        //Private properties
        private $db;
        private $id;
        private $appName;
        private $appDescription;
        private $appPrice;


    //cunstructor that connects to database or uses die to stop scripts from running if the connection to the database failed.
    //An error message will be shown on screen if the connection failed. 
        function __construct(){
            $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

            if($this->db->connect_errno > 0){
                die("Error connecting to database: " . $this->db-connect_error);
            }
        }

    //A method called "getAppetizers" that uses an sql-request to collect all data from the table "appetizers" in the database  
        public function getAppetizers() : array {
            $sql = "SELECT * FROM appetizers;";

            $result = mysqli_query($this->db, $sql);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    //A method that takes an id as argument and uses an sql-request to collect data from the database table where id is equal to id
        public function getAppetizerById($id) : array {

                $id = intval($id);
    
                $sql = "SELECT * FROM appetizers WHERE id=$id;";
    
                $result = mysqli_query($this->db, $sql);
                return $result->fetch_assoc();
        }
    //A method that takes three arguments and runs a set method to check data before it is entered into the database
    //Real_escape_string and htmlenteties is used to prevent harmful code to be entered into the database
    //An sql-request is being used to insert data to the database table 
        public function addAppetizer(string $appName, string $appDescription, string $appPrice) : bool {
            if(!$this->setAppetizer($appName, $appDescription, $appPrice)) return false;

            $appName = $this->db->real_escape_string($appName);
            $appDescription = $this->db->real_escape_string($appDescription);
            $appPrice = $this->db->real_escape_string($appPrice);

            $appName = htmlentities($appName, ENT_QUOTES, 'UTF-8');
            $appDescription = htmlentities($appDescription, ENT_QUOTES, 'UTF-8');
            $appPrice = htmlentities($appPrice, ENT_QUOTES, 'UTF-8');

            $sql = "INSERT INTO appetizers (appName, appDescription, appPrice)VALUES('$appName', '$appDescription', '$appPrice');";
            $result = $this->db->query($sql);
            return $result;
        }
    //A method that takes four arguments of which one is an id and runs a set method to check data before it is entered into the database
    //Real_escape_string and htmlenteties is used to prevent harmful code to be entered into the database
    //An sql-request is being used to update the existing data in the database table 
        public function updateAppetizer(int $id, string $appName, string $appDescription, string $appPrice) : bool {
            if(!$this->setAppetizerAndId($id, $appName, $appDescription, $appPrice)) return false;


            $appName = $this->db->real_escape_string($appName);
            $appDescription = $this->db->real_escape_string($appDescription);
            $appPrice = $this->db->real_escape_string($appPrice);

            $appName = htmlentities($appName, ENT_QUOTES, 'UTF-8');
            $appDescription = htmlentities($appDescription, ENT_QUOTES, 'UTF-8');
            $appPrice = htmlentities($appPrice, ENT_QUOTES, 'UTF-8');

            $sql = "UPDATE appetizers SET appName='" . $this->appName . "', appDescription='" . $this->appDescription . "', appPrice='" . $this->appPrice . "' WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        }

    //A set-method that checks that the appName, the appDescription and the appPrice entered in the form is longer than 0 characters
        public function setAppetizer(string $appName, string $appDescription, string $appPrice) : bool {
            if (strlen($appName) > 0 && strlen($appDescription) > 0 && strlen($appPrice) > 0) {

                $this->appName = $appName;
                $this->appDescription = $appDescription;
                $this->appPrice = $appPrice;
                return true;
              }else{
                return false;
            }
        }
         //A set-method that checks that there is an id and that the appName, the appDescription and the appPrice entered in the form is longer than 0 characters
        public function setAppetizerAndId(int $id, string $appName, string $appDescription, string $appPrice) : bool {
            if ($id !== null && strlen($appName) > 0 && strlen($appDescription) > 0 && strlen($appPrice) > 0) {

                $this->appName = $appName;
                $this->appDescription = $appDescription;
                $this->appPrice = $appPrice;
                return true;
              }else{
                return false;
            }
        }
    //A method taking id as an argument and useing an sql-request to delete data from the database where id is equal to id 
        public function deleteAppetizer($id){
            $id = intval($id);

            $sql = "DELETE FROM appetizers WHERE id=$id;";

            return mysqli_query($this->db, $sql);
        }

        // A destructor is called when the script stops running
        function __destruct(){
            mysqli_close($this->db);
        }
    }   