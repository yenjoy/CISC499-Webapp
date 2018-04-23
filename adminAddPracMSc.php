<!DOCTYPE php>
 <?php
 /*
    This page allows admins to add or edit a MSC practicum
    */
// Start the session
session_start();
include_once 'connection.php'; 
//Ensure user is admin
if($_SESSION['member_status'] != 'admin'){
    header("Location: index.php");
    die();
    }
    $flag = FALSE;
    //Check if we are editing a practicum 
    if(isset($_POST["practicumedit"])){
        $StudentID = $_POST["practicumrow"];
        $flag = TRUE;

    }
        if($flag==TRUE){
            $sql = "SELECT * FROM `PracticumMSC` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $facility = $row["Facility"];
            $evaluation = $row["StudentEval"];
            $OrganizationID = $row["OrganizationID"];
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
        <li style="float:right"><a class="active" href="https://login.queensu.ca/idp/logout.jsp">Logout</a></li>
        <li style="float:right"><a class="active" href="savedViews.php">Saved Views</a></li>
      </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">Add/Edit Practicum MSc</h1> </center>
  </head>

<body>
<div align="center">
<div class="profile">
<br><br>
<form method="post">
        <input type='hidden' name="studentnumdelete" value="<?php echo $StudentID; ?>">
        <input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
        <input class='btn btn-danger btn-md' name="delete" type="submit" value="Delete Practicum" onClick="return confirm('Are you sure?')">  
 <br><br>
        </form>

<form method="post">
<fieldset>
	<legend> Practicum </legend>
	<label > StudentID </label> <input type="number"  min="0" pattern="[0-9 ]+" title="Only Numbers" name="studentNum" value="<?php echo $StudentID; ?>" required> <br><br>
	<label > Facility </label> <select name="OrganizationID" required>
        <?php 
            $sql = "SELECT `OrganizationName`, `OrganizationID` FROM `Organization` WHERE 1 ORDER BY 'OrganizationName' ASC";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()){
                if($flag == True){
                    if($OrganizationID == $row['OrganizationID']){
                        echo " <option value = ". $row['OrganizationID'] . " selected>" . $row['OrganizationName'] . "</option>" ; 
                    }
                    else {
                    echo " <option value = ". $row['OrganizationID'] . ">" . $row['OrganizationName'] . "</option>" ; 
                    }
                }
                else{
                   echo " <option value = ". $row['OrganizationID'] . ">" . $row['OrganizationName'] . "</option>" ;  
                }
            }
        ?>
    </select> <br><br><br>
	Evaluation: <br><br>
	<textarea name="evaluation" cols="100" rows="10"> <?php echo $evaluation; ?></textarea><br><br>
    <input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
</fieldset> 
<button class="btn btn-primary btn-md buttonColor" type="submit" name="submit" Visibility="visible" id="submit" method="post">Submit</button><br>
<br>
</form>
</div>
</div>
<?php
    //Validate inputs
function verify_input($data, $con){
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
  $data = mysqli_real_escape_string($con, $data);
  return $data;  
}
//Form Submission 
    if(isset($_POST["submit"])){
        $flag = $_POST["flaginput"];
        $OrganizationID = $_POST["OrganizationID"];
	    $studentNum = $_POST["studentNum"];
	    $facility = $_POST["facility"];
	    $evaluation = $_POST["evaluation"];
        $evaluation = verify_input($evaluation, $con);
        $sql ="SELECT * FROM Organization WHERE OrganizationID = $OrganizationID";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result -> fetch_assoc();
        $facility = $row["OrganizationName"];        
        //Update the practicum we are editing
        if($flag=="true"){
            $sql = "UPDATE `PracticumMSC` SET `Facility`='$facility', `StudentEval`='$evaluation', `OrganizationID`=$OrganizationID  WHERE `StudentID`=$studentNum";
            $stmt = $con->prepare($sql);
            $stmt->execute();
                     if($_SESSION["mph"] == true ){
            header("Location: MPHAdminDashboard.php");  
         }
         else{
             header("Location: MSCAdminDashboard.php");  
         }
        }
        //Insert a new practicum
        else {
	    $sql = "INSERT INTO `PracticumMSC`(`Facility`, `StudentEval`, `StudentID`) VALUES ('$facility', '$evaluation', $studentNum)";

                if($stmt = $con->prepare($sql)){
                $stmt->execute();
                }
                else{
                    echo "<script> alert('No Student Matches that StudentID'); </script>";
                }
                 if($_SESSION["mph"] == true ){
            header("Location: MPHAdminDashboard.php");  
         }
         else{
             header("Location: MSCAdminDashboard.php");  
         }
        }
	}
//Delete the practicum
           if(isset($_POST["delete"])){
        $StudentID = $_POST["studentnumdelete"];
        $flag = $_POST["flaginput"];
        if($flag=="true"){
        $sql = "DELETE FROM `PracticumMSC` WHERE StudentID = $StudentID";
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