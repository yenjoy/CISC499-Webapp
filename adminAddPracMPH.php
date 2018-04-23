<!DOCTYPE php>
 <?php
 /*
    Page for admins to create or edit a practicum for MPH students
    */
// Start the session
session_start();
include_once 'connection.php'; 
//Ensure the user is admin
if($_SESSION['member_status'] != 'admin'){
    header("Location: index.php");
    die();
    }
    $flag = FALSE;
    //Check if we are editing a practicum rather than creating one
    if(isset($_POST["practicumedit"])){
        $StudentID = $_POST["practicumrow"];
        $flag = TRUE;

    }
    //Load the data if we are editing 
        if($flag==TRUE){
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
    <center> <h1 class="headerFont">Create MPH Practicum</h1> </center>

  </head>

<body>
<div class="profile">
<br><br>
<form method="post">
        <input type='hidden' name="studentnumdelete" value="<?php echo $StudentID; ?>">
        <input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
         <br><br>
        </form>
<form method="post">
<fieldset>
	<legend> Practicum Profile</legend>
	<label > Student #: </label> <input type="number" min="0" pattern="[0-9 ]+" title="Only Numbers" name="StudentNum" value="<?php echo $StudentID; ?>" required> <br><br>
	<label > Practicum Title" </label> <input type="text" name="projectTitle"value="<?php echo $projectTitle; ?>" required> <br><br>
	<label > Organization: </label> 
    <select name="OrganizationID" required>
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
    </select> 
	<br>
	<br>
	<br>

	<label> Paid: </label>
	<input type="radio" name="paid" value="Paid" <?php echo ($paid=='Paid')?'checked':'' ?>>
	<label> Unpaid: </label>
	<input type="radio" name="paid" value="Unpaid" <?php echo ($paid=='Unpaid')?'checked':'' ?>>

	<label > Preceptor Name: </label>  <input type="text" name="preceptorName" value="<?php echo $preceptorName; ?>" > <br><br>
	<label > Preceptor Email: </label>  <input type="text" name="contact" value="<?php echo $contact; ?>" ><br><br>
	<label > Predominant Public Health Competency:</label>  
	<select required name =  "DominantCompetencyCategory">
		<option value="Assessment and analysis">Assessment and analysis</option>
		<option value="Communication">Communication</option>
		<option value="Diversity and inclusiveness">Diversity and inclusiveness</option>
		<option value="Leadership">Leadership </option>
		<option value="Partnerships, collaboration, and advocady">Partnerships, collaboration, and advocady</option>
		<option value="Policy and program planning, implementation and evaluation">Policy and program planning, implementation and evaluation</option>
		<option value="Public health sciences">Public health sciences </option>
	</select>	
	<label > Applied Program Area 1: </label>  
	<select required name =  "appliedArea1">
		<option value = "Addictions">Addictions </option>
		<option value = "Chronic disease prevention">Chronic disease prevention </option>
		<option value = "Clinical public health">Clinical public health </option>
		<option value = "Determinants of health">Determinants of health </option>
		<option value = "Emergency preparedness">Emergency preparedness </option>
		<option value = "Environmental health">Environmental health </option>
		<option value = "Family health">Family health </option>
		<option value = "General health/wellbeing">General health/wellbeing </option>
		<option value = "Health protection (food safety, water safety, tobacco control)">Health protection (food safety, water safety, tobacco control)</option>
		<option value = "Infectious diseases">Infectious diseases </option>
		<option value = "Injury prevention">Injury prevention </option>
		<option value = "Maternal and child health">Matenal and child health </option>
		<option value = "Mental health">Mental health </option>
		<option value = "Occupational health">Occupational health </option>
		<option value = "Oral health">Oral health </option>
		<option value = "School health">School health </option>
		<option value = "Substance misuse">Addictions </option>
		<option value = "Other">Other </option>
	</select>
	<label > Applied Program Area 2: </label>
		<select required name = "appliedArea2">
		<option value = "Addictions">Addictions </option>
		<option value = "Chronic disease prevention">Chronic disease prevention </option>
		<option value = "Clinical public health">Clinical public health </option>
		<option value = "Determinants of health">Determinants of health </option>
		<option value = "Emergency preparedness">Emergency preparedness </option>
		<option value = "Environmental health">Environmental health </option>
		<option value = "Family health">Family health </option>
		<option value = "General health/wellbeing">General health/wellbeing </option>
		<option value = "Health protection (food safety, water safety, tobacco control)">Health protection (food safety, water safety, tobacco control)</option>
		<option value = "Infectious diseases">Infectious diseases </option>
		<option value = "Injury prevention">Injury prevention </option>
		<option value = "Maternal and child health">Matenal and child health </option>
		<option value = "Mental health">Mental health </option>
		<option value = "Occupational health">Occupational health </option>
		<option value = "Oral health">Oral health </option>
		<option value = "School health">School health </option>
		<option value = "Substance misuse">Addictions </option>
		<option value = "Other">Other </option>
	</select>
	<label > Applied Program Area 3: </label>
		<select required name = "appliedArea3">
		<option value = "Addictions">Addictions </option>
		<option value = "Chronic disease prevention">Chronic disease prevention </option>
		<option value = "Clinical public health">Clinical public health </option>
		<option value = "Determinants of health">Determinants of health </option>
		<option value = "Emergency preparedness">Emergency preparedness </option>
		<option value = "Environmental health">Environmental health </option>
		<option value = "Family health">Family health </option>
		<option value = "General health/wellbeing">General health/wellbeing </option>
		<option value = "Health protection (food safety, water safety, tobacco control)">Health protection (food safety, water safety, tobacco control)</option>
		<option value = "Infectious diseases">Infectious diseases </option>
		<option value = "Injury prevention">Injury prevention </option>
		<option value = "Maternal and child health">Matenal and child health </option>
		<option value = "Mental health">Mental health </option>
		<option value = "Occupational health">Occupational health </option>
		<option value = "Oral health">Oral health </option>
		<option value = "School health">School health </option>
		<option value = "Substance misuse">Addictions </option>
		<option value = "Other">Other </option>
		</select>
	
	<label > Population: </label>  
		<select required name = "population">
		<option value = "Adults">Adults </option>
		<option value = "Children and youth">Children and youth </option>
		<option value = "General public">General public </option>
		<option value = "Health care professionals">Health care professionals </option>
		<option value = "Immigrants">Immigrants </option>
		<option value = "Indigenous peoples">Indigenous peoples </option>
		<option value = "International">International</option>
		<option value = "LGBTQ+">LGBTQ+</option>
		<option value = "Marginalized/vulnerable">Marginalized/vulnerable</option>
		<option value = "Other stakeholders">Other stakeholders</option>
		<option value = "People with disabilities">People with disabilities </option>
		<option value = "Rural or remote">Rural or remote</option>
		<option value = "Seniors">Seniors</option>
		<option value = "Sex (male/female/other)">Sex(male/female/other) </option>
		<option value = "Urban">Urban</option>
		<option value = "Young adults">Young adults</option>
		<option value = "Veterans">Veterans</option>
		<option value = "Other">Other</option>
		</select>
	
	<label > Task 1: </label>  
		<select required name = "task1">
		<option value = "Contact with partner agencies/stakeholders">Contact with partnet agencies/stakeholders</option>
		<option value = "Data collection">Data collection</option>
		<option value = "Direct contact with clients">Direct contact with client </option>
		<option value = "Health education or training">Health education or training</option>
		<option value = "Health promotion">Health promotion </option>
		<option value = "Knowlege translation or exchange">Knowlege translation or exchange </option>
		<option value = "Literature review/environmental scan">Literature review/environmental scan</option>
		<option value = "Needs assessment">Needs assessment</option>
		<option value = "Organizational planning/management/evaluation">Organizational planning/management/evaluation</option>
		<option value = "Policy development">Policy development</option>
		<option value = "Program planning, implementation, evaluation">Program planning, implementation, evaluation </option>
		<option value = "Qualitative methods">Qualitative methods</option>
		<option value = "Report writing or editing">Report writing or editing </option>
		<option value = "Social marketing">Social marketing </option>
		<option value = "Statistical analysis">Statistical marketing </option>
		<option value = "Surveillance">Surveillance</option>
		<option value = "Survey development">Survey development</option>
		<option value = "Other">Other </option>
	</select>

	<label> Task 2: </label> 
		<select required name = "task2">
		<option value = "Contact with partner agencies/stakeholders">Contact with partnet agencies/stakeholders</option>
		<option value = "Data collection">Data collection</option>
		<option value = "Direct contact with clients">Direct contact with client </option>
		<option value = "Health education or training">Health education or training</option>
		<option value = "Health promotion">Health promotion </option>
		<option value = "Knowlege translation or exchange">Knowlege translation or exchange </option>
		<option value = "Literature review/environmental scan">Literature review/environmental scan</option>
		<option value = "Needs assessment">Needs assessment</option>
		<option value = "Organizational planning/management/evaluation">Organizational planning/management/evaluation</option>
		<option value = "Policy development">Policy development</option>
		<option value = "Program planning, implementation, evaluation">Program planning, implementation, evaluation </option>
		<option value = "Qualitative methods">Qualitative methods</option>
		<option value = "Report writing or editing">Report writing or editing </option>
		<option value = "Social marketing">Social marketing </option>
		<option value = "Statistical analysis">Statistical marketing </option>
		<option value = "Surveillance">Surveillance</option>
		<option value = "Survey development">Survey development</option>
		<option value = "Other">Other </option>
	</select>

	<label> Task 3: </label>
		<select required name = "task3">
		<option value = "Contact with partner agencies/stakeholders">Contact with partnet agencies/stakeholders</option>
		<option value = "Data collection">Data collection</option>
		<option value = "Direct contact with clients">Direct contact with client </option>
		<option value = "Health education or training">Health education or training</option>
		<option value = "Health promotion">Health promotion </option>
		<option value = "Knowlege translation or exchange">Knowlege translation or exchange </option>
		<option value = "Literature review/environmental scan">Literature review/environmental scan</option>
		<option value = "Needs assessment">Needs assessment</option>
		<option value = "Organizational planning/management/evaluation">Organizational planning/management/evaluation</option>
		<option value = "Policy development">Policy development</option>
		<option value = "Program planning, implementation, evaluation">Program planning, implementation, evaluation </option>
		<option value = "Qualitative methods">Qualitative methods</option>
		<option value = "Report writing or editing">Report writing or editing </option>
		<option value = "Social marketing">Social marketing </option>
		<option value = "Statistical analysis">Statistical marketing </option>
		<option value = "Surveillance">Surveillance</option>
		<option value = "Survey development">Survey development</option>
		<option value = "Other">Other </option>
	</select>
		
	<label > Job Title: </label> 
		<select required name = "role">
		<option value = "Community Health Worker"> Community Health Worker </option>
		<option value = "Health Promoter"> Health Promoter </option>
		<option value = "Program Evaluator"> Program Evaluator </option>
		<option value = "Program Planner"> Program Planner </option>
		<option value = "Project Lead"> Project Lead</option>
		<option value = "Policy Analyst"> Policy Analyst </option>
		<option value = "Research Assistant"> Research Assistant </option>
		<option value = "Other"> Other </option>
	</select>

    <label > Practicum Project(s) Description</label>  <br> <textarea name="Description" rows="10" cols="100"><?php echo $Description; ?> </textarea> <br> <br>
    <input type='hidden' name="flaginput" value="<?php if($flag==TRUE){ echo 'true';} else{ echo 'false';}?>">
</fieldset>
<button class="btn btn-primary btn-md buttonColor" type="submit" name="submit" Visibility="visible" id="submit" method="post">Submit</button><br><br>
</form>
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

//Check for form submission
	if(isset($_POST["submit"])){

        $projectTitle = $_POST["projectTitle"];
        $paid = $_POST["paid"];
        $flag = $_POST["flaginput"];
        $OrganizationID = $_POST["OrganizationID"];
        $Description = $_POST["Description"];
        $Description = verify_input($Description, $con);
        $preceptorName = $_POST["preceptorName"];
        $contact = $_POST["contact"];
        $StudentNum = $_POST["StudentNum"];
        $DominantCompetencyCategory = $_POST["DominantCompetencyCategory"];
        $appliedArea1 = $_POST["appliedArea1"];
        $appliedArea2 = $_POST["appliedArea2"];
        $appliedArea3 = $_POST["appliedArea3"];
        $population = $_POST["population"];
        $task1 = $_POST["task1"];
        $task2 = $_POST["task2"];
        $task3 = $_POST["task3"];
        $role = $_POST["role"];

        //Insert a new practicum
   		$sql = "INSERT INTO `Practicum`(`ProjectTitle`, `OrganizationID`, `Paid`, `Description`, `PreceptorName`, `Contact`, `StudentID`, `DominantCompetencyCategory`, `AppliedProgramArea1`, `AppliedProgramArea2`, `AppliedProgramArea3`, `Population`, `Task1`, `Task2`, `Task3`, `Role`) 
   		VALUES ('$projectTitle', '$OrganizationID', '$paid', '$Description', '$preceptorName', '$contact' , '$StudentNum', '$DominantCompetencyCategory', '$appliedArea1', '$appliedArea2', '$appliedArea3', '$population', '$task1', '$task2', '$task3', '$role')";
                if($stmt = $con->prepare($sql)){
                $stmt->execute();
		echo "<script> alert('Sucessfully added Practicum'); </script>";

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
    //Deleting a practicum
       if(isset($_POST["delete"])){
        $StudentID = $_POST["studentnumdelete"];
        $flag = $_POST["flaginput"];
        if($flag=="true"){
        $sql = "DELETE FROM `Practicum` WHERE StudentID = $StudentID";
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