<!DOCTYPE php>
 <?php
 /*
 File for saving a new view for admins
 */
// Start the session
session_start();
if($_SESSION["member_status"] != "admin"){
    header("Location: index.php");
    die();
}
?>

<html>
  <head>
    <title>Queen's Public Health Sciences Web Application</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/dropdownValues.js"></script>
    <link href="css/global.css" type="text/css" rel="stylesheet">
    <link href="css/adminDashboard.css" type="text/css" rel="stylesheet">
    <img src="Assets/banner.jpg" id="header">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
      <ul id="navbar">
      <li><a href="<?php if($_SESSION["mph"]== true){ echo 'MPHAdminDashboard.php';} else{ echo 'MSCAdminDashboard.php';} ?>" >Back</a></li>
      <li> <a>Add Profile</a>
        <ul>
            <a href="#">Student</a>
            <a href="#">Administrator</a>
            <a href="#">Organization</a>
            <a href="#">Practicum</a>
        </ul>
        </li>
        <li style="float:right"><a class="active" href="https://idptest.queensu.ca/idp/profile/Logout">Logout</a></li>
      </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>

  </head>

<body>
<center>
<form  id="saveviewform" name='saveviewform'  method='post' ><br><br>
            <h4 class="headerfont boldFont">Enter View Name </h4><br>
            <input type="text" name="viewname" id="viewname" maxlength="80" size="40" height="60" required pattern="[a-zA-Z0-9() ]+" title="No Special Characters"></input><br><br><br>
            <center> <button class='btn btn-primary btn-md buttonColor' type='submit' name='saveviewtwo'  id='saveviewtwo'  method='post'>Save as View</button><br><br> </center>

            </form>

</center>
</body>



<?php 

    if(isset($_POST["saveviewtwo"])){
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
            $name = $_POST["viewname"];
            $name  = trim($name );
            $name  = stripslashes($name );
            $name  = htmlspecialchars($name );
            $name  = mysqli_real_escape_string($con, $name );
           $query = $_SESSION["viewquery"];
        $columncount = $_SESSION['columncount'];
            $safequery = mysqli_real_escape_string($con, $query);

            $sql = " INSERT INTO `View` (`Name`, `Query` , `ColumnCount` ) 
            VALUES ('$name','$safequery', '$columncount')";
	    if($stmt = $con->prepare($sql)){
	    $stmt->execute();
            echo "<div class='alert alert-success'>
        <center> <strong>View Created!</strong> </center> </div>";
                    if($_SESSION["mph"] == true){
                header("Location: MPHAdminDashboard.php");
            }
            else {
                header("Location: MSCAdminDashboard.php");
            }
            }
            else{
                    echo "<div class='alert alert-danger'>
        <center> <strong>Error Creating View</strong> </center> </div>";
            }


}


?>