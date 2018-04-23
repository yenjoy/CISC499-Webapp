<!DOCTYPE php>
<?php
/*
The landing page for administrators. This page allows them to choose which programs they are interested in.
*/
// Start the session
session_start();
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
    <link href="css/Index.css" type="text/css" rel="stylesheet">
    <link href="css/global.css" type="text/css" rel="stylesheet">
    <img src="Assets/banner.jpg" id="header">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
          <ul id="navbar">
        <li style="float:right"><a class="active" href="https://login.queensu.ca/idp/logout.jsp">Logout</a></li>
      </ul>
    <center> <h1 class="headerFont"><br><?php echo "Welcome " . ($_SERVER[HTTP_COMMON_NAME]) . "!"; ?> </h1> </center>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>

  </head>
  <body>
    <div class="center">
<form method="post">
  <br><br><br><br><br>
<label  class="checkbox-inline labelStyle"><input class="checkboxes" id="mphcheck" onclick="mphcheckboxClick()"  type="radio" name="program[]" value="mph"> &nbsp &nbsp MPH</label>&nbsp;&nbsp;&nbsp;
<label class="checkbox-inline labelStyle"><input class="checkboxes" id="biocheck" onclick="msccheckboxClick()" type="radio" name="program[]" value="bio"> &nbsp &nbspBio</label>&nbsp;&nbsp;&nbsp;
<label class="checkbox-inline labelStyle"><input class="checkboxes" id="msccheck" onclick="msccheckboxClick()" type="radio" name="program[]" value="msc"> &nbsp &nbsp MSc</label>&nbsp;&nbsp;&nbsp;
<label class="checkbox-inline labelStyle"><input class="checkboxes" id="phdcheck" onclick="msccheckboxClick()" type="radio" name="program[]" value="phd">&nbsp &nbsp PhD</label>&nbsp;&nbsp;&nbsp;
<br><br><br>
<center><button type="submit" class="btn btn-primary btn-md buttonColor" name="gobutton" id="gobutton" method="post">Go</button></center><br><br>
</form>
</div>
  </body>


<?php
// used to connect to the database
include_once 'connection.php'; 

//Build the query to check if the user is an admin
$fName = $_SERVER[HTTP_QUEENSU_GIVENNAME];
$lName = $_SERVER[HTTP_QUEENSU_SURNAME];
$query = "SELECT * FROM Admin WHERE firstName='$fName' AND lastName='$lName'";
if($stmt = $con->prepare($query)){       
    // Execute the query
    $stmt->bind_param("ss", $fName, $lName);
		$stmt->execute();
		/* resultset */
		$result = $stmt->get_result();
		// Get the number of rows returned
		$num = $result->num_rows;
    //this user is not an admin, redirect them to the student page
		if($num<=0){
        $querytwo = "SELECT * FROM Student WHERE FName='$fName' AND LName='$lName'";
        if($stmttwo = $con->prepare($querytwo)){       
            // Execute the query

            $stmttwo->bind_param("ss", $fName, $lName);
            $stmttwo->execute();
            /* resultset */
            $resulttwo = $stmttwo->get_result();
            // Get the number of rows returned
            $numtwo = $resulttwo->num_rows;
            //The student is not in the DB yet, take them to the first time login page
            if($numtwo<=0){
              $_SESSION['member_status'] = 'new';
              header("Location: studentFirstLogin.php");
              die();
            }
            else{     
              $_SESSION['member_status'] = 'student';       
              $rowtwo = $resulttwo->fetch_assoc();  
              if($rowtwo['Program'] == "MPH"){
                //store a session variable of the program
                //this is useful for MSC/PHD profile page redirects
                $_SESSION['program']= 'MPH';
                header("Location: studentSearchMPH.php");
                die();
              }
          elseif($rowtwo['Program'] == "Masters in Biostatistics") {
              $_SESSION['program']= 'bio';
              header("Location: studentSearchMSC.php");
              die();
            }
          else{
            
              if ($rowtwo['Program'] == "Masters in Epidemiology"){
                $_SESSION['program']= 'MSCE';
              }
              else{
                $_SESSION['program']= 'PHD';
              }

            header("Location: studentSearchPHD.php");
            die();
          }
        }
    }
    }
    else{
      $_SESSION['member_status'] = 'admin';
  
    }
}

//form submission
if(isset($_POST['gobutton'])){
  if(!empty($_POST['program'])){
    $_SESSION["mph"] = false;
    $_SESSION["bio"] = false;
    $_SESSION["msc"] = false;
     $_SESSION["phd"] = false;
// Loop to store and display values of individual checked checkbox.
    foreach($_POST['program'] as $selected){
          if($selected=="mph"){
            $_SESSION["mph"] = true;
          }
//These session variables are used on the search pages to know what data should be displayed
          if($selected=="bio"){
            $_SESSION["bio"] = true;        
          }

          if($selected=="msc"){
            $_SESSION["msc"] = true;
          }

          if($selected=="phd"){
            $_SESSION["phd"] = true;
          }
          }

          if($_SESSION["mph"] == true) {
            header("Location: MPHAdminDashboard.php");
            die();
          }
          else{
            header("Location: MSCAdminDashboard.php");
            die();
          }
      }

     

  }
?>

</html>
