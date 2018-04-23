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
	if(isset($_POST["PassOnID"])){
        $StudentID = $_POST["PassOnID"];
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
    <center> <h1 class="headerFont">Edit MPH Practicum</h1> </center>

  </head>

<body>
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
	<legend> Practicum Profile</legend>
	<label > Student #: </label> <input type="number" min="0" pattern="[0-9 ]+" title="Only Numbers" name="StudentNum" value="<?php echo $StudentID; ?>" required> <br><br>
	<label > Practicum Title: </label> <input type="text" name="projectTitle"value="<?php echo $projectTitle; ?>" required> <br><br>
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
	<label > Predominant Public Health Competency: </label> 
	<select required name = "DominantCompetencyCategory">
	<option value="Assessment and analysis"<?php if ($DominantCompetencyCategory== 'Assessment and analysis') 
	echo 'selected="selected"'; ?>>Assessment and analysis</option>
	<option value="Communication"<?php if ($DominantCompetencyCategory== 'Communication') 
	echo 'selected="selected"'; ?>>Communication</option>
	<option value="Diversity and inclusiveness"<?php if ($DominantCompetencyCategory== 'Diversity and inclusiveness') 
	echo 'selected="selected"'; ?>>Diversity and inclusiveness</option>
	<option value="Leadership"<?php if ($DominantCompetencyCategory== 'Leadership') 
	echo 'selected="selected"'; ?>>Leadership</option>
	<option value="Partnerships, collaboration, and advocady"<?php if ($DominantCompetencyCategory== 'Partnerships, collaboration, and advocady') 
	echo 'selected="selected"'; ?>>Partnerships, collaboration, and advocady</option>
	<option value="Policy and program planning, implementation and evaluation"<?php if ($DominantCompetencyCategory== 'Policy and program planning, implementation and evaluation') 
	echo 'selected="selected"'; ?>>Policy and program planning, implementation and evaluation</option>
	<option value="Public health sciences"<?php if ($DominantCompetencyCategory== 'Public health sciences') 
	echo 'selected="selected"'; ?>>Public health sciences</option>
	</select>
	
	<label > Applied Program Area 1: </label> 
	<select required name = "appliedArea1">
	<option value="Addictions"<?php if ($appliedArea1== 'Addictions') 
	echo 'selected="selected"'; ?>>Addictions</option>
	<option value="Chronic disease prevention"<?php if ($appliedArea1== 'Chronic disease prevention') 
	echo 'selected="selected"'; ?>>Chronic disease prevention</option>
	<option value="Clinical public health"<?php if ($appliedArea1== 'Clinical public health') 
	echo 'selected="selected"'; ?>>Clinical public health</option>
	<option value="Determinants of health"<?php if ($appliedArea1== 'Determinants of health') 
	echo 'selected="selected"'; ?>>Determinants of health</option>
	<option value="Emergency preparedness"<?php if ($appliedArea1== 'Emergency preparedness') 
	echo 'selected="selected"'; ?>>Emergency preparedness</option>
	<option value="Environmental health"<?php if ($appliedArea1== 'Environmental health') 
	echo 'selected="selected"'; ?>>Environmental health</option>
	<option value="Family health"<?php if ($appliedArea1== 'Family health') 
	echo 'selected="selected"'; ?>>Family health</option>
	<option value="General health/wellbeing"<?php if ($appliedArea1== 'General health/wellbeing') 
	echo 'selected="selected"'; ?>>General health/wellbeing</option>
	<option value="Health protection (food safety, water safety, tobacco control)"<?php if ($appliedArea1== 'Health protection (food safety, water safety, tobacco control)') 
	echo 'selected="selected"'; ?>>Health protection (food safety, water safety, tobacco control)</option>
	<option value="Infectious diseases"<?php if ($appliedArea1== 'Infectious diseases') 
	echo 'selected="selected"'; ?>>Infectious diseases</option>
	<option value="Injury prevention"<?php if ($appliedArea1== 'Injury prevention') 
	echo 'selected="selected"'; ?>>Injury prevention</option>
	<option value="Maternal and child health"<?php if ($appliedArea1== 'Maternal and child health') 
	echo 'selected="selected"'; ?>>Maternal and child health</option>
	<option value="Mental health"<?php if ($appliedArea1== 'Mental health') 
	echo 'selected="selected"'; ?>>Mental health</option>
	<option value="Occupational health"<?php if ($appliedArea1== 'Occupational health') 
	echo 'selected="selected"'; ?>>Occupational health</option>
	<option value="Oral health"<?php if ($appliedArea1== 'Oral health') 
	echo 'selected="selected"'; ?>>Oral health</option>
	<option value="School health"<?php if ($appliedArea1== 'School health') 
	echo 'selected="selected"'; ?>>School health</option>
	<option value="Substance misuse"<?php if ($appliedArea1== 'Substance misuse') 
	echo 'selected="selected"'; ?>>Substance misuse</option>
	<option value="Other "<?php if ($appliedArea1== 'Other ') 
	echo 'selected="selected"'; ?>>Other </option>
	</select>

	<label > Applied Program Area 2: </label>
	<select required name = "appliedArea2">
	<option value="Addictions"<?php if ($appliedArea2== 'Addictions') 
	echo 'selected="selected"'; ?>>Addictions</option>
	<option value="Chronic disease prevention"<?php if ($appliedArea2== 'Chronic disease prevention') 
	echo 'selected="selected"'; ?>>Chronic disease prevention</option>
	<option value="Clinical public health"<?php if ($appliedArea2== 'Clinical public health') 
	echo 'selected="selected"'; ?>>Clinical public health</option>
	<option value="Determinants of health"<?php if ($appliedArea2== 'Determinants of health') 
	echo 'selected="selected"'; ?>>Determinants of health</option>
	<option value="Emergency preparedness"<?php if ($appliedArea2== 'Emergency preparedness') 
	echo 'selected="selected"'; ?>>Emergency preparedness</option>
	<option value="Environmental health"<?php if ($appliedArea2== 'Environmental health') 
	echo 'selected="selected"'; ?>>Environmental health</option>
	<option value="Family health"<?php if ($appliedArea2== 'Family health') 
	echo 'selected="selected"'; ?>>Family health</option>
	<option value="General health/wellbeing"<?php if ($appliedArea2== 'General health/wellbeing') 
	echo 'selected="selected"'; ?>>General health/wellbeing</option>
	<option value="Health protection (food safety, water safety, tobacco control)"<?php if ($appliedArea2== 'Health protection (food safety, water safety, tobacco control)') 
	echo 'selected="selected"'; ?>>Health protection (food safety, water safety, tobacco control)</option>
	<option value="Infectious diseases"<?php if ($appliedArea2== 'Infectious diseases') 
	echo 'selected="selected"'; ?>>Infectious diseases</option>
	<option value="Injury prevention"<?php if ($appliedArea2== 'Injury prevention') 
	echo 'selected="selected"'; ?>>Injury prevention</option>
	<option value="Maternal and child health"<?php if ($appliedArea2== 'Maternal and child health') 
	echo 'selected="selected"'; ?>>Maternal and child health</option>
	<option value="Mental health"<?php if ($appliedArea2== 'Mental health') 
	echo 'selected="selected"'; ?>>Mental health</option>
	<option value="Occupational health"<?php if ($appliedArea2== 'Occupational health') 
	echo 'selected="selected"'; ?>>Occupational health</option>
	<option value="Oral health"<?php if ($appliedArea2== 'Oral health') 
	echo 'selected="selected"'; ?>>Oral health</option>
	<option value="School health"<?php if ($appliedArea2== 'School health') 
	echo 'selected="selected"'; ?>>School health</option>
	<option value="Substance misuse"<?php if ($appliedArea2== 'Substance misuse') 
	echo 'selected="selected"'; ?>>Substance misuse</option>
	<option value="Other "<?php if ($appliedArea2== 'Other ') 
	echo 'selected="selected"'; ?>>Other </option>
	</select>

	<label > Applied Program Area 3: </label> 
	<select required name = "appliedArea3">
	<option value="Addictions"<?php if ($appliedArea3== 'Addictions') 
	echo 'selected="selected"'; ?>>Addictions</option>
	<option value="Chronic disease prevention"<?php if ($appliedArea3== 'Chronic disease prevention') 
	echo 'selected="selected"'; ?>>Chronic disease prevention</option>
	<option value="Clinical public health"<?php if ($appliedArea3== 'Clinical public health') 
	echo 'selected="selected"'; ?>>Clinical public health</option>
	<option value="Determinants of health"<?php if ($appliedArea3== 'Determinants of health') 
	echo 'selected="selected"'; ?>>Determinants of health</option>
	<option value="Emergency preparedness"<?php if ($appliedArea3== 'Emergency preparedness') 
	echo 'selected="selected"'; ?>>Emergency preparedness</option>
	<option value="Environmental health"<?php if ($appliedArea3== 'Environmental health') 
	echo 'selected="selected"'; ?>>Environmental health</option>
	<option value="Family health"<?php if ($appliedArea3== 'Family health') 
	echo 'selected="selected"'; ?>>Family health</option>
	<option value="General health/wellbeing"<?php if ($appliedArea3== 'General health/wellbeing') 
	echo 'selected="selected"'; ?>>General health/wellbeing</option>
	<option value="Health protection (food safety, water safety, tobacco control)"<?php if ($appliedArea3== 'Health protection (food safety, water safety, tobacco control)') 
	echo 'selected="selected"'; ?>>Health protection (food safety, water safety, tobacco control)</option>
	<option value="Infectious diseases"<?php if ($appliedArea3== 'Infectious diseases') 
	echo 'selected="selected"'; ?>>Infectious diseases</option>
	<option value="Injury prevention"<?php if ($appliedArea3== 'Injury prevention') 
	echo 'selected="selected"'; ?>>Injury prevention</option>
	<option value="Maternal and child health"<?php if ($appliedArea3== 'Maternal and child health') 
	echo 'selected="selected"'; ?>>Maternal and child health</option>
	<option value="Mental health"<?php if ($appliedArea3== 'Mental health') 
	echo 'selected="selected"'; ?>>Mental health</option>
	<option value="Occupational health"<?php if ($appliedArea3== 'Occupational health') 
	echo 'selected="selected"'; ?>>Occupational health</option>
	<option value="Oral health"<?php if ($appliedArea3== 'Oral health') 
	echo 'selected="selected"'; ?>>Oral health</option>
	<option value="School health"<?php if ($appliedArea3== 'School health') 
	echo 'selected="selected"'; ?>>School health</option>
	<option value="Substance misuse"<?php if ($appliedArea3== 'Substance misuse') 
	echo 'selected="selected"'; ?>>Substance misuse</option>
	<option value="Other "<?php if ($appliedArea3== 'Other ') 
	echo 'selected="selected"'; ?>>Other </option>
	</select>

	<label > Population: </label> 
	<select required name = "population">
	<option value="Adults"<?php if ($population== 'Adults') 
	echo 'selected="selected"'; ?>>Adults</option>
	<option value="Children and youth"<?php if ($population== 'Children and youth') 
	echo 'selected="selected"'; ?>>Children and youth</option>
	<option value="General public"<?php if ($population== 'General public') 
	echo 'selected="selected"'; ?>>General public</option>
	<option value="Health care professionals"<?php if ($population== 'Health care professionals') 
	echo 'selected="selected"'; ?>>Health care professionals</option>
	<option value="Immigrants"<?php if ($population== 'Immigrants') 
	echo 'selected="selected"'; ?>>Immigrants</option>
	<option value="Indigenous peoples"<?php if ($population== 'Indigenous peoples') 
	echo 'selected="selected"'; ?>>Indigenous peoples</option>
	<option value="International"<?php if ($population== 'International') 
	echo 'selected="selected"'; ?>>International</option>
	<option value="LGBTQ+"<?php if ($population== 'LGBTQ+') 
	echo 'selected="selected"'; ?>>LGBTQ+</option>
	<option value="Marginalized/vulnerable"<?php if ($population== 'Marginalized/vulnerable') 
	echo 'selected="selected"'; ?>>Marginalized/vulnerable</option>
	<option value="Other stakeholders"<?php if ($population== 'Other stakeholders') 
	echo 'selected="selected"'; ?>>Other stakeholders</option>
	<option value="People with disabilities"<?php if ($population== 'People with disabilities') 
	echo 'selected="selected"'; ?>>People with disabilities</option>
	<option value="Rural or remote"<?php if ($population== 'Rural or remote') 
	echo 'selected="selected"'; ?>>Rural or remote</option>
	<option value="Seniors"<?php if ($population== 'Seniors') 
	echo 'selected="selected"'; ?>>Adults</option>
	<option value="Sex (male/female/other)"<?php if ($population== 'Sex (male/female/other)') 
	echo 'selected="selected"'; ?>>Sex (male/female/other)</option>
	<option value="Urban"<?php if ($population== 'Urban') 
	echo 'selected="selected"'; ?>>Urban</option>
	<option value="Young adults"<?php if ($population== 'Young adults') 
	echo 'selected="selected"'; ?>>Young adults</option>
	<option value="Veterans"<?php if ($population== 'Veterans') 
	echo 'selected="selected"'; ?>>Veterans</option>
	<option value="Other"<?php if ($population== 'Other') 
	echo 'selected="selected"'; ?>>Other</option>
	</select>

	<label > Task 1: </label> 
	<select required name = "task1">
	<option value="Contact with partner agencies/stakeholders"<?php if ($task1== 'Contact with partner agencies/stakeholders') 
	echo 'selected="selected"'; ?>>Contact with partner agencies/stakeholders</option>
	<option value="Data collection"<?php if ($task1== 'Data collection') 
	echo 'selected="selected"'; ?>>Data collection</option>
	<option value="Direct contact with clients"<?php if ($task1== 'Direct contact with clients') 
	echo 'selected="selected"'; ?>>Direct contact with clients</option>
	<option value="Health education or training"<?php if ($task1== 'Health education or training') 
	echo 'selected="selected"'; ?>>Health education or training</option>
	<option value="Health promotion"<?php if ($task1== 'Health promotion') 
	echo 'selected="selected"'; ?>>Health promotion</option>
	<option value="Knowlege translation or exchange"<?php if ($task1== 'Knowlege translation or exchange') 
	echo 'selected="selected"'; ?>>Knowlege translation or exchange</option>
	<option value="Literature review/environmental scan"<?php if ($task1== 'Literature review/environmental scan') 
	echo 'selected="selected"'; ?>>Literature review/environmental scan</option>
	<option value="Needs assessment"<?php if ($task1== 'Needs assessment') 
	echo 'selected="selected"'; ?>>Needs assessment</option>
	<option value="Organizational planning/management/evaluation"<?php if ($task1== 'Organizational planning/management/evaluation') 
	echo 'selected="selected"'; ?>>Organizational planning/management/evaluation</option>
	<option value="Policy development"<?php if ($task1== 'Policy development') 
	echo 'selected="selected"'; ?>>Policy development</option>
	<option value="Program planning, implementation, evaluation"<?php if ($task1== 'Program planning, implementation, evaluation') 
	echo 'selected="selected"'; ?>>Program planning, implementation, evaluation</option>
	<option value="Qualitative methods"<?php if ($task1== 'Qualitative methods') 
	echo 'selected="selected"'; ?>>Qualitative methods</option>
	<option value="Report writing or editing"<?php if ($task1== 'Report writing or editing') 
	echo 'selected="selected"'; ?>>Report writing or editing</option>
	<option value="Social marketing"<?php if ($task1== 'Social marketing') 
	echo 'selected="selected"'; ?>>Social marketing</option>
	<option value="Statistical analysis"<?php if ($task1== 'Statistical analysis') 
	echo 'selected="selected"'; ?>>Statistical analysis</option>
	<option value="Surveillance"<?php if ($task1== 'Surveillance') 
	echo 'selected="selected"'; ?>>Surveillance</option>
	<option value="Survey development"<?php if ($task1== 'Survey development') 
	echo 'selected="selected"'; ?>>Survey development</option>
	<option value="Other"<?php if ($task1== 'Other') 
	echo 'selected="selected"'; ?>>Other</option>
	</select>

	<label > Task 2: </label> 
	<select required name = "task2">
	<option value="Contact with partner agencies/stakeholders"<?php if ($task2== 'Contact with partner agencies/stakeholders') 
	echo 'selected="selected"'; ?>>Contact with partner agencies/stakeholders</option>
	<option value="Data collection"<?php if ($task2== 'Data collection') 
	echo 'selected="selected"'; ?>>Data collection</option>
	<option value="Direct contact with clients"<?php if ($task2== 'Direct contact with clients') 
	echo 'selected="selected"'; ?>>Direct contact with clients</option>
	<option value="Health education or training"<?php if ($task2== 'Health education or training') 
	echo 'selected="selected"'; ?>>Health education or training</option>
	<option value="Health promotion"<?php if ($task2== 'Health promotion') 
	echo 'selected="selected"'; ?>>Health promotion</option>
	<option value="Knowlege translation or exchange"<?php if ($task2== 'Knowlege translation or exchange') 
	echo 'selected="selected"'; ?>>Knowlege translation or exchange</option>
	<option value="Literature review/environmental scan"<?php if ($task2== 'Literature review/environmental scan') 
	echo 'selected="selected"'; ?>>Literature review/environmental scan</option>
	<option value="Needs assessment"<?php if ($task2== 'Needs assessment') 
	echo 'selected="selected"'; ?>>Needs assessment</option>
	<option value="Organizational planning/management/evaluation"<?php if ($task2== 'Organizational planning/management/evaluation') 
	echo 'selected="selected"'; ?>>Organizational planning/management/evaluation</option>
	<option value="Policy development"<?php if ($task2== 'Policy development') 
	echo 'selected="selected"'; ?>>Policy development</option>
	<option value="Program planning, implementation, evaluation"<?php if ($task2== 'Program planning, implementation, evaluation') 
	echo 'selected="selected"'; ?>>Program planning, implementation, evaluation</option>
	<option value="Qualitative methods"<?php if ($task2== 'Qualitative methods') 
	echo 'selected="selected"'; ?>>Qualitative methods</option>
	<option value="Report writing or editing"<?php if ($task2== 'Report writing or editing') 
	echo 'selected="selected"'; ?>>Report writing or editing</option>
	<option value="Social marketing"<?php if ($task2== 'Social marketing') 
	echo 'selected="selected"'; ?>>Social marketing</option>
	<option value="Statistical analysis"<?php if ($task2== 'Statistical analysis') 
	echo 'selected="selected"'; ?>>Statistical analysis</option>
	<option value="Surveillance"<?php if ($task2== 'Surveillance') 
	echo 'selected="selected"'; ?>>Surveillance</option>
	<option value="Survey development"<?php if ($task2== 'Survey development') 
	echo 'selected="selected"'; ?>>Survey development</option>
	<option value="Other"<?php if ($task2== 'Other') 
	echo 'selected="selected"'; ?>>Other</option>
	</select>

<label > Task 3: </label> 
	<select required name = "task3">
	<option value="Contact with partner agencies/stakeholders"<?php if ($task3== 'Contact with partner agencies/stakeholders') 
	echo 'selected="selected"'; ?>>Contact with partner agencies/stakeholders</option>
	<option value="Data collection"<?php if ($task3== 'Data collection') 
	echo 'selected="selected"'; ?>>Data collection</option>
	<option value="Direct contact with clients"<?php if ($task3== 'Direct contact with clients') 
	echo 'selected="selected"'; ?>>Direct contact with clients</option>
	<option value="Health education or training"<?php if ($task3== 'Health education or training') 
	echo 'selected="selected"'; ?>>Health education or training</option>
	<option value="Health promotion"<?php if ($task3== 'Health promotion') 
	echo 'selected="selected"'; ?>>Health promotion</option>
	<option value="Knowlege translation or exchange"<?php if ($task3== 'Knowlege translation or exchange') 
	echo 'selected="selected"'; ?>>Knowlege translation or exchange</option>
	<option value="Literature review/environmental scan"<?php if ($task3== 'Literature review/environmental scan') 
	echo 'selected="selected"'; ?>>Literature review/environmental scan</option>
	<option value="Needs assessment"<?php if ($task3== 'Needs assessment') 
	echo 'selected="selected"'; ?>>Needs assessment</option>
	<option value="Organizational planning/management/evaluation"<?php if ($task3== 'Organizational planning/management/evaluation') 
	echo 'selected="selected"'; ?>>Organizational planning/management/evaluation</option>
	<option value="Policy development"<?php if ($task3== 'Policy development') 
	echo 'selected="selected"'; ?>>Policy development</option>
	<option value="Program planning, implementation, evaluation"<?php if ($task3== 'Program planning, implementation, evaluation') 
	echo 'selected="selected"'; ?>>Program planning, implementation, evaluation</option>
	<option value="Qualitative methods"<?php if ($task3== 'Qualitative methods') 
	echo 'selected="selected"'; ?>>Qualitative methods</option>
	<option value="Report writing or editing"<?php if ($task3== 'Report writing or editing') 
	echo 'selected="selected"'; ?>>Report writing or editing</option>
	<option value="Social marketing"<?php if ($task3== 'Social marketing') 
	echo 'selected="selected"'; ?>>Social marketing</option>
	<option value="Statistical analysis"<?php if ($task3== 'Statistical analysis') 
	echo 'selected="selected"'; ?>>Statistical analysis</option>
	<option value="Surveillance"<?php if ($task3== 'Surveillance') 
	echo 'selected="selected"'; ?>>Surveillance</option>
	<option value="Survey development"<?php if ($task3== 'Survey development') 
	echo 'selected="selected"'; ?>>Survey development</option>
	<option value="Other"<?php if ($task3== 'Other') 
	echo 'selected="selected"'; ?>>Other</option>
	</select>

<label > Job Title: </label> 
	<select required name = "role">
	<option value="Community Health Worker"<?php if ($role== 'Community Health Worker') 
	echo 'selected="selected"'; ?>>Community Health Worker</option>
	<option value="Health Promoter"<?php if ($role== 'Health Promoter') 
	echo 'selected="selected"'; ?>>Health Promoter</option>
	<option value="Program Evaluator"<?php if ($role== 'Program Evaluator') 
	echo 'selected="selected"'; ?>>Program Evaluator</option>
	<option value="Program Planner"<?php if ($role== 'Program Planner') 
	echo 'selected="selected"'; ?>>Program Planner</option>
	<option value="Project Lead"<?php if ($role== 'Project Lead') 
	echo 'selected="selected"'; ?>>Project Lead</option>
	<option value="Policy Analyst"<?php if ($role== 'Policy Analyst') 
	echo 'selected="selected"'; ?>>Policy Analyst</option>
	<option value="Research Assistant"<?php if ($role== 'Research Assistant') 
	echo 'selected="selected"'; ?>>Research Assistant</option>
	<option value="Other"<?php if ($role== 'Other') 
	echo 'selected="selected"'; ?>>Other</option>
	</select>

    <label > Practicum Project(s) Description: </label>  <br> <textarea name="Description" rows="10" cols="100"><?php echo $Description; ?> </textarea> <br> <br>
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
        //Update an already exisiting practicum
        if ($flag=="true"){
            $sql = "UPDATE `Practicum` SET `ProjectTitle`='$projectTitle', `OrganizationID`=$OrganizationID, `Paid`='$paid', `Description`= '$Description', `PreceptorName`='$preceptorName',`Contact`='$contact', `DominantCompetencyCategory`='$DominantCompetencyCategory', `AppliedProgramArea1`='$appliedArea1', `AppliedProgramArea2`='$appliedArea2', `AppliedProgramArea3`= '$appliedArea3', `Population`='$population', `Task1`='$task1', `Task2`='$task2', `Task3`= '$task3', `Role` = '$role' WHERE `StudentID`= $StudentNum";
            $stmt = $con->prepare($sql);
            $stmt->execute();
	    echo "<script> alert('Practicum Updated'); </script>";
	}
        	else{
            	echo "<script> alert('Error Updating Practicum'); </script>";
       		}
            	if($_SESSION["mph"] == true ){
           	echo "<script> location.href='https://webappdev.queensu.ca/phs/MPHAdminDashboard.php'; </script>";
    		exit;
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