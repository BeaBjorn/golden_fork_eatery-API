<?php 
/*
   Author:  Beatrice björn
   For: Webbutvecklingsprogramet - Webbutveckling III - Projekt - API för restaurang
   Last updated : 2022-08-21 
*/
?>

<?php 
    //Class named "Account" with private properties
    class Booking{
        //Private properties
        private $db;
        private $id;
        private $fName;
        private $sName;
        private $phoneNumber;
        private $email;
        private $numberOfGuests;
        private $date;
        private $time;

    //cunstructor that connects to database or uses die to stop scripts from running if the connection to the database failed.
    //An error message will be shown on screen if the connection failed. 
        function __construct(){
            $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

            if($this->db->connect_errno > 0){
                die("Error connecting to database: " . $this->db-connect_error);
            }
        }
    //A method called "getBookings" that uses an sql-request to collect all data from the table "bookings" in the database  
        public function getBookings() : array {
            $sql = "SELECT * FROM bookings;";

            $result = mysqli_query($this->db, $sql);

            return mysqli_fetch_all($result, MYSQLI_ASSOC);
        }

    //A method that takes an id as argument and uses an sql-request to collect data from the database table where id is equal to id
        public function getBookingById($id) : array {

                $id = intval($id);
    
                $sql = "SELECT * FROM bookings WHERE id=$id;";
    
                $result = mysqli_query($this->db, $sql);
                return $result->fetch_assoc();
        }

    //A method that takes seven arguments and runs a set method to check data before it is entered into the database
    //Real_escape_string and htmlenteties is used to prevent harmful code to be entered into the database
    //An sql-request is being used to insert data to the database table 
        public function addBooking(string $fName, string $sName, string $phoneNumber, string $email, int $numberOfGuests, string $date, string $time) : bool {
            if(!$this->setBooking($fName, $sName, $phoneNumber, $email, $numberOfGuests, $date, $time)) return false;

            $fName = $this->db->real_escape_string($fName);
            $sName = $this->db->real_escape_string($sName);
            $phoneNumber = $this->db->real_escape_string($phoneNumber);
            $email = $this->db->real_escape_string($email);
            $numberOfGuests = $this->db->real_escape_string($numberOfGuests);
            $date = $this->db->real_escape_string($date);
            $time = $this->db->real_escape_string($time);

            $fName = htmlentities($fName, ENT_QUOTES, 'UTF-8');
            $sName = htmlentities($sName, ENT_QUOTES, 'UTF-8');
            $phoneNumber = htmlentities($phoneNumber, ENT_QUOTES, 'UTF-8');
            $email = htmlentities($email, ENT_QUOTES, 'UTF-8');
            $numberOfGuests = htmlentities($numberOfGuests, ENT_QUOTES, 'UTF-8');
            $date = htmlentities($date, ENT_QUOTES, 'UTF-8');
            $time = htmlentities($time, ENT_QUOTES, 'UTF-8');

            $sql = "INSERT INTO bookings(fName, sName, phoneNumber, email, numberOfGuests, date, time)VALUES('$fName', '$sName', '$phoneNumber', '$email', '$numberOfGuests', '$date', '$time');";
            $result = $this->db->query($sql);
            return $result;
        }
    //A method that takes eight arguments of which one is an id and runs a set method to check data before it is entered into the database
    //Real_escape_string and htmlenteties is used to prevent harmful code to be entered into the database
    //An sql-request is being used to update the existing data in the database table 
        public function updateBooking(int $id, string $fName, string $sName, string $phoneNumber, string $email, int $numberOfGuests, string $date, string $time) : bool {
            if(!$this->setBookingAndId($id, $fName, $sName, $phoneNumber, $email, $numberOfGuests, $date, $time)) return false;

            $fName = $this->db->real_escape_string($fName);
            $sName = $this->db->real_escape_string($sName);
            $phoneNumber = $this->db->real_escape_string($phoneNumber);
            $email = $this->db->real_escape_string($email);
            $numberOfGuests = $this->db->real_escape_string($numberOfGuests);
            $date = $this->db->real_escape_string($date);
            $time = $this->db->real_escape_string($time);

            $fName = htmlentities($fName, ENT_QUOTES, 'UTF-8');
            $sName = htmlentities($sName, ENT_QUOTES, 'UTF-8');
            $phoneNumber = htmlentities($phoneNumber, ENT_QUOTES, 'UTF-8');
            $email = htmlentities($email, ENT_QUOTES, 'UTF-8');
            $numberOfGuests = htmlentities($numberOfGuests, ENT_QUOTES, 'UTF-8');
            $date = htmlentities($date, ENT_QUOTES, 'UTF-8');
            $time = htmlentities($time, ENT_QUOTES, 'UTF-8');

            $sql = "UPDATE bookings SET fName='" . $this->fName . "', sName='" . $this->sName . "', phoneNumber='" . $this->phoneNumber . "', 
            email='" . $this->email . "', numberOfGuests='" . $this->numberOfGuests . "', date='" . $this->date . "', time='" . $this->time . "' WHERE id=$id;";
            $result = $this->db->query($sql);
            return $result;
        }
    //A method taking id as an argument and useing an sql-request to delete data from the database where id is equal to id 
        public function deleteBooking($id){
            $id = intval($id);

            $sql = "DELETE FROM bookings WHERE id=$id;";

            return mysqli_query($this->db, $sql);
        }

    //A set-method that checks that the fName and the sName entered is longer that or equal to 2 characters.
    //That the phoneNumber entered is longer than 5 characters.
    //That the email and the numberOfGuests entered are longer than 0 characters as well as checking that the email entered is of valid format
    //That date entered is longer that 8 characters and that the time entered is longer that 4 characters
        public function setBooking(string $fName, string $sName, string $phoneNumber, string $email, string $numberOfGuests, string $date, string $time) : bool {
            if (strlen($phoneNumber) >= 5 && strlen($fName) >= 2 && strlen($sName) >= 2 && filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($email) > 0 && 
                strlen($numberOfGuests) > 0 && strlen($date) > 8 && strlen($time) > 4) {
               
                $this->fName = $fName;
                $this->sName = $sName;
                $this->phoneNumber = $phoneNumber;
                $this->email = $email;
                $this->numberOfGuests = $numberOfGuests;
                $this->date = $date;
                $this->time = $time;
                return true;
              }else{
                return false;
            }
        }

    //A set-method that checks that that there is an id and that the fName and the sName entered is longer that or equal to 2 characters.
    //That the phoneNumber entered is longer than 5 characters.
    //That the email and the numberOfGuests entered are longer than 0 characters as well as checking that the email entered is of valid format
    //That date entered is longer that 8 characters and that the time entered is longer that 4 characters
        public function setBookingAndId(int $id, string $fName, string $sName, string $phoneNumber, string $email, string $numberOfGuests, string $date, string $time) : bool {
            if ($id !== null && strlen($phoneNumber) >= 5 && strlen($fName) >= 2 && strlen($sName) >= 2 && filter_var($email, FILTER_VALIDATE_EMAIL) && 
                strlen($email) > 0 && strlen($numberOfGuests) > 0 && strlen($date) > 8 && strlen($time) > 4) {

                $this->fName = $fName;
                $this->sName = $sName;
                $this->phoneNumber = $phoneNumber;
                $this->email = $email;
                $this->numberOfGuests = $numberOfGuests;
                $this->date = $date;
                $this->time = $time;
                return true;
              }else{
                return false;
        }
    }

        // A destructor is called when the script stops running
        function __destruct(){
            mysqli_close($this->db);
        }
    }   