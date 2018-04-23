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


// This block of PHP checks if the student is already in the database and then pulls in the information from the database about
// that student.

        $StudentID = ($_SERVER[HTTP_QUEENSU_EMPLID]);
        $sql = "SELECT COUNT(*) as total FROM `Student` WHERE `StudentID` = $StudentID";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result -> fetch_assoc();
        $total = $count['total'];
        $flag = FALSE;
        $comment = "Please enter any other comments";
        // If the student is in the database, then this if will be triggered
        if ($total > 0){
            $flag = TRUE;
            $sql = "SELECT * FROM `Student` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            
            //Set the information in the rows to what they are in the database.

            $graduatingYear = $row['GraduatingYear'];
            $Email = $row["OtherEmail"];
            $Gender = $row["Gender"];
            $citizenship = $row["Citizenship"];
            $homeProvince = $row["homeProvince"];
            $currJobTitle = $row["CurrentJobTitle"]; 
            $currEmployer =  $row["CurrentEmployer"];
            $comment = $row["OpenComments"];

            // if the student is in one of the other 3 programs, and html injected themselves to this page, redirect them to
            //the index page.
            if ($row['Program'] == "Masters in Epidemiology"){
                Header("Location: profileMSCE.php");
                die();
            }elseif ($row['Program'] == "Masters in Biostatistics") {
                Header("Location: profileMSCB.php");
                die();
            }elseif ($row['Program'] == "MPH") {
                Header("Location: profileMPH.php");
                die();
            }
            // fill in the information from the education table
            $sql = "SELECT * FROM `Education` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $startDate = $row["StartDate"];
            $endDate = $row["EndDate"];
            $UGProgram = $row["UGProgram"];

            // fill in the information from the education table
            $sql = "SELECT * FROM `Funding` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $Amount = $row["Amount"];
            $Source = $row["Source"];
            $num = $result ->num_rows;
        if ($num >=1){
            $funFlag = TRUE; // this is a flag that will help the php block below decide wheter to use an update or insert statement
        }// end num if
        else{
            $funFlag = FALSE; // if the flag is false then it will use an insert statement

        }//end else

    }//end total if 
    // end of PHP block
    ?>
<html>
<!-- start of header -->
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
      <li><a onClick="<?php if($flag==FALSE){ echo 'IsAccountCreated()';}?>" href="<?php if($flag==TRUE){ echo 'studentSearchMSC.php';}?>">Dashboard</a></li>     
        <li style="float:right"><a class="active" href="https://idptest.queensu.ca/idp/profile/Logout">Logout</a></li>
      </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">PhD Student Profile</h1> </center>
    <center> <h1><?php echo "Welcome " . ($_SERVER[HTTP_QUEENSU_GIVENNAME]) . "!"; ?> </h1> </center>

  </head>
  <!-- end of header -->
    <body>
     <div class="profile"> 
<br>
<!-- only show this message on the first visit to this page -->
    <?php if($flag==false){
        echo "<p> Please ensure that you have selected the correct program before continuing. </p>";
    }
    ?>
        <br><br>
        <!-- this is the form for the user input -->
        <form method="post">
        <label id="program">Program: </label>
        <select onchange="location = this.options[this.selectedIndex].value;" <?php if($flag) { echo 'disabled'; } ?> >
       
        <option value="#">PhD Epidemiology</option>
        <option value="profileMPH.php">MPH</option>
        <option value="profileMSCE.php">MSC Epidemiology</option>
        <option value="profileMSCB.php">MSC Biostatistics</option>
        </select>    <br><br>
        <h4 class="headerfont boldFont">General Information</h4> <br>
        <label id="firstName">First Name: </label>
        <input type="text" name="FName" readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_GIVENNAME]);?>"/><br><br>

        <label id="lastName">Last Name: </label>
        <input type="text" name="LName" readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_SURNAME]);?>"/><br><br>

        <label id="netID">Net ID: </label>
        <input type="text" readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_NETID]);?>" /><br><br>

        <label id="Student #">Student #: </label>
        <input type="text" name="StudentNum" readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_EMPLID]);?>"/><br><br>

        <label id="GraduatingYear" > Graduating Year: </label>
        <input type="number" min="0" name="GraduatingYear" value="<?php echo $graduatingYear;?>" required><br><br>

        <label id="QueensEmail">Queen's Email: </label>
        <input type="text"  name="QueensEmail" readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_NETID]);?>@queensu.ca" required><br><br>

        <label id="altEmail">Other Email: </label>
            <input type="email"  name="altEmail" value="<?php echo $Email;?>" ><br><br>
            <div style='margin-right: 110px;'>
        <label id="gender" > Gender: </label>
        <select style="width: 100px;"  name="Gender"><?php
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
        </div>
                <label id="citizenship" > Citizenship: </label>
                <input type="text" name="citizenship" value="<?php echo $citizenship; ?>"/> <br><br>
                
                <label id="homeProvince" > Home Province: </label>
                <input type="text" name="homeProvince" value="<?php echo $homeProvince; ?>"/> <br><br>


        <h4 class="headerfont boldFont">Undergrad Information</h4> <br>
        <label id="startDate" > Start Date: </label>
        <input type="date" title="yyyy-mm-dd" pattern="[0-9-]{10}"   name="startDate" value="<?php echo $startDate; ?>"/> (yyyy-mm-dd)<br><br>

        <label id="endDate" > End Date: </label>
        <input type="date" title="yyyy-mm-dd" pattern="[0-9-]{10}"  name="endDate" value="<?php echo $endDate; ?>"/> (yyyy-mm-dd)<br><br>

        <label id="UGProgram" > Undergrad Program: </label>
        <input type="text" "  name="UGProgram" value="<?php echo $UGProgram; ?>"/>
        <br><br>


        <h4 class="headerfont boldFont">Funding Information</h4> <br>
                <label id="fundingAmount" >Funding Amount: </label>
                <input type="number" name="fundingAmount" value="<?php echo $Amount; ?>"/> <br><br>
                
                <label id="fundingSource" >Funding Source: </label>
                <input type="text" name="fundingSource" value="<?php echo $Source; ?>"/><br><br><br>

                <label id="openComments">Open Comments: </label><br>
                <textarea rows="6" cols="50" name="comments" placeholder="Please Enter any Comments"> <?php echo $comment; ?></textarea><br><br>

        <button class='btn btn-primary btn-md buttonColor' type="submit" name="submit" >Submit</button><br><br>
        </form>           
        </div>
    </body>
    <!-- this script ensures the profile is created before the user can navigate to the dashboard -->
    <script> 
        function IsAccountCreated() {
                alert("You must create a profile first!");
        }
    </script>

   <?php

