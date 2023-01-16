<?php 
/*
   Author:  Beatrice björn
   For: Webbutvecklingsprogramet - Webbutveckling III - Projekt - API för restaurang
   Last updated : 2022-08-21 
*/
?>

<?php 
    //Class named "Account" with private properties
    class Main{
        //Private properties
        private $db;
        private $id;
        private $mainName;
        private $mainDescription;
        private $mainPrice;


    //cunstructor that connects to database or uses die to stop scripts from running if the connection to the database failed.
    //An error message will be shown on screen if the connection failed. 
        function __construct(){
            $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

            if($this->db->connect_errno > 0){
                die("Error connecting to database: " . $this->db-connect_error);
            }
        }

    //A method called "getMains" that uses an sql-request to collect all data from the table "mains" in the database  
        public function getMains() : array {
            $sql = "SELECT * FROM mains;";

            $result = mysqli_query($this->db, $sql);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    //A method that takes an id as argument and uses an sql-request to collect data from the database table where id is equal to id
        public function getMainById($id) : array {

                $id = intval($id);
    
                $sql = "SELECT * FROM mains WHERE id=$id;";
    
                $result = mysqli_query($this->db, $sql);
                return $result->fetch_assoc();
        }
    //A method that takes three arguments and runs a set method to check data before it is entered into the database
    //Real_escape_string and htmlenteties is used to prevent harmful code to be entered into the database
    //An sql-request is being used to insert data to the database table 
        public function addMain(string $mainName, string $mainDescription, string $mainPrice) : bool {
            if(!$this->setMain($mainName, $mainDescription, $mainPrice)) return false;

            $mainName = $this->db->real_escape_string($mainName);
            $mainDescription = $this->db->real_escape_string($mainDescription);
            $mainPrice = $this->db->real_escape_string($mainPrice);

            $mainName = htmlentities($mainName, ENT_QUOTES, 'UTF-8');
            $mainDescription = htmlentities($mainDescription, ENT_QUOTES, 'UTF-8');
            $mainPrice = htmlentities($mainPrice, ENT_QUOTES, 'UTF-8');

            $sql = "INSERT INTO mains (mainName, mainDescription, mainPrice)VALUES('$mainName', '$mainDescription', '$mainPrice');";
            $result = $this->db->query($sql);
            return $result;
        }
    //A method that takes four arguments of which one is an id and runs a set method to check data before it is entered into the database
    //Real_escape_string and htmlenteties is used to prevent harmful code to be entered into the database
    //An sql-request is being used to update the existing data in the database table 
        public function updateMain(int $id, string $mainName, string $mainDescription, string $mainPrice) : bool {
            if(!$this->setMainAndId($id, $mainName, $mainDescription, $mainPrice)) return false;

            $mainName = $this->db->real_escape_string($mainName);
            $mainDescription = $this->db->real_escape_string($mainDescription);
            $mainPrice = $this->db->real_escape_string($mainPrice);

            $mainName = htmlentities($mainName, ENT_QUOTES, 'UTF-8');
            $mainDescription = htmlentities($mainDescription, ENT_QUOTES, 'UTF-8');
            $mainPrice = htmlentities($mainPrice, ENT_QUOTES, 'UTF-8');

            $sql = "UPDATE mains SET mainName='" . $this->mainName . "', mainDescription='" . $this->mainDescription . "', mainPrice='" . $this->mainPrice . "' WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        }

    //A set-method that checks that the mainName, the mainDescription and the mainPrice entered in the form is longer than 0 characters
        public function setMain(string $mainName, string $mainDescription, string $mainPrice) : bool {
            if (strlen($mainName) > 0 && strlen($mainDescription) > 0 && strlen($mainPrice) > 0) {

                $this->mainName = $mainName;
                $this->mainDescription = $mainDescription;
                $this->mainPrice = $mainPrice;
                return true;
              }else{
                return false;
            }
        }
    //A set-method that checks that there is an id and that the mainName, the mainDescription and the mainPrice entered in the form is longer than 0 characters
        public function setMainAndId(int $id, string $mainName, string $mainDescription, string $mainPrice) : bool {
            if ($id !== null && strlen($mainName) > 0 && strlen($mainDescription) > 0 && strlen($mainPrice) > 0) {

                $this->mainName = $mainName;
                $this->mainDescription = $mainDescription;
                $this->mainPrice = $mainPrice;
                return true;
              }else{
                return false;
            }
        }
    //A method taking id as an argument and useing an sql-request to delete data from the database where id is equal to id 
        public function deleteMain($id){
            $id = intval($id);

            $sql = "DELETE FROM mains WHERE id=$id;";

            return mysqli_query($this->db, $sql);
        }

        // A destructor is called when the script stops running
        function __destruct(){
            mysqli_close($this->db);
        }
    }   