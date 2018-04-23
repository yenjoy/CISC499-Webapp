<!DOCTYPE php>
 <?php

 /*
 This page allows admins to create a thesis for an associated student
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
    if(isset($_POST["thesisedit"])){
        $StudentID = $_POST["thesisrow"];
        $flag = TRUE;

    }
    //If we are updating a thesis, fetch the information
        if($flag==TRUE){
            $sql = "SELECT * FROM `Thesis` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $Title = $row["Title"];
            $ResearchArea = $row["ResearchArea"];
            $Supervisor = $row["Supervisor"];
            $Defence = $row["DefenseCommittee"];
            $Abstract = $row["Abstract"];

            
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
    <center> <h1 class="headerFont">Add Thesis</h1> </center>
  </head>
<body> 
     <div class="profile">
    <form method="post">
        <input type='hidden' name="thesisnumdelete" value="<?php echo $StudentID; ?>">
        <input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
        <input class='btn btn-danger btn-md' name="delete" type="submit" value="Delete Thesis" onClick="return confirm('Are you sure?')">  
 <br><br>
        </form>
	<form method="post">
	<fieldset>
		<legend> Thesis Information</legend>
		<label id="StudentID" >StudentID: </label> <input type="number" name="studentNum" min="0" pattern="[0-9 ]+" title="Only Numbers" value="<?php echo $StudentID; ?>" required> <br>
        <br>

		<label id="thesistitle">Thesis Title: </label> <input style="width: 50%;" type="text" name="title" value="<?php echo $Title; ?>" required> <br><br>

		<label id="area" >Research Area: </label> <input type="text" name="researchArea" value="<?php echo $ResearchArea; ?>" > <br><br>
		<label id="supervisor" >Supervisor: </label>  <input type="text" name="supervisor" value="<?php echo $Supervisor; ?>" > <br><br>
        <label id="defencecommitte" >Defence Committee: </label>  <input type="text" name="defence" value="<?php echo $Defence; ?>"> <br><br>
        <input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
          <label id="abstractlabel">Abstract: </label><br>
                <textarea rows="6" cols="50" name="abstract" ><?php echo $Abstract; ?></textarea><br><br>
	</fieldset>
	<button class="btn btn-primary btn-md buttonColor" type="submit" name="submit" Visibility="visible" id="submit" method="post">Submit</button><br><br>
</form>
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
            $StudentID = $_POST["studentNum"];
            $Title = $_POST["title"];
            $Title = verify_input($Title, $con);
            $ResearchArea = $_POST["researchArea"];
            $Supervisor = $_POST["supervisor"];
            $Defence = $_POST["defence"];
            $Abstract = $_POST["abstract"];
            $Abstract = verify_input($Abstract, $con);
            $flag = $_POST["flaginput"];   
            //We are updating       
            if ($flag=="true"){
                $sql = "UPDATE `Thesis` SET `Title`='$Title',`ResearchArea`='$ResearchArea',`Supervisor`='$Supervisor',`DefenseCommittee`='$Defence',`Abstract`='$Abstract' WHERE `StudentID` = $StudentID";
                $stmt = $con->prepare($sql);
                $stmt->execute();
             if($_SESSION["mph"] == true ){
                header("Location: MPHAdminDashboard.php");  
         }
         else{
                header("Location: MSCAdminDashboard.php");  
         }
            }
            //Else we are inserting
            else{
                $sql = "INSERT INTO `Thesis`(`Title`, `ResearchArea`, `StudentID`, `Supervisor`,`DefenseCommittee`, `Abstract`) VALUES ('$Title','$ResearchArea',$StudentID,'$Supervisor','$Defence','$Abstract')";
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
//Delete a thesis
        if(isset($_POST["delete"])){
        $StudentID = $_POST["thesisnumdelete"];
        $flag = $_POST["flaginput"];
        if($flag=="true"){
        $sql = "DELETE FROM `Thesis` WHERE StudentID = $StudentID";
        $stmt = $con->prepare($sql);
         $stmt->execute();
        echo "<script> alert('Thesis Deleted'); </script>";
        }
        

       }

       


    ?>
    </div>

</body>
</html>