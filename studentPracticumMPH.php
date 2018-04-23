<!DOCTYPE php>
 <?php
// Start the session
session_start();
include_once 'connection.php'; 
if($_SESSION['member_status'] != 'student'){
    header("Location: index.php");
    die();
    }
    $flag = FALSE;
        $StudentID = ($_SERVER[HTTP_QUEENSU_EMPLID]);
        $sql = "SELECT COUNT(*) as total FROM `Practicum` WHERE `StudentID` = $StudentID";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result -> fetch_assoc();
        $total = $count['total'];
        $flag = FALSE;
        if ($total > 0){
            $flag = true;
            $sql = "SELECT * FROM `Practicum` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $projectTitle = $row["ProjectTitle"];
            $paid = $row["Paid"];
            $OrganizationID = $row["OrganizationID"];
            $Description = $row["Description"];
            $preceptorName = $row["PreceptorName"];
            $contact = $row["Contact"];
            $DominantCompetencyCategory = $row["DominantCompetencyCategory"];
            $appliedArea1 = $row["AppliedProgramArea1"];
            $appliedArea2 = $row["AppliedProgramArea2"];
            $appliedArea3 = $row["AppliedProgramArea3"];
            $population = $row["Population"];
            $task1 = $row["Task1"];
            $task2 = $row["Task2"];
            $task3 = $row["Task3"];
            $role = $row["Role"];
}
function test_input($data,$con) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = mysqli_real_escape_string($con, $data);
    return $data;
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
      <li><a  href="studentSearchMPH.php">Dashboard</a></li>     
        <li style="float:right"><a class="active" href="https://idptest.queensu.ca/idp/profile/Logout">Logout</a></li>
      </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">Create/Edit MPH Practicum</h1> </center>

  </head>

<body>
<div align="CENTER">
<div class = "profile">
<form method="post">
<fieldset>
	<legend> Practicum</legend>
	<label> StudentID: </label><input type="number" name="StudentNum" value="<?php echo $StudentID; ?>" required> <br><br>
	<label> Project Title: </label><input type="text" name="projectTitle" value="<?php echo $projectTitle; ?>" required> <br><br>
	<label>Organization: </label>
    <select name="OrganizationID" required>
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
	<label> Paid: </label> <input type="radio" name="paid" value="Paid" <?php if($paid=='Paid'){ echo 'checked';} ?>> Yes <input type="radio" name="paid" value="Unpaid" <?php if($paid!='Paid'){ echo 'checked';} ?>> No <br> <br>
	<label>Preceptor Name: </label><input type="text" name="preceptorName" value="<?php echo $preceptorName; ?>" > <br><br>
	<label>Contact: </label><input type="text" name="contact" value="<?php echo $contact; ?>" ><br><br>
	<label>Dominant Competancy Category: </label><input type="text" pattern="[a-zA-Z ]+" name="DominantCompetencyCategory" value="<?php echo $DominantCompetencyCategory; ?>"> <br><br>
	<label>Applied Area 1: </label><input type="text" name="appliedArea1" value="<?php echo $appliedArea1; ?>"> <br><br>
	<label>Applied Area 2: </label><input type="text" name="appliedArea2" value="<?php echo $appliedArea2; ?>"> <br><br>
	<label>Applied Area 3: </label><input type="text" name="appliedArea3" value="<?php echo $appliedArea3; ?>"> <br><br>
	<label>Population: </label><input type="text" name="population" value="<?php echo $population; ?>"> <br><br>
	<label>Task 1: </label><input type="text" name="task1" value="<?php echo $task1; ?>" > <br><br>
	<label>Task 2: </label><input type="text" name="task2" value="<?php echo $task2; ?>"> <br><br>
	<label>Task 3: </label><input type="text" name="task3" value="<?php echo $task3; ?>"> <br><br>
	<label>Role: </label><input type="text" name="role" value="<?php echo $role; ?>"> <br><br>
	<label>Description: </label><br> <textarea name="Description" rows="10" cols="100"><?php echo $Description; ?> </textarea> <br> <br>
    <input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
</fieldset>
<button class="btn btn-primary btn-md buttonColor" type="submit" name="submit" Visibility="visible" id="submit" method="post">Submit</button><br><br>
</form>
</div>
<?php
	if(isset($_POST["submit"])){

        $projectTitle = test_input($_POST["projectTitle"],$con);
        $paid = $_POST["paid"];
        $flag = $_POST["flaginput"];
        $OrganizationID = $_POST["OrganizationID"];

        
        $preceptorName = test_input($_POST["preceptorName"],$con);
        
        $contact = test_input($_POST["contact"],$con);
        
        $StudentNum = test_input($_POST["StudentNum"],$con);
        $DominantCompetencyCategory = test_input($_POST["DominantCompetencyCategory"],$con);
        
        $appliedArea1 = test_input($_POST["appliedArea1"],$con);
        
        $appliedArea2 = test_input($_POST["appliedArea2"],$con);
        
        $appliedArea3 = test_input($_POST["appliedArea3"],$con);
        
        $population = test_input($_POST["population"],$con);
        
        $task1 = test_input($_POST["task1"],$con);
        
        $task2 = test_input($_POST["task2"],$con);
        
        $task3 = test_input($_POST["task3"],$con);
        
        $role = test_input($_POST["role"],$con);

        
        if ($flag=="true"){
            $sql = "UPDATE `Practicum` SET `ProjectTitle`='$projectTitle', `OrganizationID`=$OrganizationID, `Paid`='$paid', `Description`= '$Description', `PreceptorName`='$preceptorName',`Contact`='$contact', `DominantCompetencyCategory`='$DominantCompetencyCategory', `AppliedProgramArea1`='$appliedArea1', `AppliedProgramArea2`='$appliedArea2', `AppliedProgramArea3`= '$appliedArea3', `Population`='$population', `Task1`='$task1', `Task2`='$task2', `Task3`= '$task3', `Role` = '$role' WHERE `StudentID`= $StudentNum";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            header("Location: studentSearchMPH.php");  
         }   
else{
        
   		$sql = "INSERT INTO `Practicum`(`ProjectTitle`, `OrganizationID`, `Paid`, `Description`, `PreceptorName`, `Contact`, `StudentID`, `DominantCompetencyCategory`, `AppliedProgramArea1`, `AppliedProgramArea2`, `AppliedProgramArea3`, `Population`, `Task1`, `Task2`, `Task3`, `Role`) 
   		VALUES ('$projectTitle', '$OrganizationID', '$paid', '$Description', '$preceptorName', '$contact' , $StudentNum, '$DominantCompetencyCategory', '$appliedArea1', '$appliedArea2', '$appliedArea3', '$population', '$task1', '$task2', '$task3', '$role')";
   		$stmt = $con->prepare($sql);
        $stmt->execute();
        header("Location: studentSearchMPH.php");  
}
	}

?>

</body>
</html>