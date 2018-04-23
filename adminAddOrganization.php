<!DOCTYPE php>
 <?php
 /*
    Page for admins to add a new organization
	DEV VERSION
    */
// Start the session
session_start();
include_once 'connection.php'; 
//Ensures the user is an admin
if($_SESSION['member_status'] != 'admin'){
    header("Location: index.php");
    die();
    }
    $flag = FALSE;
    //Checks to see if an organization has been posted to edit
    if(isset($_POST["organizationedit"])){
        $OrganizationID = $_POST["organizationrow"];
        $flag = TRUE;

    }
    //If so, retrieve that organization
        if($flag==TRUE){
            $sql = "SELECT * FROM `Organization` WHERE `OrganizationID` = $OrganizationID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $organization = $row["OrganizationName"];
            $address = $row["StreetNameNumber"];
            $city = $row["City"];
            $province = $row["Province"];
            $country = $row["Country"];
            $postalCode = $row["ZipPostalCode"];
            $organizationType = $row["OrganizationType"];

            
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
       </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">Create Organization</h1> </center>

  </head>

<body>
<div align="CENTER">  <br>
        <div class="profile">
        <form method="post">

	<h4 class="headerfont boldFont">Organization Information</h4> <br>

        <label id="organization">Organization Name: </label>
        <input type="text" name="organization" value="<?php echo $organization; ?>"/><br><br>

	<label id="address">Address: </label>
        <input type="text" name="address" value="<?php echo $address; ?>"/><br><br>

	<label id="city">City: </label>
        <input type="text" name="city" value="<?php echo $city; ?>"/><br><br>

	<label id="province label">Province: </label>
	<select required name = "province">
		<option value="Alberta"<?php if ($province== 'Alberta') 
		echo 'selected="selected"'; ?>>Alberta</option>
		<option value="British Columbia"<?php if ($province== 'British Columbia') 
		echo ' selected="selected"'; ?>>British Columbia</option>
		<option value="Manitoba"<?php if ($province== 'Manitoba') 
		echo ' selected="selected"'; ?>>Manitoba</option>
		<option value="New Brunswick"<?php if ($province== 'New Brunswick') 
		echo ' selected="selected"'; ?>>New Brunswick</option>
		<option value="Newfoundland and Labrador"<?php if ($province== 'Newfoundland and Labrador') 
		echo ' selected="selected"'; ?>>Newfoundland and Labrador</option>
		<option value="Nova Scotia"<?php if ($province== 'Nova Scotia') 
		echo ' selected="selected"'; ?>>Nova Scotia</option>
		<option value="Ontario"<?php if ($province== 'Ontario') 
		echo ' selected="selected"'; ?>>Ontario</option>
		<option value="Prince Edward Island"<?php if ($province== 'Prince Edward Island') 
		echo ' selected="selected"'; ?>>Prince Edward Island</option>
		<option value="Quebec"<?php if ($province== 'Quebec') 
		echo ' selected="selected"'; ?>>Quebec</option>
		<option value="Saskatchewan"<?php if ($province== 'Saskatchewan') 
		echo ' selected="selected"'; ?>>Saskatchewan</option>
		<option value="Northwest Territories"<?php if ($province== 'Northwest Territories') 
		echo ' selected="selected"'; ?>>Northwest Territories</option>
		<option value="Nunavut"<?php if ($province== 'Nunavut') 
		echo ' selected="selected"'; ?>>Nunavut</option>
		<option value="Yukon"<?php if ($province== 'Yukon') 
		echo ' selected="selected"'; ?>>Yukon</option>
	</select>					

	<label id="organization type">Organization Type: </label>
	<select required name = "organizationtype">
		<option value="Community Health Center">Community Health Center</option>
		<option value="Federal Organization">Federal Organization</option>
		<option value="First Nations">First Nations</option>
		<option value="Hospital/Healthcare">Hospital/Healthcare</option>
		<option value="International">International</option>
		<option value="Local Health Integration Network (LHIN)">Local Health Integration Network (LHIN)</option>
		<option value="Municipal Government">Municipal Government</option>
		<option value="Non-Governmental Organization">Non-Governmental Organization</option>
		<option value="Provincial Organization">Provincial Organization</option>
		<option value="Public Health Department/Unit">Public Health Department/Unit</option>
		<option value="Territorial Organization">Territorial Organization</option>
		<option value="Other">Other</option>
	</select>
	<input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
	<br><br>
	<br><br>
 
        <button class='btn btn-primary btn-md buttonColor' type="submit" name="submit" >Submit</button><br><br>    
        </form>  
        </div>
        </div>
    </body>

<?php
    if(isset($_POST["submit"])){

        //Retrieve all data and insert it into the DB
        $OrganizationID = $_POST["OrganizationID"];   
        $flag = $_POST["flaginput"];
        $organization = $_POST["organization"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $province = $_POST["province"];
        $country = $_POST["country"];
        $postalCode = $_POST["postalCode"];
        $organizationType = $_POST["organizationtype"];
	
        $sql = "INSERT INTO `Organization`(`OrganizationName`, `StreetNameNumber`, `City`, `Province`, `Country`, `ZipPostalCode`, `OrganizationType`) 
        VALUES ('$organization', '$address', '$city', '$province', '$country', '$postalCode' , '$organizationType')";
        
	if($stmt = $con->prepare($sql)){
        $stmt->execute();
	echo "<script> alert('Sucessfully Added Organization'); </script>";

        }
        else{
            echo "<script> alert('Error Adding Organization'); </script>";
        }
        if($_SESSION["mph"] == true ){
            header("Location: MPHAdminDashboard.php");  
         }
         else{
             header("Location: MSCAdminDashboard.php");  
         }
 
 
    }
//Delete the organization
       if(isset($_POST["delete"])){
        $OrganizationID = $_POST["organizationnumdelete"];
        $flag = $_POST["flaginput"];
        if($flag=="true"){
        $sql = "DELETE FROM `Organization` WHERE OrganizationID = $OrganizationID";
        $stmt = $con->prepare($sql);
         $stmt->execute();
         if($_SESSION["mph"] == true ){
            header("Location: MPHAdminDashboard.php");  
         }
         else{
             header("Location: MSCAdminDashboard.php");  
         }
        }
        
 
       }
 
?>
</body>
</html>