// set all of the variables to "" (to prevent against undefined variables)

   $StudentID = 
            $FName = $LName = $GraduatingYear = $QueensEmail = $OtherEmail = $OpenComments = $Program =  $startDate =  $endDate =
            $UGProgram = $Gender = $Citizenship = $homeProvince =  $fundingAmount = $fundingSource = "";
        
        // when the search button is clicked this if will trigger
        if(isset($_POST["submit"])){
            // set all these variables with the data in the input fields. First clense the input to prevent against XSS
            // and html injection
            $StudentID = test_input($_POST["StudentNum"], $con);
            $FName = test_input($_POST["FName"], $con);
            $LName = test_input($_POST["LName"], $con);
            $GraduatingYear = test_input($_POST["GraduatingYear"], $con);
            $QueensEmail = test_input($_POST["QueensEmail"], $con);
            $OtherEmail = test_input($_POST["altEmail"], $con);
            $OpenComments = test_input($_POST["comments"], $con);
            $Program = "PHD in Epidemiology";
            $startDate = test_input($_POST["startDate"], $con);
            $endDate = test_input($_POST["endDate"], $con);
            $UGProgram = test_input($_POST["UGProgram"], $con);
            $Gender = test_input($_POST["Gender"], $con);
            $Citizenship = test_input($_POST["citizenship"], $con);
            $homeProvince = test_input($_POST["homeProvince"], $con);
            $fundingAmount = test_input($_POST["fundingAmount"], $con);
            $fundingSource = test_input($_POST["fundingSource"], $con);

            // if the user is in the database use update statements, otherwise use insert statements.
            if ($flag == TRUE){
                $sql = "UPDATE `Student` SET `GraduatingYear`= $GraduatingYear, `OtherEmail`='$OtherEmail',`OpenComments`='$OpenComments',`Program`='$Program',`Gender`='$Gender',`Citizenship`='$Citizenship',`homeProvince`='$homeProvince' WHERE `StudentID`= $StudentID";
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
                $sql = "INSERT INTO `Student` (`StudentID`, `FName`, `LName`, `GraduatingYear`, `QueensEmail`, `OtherEmail`, `OpenComments`, `Program`, `Gender`, `Citizenship`, `homeProvince`) 
                VALUES ($StudentID, '$FName', '$LName', $GraduatingYear, '$QueensEmail', '$OtherEmail', '$OpenComments', '$Program', '$Gender', '$Citizenship', '$homeProvince')";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                $sql = "INSERT INTO `Education`(`StudentID`, `StartDate`, `EndDate`, `UGProgram`) VALUES ($StudentID, STR_TO_DATE('$startDate', '%Y-%m-%d'), STR_TO_DATE('$endDate', '%Y-%m-%d'), '$UGProgram')";
                $stmt = $con->prepare($sql);
                $stmt->execute();
                $sql = "INSERT INTO `Funding`(`StudentID`, `Amount`, `Source`) VALUES ($StudentID, $fundingAmount, '$fundingSource')";
                $stmt = $con->prepare($sql);
                $stmt->execute();
            }
             
            echo " <script> location.replace('studentSearchPHD.php'); </script>";
       }
    ?>
</html>