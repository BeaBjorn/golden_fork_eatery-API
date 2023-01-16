<?php 
/*
   Author:  Beatrice björn
   For: Webbutvecklingsprogramet - Webbutveckling III - Projekt - API för restaurang
   Last updated : 2022-08-21 
*/
?>

<?php 
    //Class named "Account" with private properties
    class Dessert{
        //Private properties
        private $db;
        private $id;
        private $DessName;
        private $dessDescription;
        private $dessPrice;


    //cunstructor that connects to database or uses die to stop scripts from running if the connection to the database failed.
    //An error message will be shown on screen if the connection failed. 
        function __construct(){
            $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

            if($this->db->connect_errno > 0){
                die("Error connecting to database: " . $this->db-connect_error);
            }
        }

    //A method called "getDesserts" that uses an sql-request to collect all data from the table "desserts" in the database  
        public function getDesserts() : array {
            $sql = "SELECT * FROM desserts;";

            $result = mysqli_query($this->db, $sql);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
    //A method that takes an id as argument and uses an sql-request to collect data from the database table where id is equal to id
        public function getDessertById($id) : array {

                $id = intval($id);
    
                $sql = "SELECT * FROM desserts WHERE id=$id;";
    
                $result = mysqli_query($this->db, $sql);
                return $result->fetch_assoc();
        }
    //A method that takes three arguments and runs a set method to check data before it is entered into the database
    //Real_escape_string and htmlenteties is used to prevent harmful code to be entered into the database
    //An sql-request is being used to insert data to the database table 
        public function addDessert(string $dessName, string $dessDescription, string $dessPrice) : bool {
            if(!$this->setDessert($dessName, $dessDescription, $dessPrice)) return false;

            $dessName = $this->db->real_escape_string($dessName);
            $dessDescription = $this->db->real_escape_string($dessDescription);
            $dessPrice = $this->db->real_escape_string($dessPrice);

            $dessName = htmlentities($dessName, ENT_QUOTES, 'UTF-8');
            $dessDescription = htmlentities($dessDescription, ENT_QUOTES, 'UTF-8');
            $dessPrice = htmlentities($dessPrice, ENT_QUOTES, 'UTF-8');

            $sql = "INSERT INTO desserts (dessName, dessDescription, dessPrice)VALUES('$dessName', '$dessDescription', '$dessPrice');";
            $result = $this->db->query($sql);
            return $result;
        }
    //A method that takes four arguments of which one is an id and runs a set method to check data before it is entered into the database
    //Real_escape_string and htmlenteties is used to prevent harmful code to be entered into the database
    //An sql-request is being used to update the existing data in the database table 
        public function updateDessert(int $id, string $dessName, string $dessDescription, string $dessPrice) : bool {
            if(!$this->setDessertAndId($id, $dessName, $dessDescription, $dessPrice)) return false;

            $dessName = $this->db->real_escape_string($dessName);
            $dessDescription = $this->db->real_escape_string($dessDescription);
            $dessPrice = $this->db->real_escape_string($dessPrice);

            $dessName = htmlentities($dessName, ENT_QUOTES, 'UTF-8');
            $dessDescription = htmlentities($dessDescription, ENT_QUOTES, 'UTF-8');
            $dessPrice = htmlentities($dessPrice, ENT_QUOTES, 'UTF-8');

            $sql = "UPDATE desserts SET dessName='" . $this->dessName . "', dessDescription='" . $this->dessDescription . "', dessPrice='" . $this->dessPrice . "' WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        }

    //A set-method that checks that the dessName, the dessDescription and the dessPrice entered in the form is longer than 0 characters
        public function setDessert(string $dessName, string $dessDescription, string $dessPrice) : bool {
            if (strlen($dessName) > 0 && strlen($dessDescription) > 0 && strlen($dessPrice) > 0) {

                $this->dessName = $dessName;
                $this->dessDescription = $dessDescription;
                $this->dessPrice = $dessPrice;
                return true;
              }else{
                return false;
            }
        }
    //A set-method that checks that there is an id and that the appName, the appDescription and the appPrice entered in the form is longer than 0 characters
        public function setDessertAndId(int $id, string $dessName, string $dessDescription, string $dessPrice) : bool {
            if ($id !== null && strlen($dessName) > 0 && strlen($dessDescription) > 0 && strlen($dessPrice) > 0) {

                $this->dessName = $dessName;
                $this->dessDescription = $dessDescription;
                $this->dessPrice = $dessPrice;
                return true;
              }else{
                return false;
            }
        }
    //A method taking id as an argument and useing an sql-request to delete data from the database where id is equal to id 
        public function deleteDessert($id){
            $id = intval($id);

            $sql = "DELETE FROM desserts WHERE id=$id;";

            return mysqli_query($this->db, $sql);
        }

        // A destructor is called when the script stops running
        function __destruct(){
            mysqli_close($this->db);
        }
    }   