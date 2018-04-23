<!DOCTYPE php>
 <?php
 /*
    Page for admins to add a new organization
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
    if(isset($_POST["PassOnID"])){
        $OrganizationID = $_POST["PassOnID"];
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
            $Province = $row["Province"];
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
        //<li style="float:right"><a class="active" href="savedViews.php">Saved Views</a></li>
      </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">Edit Organization</h1> </center>

  </head>

<!--
<body>
    <div class="profile">
        <div align="CENTER">  <br>

	<form method="post">
	<fieldset>
		<legend> Organization Profile</legend>
		Organization Name: <input type="text" name="organization" value="<?php echo $organization; ?>" required> <br><br>
		Address: <input type="text" name="address" pattern="[^'\x22><]+" title="No Special Characters (Quotes or Angle Brackets)" value="<?php echo $address; ?>" > <br><br>
		City: <input type="text" name="city" pattern="[^'\x22><]+" title="No Special Characters (Quotes or Angle Brackets)"  value="<?php echo $city; ?>" > <br><br>
		Province/Territory: <input type="text" name="province" pattern="[^'\x22><]+" title="No Special Characters (Quotes or Angle Brackets)" value="<?php echo $province; ?>" > <br><br>
		Country: <input type="text" name="country" pattern="[^'\x22><]+" title="No Special Characters (Quotes or Angle Brackets)" value="<?php echo $country; ?>" > <br><br>
		Postal Code: <input type="text"  pattern="[^'\x22><]+" title="No Special Characters (Quotes or Angle Brackets)" name="postalCode" value="<?php echo $postalCode; ?>" > <br><br>
        Organization Type: <input type="text" pattern="[^'\x22><]+" title="No Special Characters (Quotes or Angle Brackets)" name="organizationtype" value="<?php echo $organizationType; ?>"> <br><br>
        <input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
         <input type='hidden' name="OrganizationID" value="<?php echo $OrganizationID; ?>">
	</fieldset>
	<button class="btn btn-primary btn-md buttonColor" type="submit" name="submit" Visibility="visible" id="submit" method="post">Submit</button><br><br>
</form>
</div>
</div>
</body>

// -->

<body>
<div class = "profile">
<div align="CENTER">  <br>

<form method = "post">
	<h4 class = "headerfont boldFont"> Organization Info </h4>
        <label id="organization">Organization Name: </label>
        <input type="text" name="organization" value="<?php echo $organization; ?>"/><br><br>

	<label id="address">Address: </label>
        <input type="text" name="address" value="<?php echo $address; ?>"/>
	<br><br>

	<label id="city">City: </label>
        <input type="text" name="city" value="<?php echo $city; ?>"/>
	<br><br>

	<select required name = "Province">
		<option value="Alberta"<?php if ($Province == 'Alberta') 
		echo 'selected="selected"'; ?>>Alberta</option>
		<option value="British Columbia"<?php if ($Province == 'British Columbia') 
		echo 'selected="selected"'; ?>>British Columbia</option>
		<option value="Manitoba"<?php if ($Province == 'Manitoba') 
		echo 'selected="selected"'; ?>>Manitoba</option>
		<option value="New Brunswick"<?php if ($Province == 'New Brunswick') 
		echo 'selected="selected"'; ?>>New Brunswick</option>
		<option value="Newfoundland and Labrador"<?php if ($Province == 'Newfoundland and Labrador') 
		echo 'selected="selected"'; ?>>Newfoundland and Labrador</option>
		<option value="Nova Scotia"<?php if ($Province == 'Nova Scotia') 
		echo 'selected="selected"'; ?>>Nova Scotia</option>
		<option value="Ontario"<?php if ($Province == 'Ontario') 
		echo 'selected="selected"'; ?>>Ontario</option>
		<option value="Prince Edward Island"<?php if ($Province == 'Prince Edward Island') 
		echo 'selected="selected"'; ?>>Prince Edward Island</option>
		<option value="Quebec"<?php if ($Province == 'Quebec') 
		echo 'selected="selected"'; ?>>Quebec</option>
		<option value="Saskatchewan"<?php if ($Province == 'Saskatchewan') 
		echo 'selected="selected"'; ?>>Saskatchewan</option>
		<option value="Northwest Territories"<?php if ($Province == 'Northwest Territories') 
		echo 'selected="selected"'; ?>>Northwest Territories</option>
		<option value="Nunavut"<?php if ($Province == 'Nunavut') 
		echo 'selected="selected"'; ?>>Nunavut</option>
		<option value="Yukon"<?php if ($Province == 'Yukon') 
		echo  'selected="selected"'; ?>Yukon</Province 

	<label id="country name">Country: </label>
	<input type="text" name="country" value="<?php echo $country; ?>"/><br><br>
	<label id="postalcode">Postal Code: </label>
        <input type="text" name="postalcode" value="<?php echo $postalcode; ?>"/><br><br>

	<label id="organization type">Organization Type: </label>
		<select required name = "organizationtype">
		<option value="Community Health Center"<?php if ($organizationType== 'Community Health Center') 
		echo 'selected="selected"'; ?>>Community Health Center</option>
		<option value="Federal Organization"<?php if ($organizationType== 'Federal Organization') 
		echo 'selected="selected"'; ?>>Federal Organization</option>
		<option value="First Nations"<?php if ($organizationType== 'First Nations') 
		echo 'selected="selected"'; ?>>First Nations</option>
		<option value="Hospital/Healthcare"<?php if ($organizationType== 'Hospital/Healthcare') 
		echo 'selected="selected"'; ?>>Hospital/Healthcare</option>
		<option value="International"<?php if ($organizationType== 'International') 
		echo 'selected="selected"'; ?>>International</option>
		<option value="Local Health Integration Network (LHIN)"<?php if ($organizationType== 'Local Health Integration Network (LHIN)') 
		echo 'selected="selected"'; ?>>Local Health Integration Network (LHIN)</option>
		<option value="Municipal Government"<?php if ($organizationType== 'Municipal Government') 
		echo 'selected="selected"'; ?>>Municipal Government</option>
		<option value="Non-Governmental Organization"<?php if ($organizationType== 'Non-Governmental Organization') 
		echo 'selected="selected"'; ?>>Non-Governmental Organization</option>
		<option value="Provincial Organization"<?php if ($organizationType== 'Provincial Organization') 
		echo 'selected="selected"'; ?>>Provincial Organization</option>
		<option value="Public Health Department/Unit"<?php if ($organizationType== 'Public Health Department/Unit') 
		echo 'selected="selected"'; ?>>Public Health Department/Unit</option>
		<option value="Territorial Organization"<?php if ($organizationType== 'Territorial Organization') 
		echo 'selected="selected"'; ?>>Public Health Department/Unit</option>
		<option value="Other"<?php if ($organizationType== 'Other') 
		echo 'selected="selected"'; ?>>Other</option>
	</select>

	<input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
        <input type='hidden' name="OrganizationID" value="<?php echo $OrganizationID; ?>">
	<button class="btn btn-primary btn-md buttonColor" type="submit" name="submit" Visibility="visible" id="submit" method="post">Submit</button><br><br>
</body>
</form>
</div>
</div>

<?php
if(isset($_POST["submit"])){
        //Retrieve all data and insert it into the DB
        $editflag = true;
	//$flag = $_POST["flaginput"];

        $OrganizationID = $_POST["OrganizationID"];   
        $organization = $_POST["organization"];
        $address = $_POST["address"];
        $city = $_POST["city"];
        $province = $_POST["Province"];
        $country = $_POST["country"];
        $postalCode = $_POST["postalcode"];
        $organizationType = $_POST["organizationtype"];


            $sql = "UPDATE `Organization` SET `OrganizationName`='$organization', 
			`StreetNameNumber`='$address', 
			`City`='$city', 
			`Province`= '$province', 
			`Country`='$country',
			`ZipPostalCode`='$postalcode',
			`OrganizationType`='$organizationType' 
			WHERE `OrganizationID`= $OrganizationID";
        	if($stmt = $con->prepare($sql)){
        	$stmt->execute();
		echo "<script> alert('Organization Updated'); </script>";
        	}
        	else{
            	echo "<script> alert('Error Updating Organization'); </script>";
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