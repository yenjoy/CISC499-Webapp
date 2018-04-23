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
      <!-- start of navbar -->

      <ul id=navbar>

<!--         <li><a href="studentCreateMSCB.php">Edit Profile</a></li> -->
        <li><a href="profileMSCB.php">Edit Profile</a></li>
        <li><a href="studentPracticumMSC.php">Edit Practicum Evaluation</a> </li>
        <li style="float:right"><a class="active" href="https://idptest.queensu.ca/idp/profile/Logout">Logout</a></li>
      </ul>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">Biostatistics Student Dashboard</h1> </center>
    <center> <h1><?php echo "Welcome " . ($_SERVER[HTTP_QUEENSU_GIVENNAME]) . "!"; ?> </h1> </center>
  </head>

  <body>

        <center>
          <form  id="regularField" name='search'  method='post'><br><br>
            <h4 class="headerfont boldFont">General Search</h3>
              <select name="options" id="options"> 
                    <optgroup label="Student Search">
                    <option value="Facility" <?php if ($_POST['options']=='Facility') {echo "selected='selected'"; } ?> >Facility</option>
                    <option value="StudentEval" <?php if ($_POST['options']=='StudentEval') {echo "selected='selected'"; } ?> >Student Evaluation</option>
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


if(isset($_POST['searchbutton'])){
  $searchCriteria = test_input($_POST['searchbar'], $con); //get search bar content
  //echo $searchCriteria;
  $options = $_POST['options']; //See which dropdown is selected
  $showOrganizationTable = False;
  $showPracticumTable = False;
  // For debugging
 // echo $options;
  //$query="badQuery";
}

if($options == 'Facility' || $options == 'StudentEval'){  
  $showPracticumTable = True;
      if(empty($searchCriteria)){
        //echo "prac empty";
        $query = "SELECT * FROM PracticumMSC" ;
      }
      else{
        //echo "prac with text";
        $query = "SELECT * FROM PracticumMSC WHERE $options LIKE '%$searchCriteria%'";
      }
}


  // DEBUG echo $query;
  $stmt = $con->prepare($query);
  $stmt->execute();
  $result = $stmt->get_result();

if($showPracticumTable == True){
       echo "<center>";
      echo "<div class=scroll>";
        echo "<table class = 'table table-hover' id = 'practicumtable' >";
          echo "<thead>";
          echo " <tr> <th> Facility </th> <th>Student Evaluation</th></tr> </thead>";
          echo "<tbody>";
             while($row = $result->fetch_assoc()){
                    //echo"inside while";
                    echo " <tr> <td>" . $row['Facility'] . "</td> <td> " . $row['StudentEval'] . " </td> </tr>"; 
        }
        echo "</tbody> </table>";
      echo "</div>";
       echo "</center>";

    }
   
?>
