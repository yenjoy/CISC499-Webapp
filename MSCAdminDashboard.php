<!DOCTYPE php>
<?php
/*
The main page for MSC admins, they can search through the database or navigate to other pages.
*/
// Start the session
session_start();
//Ensure user is admin
if($_SESSION["member_status"] != "admin"){
    header("Location: index.php");
    die();
}

    if($_SESSION["bio"] == true){
        $querycondition = " program = 'Masters in Biostatistics'";
        if($_SESSION["msc"] == true){
            $querycondition .= " OR program = 'Masters in Epidemiology'";
        }

         if($_SESSION["phd"] == true){
            $querycondition .= " OR program = 'PHD in Epidemiology'";
        }
    }
    elseif($_SESSION["msc"] == true){
        $querycondition = " program = 'Masters in Epidemiology'";
        if($_SESSION["phd"] == true){
            $querycondition .= " OR program = 'PHD in Epidemiology'";
        }
    }
    elseif($_SESSION["phd"] == true){
        $querycondition = " program = 'PHD in Epidemiology'";
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
      <li><a href="index.php">Home</a></li>
      <li class="dropdown">
        <a href="javascript:void(0)" class="dropbtn">Add Profile</a>
        <ul>
            <a href="adminCreateStudent.php">Student</a>
            <a href="addAdmin.php">Administrator</a>
            <a href="adminAddOrganization.php">Organization</a>
            <a href="adminAddPracMSc.php">Practicum</a>
            <a href="adminCreateThesis.php">Thesis</a>
        </ul>
        </li>
        
        <li style="float:right"><a class="active" href="https://login.queensu.ca/idp/logout.jsp">Logout</a></li>
        <li style="float:right"><a class="active" href="savedViews.php">Saved Views</a></li>
      </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">MSc Admin Dashboard</h1> </center>
  </head>

  <body>
      <center>
      <!-- This is the form for the general search. It contains one dropbox and a text input -->
      <form  id="regularField" name='search'  method='post'><br><br>
            <h4 class="headerfont boldFont">General Search</h4>
	            <select name="options" id="options"> 
                    <optgroup label="Student">
                    <option value="StudentID" <?php if ($_POST['options']=='StudentID') {echo "selected='selected'"; } ?> >Student #</option>
                    <option value="FName" <?php if ($_POST['options']=='FName') {echo "selected='selected'"; } ?> >First Name</option>
                    <option value="LName"<?php if ($_POST['options']=='LName') {echo "selected='selected'"; } ?> >Last Name</option>
                    <option value="Gender" <?php if ($_POST['options']=='Gender') {echo "selected='selected'"; } ?> >Gender</option>
                    <option value="GraduatingYear" <?php if ($_POST['options']=='GraduatingYear') {echo "selected='selected'"; } ?> >Graduating Year</option>

		    <option value="CurrentEmployer" <?php if ($_POST['options']==CurrentEmployer) {echo "selected='selected'"; } ?> >Current Employer</option>
		    <option value="CurrentJobTitle" <?php if ($_POST['options']==CurrentJobTitle) {echo "selected='selected'"; } ?> >Current Job Title</option>

                    <option value="Citizenship" <?php if ($_POST['options']=='Citizenship') {echo "selected='selected'"; } ?> >Citizenship</option>
                    <option value="HomeProvince" <?php if ($_POST['options']=='HomeProvince') {echo "selected='selected'"; } ?> >Home Province</option>
                    <option value="QueensEmail" <?php if ($_POST['options']=='QueensEmail') {echo "selected='selected'"; } ?> >Queen's Email</option>
                    <option value="Program" <?php if ($_POST['options']=='Program') {echo "selected='selected'"; } ?> >Program</option>
                    </optgroup>
                    <optgroup label="Organization">
                    <option value="OrganizationName" <?php if ($_POST['options']=='OrganizationName') {echo "selected='selected'"; } ?> >Organization Name</option>
                    <option value="Province" <?php if ($_POST['options']=='Province') {echo "selected='selected'"; } ?> >Province</option>
                    <option value="City" <?php if ($_POST['options']=='City') {echo "selected='selected'"; } ?> >City</option>
                    <option value="StreetNameNumber" <?php if ($_POST['options']=='StreetNameNumber') {echo "selected='selected'"; } ?> >Address</option> 
                    </optgroup>
                    <optgroup label="Practicum">  
                    <option value="Facility" <?php if ($_POST['options']=='Facility') {echo "selected='selected'"; } ?> >Facility</option>
                    </optgroup>
                    <optgroup label="Thesis">  
                    <option value="Title" <?php if ($_POST['options']=='Title') {echo "selected='selected'"; } ?> >Title</option>
                    <option value="Supervisor" <?php if ($_POST['options']=='Supervisor') {echo "selected='selected'"; } ?> >Supervisor</option>
                    <option value="ResearchArea" <?php if ($_POST['options']=='ResearchArea') {echo "selected='selected'"; } ?> >Research Area</option>
                    <option value="DefenseCommittee" <?php if ($_POST['options']=='DefenseCommittee') {echo "selected='selected'"; } ?> >Defense Committee</option>
                    </optgroup>
                </select>
            <input type="text" id="searchbar" size="80" value="<?php echo isset($_POST['searchbar']) ? $_POST['searchbar'] : '' ?>" height="60"></input><br><br>
            <button class="btn btn-primary btn-md buttonColor" type="submit" name="searchbutton" Visibility="visible" id="searchbutton" method="post">Search</button><br><br>
        </form><br>
        <!-- End of general search form -->
        <btn type="button" name="advancedSearch" id="advancedSearch" data-toggle="collapse" data-target="#advancedDiv">Advanced Search</btn><br><br>

<div class="collapse advancedborder" id="advancedDiv" >
<!-- Form for advanced search, contains 4 dropboxes and text inputs -->
<form id="advancedField" name='advancedField' method='post'>
<br><br>
  <select name="select1" id = "select1">
                    <optgroup label="Student" class="Student">
                    <option value="StudentID" class="StudentID" <?php if ($_POST['select1']=='StudentID') {echo "selected='selected'"; } ?> >Student #</option>
                    <option value="FName" class="FName" <?php if ($_POST['select1']=='FName') {echo "selected='selected'"; } ?> >First Name</option>
                    <option value="LName" class="LName" <?php if ($_POST['select1']=='LName') {echo "selected='selected'"; } ?> >Last Name</option>
                    <option value="GraduatingYear" class="GraduatingYear" <?php if ($_POST['select1']=='GraduatingYear') {echo "selected='selected'"; } ?> >Graduating Year</option>
		<option value="CurrentEmployer" <?php if ($_POST['select1']==CurrentEmployer) {echo "selected='selected'"; } ?> >Current Employer</option>
		<option value="CurrentJobTitle" <?php if ($_POST['select1']==CurrentJobTitle) {echo "selected='selected'"; } ?> >Current Job Title</option>                    
<option value="Citizenship" class="Citizenship" <?php if ($_POST['select1']=='Citizenship') {echo "selected='selected'"; } ?> >Citizenship</option>
                    <option value="HomeProvince" class="HomeProvince" <?php if ($_POST['select1']=='HomeProvince') {echo "selected='selected'"; } ?> >Home Province</option>
                    <option value="QueensEmail" class="QueensEmail" <?php if ($_POST['select1']=='QueensEmail') {echo "selected='selected'"; } ?> >Queen's Email</option>
                    <option value="Program" class="Program" <?php if ($_POST['select1']=='Program') {echo "selected='selected'"; } ?> >Program</option>
                    </optgroup>
                    <optgroup label="Organization" class ="Organization">
                    <option value="OrganizationName" class="OrganizationName" <?php if ($_POST['select1']=='OrganizationName') {echo "selected='selected'"; } ?> >Organization Name</option>
                    <option value="Province" class="Province" <?php if ($_POST['select1']=='Province') {echo "selected='selected'"; } ?> >Province</option>
                    <option value="City" class="City" <?php if ($_POST['select1']=='City') {echo "selected='selected'"; } ?> >City</option>
                    <option value="StreetNameNumber" class="StreetNameNumber" <?php if ($_POST['select1']=='StreetNameNumber') {echo "selected='selected'"; } ?> >Address</option> 
                    </optgroup>
                    <optgroup label="Practicum">  
                    <option value="Facility" class="Facility" <?php if ($_POST['select1']=='Facility') {echo "selected='selected'"; } ?> >Facility</option>
                    </optgroup>
                    <optgroup label="Thesis">  
                    <option value="Title" class="Title" <?php if ($_POST['select1']=='Title') {echo "selected='selected'"; } ?> >Title</option>
                    <option value="Supervisor" class="Supervisor" <?php if ($_POST['select1']=='Supervisor') {echo "selected='selected'"; } ?> >Supervisor</option>
                    <option value="ResearchArea" class="ResearchArea" <?php if ($_POST['select1']=='ResearchArea') {echo "selected='selected'"; } ?> >Research Area</option>
                    <option value="DefenseCommittee"class="DefenseCommittee" <?php if ($_POST['select1']=='DefenseCommittee') {echo "selected='selected'"; } ?> >Defense Committee</option>
                    </optgroup>
  </select>
  <input type="text" name="searchbar1" id="searchbar1" size="80" height="60"></input> <br><br><br>

  <select id = "select2" name="select2" >
  <option value="blank" ></option>
                    <optgroup label="Student" class="Student">
                    <option value="StudentID" class="StudentID" <?php if ($_POST['select2']=='StudentID') {echo "selected='selected'"; } ?> >Student #</option>
                    <option value="FName" class="FName" <?php if ($_POST['select2']=='FName') {echo "selected='selected'"; } ?> >First Name</option>
                    <option value="LName" class="LName" <?php if ($_POST['select2']=='LName') {echo "selected='selected'"; } ?> >Last Name</option>
                    <option value="GraduatingYear" class="GraduatingYear" <?php if ($_POST['select2']=='GraduatingYear') {echo "selected='selected'"; } ?> >Graduating Year</option>
		<option value="CurrentEmployer" <?php if ($_POST['select2']==CurrentEmployer) {echo "selected='selected'"; } ?> >Current Employer</option>
		<option value="CurrentJobTitle" <?php if ($_POST['select2']==CurrentJobTitle) {echo "selected='selected'"; } ?> >Current Job Title</option>                    
<option value="Citizenship" class="Citizenship" <?php if ($_POST['select2']=='Citizenship') {echo "selected='selected'"; } ?> >Citizenship</option>
                    <option value="HomeProvince" class="HomeProvince" <?php if ($_POST['select2']=='HomeProvince') {echo "selected='selected'"; } ?> >Home Province</option>
                    <option value="QueensEmail" class="QueensEmail" <?php if ($_POST['select2']=='QueensEmail') {echo "selected='selected'"; } ?> >Queen's Email</option>
                    <option value="Program" class="Program" <?php if ($_POST['select2']=='Program') {echo "selected='selected'"; } ?> >Program</option>
                    </optgroup>
                    <optgroup label="Organization" class ="Organization">
                    <option value="OrganizationName" class="OrganizationName" <?php if ($_POST['select2']=='OrganizationName') {echo "selected='selected'"; } ?> >Organization Name</option>
                    <option value="Province" class="Province" <?php if ($_POST['select2']=='Province') {echo "selected='selected'"; } ?> >Province</option>
                    <option value="City" class="City" <?php if ($_POST['select2']=='City') {echo "selected='selected'"; } ?> >City</option>
                    <option value="StreetNameNumber" class="StreetNameNumber" <?php if ($_POST['select2']=='StreetNameNumber') {echo "selected='selected'"; } ?> >Address</option> 
                    </optgroup>
                    <optgroup label="Practicum">  
                    <option value="Facility" class="Facility" <?php if ($_POST['select2']=='Facility') {echo "selected='selected'"; } ?> >Facility</option>
                    </optgroup>
                    <optgroup label="Thesis">  
                    <option value="Title" class="Title" <?php if ($_POST['select2']=='Title') {echo "selected='selected'"; } ?> >Title</option>
                    <option value="Supervisor" class="Supervisor" <?php if ($_POST['select2']=='Supervisor') {echo "selected='selected'"; } ?> >Supervisor</option>
                    <option value="ResearchArea" class="ResearchArea" <?php if ($_POST['select2']=='ResearchArea') {echo "selected='selected'"; } ?> >Research Area</option>
                    <option value="DefenseCommittee"class="DefenseCommittee" <?php if ($_POST['select2']=='DefenseCommittee') {echo "selected='selected'"; } ?> >Defense Committee</option>
                    </optgroup>
  </select>
  <input type="text" name="searchbar2" id="searchbar1" size="80" height="60"></input> <br><br><br>

  <select id = "select3" name="select3" >
  <option value="blank"></option>
                    <optgroup label="Student" class="Student">
                    <option value="StudentID" class="StudentID" <?php if ($_POST['select3']=='StudentID') {echo "selected='selected'"; } ?> >Student #</option>
                    <option value="FName" class="FName" <?php if ($_POST['select3']=='FName') {echo "selected='selected'"; } ?> >First Name</option>
                    <option value="LName" class="LName" <?php if ($_POST['select3']=='LName') {echo "selected='selected'"; } ?> >Last Name</option>
<option value="CurrentEmployer" <?php if ($_POST['select3']==CurrentEmployer) {echo "selected='selected'"; } ?> >Current Employer</option>
		<option value="CurrentJobTitle" <?php if ($_POST['select3']==CurrentJobTitle) {echo "selected='selected'"; } ?> >Current Job Title</option>                                  
 <option value="GraduatingYear" class="GraduatingYear" <?php if ($_POST['select3']=='GraduatingYear') {echo "selected='selected'"; } ?> >Graduating Year</option>
                    <option value="Citizenship" class="Citizenship" <?php if ($_POST['select3']=='Citizenship') {echo "selected='selected'"; } ?> >Citizenship</option>
                    <option value="HomeProvince" class="HomeProvince" <?php if ($_POST['select3']=='HomeProvince') {echo "selected='selected'"; } ?> >Home Province</option>
                    <option value="QueensEmail" class="QueensEmail" <?php if ($_POST['select3']=='QueensEmail') {echo "selected='selected'"; } ?> >Queen's Email</option>
                    <option value="Program" class="Program" <?php if ($_POST['select3']=='Program') {echo "selected='selected'"; } ?> >Program</option>
                    </optgroup>
                    <optgroup label="Organization" class ="Organization">
                    <option value="OrganizationName" class="OrganizationName" <?php if ($_POST['select3']=='OrganizationName') {echo "selected='selected'"; } ?> >Organization Name</option>
                    <option value="Province" class="Province" <?php if ($_POST['select3']=='Province') {echo "selected='selected'"; } ?> >Province</option>
                    <option value="City" class="City" <?php if ($_POST['select3']=='City') {echo "selected='selected'"; } ?> >City</option>
                    <option value="StreetNameNumber" class="StreetNameNumber" <?php if ($_POST['select3']=='StreetNameNumber') {echo "selected='selected'"; } ?> >Address</option> 
                    </optgroup>
                    <optgroup label="Practicum">  
                    <option value="Facility" class="Facility" <?php if ($_POST['select3']=='Facility') {echo "selected='selected'"; } ?> >Facility</option>
                    </optgroup>
                    <optgroup label="Thesis">  
                    <option value="Title" class="Title" <?php if ($_POST['select3']=='Title') {echo "selected='selected'"; } ?> >Title</option>
                    <option value="Supervisor" class="Supervisor" <?php if ($_POST['select3']=='Supervisor') {echo "selected='selected'"; } ?> >Supervisor</option>
                    <option value="ResearchArea" class="ResearchArea" <?php if ($_POST['select3']=='ResearchArea') {echo "selected='selected'"; } ?> >Research Area</option>
                    <option value="DefenseCommittee"class="DefenseCommittee" <?php if ($_POST['select3']=='DefenseCommittee') {echo "selected='selected'"; } ?> >Defense Committee</option>
                    </optgroup>
  </select>
  <input type="text" name="searchbar3" id="searchbar1" size="80" height="60"></input> <br><br><br>

  <select id = "select4" name="select4">
  <option value="blank"></option>
                    <optgroup label="Student" class="Student">
                    <option value="StudentID" class="StudentID" <?php if ($_POST['select4']=='StudentID') {echo "selected='selected'"; } ?> >Student #</option>
                    <option value="FName" class="FName" <?php if ($_POST['select4']=='FName') {echo "selected='selected'"; } ?> >First Name</option>
                    <option value="LName" class="LName" <?php if ($_POST['select4']=='LName') {echo "selected='selected'"; } ?> >Last Name</option>
                    <option value="GraduatingYear" class="GraduatingYear" <?php if ($_POST['select4']=='GraduatingYear') {echo "selected='selected'"; } ?> >Graduating Year</option>
<option value="CurrentEmployer" <?php if ($_POST['select4']==CurrentEmployer) {echo "selected='selected'"; } ?> >Current Employer</option>
		<option value="CurrentJobTitle" <?php if ($_POST['select4']==CurrentJobTitle) {echo "selected='selected'"; } ?> >Current Job Title</option>                        
<option value="Citizenship" class="Citizenship" <?php if ($_POST['select4']=='Citizenship') {echo "selected='selected'"; } ?> >Citizenship</option>
                    <option value="HomeProvince" class="HomeProvince" <?php if ($_POST['select4']=='HomeProvince') {echo "selected='selected'"; } ?> >Home Province</option>
                    <option value="QueensEmail" class="QueensEmail" <?php if ($_POST['select4']=='QueensEmail') {echo "selected='selected'"; } ?> >Queen's Email</option>
                    <option value="Program" class="Program" <?php if ($_POST['select4']=='Program') {echo "selected='selected'"; } ?> >Program</option>
                    </optgroup>
                    <optgroup label="Organization" class ="Organization">
                    <option value="OrganizationName" class="OrganizationName" <?php if ($_POST['select4']=='OrganizationName') {echo "selected='selected'"; } ?> >Organization Name</option>
                    <option value="Province" class="Province" <?php if ($_POST['select4']=='Province') {echo "selected='selected'"; } ?> >Province</option>
                    <option value="City" class="City" <?php if ($_POST['select4']=='City') {echo "selected='selected'"; } ?> >City</option>
                    <option value="StreetNameNumber" class="StreetNameNumber" <?php if ($_POST['select4']=='StreetNameNumber') {echo "selected='selected'"; } ?> >Address</option> 
                    </optgroup>
                    <optgroup label="Practicum">  
                    <option value="Facility" class="Facility" <?php if ($_POST['select4']=='Facility') {echo "selected='selected'"; } ?> >Facility</option>
                    </optgroup>
                    <optgroup label="Thesis">  
                    <option value="Title" class="Title" <?php if ($_POST['select4']=='Title') {echo "selected='selected'"; } ?> >Title</option>
                    <option value="Supervisor" class="Supervisor" <?php if ($_POST['select4']=='Supervisor') {echo "selected='selected'"; } ?> >Supervisor</option>
                    <option value="ResearchArea" class="ResearchArea" <?php if ($_POST['select4']=='ResearchArea') {echo "selected='selected'"; } ?> >Research Area</option>
                    <option value="DefenseCommittee"class="DefenseCommittee" <?php if ($_POST['select4']=='DefenseCommittee') {echo "selected='selected'"; } ?> >Defense Committee</option>
                    </optgroup>
  </select>
  <input type="text" name="searchbar4" id="searchbar1" size="80" height="60"></input> <br><br><br>
 	 <button type="submit" name ="advancedSearchButton" id ="advancedSearchButton" method ="post">Search</button><br><br>
</form>   
<!--End of advanced Search -->  
        </div>
        </center><br><br><br> 


</body>

<script>
//Shows the advanced search box
    function showAdvanced(){
        if(document.getElementById("advancedDiv").className == "hideElement"){
            document.getElementById("advancedDiv").className = "showElement advancedborder";
        }
        else{
            document.getElementById("advancedDiv").className = "hideElement";
        }
    }

</script>
</html>

<?php
include_once 'connection.php'; 
function verify_input($data, $con){
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
  $data = mysqli_real_escape_string($con, $data);
  return $data;  
}

//check if the search form is submitted
if(isset($_POST['searchbutton'])){
	$searchCriteria = $_POST['searchbar']; //get search bar content
	$options = $_POST['options']; //See which dropdown is selected
   	 $searchCriteria = verify_input($searchCriteria, $con);
	$showStudentTable = False;
	$showOrganizationTable = False;
	$showPracticumTable = False;
    



    //If it's an option from the student table 
 if ($options == "StudentID" || $options == "GraduatingYear" || $options == "FName" || $options == "Program"|| $options == "LName" || $options == "HomeProvince" || $options == "QueensEmail" || $options == "Citizenship" || $options == "Gender")
 	 {
        
    	$showStudentTable = True;
    	if(empty($searchCriteria)){
    		$query = "SELECT * FROM Student WHERE Program = 'Masters in Biostatistics'";
    	}
    	else{
    		$query = "SELECT * FROM Student WHERE Program = 'Masters in Biostatistics' AND $options LIKE '%$searchCriteria%'";
    	}
    }

    //If it's an option from the organization table 
     if ($options == "OrganizationName" || $options == "StreetNameNumber" || $options == "Province" || $options == "City")
    {
    	$showOrganizationTable = True;
    	if(empty($searchCriteria)){
    		$query = "SELECT * FROM Organization";
    	}
    	else{
    		$query = "SELECT * FROM Organization WHERE $options = '$searchCriteria'";
    	}
    }

        //If it's an option from the practicum table 
     if ($options == "Facility")
    {
    	$showPracticumTable = True;
    	if(empty($searchCriteria)){
    		$query = "SELECT Facility, Student.StudentID, FName, LName, StudentEval FROM PracticumMSC LEFT JOIN Student ON PracticumMSC.StudentID = Student.StudentID";
            $query .= " WHERE (" . $querycondition . " )";
    	}
    	else{
    		$query = "SELECT Facility, Student.StudentID, FName, LName, StudentEval FROM PracticumMSC LEFT JOIN Student ON PracticumMSC.StudentID = Student.StudentID WHERE $options LIKE '%$searchCriteria%'";
            $query .= " AND (" . $querycondition . " )";
    	}
    }

    if($options == "Title" || $options == "Supervisor" || $options == "ResearchArea" || $options == "DefenseCommittee" ){
        $showThesisTable = True;
    	if(empty($searchCriteria)){
    		$query = "SELECT Title, Student.StudentID, FName, LName, Supervisor, ResearchArea, DefenseCommittee, Abstract FROM Thesis LEFT JOIN Student ON Thesis.StudentID = Student.StudentID";
            $query .= " WHERE (" . $querycondition . " )";
    	}
    	else{
    		$query = "SELECT Title, Student.StudentID, FName, LName, Supervisor, ResearchArea, DefenseCommittee, Abstract FROM Thesis LEFT JOIN Student ON Thesis.StudentID = Student.StudentID WHERE $options LIKE '%$searchCriteria%'";
            $query .= " AND (" . $querycondition . " )";
    	}
    }

	$stmt = $con->prepare($query);
         
       $stmt->execute();
        // results 
        $result = $stmt->get_result();
        //if (mysql_num_rows($result) == 0 ){ echo "No Results Found";}
	$result->num_rows;
	//or mysql fetch array? Maybe?

	//BOOKMARK
        //Display the student table 
        if($showStudentTable == True){
            echo "<div class='scroll ' >";
 		    echo "<table class = 'table table-hover table-bordered' id='studenttable' >";
        	echo "<thead>";
	     echo "<tbody>";

        	 while($row = $result->fetch_assoc()){


		echo "<br>";
		echo $row ['FName']." ". $row ['LName']."\n"."<br>".$row['StudentID']."\n"."<br>".$row['QueensEmail'];
		echo "<br>"."\n";
		$newID = $row['StudentID'];

		echo "<form method='POST' action= 'adminEditStudent.php'>";
		echo "<input type='hidden' name='PassOnID' value= '$newID'/> ";
		echo "<input id='button' type='submit' name = '$newID' value='See More'/>";
		echo " </form> ";
		
		echo "<br>"."\n"."<br>";
		}
    		echo "</tbody> </table>";
            echo "</div>";

		}

		////Display the organization table
		if($showOrganizationTable == True){
            echo "<div class='scroll' >";
    		echo "<table class = 'table table-hover table-bordered'  id='organizationtable'>";
        	echo "<thead>";
             	echo "<tbody>";

             while($row = $result->fetch_assoc()){
		echo "<br>";
		echo $row ['OrganizationName']."<br>".$row['OrganizationType']."\n"."<br>".$row['StreetNameNumber'];
		echo "<br>"."\n";
		$newID = $row['OrganizationID'];
		
		echo "<form method='POST' action= 'adminEditOrganization.php'>";
		echo "<input type='hidden' name='PassOnID' value= '$newID'/> ";
		echo "<input id='button' type='submit' name = '$newID' value='See More'/>";
		echo " </form> ";
		echo "<br>"."\n";
     		}
    		echo "</tbody> </table>";   
            echo "</div>";

		}

		////Display the practicum table
		if($showPracticumTable == True){
            	echo "<div class='scroll' >";
    		echo "<table class = 'table table-hover table-bordered' id = 'practicumtable' >";
        	echo "<thead>";
             	echo "<tbody>";
             while($row = $result->fetch_assoc()){
 		echo $row ['ProjectTitle']."<br>".$row['PreceptorName']."\n"."<br>";
		$newID = $row['StudentID'];
		echo "<form method='POST' action= 'adminEditPracMPH.php'>";
		echo "<input type='hidden' name='PassOnID' value= '$newID'/> ";
		echo "<input id='button' type='submit' name = '$newID' value='See More'/>";
		echo "<br>"."\n";
		echo "<br>"."\n";
    		}
    		echo "</tbody> </table>";  
            echo "</div>";  
                   

		}

        if($showThesisTable == True){
            echo "<div class='scroll' >";
 		    echo "<table class = 'table table-hover table-bordered' id='thesistable' >";
        	echo "<thead>";
  	          echo "<tbody>";
            	while($row = $result->fetch_assoc()){
 		echo $row ['Title']."<br>".$row['ResearchArea']."\n"."<br>";
		$newID = $row['StudentID'];
		echo "<form method='POST' action= 'adminEditThesis.php'>";
		echo "<input type='hidden' name='PassOnID' value= '$newID'/> ";
		echo "<input id='button' type='submit' name = '$newID' value='See More'/>";
		echo "<br>"."\n";
		echo "<br>"."\n";

		}
    		echo "</tbody> </table>";
            echo "</div>";        

		}
	}


    	/*
		THIS IS THE PHP FOR THE ADVANCED SEARCH
		*/
if(isset($_POST['advancedSearchButton'])){
    $joinStudentTable = False;
	$joinOrganizationTable = False;
	$joinPracticumTable = False;
    $joinThesisTable = False;
    $searchCriteria = array();


    //It was tricky to do this in a loop, so I did it this way to store time 
    $searchCriteria[0] = $_POST['searchbar1']; //get search bar content
    $searchCriteria[0] = verify_input($searchCriteria[0], $con);
    $searchCriteria[1] = $_POST['searchbar2']; //get search bar content
    $searchCriteria[1] = verify_input($searchCriteria[1], $con);
    $searchCriteria[2] = $_POST['searchbar3']; //get search bar content
    $searchCriteria[2] = verify_input($searchCriteria[2], $con);
    $searchCriteria[3] = $_POST['searchbar4']; //get search bar content
    $searchCriteria[3] = verify_input($searchCriteria[3], $con);
    $options = array();
    $options[0] = $_POST['select1'];
    $options[1] = $_POST['select2'];
    $options[2] = $_POST['select3'];
    $options[3] = $_POST['select4'];
    // build the select part of the query
    $i=0;

    //Look for a Student Column, if there are none then we know we are linking organization and practicum
    while($options[$i] != "blank" && $i < 4){

        if ($options[$i] == "StudentID" || $options[$i] == "FName" || $options[$i] == "LName" || $options[$i] == "GraduatingYear" ||  $options[$i] == "CurrentEmployer" || $options[$i] == "CurrentJobTitle" || $options[$i] == "Citizenship" ||  $options[$i] == "homeProvince" ||  $options[$i] == "QueensEmail" ||  $options[$i] == "Program")
  {
    	$joinStudentTable = True;
    }
     if ($options[$i] == "Facility")
    {
    	$joinPracticumTable = True;
    }
    if ($options[$i] == "OrganizationID" || $options[$i] == "OrganizationName" || $options[$i] == "City" || $options[$i] == "Province" || $options[$i] == "StreetNameNumber")
    {
    	$joinOrganizationTable = True;
    }
    if($options[$i] == "Title" || $options[$i] == "Supervisor" || $options[$i] == "ResearchArea" || $options[$i] == "DefenseCommittee" )
    {
    	$joinThesisTable = True;
    }
     $i = $i+1;
    }

    $j = 0;
    $temp = 0;
    //Student Table, put the arrays into an sql query
    if($joinStudentTable == True){
        $checkProgram = true;
    if($options[$j]=="StudentID"){
    	$query = "SELECT Student.";
        $checked = true;
    }
    else {
        $query = "SELECT ";
        $checked = false;
    }
    	$extendedquery = "";
    	while ($j < $i){

            if($options[$j]=="StudentID" && $checked == false){
                $query .= " Student.";
                $query .= $options[$j];
                $query .= ", ";
            }
            else{              
                    $query .= $options[$j];
                    $query .= ", ";
            }
    		if(!empty($searchCriteria[$j])){
                $hasCriteria = true;
    			if($temp == 0){
    				$extendedquery .= " WHERE";
    				$temp = 1;
    			}
    			if($options[$j]=="StudentID"){
    				$extendedquery .= " Student.";
    				$extendedquery .= $options[$j];
    				$extendedquery .= " LIKE" . "'%$searchCriteria[$j]%'";
    				$extendedquery .= " AND";
    			}
    			else{
    				$extendedquery .= " " . $options[$j] . " LIKE " . "'%$searchCriteria[$j]%'";
    				$extendedquery .= " AND";
    			}
    		}
    		$j = $j+1;

    }
    $query = substr($query, 0, -2);
    $extendedquery = substr($extendedquery, 0, -4);
    if($joinOrganizationTable == True){
        $query .= " FROM Student LEFT JOIN PracticumMSC ON Student.StudentID=PracticumMSC.StudentID LEFT JOIN Thesis ON Student.StudentID=Thesis.StudentID LEFT JOIN Organization ON PracticumMSC.OrganizationID = Organization.OrganizationID"; 
    }
    elseif($joinPracticumTable == True){
    $query .= " FROM Student LEFT JOIN PracticumMSC ON Student.StudentID=PracticumMSC.StudentID LEFT JOIN Thesis ON Student.StudentID=Thesis.StudentID"; 
    }
    elseif($joinThesisTable == True){
        $query .= " FROM Student LEFT JOIN Thesis ON Student.StudentID=Thesis.StudentID"; 
    }
    else{
        $query.= " FROM Student";
    }
    $query .= $extendedquery;
    }

    elseif($joinPracticumTable == True){
        if($options[$j] == "StudentID" || $options[$j] == "OrganizationID" ){
    	$query = "SELECT PracticumMSC.";
        }
        else {
            $query = "SELECT ";
        }
    	$extendedquery = "";
    	while ($j < $i){          
            if($options[$j] == "StudentID" || $options[$j] == "OrganizationID" ){
                $query .= " PracticumMSC.";
                $query .= $options[$j];
                $query .= ", ";
            }
            else{
    		        $query .= $options[$j];
    		        $query .= ", ";
            }
    		if(!empty($searchCriteria[$j])){
                $hasCriteria = true;
    			if($temp == 0){
    				$extendedquery .= " WHERE";
    				$temp = 1;
    			}
    			if($options[$j]=="OrganizationID"){
    				$extendedquery .= " Organization.";
    				$extendedquery .= $options[$j];
    				$extendedquery .= " LIKE " . "%'$searchCriteria[$j]%'";
    				$extendedquery .= " AND";
    			}
    			else{
    				    $extendedquery .= " " . $options[$j] . " LIKE " . "'%$searchCriteria[$j]%'";
    				    $extendedquery .= " AND";
    			}
    		}
    		$j = $j+1;

    }
    $query = substr($query, 0, -2);
    $extendedquery = substr($extendedquery, 0, -4);
    if($joinOrganizationTable == True){
    $query .= " FROM PracticumMSC LEFT JOIN Organization ON Organization.OrganizationID=PracticumMSC.OrganizationID LEFT JOIN Thesis ON PracticumMSC.StudentID=Thesis.StudentID"; 
    }
    elseif($joinThesisTable == True){
        $query .= " FROM PracticumMSC LEFT JOIN Thesis ON PracticumMSC.StudentID=Thesis.StudentID"; 
    }
        else{
        $query.= " FROM PracticumMSC";
    }
    $query .= $extendedquery;
    }

    elseif($joinThesisTable == True){
        if($options[$j] == "StudentID"){
    	$query = "SELECT Thesis.";
        }
        else {
            $query = "SELECT ";
        }
    	$extendedquery = "";
    	while ($j < $i){          
            if($options[$j] == "StudentID"){
                $query .= " Thesis.";
                $query .= $options[$j];
                $query .= ", ";
            }
            else{
    		        $query .= $options[$j];
    		        $query .= ", ";
            }
    		if(!empty($searchCriteria[$j])){
                $hasCriteria = true;
    			if($temp == 0){
    				$extendedquery .= " WHERE";
    				$temp = 1;
    			}
    			if($options[$j]=="StudentID"){
    				$extendedquery .= " Thesis.";
    				$extendedquery .= $options[$j];
    				$extendedquery .= " LIKE " . "%'$searchCriteria[$j]%'";
    				$extendedquery .= " AND";
    			}
    			else{
    				    $extendedquery .= " " . $options[$j] . " LIKE " . "'%$searchCriteria[$j]%'";
    				    $extendedquery .= " AND";
    			}
    		}
    		$j = $j+1;

    }
    $query = substr($query, 0, -2);
    $extendedquery = substr($extendedquery, 0, -4);
    if($joinOrganizationTable == True){
    $query .= " FROM Thesis LEFT JOIN PracticumMSC ON Thesis.StudentID=PracticumMSC.StudentID LEFT JOIN Organization ON Organization.OrganizationID=PracticumMSC.OrganizationID"; 
    }
        else{
        $query.= " FROM Thesis";
    }
    $query .= $extendedquery;
    }

    elseif($joinOrganizationTable == True){
        if($options[$j]=="OrganizationID"){
            $query = "SELECT Organization.";
        }
        else {
            $query = "SELECT ";
        }
            $extendedquery = "";
            while ($j < $i){
             
                 $query .= $options[$j];
                 $query .= ", ";
                
                if(!empty($searchCriteria[$j])){
                    $hasCriteria = true;
                    if($temp == 0){
                        $extendedquery .= " WHERE";
                        $temp = 1;
                    }

    			    $extendedquery .= " " . $options[$j] . " LIKE " . "'%$searchCriteria[$j]%'";
                    $extendedquery .= " AND";
                }
    		$j = $j+1;

    }
    $query = substr($query, 0, -2);
    $extendedquery = substr($extendedquery, 0, -4);
    $query.= " FROM Organization";
    $query .= $extendedquery;

    }

    if($hasCriteria == true && $checkProgram == true){
        $query .= " AND (" . $querycondition . " )";
    }
    elseif($hasCriteria !=true && $checkProgram == true){
        $query .= " WHERE (" . $querycondition . " )";
    }
	$stmt = $con->prepare($query);
    //echo $query;
    $stmt->execute();
        // results 
    $result = $stmt->get_result();
        		echo "<table class = 'table table-hover' id='advancedtable'>";
        	echo "<thead>";
        	echo "<tr>";
     $h = 0; 
     $columncount = 0;
     	while($h < $i){
     		echo "<th>". $options[$h] . "</th>";
            $columncount = $columncount + 1;
     		$h = $h + 1;
     	}
     	echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
  
    $t = 0;
    $s = 0;

    while(($row = $result->fetch_assoc())){
    		$t = 0;
    			echo "<tr>";
    			while($t < $i){
                    echo " <td >" . $row[$options[$t]] . "</td>"; 
                    $t = $t +1;
    		}
            $s = $s +1;
    		echo "</tr>";
    	}
            echo "</tbody>";
    		echo "</table>";
            echo "<form  id='viewform' name='search'  method='post' action='newView.php'>";
            echo "<center> <button class='btn btn-primary btn-md buttonColor' type='submit' name='saveview'  id='saveview'  method='post'>Save as View</button><br><br> </center>";
            echo "</form>";
            $_SESSION['viewquery'] = $query;
            $_SESSION['columncount'] = $columncount;           
        


    }
    ?>