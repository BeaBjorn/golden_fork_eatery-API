<?php
/*
   Author:  Beatrice björn
   For: Webbutvecklingsprogramet - Webbutveckling III - Projekt - API för restaurang
   Last updated : 2022-08-21 
*/
?>
<?php 
    //Class named "Alcohol" with private properties
    class About{
        //Private properties
        private $db;
        private $id;
        private $titel;
        private $info;


    //cunstructor that connects to database or uses die to stop scripts from running if the connection to the database failed.
    //An error message will be shown on screen if the connection failed. 
        function __construct(){
            $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

            if($this->db->connect_errno > 0){
                die("Error connecting to database: " . $this->db-connect_error);
            }
        }

    //A method called "getDrinks" that uses an sql-request to collect all data from the table "alcohol" in the database    
        public function getInfo() : array {
            $sql = "SELECT * FROM aboutUs;";

            $result = mysqli_query($this->db, $sql);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

    //A method that takes an id as argument and uses an sql-request to collect data from the database table where id is equal to id
        public function getInfoAndId($id) : array {

                $id = intval($id);
    
                $sql = "SELECT * FROM aboutUs WHERE id=$id;";
    
                $result = mysqli_query($this->db, $sql);
                return $result->fetch_assoc();
        }

    //A method that takes two arguments and runs a set method to check data before it is entered into the database
    //Real_escape_string and htmlenteties is used to prevent harmful code to be entered into the database
    //An sql-request is being used to insert data to the database table 
        public function addInfo(string $titel, string $info) : bool {
            if(!$this->setInfo($titel, $info)) return false;

            $titel = $this->db->real_escape_string($titel);
            $info = $this->db->real_escape_string($info);

            $titel = htmlentities($titel, ENT_QUOTES, 'UTF-8');
            $info = htmlentities($info, ENT_QUOTES, 'UTF-8');

            $sql = "INSERT INTO aboutUs (titel, info)VALUES('$titel', '$info');";
            $result = $this->db->query($sql);
            return $result;
        }
    //A method that takes three arguments of which one is an id and runs a set method to check data before it is entered into the database
    //Real_escape_string and htmlenteties is used to prevent harmful code to be entered into the database
    //An sql-request is being used to update the existing data in the database table 
        public function updateInfo(int $id, string $titel, string $info) : bool {
            if(!$this->setInfoAndId($id, $titel, $info)) return false;

            $titel = $this->db->real_escape_string($titel);
            $info = $this->db->real_escape_string($info);

            $titel = htmlentities($titel, ENT_QUOTES, 'UTF-8');
            $info = htmlentities($info, ENT_QUOTES, 'UTF-8');

            $sql = "UPDATE aboutUs SET titel='" . $this->titel . "', info='" . $this->info . "' WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        }

    //A set-method that checks that the drinkName and the drinkPrice entered in the form is longer than 0 characters
        public function setInfo(string $titel, string $info) : bool {
            if (strlen($titel) > 0 && strlen($info) > 0) {
                $this->titel = $titel;
                $this->info = $info;
                return true;
              }else{
                return false;
            }
        }
    //A set-method that checks that there is an id and that the drinkName and the drinkPrice entered in the form is longer than 0 characters
        public function setInfoAndId(int $id, string $titel, string $info) : bool {
            if ($id !== null && strlen($titel) > 0 && strlen($info) > 0) {
                $this->titel = $titel;
                $this->info = $info;
                return true;
              }else{
                return false;
            }
        }

    //A method taking id as an argument and useing an sql-request to delete data from the database where id is equal to id 
        public function deleteInfo($id) : bool{
            $id = intval($id);

            $sql = "DELETE FROM aboutUs WHERE id=$id;";

            return mysqli_query($this->db, $sql);
        }

        // A destructor is called when the script stops running
        function __destruct(){
            mysqli_close($this->db);
        }
    }   