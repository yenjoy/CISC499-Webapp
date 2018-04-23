<!DOCTYPE php>
<?php
//start the PHP session (ensures the user is connected to the database, and the session is fresh)
session_start();
// Error checking (for internal debug purposes)
            // ini_set('display_errors', 1);
            // ini_set('display_startup_errors', 1);
            // error_reporting(E_ALL);
// Ensures the user is connected to the database
include 'connection.php'; 
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

        $StudentID = ($_SERVER[HTTP_QUEENSU_EMPLID]);
        $sql = "SELECT COUNT(*) as total FROM `Student` WHERE `StudentID` = $StudentID";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result -> fetch_assoc();
        $total = $count['total'];
        $flag = FALSE;
        $comment = "Please enter any other comments";

        // This if will be triggered only if the student is in the database.
        if ($total > 0){
            $flag = TRUE;
            $sql = "SELECT * FROM `Student` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $graduatingYear = $row['GraduatingYear'];
            $Email = $row["OtherEmail"];
            $Gender = $row["Gender"];
            $citizenship = $row["Citizenship"];
            $homeProvince = $row["homeProvince"];
            $currJobTitle = $row["CurrentJobTitle"]; 
            $currEmployer =  $row["CurrentEmployer"];
            $comment = $row["OpenComments"];

            // If for some reason the student has navigated here by accident, redirect them.
            if ($row['Program'] == "Masters in Epidemiology"){
                Header("Location: profileMSCE.php");
                die();
            }elseif ($row['Program'] == "Masters in Biostatistics") {
                Header("Location: profileMSCB.php");
                die();
            }elseif ($row['Program'] == "PHD in Epidemiology"){
                Header("Location: profilePHD.php");
                die();
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
    <link href="css/Index.css" type="text/css" rel="stylesheet">
    <img src="Assets/banner.jpg" id="header">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
     <!-- Start of Navbar definition -->
      <ul id="navbar">
      <li><a onClick="<?php if($flag==FALSE){ echo 'IsAccountCreated()';}?>" href="<?php if($flag==TRUE){ echo 'studentSearchMPH.php';}?>">Dashboard</a></li>     
        <li style="float:right"><a class="active" href="https://idptest.queensu.ca/idp/profile/Logout">Logout</a></li>
      </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">MPH Student Profile</h1> </center>
    <center> <h1><?php echo "Welcome " . ($_SERVER[HTTP_QUEENSU_GIVENNAME]) . "!"; ?> </h1> </center>

  </head>
    <body>
        <div align="CENTER">  
        <br><br><br>
        <!-- Only show this line of text on the first visit to the page -->
    <?php if($flag==false){
        echo "<p> Please ensure that you have selected the correct program before continuing. </p>";
    }
    ?>
        <br><br>
        <div class="profile"> 
        <!-- this is the profile form -->
        <form method="post" >
            <label id="program" name="program">Program: </label>
            <select <?php if($flag==true) { echo 'disabled'; } ?> onchange="location = this.options[this.selectedIndex].value;">
                <option value="profileMPH.php">MPH</option>
                <option value="profilePHD.php">PHD</option>
                <option value="profileMSCB.php">MSc Biostatistics</option>
                <option value="profileMSCE.php">MSc Epidemiology</option>
            </select>   <br> <br>
            
            
            <label id="firstName">First Name: </label>
            <input type="text"  readonly name="FName"  value="<?php echo ($_SERVER[HTTP_QUEENSU_GIVENNAME]);?>" required><br><br>
            
            <label id="lastName">Last Name: </label>
            <input type="text" readonly name="LName" value="<?php echo ($_SERVER[HTTP_QUEENSU_SURNAME]);?>" required><br><br>
            
            <label id="Student #">Student #: </label>
            <input type="text" readonly name="StudentNum"  value="<?php echo ($_SERVER[HTTP_QUEENSU_EMPLID]);?>" required><br><br>
            <label id="GraduatingYear" > Graduating Year: </label>
            <input type="number" min="0" name="GraduatingYear" value="<?php echo $graduatingYear; ?>" required><br><br>
            
         
            <label id="QueensEmail">Queen's Email: </label>
            <input type="text" name="QueensEmail" readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_NETID]);?>@queensu.ca" required><br><br>
            
            <label id="altEmail">Other Email: </label>
            <input type="email" name="altEmail" value="<?php echo $Email; ?>" ><br><br>

            
            <label id="openComments">Open Comments: </label><br>
            <textarea rows="6" cols="50" name="comments" placeholder="Please Enter any Comments"> <?php echo $comment; ?></textarea>
            
            
                <br><br>
            
                <button class='btn btn-primary btn-md buttonColor' type="submit" name="submit" >Submit</button><br><br>
        </form>
    </div>
    </body>

                <script> 
        function IsAccountCreated() {
                alert("You must create a profile first!");
        }
        </script>
    <?php

    // declare all variables as "" to eliminate undefined errors
        $OpenComments = $StudentID = $FName = $LName = $GraduatingYear = $QueensEmail = $OtherEmail = $program = "";

        if(isset($_POST["submit"])){   

        //Sanitize the input that the user has given   
            $StudentID = test_input($_POST["StudentNum"],$con);
            $FName = test_input($_POST["FName"],$con);
            $LName = test_input($_POST["LName"],$con);
            $GraduatingYear = test_input($_POST["GraduatingYear"],$con);
            $QueensEmail = test_input($_POST["QueensEmail"],$con);
            $OtherEmail = test_input($_POST["altEmail"],$con);
            //$OtherEmail = mysqli_real_escape_string($con, $OtherEmail);
            $OpenComments = test_input($_POST["comments"],$con);
            //$OpenComments = mysqli_real_escape_string($con,$OpenComments);

            $Program = "MPH";
            //if(empty($OpenComments)) {
            //    $OpenComments = '';
            //}
            // update the information if the student is already in the database
            if ($flag == TRUE){
                $sql = "UPDATE `Student` SET `GraduatingYear`= $GraduatingYear, `OtherEmail`='$OtherEmail',`OpenComments`='$OpenComments',`Program`='$Program' WHERE `StudentID`= $StudentID";
                $stmt = $con->prepare($sql);
                $stmt->execute();
   
            }
            // insert information if the student is not in the database.
            else{ 
                $sql = "INSERT INTO `Student` (`StudentID`, `FName`, `LName`, `GraduatingYear`, `QueensEmail`, `OtherEmail`, `OpenComments`, `Program`) 
                VALUES ($StudentID, '$FName', '$LName', $GraduatingYear, '$QueensEmail', '$OtherEmail', '$OpenComments', '$Program')";
                $stmt = $con->prepare($sql);
                $stmt->execute();
    
            }
            // redirect to the search page.
          echo " <script> location.replace('studentSearchMPH.php'); </script>";
        }
    ?>

</html>