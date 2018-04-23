<!DOCTYPE php>
 <?php
// Start the session
session_start();

$host = '10.20.49.11:3306';
$db_name = 'phs';
$username = 'phs';
$password = 'FWG1udZN3zVS';
try {
     $con = new mysqli($host,$username,$password, $db_name);
}   
catch(Exception $exception){
          echo "Connection error: " . $exception->getMessage();
         }
?>