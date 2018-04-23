<!DOCTYPE php>
<?php
// Start the session
session_start();
include_once 'connection.php'; 
if($_SESSION['member_status'] != 'student'){
    header("Location: index.php");
    die();
    }
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
    <link href="css/global.css" type="text/css" rel="stylesheet">
    <link href="css/adminDashboard.css" type="text/css" rel="stylesheet">
    <img src="Assets/banner.jpg" id="header">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <!-- start of nav bar -->
    <ul id="navbar">
        <li><a href="profileMPH.php">Edit Profile</a></li>
        <li><a href="studentPracticumMPH.php">Edit Practicum</a> </li>
        <li style="float:right"><a class="active" href="https://idptest.queensu.ca/idp/profile/Logout">Logout</a></li>
    </ul>
      <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">MPH Student Dashboard</h1> </center>
    <center> <h1><?php echo "Welcome " . ($_SERVER[HTTP_QUEENSU_GIVENNAME]) . "!"; ?> </h1> </center>
  </head>

  <body>
        <center>
        <!-- start of search form -->
          <form  id="regularField" name='search'  method='post'><br><br>
            <h4 class="headerfont boldFont">General Search</h3>
              <select name="options" id="options"> 
                    <optgroup label="Student Search">
                    <option value="ProjectTitle" <?php if ($_POST['options']=='ProjectTitle') {echo "selected='selected'"; } ?> >Practicum Title</option>
                    <option value="OrganizationName" <?php if ($_POST['options']=='OrganizationName') {echo "selected='selected'"; } ?> >Practicum Organization</option>
                    <option value="DominantCompetencyCategory"<?php if ($_POST['options']=='DominantCompetencyCategory') {echo "selected='selected'"; } ?> >Public Health Area</option>
                    <option value="Task1" <?php if ($_POST['options']=='Task1') {echo "selected='selected'"; } ?> >Task</option>
                    </optgroup>
                    </select>
                    </h4>
<input type="text" name="searchbar" id="searchbar" size="80" value="<?php echo isset($_POST['searchbar']) ? $_POST['searchbar'] : '' ?>" height="60"></input><br><br>
            <button class="btn btn-primary btn-md buttonColor" type="submit" name="searchbutton" Visibility="visible" id="searchbutton" method="post">Search</button><br><br>
        </form><br>
        </center>
</body>
  </html>

  <?php
// this function allows input stripping.  it takes one parameter $data which is the input into a text field
// this function is neccesary for sanitizing the input and preventing XSS and HTML injection attacks.
function test_input($data, $con) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  $data = mysqli_real_escape_string($con, $data);
  return $data;
}// end of function


 
// show error
if(!$con){
    die('Connect Error: ' . $mysqli->connect_error);
}
// if the user clicks the search button
if(isset($_POST['searchbutton'])){
  $searchCriteria = test_input($_POST['searchbar'], $con); //get search bar content

  //echo $searchCriteria;
  $options = $_POST['options']; //See which dropdown is selected
  $showOrganizationTable = False; // only show the user what is neccesary
  $showPracticumTable = False;
  // For debugging
 // echo $options;
 
  //$query="badQuery";
}

if($options == 'ProjectTitle' || $options == 'DominantCompetencyCategory'){  
  $showPracticumTable = True;
      if(empty($searchCriteria)){
            // DEBUG echo "prac empty";
        $query = "SELECT * FROM Practicum LEFT JOIN Organization ON Organization.OrganizationID=Practicum.OrganizationID";
      }
      else{
        // DEBUG echo "prac with text";
        $query = "SELECT * FROM Practicum LEFT JOIN Organization ON Organization.OrganizationID=Practicum.OrganizationID WHERE $options LIKE '%$searchCriteria%'";
      }
}
// if task is selected we must search all tasks.
if($options == 'Task1'){
  $showPracticumTable = True;
  if(empty($searchCriteria)){
    $query = "SELECT * FROM Practicum LEFT JOIN Organization ON Organization.OrganizationID=Practicum.OrganizationID";
  }
  else{
    $query = "SELECT * FROM Practicum LEFT JOIN Organization ON Organization.OrganizationID=Practicum.OrganizationID WHERE (Task1 LIKE '%$searchCriteria%' OR Task2 LIKE '%$searchCriteria%' OR Task3 LIKE '%$searchCriteria%')";
  }


}

if ($options == 'OrganizationName'){
  $showOrganizationTable = True;
  if(empty($searchCriteria)){
    // Empty search criteria, show everything
    $query = "SELECT * FROM Organization";
  }
  else{
    $query = "SELECT * FROM Organization WHERE $options LIKE '%$searchCriteria%'";
  }
}

  $stmt = $con->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result();

// only one of the above variables will be true, not both.

    ////Display the organization table
    if($showOrganizationTable == True){
    echo "<center>";
    echo "<div class='scroll'>";
        echo "<table class = 'table table-hover table-bordered' id='organizationtable'>";
          echo "<thead>";
          echo " <tr>  <th> Organization Name </th> <th> Organization Type </th>  <th> Organization Address</th> <th> City </th> <th> Province </th> <th> Country </th> </tr> </thead>";
          echo "<tbody>";
             while($row = $result->fetch_assoc()){
                    echo "</td> <td> " . $row['OrganizationName'] . "</td> <td> "  . $row['OrganizationType'] . "</td> <td> "   . $row['StreetNameNumber'] . " </td> <td> " . $row['City'] . "</td> <td> " . $row['Province'] .  "</td>  <td> " . $row['Country'] .  "</td> </tr>"; 
        }
        echo "</tbody> </table>";    
        echo "</div>";
        echo "</center>";
    }

    ////Display the practicum table
    if($showPracticumTable == True){
       echo "<center>";
      echo "<div class='scroll'>";
        echo "<table class = 'table table-hover table-bordered' id = 'practicumtable' >";
          echo "<thead>";
          echo " <tr> <th> Practicum Title </th> <th>Organization Name </th>  <th> Paid/Unpaid </th> <th style='min-width:250px'> Description</th> <th style='min-width:150px'>Public Health Area</th> <th> Populations </th> <th style='min-width:200px'> Applied Program Area 1</th> <th style='min-width:200px'> Applied Program Area 2</th>  <th style='min-width:200px'> Applied Program Area 3</th> <th style='min-width:200px'> Task 1</th> <th style='min-width:200px'> Task 2 </th> <th style='min-width:200px'> Task 3 </th> <th style='min-width:200px'> Role </th></tr> </thead>";
          echo "<tbody>";
             while($row = $result->fetch_assoc()){
                    //echo"inside while";
                    echo " <tr> <td>" . $row['ProjectTitle'] . "</td> <td> " . $row['OrganizationName'] . " </td> <td> " . $row['Paid'] . "</td> <td> " . $row['Description'] . " </td>  <td>" . $row['DominantCompetencyCategory'] . " </td> <td> " . $row['Population'] . " </td> <td> " . $row['AppliedProgramArea1'] .  "</td> <td> " . $row['AppliedProgramArea2'] .  "</td> <td> " . $row['AppliedProgramArea3'] .  "</td> <td> " . $row['Task1'] .  "</td> <td> " . $row['Task2'] .  "</td> <td> " . $row['Task3'] .  "</td> <td> " . $row['Role'] ." </td> </tr>"; 
        }
        echo "</tbody> </table>";
      echo "</div>";
       echo "</center>";

    }
?>