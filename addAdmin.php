<!DOCTYPE php>
 <?php
 /*
 File for adding a new administrator to the DB
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
    <link href="css/Form.css" type="text/css" rel="stylesheet">
    <link href="css/adminDashboard.css" type="text/css" rel="stylesheet">
    <img src="Assets/banner.jpg" id="header">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
      <ul id="navbar">
 <li><a href="<?php if($_SESSION["mph"]== true){ echo 'MPHAdminDashboard.php';} else{ echo 'MSCAdminDashboard.php';} ?>" >Back</a></li>
        <li style="float:right"><a class="active" href="https://login.queensu.ca/idp/logout.jsp">Logout</a></li>
        //<li style="float:right"><a class="active" href="savedViews.php">Saved Views</a></li>
      </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">Add Admin</h1> </center>

  </head>

<body>

<!--
<div class="profile">
<form method="POST">
<fieldset>
	<legend> Add Admin </legend>
		First Name: <input type="text" name="FName"> <br><br>
		Last Name: <input type="text" name="LName"> <br><br>
</fieldset>
//-->

<div class ="profile">
<form method = "post">
	<h4 class = "headerfont boldFont"> General Information </h4> <br>
	<label id = "firstName">First Name: </label>
	<input type="text" name="FName" value="<?php echo $FName; ?>"/><br><br>
        <label id="lastName">Last Name: </label>
        <input type="text" name="LName"  value="<?php echo $LName; ?>"/><br><br>
	<button class="btn btn-primary btn-md buttonColor" type="submit" name="submit" Visibility="visible" id="submit" method="post">Submit</button><br>
<br>
</form>
</div>
<?php 	
include_once 'connection.php'; 
    if(isset($_POST["submit"])){
	    $FName = $_POST["FName"];
	    $LName = $_POST["LName"];

	    $sql = "INSERT INTO `Admin`(`firstName`, `lastName`) VALUES ('$FName', '$LName')";

	    if($stmt = $con->prepare($sql)){
	    $stmt->execute();
      echo "<div class='alert alert-success'>
 <center> <strong>Admin Created!</strong> </center> </div>";
      }
      else{
              echo "<div class='alert alert-danger'>
 <center> <strong>Adminstrator already exists!</strong> </center> </div>";
      }
	}


?>

</body>
</html>