<!DOCTYPE php>
<?php
//start the PHP session (ensures the user is connected to the database, and the session is fresh)
session_start();
// Error checking (for internal debug purposes)
            // ini_set('display_errors', 1);
            // ini_set('display_startup_errors', 1);
            // error_reporting(E_ALL);
// Ensures the user is connected to the database
include_once 'connection.php'; 
if($_SESSION['member_status'] != 'student'){
    // if the member isnt a student then redirect them to index so they are taken to the correct page
    header("Location: index.php");
    // kill the connection so it can be restarted on the new page
    die();
    }


// this function allows input stripping.  it takes one parameter $data which is the input into a text field
// this function is neccesary for sanitizing the input and preventing XSS and HTML injection attacks.
function test_input($data, $con) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = mysqli_real_escape_string($con, $data);
  return $data;
}// end of function


// This block of PHP gets the students infomation from the database, it first checks if the student is in the database before executing
        $StudentID = ($_SERVER[HTTP_QUEENSU_EMPLID]);
        $sql = "SELECT COUNT(*) as total FROM `Student` WHERE `StudentID` = $StudentID";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result -> fetch_assoc();
        $total = $count['total'];
        $flag = FALSE;
        $comment = "Please enter any other comments";

        // if the student is in the database this if condition will be triggered
        if ($total > 0){
            // the flag tells the following php block to use update statments instead of insert statements
            $flag = TRUE;

            $sql = "SELECT * FROM `Student` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            // fill in the users data
            $graduatingYear = $row['GraduatingYear'];
            $Email = $row["OtherEmail"];
            $Gender = $row["Gender"];
            $citizenship = $row["Citizenship"];
            $homeProvince = $row["homeProvince"];
            $currJobTitle = $row["CurrentJobTitle"]; 
            $currEmployer =  $row["CurrentEmployer"];
            $comment = $row["OpenComments"];

            // if the student is on the wrong profile page for some reason redirect them.

            if ($row['Program'] == "Masters in Biostatistics"){
                Header("Location: profileMSCB.php");
                die();
            }elseif ($row['Program'] == "PHD in Epidemiology") {
                Header("Location: profilePHD.php");
                die();
            }elseif ($row['Program'] == "MPH") {
                Header("Location: profileMPH.php");
                die();
            }
// enter the information from the education table into the sections
            $sql = "SELECT * FROM `Education` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();

            $startDate = $row["StartDate"];
            $endDate = $row["EndDate"];
            $UGProgram = $row["UGProgram"];

// enter the information from the funding table into the sections
            $sql = "SELECT * FROM `Funding` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $num = $result ->num_rows;
        
            $Amount = $row["Amount"];
            $Source = $row["Source"];
        if ($num >=1){
            $funFlag = TRUE; // this is a flag that will help the php block below decide wheter to use an update or insert statement
        }
        else{
            $funFlag = FALSE; // if the flag is false then it will use an insert statement

        }
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
   <!-- This is the navbar displayed at the top of the screen -->
    <ul id="navbar">
       <li><a onClick="<?php if($flag==FALSE){ echo 'IsAccountCreated()';}?>" href="<?php if($flag==TRUE){ echo 'studentSearchPHD.php';}?>">Dashboard</a></li>      
        <li><a href="studentCreateThesis.php">Edit Thesis Information</a></li>
        <li style="float:right"><a class="active" href="https://idptest.queensu.ca/idp/profile/Logout">Logout</a></li>
    </ul>
      <br><br>
      <!-- this is the welcome message displayed below the nav bar -->
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">Masters of Science Epidemiology Student Profile</h1> </center>
    <center> <h1><?php echo "Welcome " . ($_SERVER[HTTP_QUEENSU_GIVENNAME]) . "!"; ?> </h1> </center>
  </head>
  <!-- this script serves to check if the account has been created before redirecting to the dashboard -->
    <script> 
        function IsAccountCreated() {
                alert("You must create a profile first!");
        }
    </script>
  <body>
    
    <div class="profile">  
        <br>
        <!-- only show this on the first visit to this page -->
    <?php if($flag==false){
        echo "<p> Please ensure that you have selected the correct program before continuing. </p>";
    }
    ?>
        <br>
        <!-- this is the form to enter information into -->
        <form method="POST">
            <fieldset>
            <legend> Student Information </legend>
                <label id="program" >Program: </label>
                    <select onchange="location = this.options[this.selectedIndex].value;" <?php if($flag){ echo "disabled";} ?>>
                        <option value="#">MSc Epidemiology</option>
                        <option value="profileMPH.php">MPH</option>
                        <option value="profileMSCB.php">MSC Biostatistics</option>
                        <option value="profilePHD.php">PHD Epidemiology</option>
                    </select><br>    
                <label id="firstName">First Name: </label>
                <input type="text"  name="FName"readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_GIVENNAME]);?>"/>
                <br>
                <label id="lastName">Last Name: </label>
                <input type="text" name="LName"readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_SURNAME]);?>"/>
                <br>
                <label id="Student #">Student #: </label>
                <input type="text" name="studentNum" readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_EMPLID]);?>"/>
                <br>
                <label id="GraduatingYear"> Graduating Year: </label>
                <input type="number" min="0" pattern="[0-9 ]+" name="graduatingYear" value="<?php echo $graduatingYear; ?>"/>
                <br> 
                <label id="QueensEmail">Queen's Email: </label>
                <input type="text" title="Enter only Letters Numbers . @ `" pattern="[a-zA-Z0-9.@` ]+" name="Qemail" readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_NETID]);?>@queensu.ca"/>
                <br>
                <label id="altEmail">Other Email: </label>
                <input type="text" name="Email" value="<?php echo $Email; ?>"  />
                <br>
            </fieldset>
            <br><br>
            <fieldset>
            <legend> Undergrad Information </legend>
           
                <label id="startDate" > Start Date: </label>
                <input type="date" title="yyyy-mm-dd" pattern="[0-9- ]{10}" name="startDate" value="<?php echo $startDate; ?>"/> (yyyy-mm-dd)
                <br>
                <label id="endDate" > End Date: </label>
                <input type="date" title="yyyy-mm-dd" pattern="[0-9- ]{10}" name="endDate" value="<?php echo $endDate; ?>"/> (yyyy-mm-dd)
                <br>
                <label id="UGProgram" > Undergrad Program: </label>
                <input type="text" name="UGProgram" value="<?php echo $UGProgram; ?>"/>
                <br>
            </fieldset>
            <br><br>
            <fieldset>
                
                <legend> Professional Information</legend>
                <label id="currJobTitle" > Current Job title</label>
                <input type="text" " name="currJobTitle" value="<?php echo $currJobTitle; ?>"/>
                <br>
                <label id="currEmployer" > Current Employer: </label>
                <input type="text" " name="currEmployer" value="<?php echo $currEmployer; ?>"/>
                <br>


            </fieldset>
            <br><br>
            <fieldset>
            <legend> Additonal Background Information </legend>
            
                <label id="gender" > Gender: </label>
                <select name="Gender">
                    <?php
                        if ($Gender = 'Male'){
                            echo '<option value=""> --- </option>';
                            echo '<option value="Male" selected> Male </option>';
                            echo '<option value="Female"> Female </option>';
                            echo '<option value="Other"> Other </option>';
                        }elseif ($Gender = 'Female') {
                            echo '<option value=""> --- </option>';
                            echo '<option value="Male"> Male </option>';
                            echo '<option value="Female" selected> Female </option>';
                            echo '<option value="Other"> Other </option>';
                        }elseif ($Gender = 'Other') {
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

                    ?>

                </select> 
                <br>
                
                <label id="citizenship" > Citizenship: </label>
                <input type="text" " name="citizenship" value="<?php echo $citizenship; ?>"/>
                <br>
                
                <label id="homeProvince" > Home Province: </label>
                <input type="text" " name="homeProvince" value="<?php echo $homeProvince; ?>"/>
                <br>

            </fieldset>
            <br><br>
            <fieldset>
            <legend> Funding </legend>
            
                <label id="fundingAmount" >Funding Amount: </label>
                <input type="number" title="Enter only numbers" pattern="[0-9 ]+" name="fundingAmount" value="<?php echo $Amount; ?>"/>
                <br>
                
                <label id="fundingSource" >Funding Source: </label>
                <input type="text" name="fundingSource" value="<?php echo $Source; ?>"/>
                <br>

            </fieldset>
            <br><br>
            <fieldset>
                <label id="openComments">Open Comments: </label>
                <br>
        
                 <textarea name="comments" rows="6" cols="50"> <?php echo $comment; ?> </textarea>
            </fieldset>
        <br>
        
        <button class="btn btn-primary btn-md buttonColor" align="CENTER" type="submit" name="Submit" Visibility="visible" id="Submit" method="post">Submit</button>
        <br><br>
    </form>
    </div>

    <!-- end of HTML -->

    <?php

            $GraduatingYear = $Email = $Gender = $Citizenship =  $homeProvince =  "";
            $StudentID = $FName = $LName = $CurrentEmployer = $CurrentJobTitle = $QueensEmail = $OtherEmail = $OpenComments = "";
            $Program = $startDate = $endDate = $UGProgram = $fundingAmount = $fundingSource = "";
// define variables and set to empty values

        if(isset($_POST["Submit"])){

            // Sanitize the input the student has given us

            $StudentID = test_input($_POST["studentNum"], $con);
            $FName = test_input($_POST["FName"], $con);
            $LName = test_input($_POST["LName"], $con);
            $GraduatingYear = test_input($_POST["graduatingYear"], $con);
            $CurrentEmployer = test_input($_POST["currEmployer"], $con);
            $CurrentJobTitle = test_input($_POST["currJobTitle"], $con);
            $QueensEmail = test_input($_POST["Qemail"], $con);
            $OtherEmail = test_input($_POST["Email"], $con);
            $OpenComments = test_input($_POST["comments"], $con);
            $Program = "Masters in Epidemiology";

            $startDate = test_input($_POST["startDate"], $con);
            $endDate = test_input($_POST["endDate"], $con);
            $UGProgram = test_input($_POST["UGProgram"], $con);

            $Gender = test_input($_POST["Gender"], $con);
            $Citizenship = test_input($_POST["citizenship"], $con);
            $homeProvince = test_input($_POST["homeProvince"], $con);

            $fundingAmount = test_input($_POST["fundingAmount"], $con);
            $fundingSource = test_input($_POST["fundingSource"], $con);


            // if the user is in the database, then update their information, otherwise insert it.
            if ($flag == TRUE){
                $sql = "UPDATE `Student` SET `GraduatingYear`= $GraduatingYear,`CurrentEmployer`='$CurrentEmployer',`CurrentJobTitle`='$CurrentJobTitle', `OtherEmail`='$OtherEmail',`OpenComments`='$OpenComments',`Program`='$Program',`Gender`='$Gender',`Citizenship`='$Citizenship',`homeProvince`='$homeProvince' WHERE `StudentID`= $StudentID";

                $stmt = $con->prepare($sql);
                $stmt->execute();

                $sql = "UPDATE `Education` SET`StartDate`=STR_TO_DATE('$startDate', '%Y-%m-%d'),`EndDate`=STR_TO_DATE('$endDate', '%Y-%m-%d'),`UGProgram`='$UGProgram' WHERE `StudentID`= $StudentID";

            

                $stmt = $con->prepare($sql);
                $stmt->execute();

            if($funFlag){   // Fun flag is true
                $sql = "UPDATE `Funding` SET `Amount`=$fundingAmount,`Source`='$fundingSource' WHERE `StudentID`= $StudentID";
            }
            if($funFlag == FALSE) // Fun flag is false
            {
                $sql ="INSERT INTO `Funding`(`StudentID`, `Amount`, `Source`) VALUES ($StudentID, $fundingAmount, '$fundingSource')";
            }


                $stmt = $con->prepare($sql);
                $stmt->execute();
            }
            else{ 


                $sql = "INSERT INTO `Student` (`StudentID`, `FName`, `LName`, `GraduatingYear`, `CurrentEmployer`, `CurrentJobTitle`, `QueensEmail`, `OtherEmail`, `OpenComments`, `Program`, `Gender`, `Citizenship`, `homeProvince`) 
                VALUES ($StudentID, '$FName', '$LName', $GraduatingYear, '$CurrentEmployer', '$CurrentJobTitle', '$QueensEmail', '$OtherEmail', '$OpenComments', '$Program', '$Gender', '$Citizenship', '$homeProvince')";
                $stmt = $con->prepare($sql);
                $stmt->execute();

                $sql = "INSERT INTO `Education`(`StudentID`, `StartDate`, `EndDate`, `UGProgram`) VALUES ($StudentID, STR_TO_DATE('$startDate', '%Y-%m-%d'), STR_TO_DATE('$endDate', '%Y-%m-%d'), '$UGProgram')";
                $stmt = $con->prepare($sql);
                $stmt->execute();

                $sql = "INSERT INTO `Funding`(`StudentID`, `Amount`, `Source`) VALUES ($StudentID, $fundingAmount, '$fundingSource')";
                $stmt = $con->prepare($sql);
                $stmt->execute();

            }
            // redirect to the student search page.
           echo " <script> location.replace('studentSearchPHD.php'); </script>";
        }

    ?>
    </body>
</html>