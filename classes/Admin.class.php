<?php
/*
   Author:  Beatrice björn
   For: Webbutvecklingsprogramet - Webbutveckling III - Projekt - API för restaurang
   Last updated : 2022-08-21 
*/
?>
<?php 
    //Class named "Account" with private properties
    class Admin{
        //Private properties
        private $db;
        private $id;
        private $username;
        private $password;
        private $conf_password;

    //cunstructor that connects to database or uses die to stop scripts from running if the connection to the database failed.
    //An error message will be shown on if the connection failed. 
        function __construct(){
            $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

            if($this->db->connect_errno > 0){
                die("Error connecting to database: " . $this->db-connect_error);
            }
        }

    //A function that takes two arguments, "username" and "password" to login registered users on the website.    
    //An sql request gets all the information stored in the database table 'admin' where username is the same at the username 
    //entered in the login-form. If more than 0 rows are returned the password from the table is collected and compared to the 
    //password entered in the login-form by using the method "password_verify". 
    //If the if-statement returns true a sessionvariable is created to store the username of the logged in user. 
        public function loginUser(string $username, string $password) : bool {
            $username = $this->db->real_escape_string($username);
            $password = $this->db->real_escape_string($password);
            $sql = "SELECT * FROM admin WHERE username='$username';";

            $result = $this->db->query($sql);

            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                $stored_pword = $row['password'];

                if(password_verify($password, $stored_pword)){
                    $_SESSION['username'] = $username;
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }

        // A function using the session-variable username to prevent users that are not logged in to access restricted pages on the website
        public function adminOnly() : bool {
            if(!isset($_SESSION['username'])){
                header("location: login.php");
                exit;
            }
        }

        // A set-method that checks that the username entered in the form is longer than or equal to 4 characters
        //That the password entered is longer than 8 characters and that the two passwords enterred are the same
        public function setUser(string $username, string $password, string $conf_password) : bool {
            if (strlen($username) >= 4 && strlen($password) >= 8 && $password === $conf_password) {
                $this->username = $username;
                $this->password = $password;
                $this->conf_password = $conf_password;
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

