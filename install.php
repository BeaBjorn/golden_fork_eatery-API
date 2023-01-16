<?php 
/*
   Author:  Beatrice björn
   For: Webbutvecklingsprogramet - Webbutveckling III - Projekt - API för restaurang
   Last updated : 2022-08-21 
*/
?>

<?php 
//includes the config.php file
    include("api/config.php");

//Connect to the database and sends out an error message if the connection failed
    $db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);
    if($db->connect_errno > 0){
        die("Fel vid databasanslutning: " . $db->connect_error);
}

//An sql-request that delets all tables listed below if they a;ready exists in the database.
//This is done to prevent multiple tables with the same name
$sql = "DROP TABLE IF EXISTS aboutUs, bookings, admin, mains, drinks, appetizers, desserts, alcohol, noAlcohol, hotDrinks;";    

//Creates a table called "aboutUs" in the database containing and id (auto incremented), a title and text
$sql .= "CREATE TABLE aboutUs(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    titel VARCHAR(200) NOT NULL,
    info TEXT(3000) NOT NULL
    );";
//Creates a table called "bookings" in the database containing and id (auto incremented), fName, sName, phoneNumber, email, 
//numberOfGuests, date and time
$sql .= "CREATE TABLE bookings(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    fName VARCHAR(200) NOT NULL,
    sName VARCHAR(200) NOT NULL, 
    phoneNumber VARCHAR(20) NOT NULL,
    email VARCHAR (200) NOT NULL,
    numberOfGuests INT(1) NOT NULL,
    date VARCHAR(10) NOT NULL,
    time VARCHAR(5) NOT NULL
    );";
//Creates a table called "appetizers" in the database containing and id (auto incremented), appName, appDescription and appPrice
$sql .= "CREATE TABLE appetizers(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    appName VARCHAR(200) NOT NULL,
    appDescription TEXT(500) NOT NULL,
    appPrice VARCHAR(5) NOT NULL
    );";
//Creates a table called "mains" in the database containing and id (auto incremented), mainName, mainDescription and mainPrice
$sql .= "CREATE TABLE mains(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    mainName VARCHAR(200) NOT NULL,
    mainDescription TEXT(500) NOT NULL,
    mainPrice VARCHAR(5) NOT NULL
    );";
//Creates a table called "desserts" in the database containing and id (auto incremented), dessName, dessDescription and dessPrice
$sql .= "CREATE TABLE desserts(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    dessName VARCHAR(200) NOT NULL,
    dessDescription TEXT(500) NOT NULL,
    dessPrice VARCHAR(5) NOT NULL
    );";
//Creates a table called "alcohol" in the database containing and id (auto incremented), drinkName and drinkPrice
$sql .= "CREATE TABLE alcohol(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    drinkName VARCHAR(200),
    drinkPrice VARCHAR(5) NOT NULL
    );";
//Creates a table called "noAlcohol" in the database containing and id (auto incremented), drinkName and drinkPrice
$sql .= "CREATE TABLE noAlcohol(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    drinkName VARCHAR(200),
    drinkPrice VARCHAR(5) NOT NULL
    );";
//Creates a table called "hotDrinks" in the database containing and id (auto incremented), drinkName and drinkPrice
$sql .= "CREATE TABLE hotDrinks(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    drinkName VARCHAR(200),
    drinkPrice VARCHAR(5) NOT NULL
    );";

//Creates a table called "admin" in the database containing and id (auto incremented), username, password and jioned
$sql .= "CREATE TABLE admin(
    id INT(11) PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(200) NOT NULL,
    password VARCHAR(200) NOT NULL, 
    joined timestamp NOT NULL DEFAULT current_timestamp()
    );";

//prints sql questions with the table to the screen
echo "<pre>$sql</pre>";

// This prints a message to the screen saying weather the installation of the table was successful or not
if($db->multi_query($sql)){
    echo "Tabell installerad i databas!";
}else{
    echo "Något gick snett vid installation av tabell.";
}
?>