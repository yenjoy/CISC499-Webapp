<!DOCTYPE php>
<?php
/*
    File for admins to edit students of any program
*/
// Start the session
session_start();
include_once 'connection.php'; 
//Ensure they are an admin
if($_SESSION['member_status'] != 'admin'){
    header("Location: index.php");
    die();
    }

//BOOKMARK	
    $flag = FALSE;
    //Check to see if there has been a value posted, if so we know we are editing a student and we should load their data
    if(isset($_POST["PassOnID"])){
        $StudentID = $_POST["PassOnID"];
        $flag = TRUE;

    }

    //Load the students data
        if($flag==TRUE){
	//testing data
	//$StudentID = 2600352;
            $comment = "Please enter any other comments";
            $sql = "SELECT * FROM `Student` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $FName = $row["FName"];
            $LName = $row["LName"];
            $QueensEmail = $row["QueensEmail"];
            $graduatingYear = $row['GraduatingYear'];
            $Email = $row["OtherEmail"];
            $Gender = $row["Gender"];
            $citizenship = $row["Citizenship"];
            $homeProvince = $row["homeProvince"];
            $currJobTitle = $row["CurrentJobTitle"]; 
            $currEmployer =  $row["CurrentEmployer"];
            $Program = $row["Program"];
            $comment = $row["OpenComments"];
            $sql = "SELECT * FROM `Education` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $startDate = $row["StartDate"];
            $endDate = $row["EndDate"];
            $UGProgram = $row["UGProgram"];
            $sql = "SELECT * FROM `Funding` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $Amount = $row["Amount"];
            $Source = $row["Source"];
             $sql = "SELECT * FROM `Future` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $furtherStudies = $row["FurtherStudies"];
            $futureEmployment = $row["Employment"];


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
    <center> <h1 class="headerFont">Edit Student</h1> </center>

  </head>
    <body>
        <div align="CENTER">  <br>
        <form method="post">
        <input type='hidden' name="studentnumdelete" value="<?php echo $StudentID; ?>">
        <input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
	
	<div style="position:absolute;left:50%;right 50%;">
        <input class='btn btn-danger btn-md' name="delete" type="submit" value="Delete Student" onClick="return confirm('Are you sure?')">  
	</div>

 <br>
        </form>
        <br>
        <div class="profile">
        <form method="post">
        <label id="program">Program: </label>
        <select required name="programselection"><?php
                        if ($Program == 'MPH'){
                            echo '<option value="Masters in Biostatistics"> Masters in Biostatistics </option>';
                            echo '<option value="MPH" selected> MPH </option>';
                            echo '<option value="PHD in Epidemiology"> PHD in Epidemiology </option>';
                            echo '<option value="Masters in Epidemiology"> Masters in Epidemiology </option>';
                        }elseif ($Program == 'Masters in Biostatistics'){
                            
                            echo '<option value="Masters in Biostatistics" selected> Masters in Biostatistics </option>';
                            echo '<option value="MPH" > MPH </option>';
                            echo '<option value="PHD in Epidemiology"> PHD in Epidemiology </option>';
                            echo '<option value="Masters in Epidemiology"> Masters in Epidemiology </option>';
                        }elseif ($Program == 'Masters in Epidemiology'){
                            echo '<option value="Masters in Biostatistics"> Masters in Biostatistics </option>';
                            echo '<option value="MPH"> MPH </option>';
                            echo '<option value="PHD in Epidemiology"> PHD in Epidemiology </option>';
                            echo '<option value="Masters in Epidemiology"  selected> Masters in Epidemiology </option>';
                        }else{
                            echo '<option value="Masters in Biostatistics"> Masters in Biostatistics </option>';
                            echo '<option value="MPH"> MPH </option>';
                            echo '<option value="PHD in Epidemiology" selected> PHD in Epidemiology </option>';
                            echo '<option value="Masters in Epidemiology"> Masters in Epidemiology </option>';
                        }
                    ?></select><br><br>
        <h4 class="headerfont boldFont">General Information</h4> <br>
        <label id="firstName">First Name: </label>
        <input type="text" name="FName" value="<?php echo $FName; ?>"/><br><br>

        <label id="lastName">Last Name: </label>
        <input type="text" name="LName"  value="<?php echo $LName; ?>"/><br><br>

        <label id="Student #">Student #: </label>
        <input type="number" name="StudentNum" required pattern="[0-9 ]+" title="Only Numbers"  value="<?php echo $StudentID; ?>"/><br><br>

        <label id="GraduatingYear" > Graduating Year: </label>
        <input type="number" name="GraduatingYear" min="0" required pattern="[0-9 ]+" title="Only Numbers" value="<?php echo $graduatingYear; ?>" required><br><br>

        <label id="QueensEmail">Queen's Email: </label>
        <input type="email"   name="QueensEmail" value="<?php echo "$QueensEmail"; ?>" required><br><br>
        <label id="altEmail">Other Email: </label>
            <input type="email" name="altEmail"  value="<?php echo $Email; ?>" ><br><br>
        <label id="gender" > Gender: </label>
        <select style="width: 100px;" name="Gender"><?php
                        if ($Gender == 'Male'){
                            echo '<option value=""> --- </option>';
                            echo '<option value="Male" selected> Male </option>';
                            echo '<option value="Female"> Female </option>';
                            echo '<option value="Other"> Other </option>';
                        }elseif ($Gender == 'Female') {
                            echo '<option value=""> --- </option>';
                            echo '<option value="Male"> Male </option>';
                            echo '<option value="Female" selected> Female </option>';
                            echo '<option value="Other"> Other </option>';
                        }elseif ($Gender == 'Other') {
                            echo '<option value=""> --- </option>';
                            echo '<option value="Male"> Male </option>';
                            echo '<option value="Female"> Female </option>';
                            echo '<option value="Other" selected> Other </option>';
                        }else{
                            echo '<option value=""> --- </option>';
                            echo '<option value="Male"> Male </option>';
                            echo '<option value="Female"> Female </option>';
                            echo '<option value="Other"> Other </option>';
                        }
                    ?></select> <br><br>
                <label id="citizenship" > Citizenship: </label>
                <input type="text" name="citizenship" value="<?php echo $citizenship; ?>"/> <br><br>
                
        <label id="province">Province: </label>

	<select required name = "homeProvince">
		<option value="Alberta"<?php if ($homeProvince == 'Alberta') 
		echo 'selected="selected"'; ?>>Alberta</option>
		<option value="British Columbia"<?php if ($homeProvince == 'British Columbia') 
		echo ' selected="selected"'; ?>>British Columbia</option>
		<option value="Manitoba"<?php if ($homeProvince == 'Manitoba') 
		echo ' selected="selected"'; ?>>Manitoba</option>
		<option value="New Brunswick"<?php if ($homeProvince == 'New Brunswick') 
		echo ' selected="selected"'; ?>>New Brunswick</option>
		<option value="Newfoundland and Labrador"<?php if ($homeProvince == 'Newfoundland and Labrador') 
		echo ' selected="selected"'; ?>>Newfoundland and Labrador</option>
		<option value="Nova Scotia"<?php if ($homeProvince == 'Nova Scotia') 
		echo ' selected="selected"'; ?>>Nova Scotia</option>
		<option value="Ontario"<?php if ($homeProvince == 'Ontario') 
		echo ' selected="selected"'; ?>>Ontario</option>
		<option value="Prince Edward Island"<?php if ($homeProvince == 'Prince Edward Island') 
		echo ' selected="selected"'; ?>>Prince Edward Island</option>
		<option value="Quebec"<?php if ($homeProvince == 'Quebec') 
		echo ' selected="selected"'; ?>>Quebec</option>
		<option value="Saskatchewan"<?php if ($homeProvince == 'Saskatchewan') 
		echo ' selected="selected"'; ?>>Saskatchewan</option>
		<option value="Northwest Territories"<?php if ($homeProvince == 'Northwest Territories') 
		echo ' selected="selected"'; ?>>Northwest Territories</option>
		<option value="Nunavut"<?php if ($homeProvince == 'Nunavut') 
		echo ' selected="selected"'; ?>>Nunavut</option>
		<option value="Yukon"<?php if ($homeProvince == 'Yukon') 
		echo ' selected="selected"'; ?>>Yukon</option>
	</select>		


        <h4 class="headerfont boldFont">Undergrad Information</h4> <br>
        <label id="startDate" > Start Date: </label>
        <input type="date"   name="startDate" value="<?php echo $startDate; ?>"/><br><br>

        <label id="endDate" > End Date: </label>
        <input type="date"  name="endDate" value="<?php echo $endDate; ?>"/><br><br>

        <label id="UGProgram" > Undergrad Program: </label>
        <input type="text" name="UGProgram" value="<?php echo $UGProgram; ?>"/><br><br>


        <h4 class="headerfont boldFont">Funding Information</h4> <br>
                <label id="fundingAmount" >Funding Amount: </label>
                <input type="number" pattern="[0-9]+" title="Only Numbers" name="fundingAmount" value="<?php echo $Amount; ?>"/> <br><br>
                
                <label id="fundingSource" >Funding Source: </label>
                <input type="text" name="fundingSource" value="<?php echo $Source; ?>"/><br><br><br>

        <h4 class="headerfont boldFont">Post-Grad Information</h4> <br>
                <label id="furtherstudies" >Further Studies: </label>
                <input type="text" name="furtherStudies" value="<?php echo $furtherStudies; ?>"/> <br><br>
                
                <label id="futureemployment" >Current Employer/Organization Name: </label>
                <input type="text" name="futureEmployment" value="<?php echo $futureEmployment; ?>"/><br><br><br>

                <label id="openComments">Open Comments: </label><br>
                <textarea rows="6" cols="50" name="comments" placeholder="Please Enter any Comments"><?php echo $comment; ?></textarea><br><br>

        <button class='btn btn-primary btn-md buttonColor' type="submit" name="submit" >Submit</button><br><br>    
        </form>  
        </div>
    </body>


   <?php
function verify_input($data, $con){
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
  $data = mysqli_real_escape_string($con, $data);
  return $data;  
}
        if(isset($_POST["submit"])){
            $StudentID = $_POST["StudentNum"];
            $FName = $_POST["FName"];
            $LName = $_POST["LName"];
            $flag = true;
            $GraduatingYear = $_POST["GraduatingYear"];
            $QueensEmail = $_POST["QueensEmail"];
            $OtherEmail = $_POST["altEmail"];
            $OpenComments = $_POST["comments"];
            $OpenComments = verify_input($OpenComments, $con);
            $Program = $_POST["programselection"];
            $startDate = $_POST["startDate"];
            $endDate = $_POST["endDate"];
            $UGProgram = $_POST["UGProgram"];
            $Gender = $_POST["Gender"];
            $Citizenship = $_POST["citizenship"];
            $homeProvince = $_POST["homeProvince"];
            $fundingAmount = $_POST["fundingAmount"];
            $fundingSource = $_POST["fundingSource"];
            $furtherStudies = $_POST["furtherStudies"];
            $futureEmployment = $_POST["futureEmployment"];
            if ($flag=="true"){
                $sql = "UPDATE `Student` SET `FName`='$FName', `LName`='$LName', `QueensEmail`='$QueensEmail', `GraduatingYear`= $GraduatingYear, `OtherEmail`='$OtherEmail',`OpenComments`='$OpenComments',`Program`='$Program',`Gender`='$Gender',`Citizenship`='$Citizenship',`homeProvince`='$homeProvince' WHERE `StudentID`= $StudentID";
                if($stmt = $con->prepare($sql)){
                $stmt->execute();
		echo "<script> alert('Student Updated'); </script>";

                }
                else{
                    echo "<script> alert('Error Updating Student'); </script>";
                }
                $sql = "UPDATE `Education` SET`StartDate`=STR_TO_DATE('$startDate', '%Y-%m-%d'),`EndDate`=STR_TO_DATE('$endDate', '%Y-%m-%d'),`UGProgram`='$UGProgram' WHERE `StudentID`= $StudentID";
                if($stmt = $con->prepare($sql)){
                $stmt->execute();
                }
                $sql = "UPDATE `Funding` SET `Amount`=$fundingAmount,`Source`='$fundingSource' WHERE `StudentID`= $StudentID";
                 if($stmt = $con->prepare($sql)){
                $stmt->execute();
                }
                $sql = "UPDATE `Future` SET `FurtherStudies`='$furtherStudies',`Employment`='$futureEmployment' WHERE `StudentID`= $StudentID";
                if($stmt = $con->prepare($sql)){
                $stmt->execute();
                
                }
            }
            else{ 
                $sql = "INSERT INTO `Student` (`StudentID`, `FName`, `LName`, `GraduatingYear`, `QueensEmail`, `OtherEmail`, `OpenComments`, `Program`, `Gender`, `Citizenship`, `homeProvince`) 
                VALUES ($StudentID, '$FName', '$LName', $GraduatingYear, '$QueensEmail', '$OtherEmail', '$OpenComments', '$Program', '$Gender', '$Citizenship', '$homeProvince')";
                if($stmt = $con->prepare($sql)){
                $stmt->execute();
                }
                else{
                    echo "<script> alert('Error Adding Student'); </script>";
                }
                $sql = "INSERT INTO `Education`(`StudentID`, `StartDate`, `EndDate`, `UGProgram`) VALUES ($StudentID, STR_TO_DATE('$startDate', '%Y-%m-%d'), STR_TO_DATE('$endDate', '%Y-%m-%d'), '$UGProgram')";
                if($stmt = $con->prepare($sql)){
                $stmt->execute();
                }
                $sql = "INSERT INTO `Funding`(`StudentID`, `Amount`, `Source`) VALUES ($StudentID, $fundingAmount, '$fundingSource')";
                if($stmt = $con->prepare($sql)){
                $stmt->execute();
                }
                $sql = "INSERT INTO `Future`(`StudentID`, `FurtherStudies`, `Employment`) VALUES ($StudentID, '$furtherStudies', '$futureEmployment')";
                if($stmt = $con->prepare($sql)){
                $stmt->execute();
                }
	}
 
        if($_SESSION["mph"] == true && $failed != true){
            echo " <script> location.replace('MPHAdminDashboard.php'); </script>";
         } //close if
         else{
             echo " <script> location.replace('MSCAdminDashboard.php'); </script>";
         } //close else
            
  }
       if(isset($_POST["delete"])){
        $StudentID = $_POST["studentnumdelete"];
        $flag = $_POST["flaginput"];
        if($flag=="true"){
        $sql = "DELETE FROM `Education` WHERE StudentID = $StudentID";
        $stmt = $con->prepare($sql);
         $stmt->execute();   
        $sql = "DELETE FROM `Funding` WHERE StudentID = $StudentID";
        $stmt = $con->prepare($sql);
         $stmt->execute();
         $sql = "DELETE FROM `Thesis` WHERE StudentID = $StudentID";
        $stmt = $con->prepare($sql);
         $stmt->execute();
         $sql = "DELETE FROM `Future` WHERE StudentID = $StudentID";
        $stmt = $con->prepare($sql);
         $stmt->execute();
        $sql = "DELETE FROM `Student` WHERE StudentID = $StudentID";
        $stmt = $con->prepare($sql);
         $stmt->execute();
        }
        

       }

    
        ?>
</html>