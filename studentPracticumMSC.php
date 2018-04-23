<!DOCTYPE php>
 <?php
// Start the session
session_start();
include_once 'connection.php'; 
if($_SESSION['member_status'] != 'student'){
    header("Location: index.php");
    die();
    }
        $StudentID = ($_SERVER[HTTP_QUEENSU_EMPLID]);
        $sql = "SELECT COUNT(*) as total FROM `PracticumMSC` WHERE `StudentID` = $StudentID";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result -> fetch_assoc();
        $total = $count['total'];
        $flag = FALSE;
        if ($total > 0){
            $flag = TRUE;
            $sql = "SELECT * FROM `PracticumMSC` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $facility = $row["Facility"];
            $evaluation = $row["StudentEval"];
            $OrganizationID = $row["OrganizationID"];
        }
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}// end of function
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
      <li><a  href="studentSearchMSC.php">Dashboard</a></li>     
        <li style="float:right"><a class="active" href="https://idptest.queensu.ca/idp/profile/Logout">Logout</a></li>
      </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">Add/Edit Practicum MSc</h1> </center>
  </head>

<body>
<div align="center">
<form method="post">
<fieldset>
	<legend> Practicum </legend>
	Student Number: <input type="number" name="studentNum" value="<?php echo $StudentID; ?>" required readonly='readonly'> <br><br>
	Facility:     <select name="OrganizationID">
        <option selected disabled> Choose Here</option>
        <?php
            $sql = "SELECT `OrganizationName`, `OrganizationID` FROM `Organization` WHERE 1";
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
    </select> <br><br>
	Evaluation: <br><br>
	<textarea name="evaluation" cols="100" rows="10"> <?php echo $evaluation; ?></textarea><br><br>
    <input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
</fieldset> 
<button class="btn btn-primary btn-md buttonColor" type="submit" name="submit" Visibility="visible" id="submit" method="post">Submit</button><br>
<br>
</form>
</div>
<?php
    if(isset($_POST["submit"])){
        $flag = $_POST["flaginput"];
        $OrganizationID = $_POST["OrganizationID"];
	    $studentNum = test_input($_POST["studentNum"]);
	    $evaluation = test_input($_POST["evaluation"]);
        $sql ="SELECT * FROM Organization WHERE OrganizationID = $OrganizationID";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result -> fetch_assoc();
        $facility = $row["OrganizationName"];      
        if($flag=="true"){

            $sql = "UPDATE `PracticumMSC` SET `Facility`='$facility', `StudentEval`='$evaluation', `OrganizationID`=$OrganizationID  WHERE `StudentID`=$studentNum";
            $stmt = $con->prepare($sql);
            $stmt->execute();
        header("Location: studentSearchMSC.php");  
        }
        else {
	    $sql = "INSERT INTO `PracticumMSC`(`Facility`, `StudentEval`, `StudentID`) VALUES ('$facility', '$evaluation', $studentNum)";
	    $stmt = $con->prepare($sql);
	    $stmt->execute();
        header("Location: studentSearchMSC.php");  
        }
	}


?>
</body>
</html>