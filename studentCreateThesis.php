<!DOCTYPE php>
<html>
<?php
session_start();
include_once 'connection.php'; 
if($_SESSION['member_status'] != 'student'){
    header("Location: index.php");
    die();
    }
        $StudentID = ($_SERVER[HTTP_QUEENSU_EMPLID]);
        $sql = "SELECT COUNT(*) as total FROM `Student` WHERE `StudentID` = $StudentID";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result -> fetch_assoc();
        $total = $count['total'];
        $flag = FALSE;
        $comment = "Please enter any other comments";
        if ($total > 0){
            $flag = TRUE;
            $sql = "SELECT * FROM `Student` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();
            $program = $row['program'];
    }
 ?>
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
       <li><a href=<?php if($program == "MPH"){echo "studentSearchMPH.php";}elseif($program == "Masters in Biostatistics"){echo "studentSearchMSCB.php";} else {echo "studentSearchPHD.php";} ?> >Dashboard</a></li>    
        <li style="float:right"><a class="active" href="https://idptest.queensu.ca/idp/profile/Logout">Logout</a></li>
    </ul>
      <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
    <center> <h1 class="headerFont">PhD in Epidemiology Student Profile</h1> </center>
    <center> <h1><?php echo "Welcome " . ($_SERVER[HTTP_QUEENSU_GIVENNAME]) . "!"; ?> </h1> </center>
  </head>
<body>
    <?php
        include_once 'connection.php'; 
 

        $StudentID = ($_SERVER[HTTP_QUEENSU_EMPLID]);

        $sql = "SELECT COUNT(*) as total FROM `Thesis` WHERE `StudentID` = $StudentID";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result -> fetch_assoc();
        $total = $count['total'];
        $Abstract = "Please enter any other comments";
        $flag = FALSE;
        if ($total > 0){
            $flag = TRUE;
            $sql = "SELECT * FROM `Thesis` WHERE `StudentID` = $StudentID";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result -> fetch_assoc();

            $Title = $row["Title"];
            $ResearchArea = $row["ResearchArea"];
            $Supervisor = $row["Supervisor"];
            $Defence = $row["DefenseCommittee"];
            $Abstract = $row["Abstract"];

        }
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



    ?>    
 
    <div class="form" align="center">
    <form method="post">
        <fieldset>
            <LEGEND> Thesis Information</LEGEND>
            Student Number: <input type="text" name="studentNum" readonly="readonly" value="<?php echo ($_SERVER[HTTP_QUEENSU_EMPLID]);?>"/> <br>
            Thesis Title: <input type="text" value="<?php echo $Title; ?>"> <br>
            Research Area: <input type="text" value="<?php echo $ResearchArea; ?>"> <br>
            Supervisor: <input type="text" value="<?php echo $Supervisor; ?>"><br>
            Defence Committee: <input type="text" name="defence" readonly="readonly" value="<?php echo $Defence; ?>"> <br>
            Abstract: <br>
            <textarea name="Abstract" cols="100" rows="10"> <?php echo $Abstract; ?> </textarea>
        </fieldset>
        <br>
        <button class="btn btn-primary btn-md buttonColor" type="submit" name="Submit" Visibility="visible" id="Submit" method="post">Submit</button>

    </form> 
    <br><br>
    </div>

    <?php
    
 
        if(isset($_POST["Submit"])){


            $StudentID = test_input($_POST["studentNum"]);
            $Title = test_input($_POST["thesisTitle"]);
            $ResearchArea = test_input($_POST["researchArea"]);
            $Supervisor = test_input($_POST["supervisor"]);
            $Abstract = test_input($_POST["Abstract"]);


            
            if ($flag){
                $sql = "UPDATE `Thesis` SET `Title`='$Title',`ResearchArea`='$ResearchArea',`Supervisor`='$Supervisor',`Abstract`='$Abstract' WHERE `StudentID` = $StudentID";
 
                $stmt = $con->prepare($sql);
                $stmt->execute();
            }
            else{
                $sql = "INSERT INTO `Thesis`(`Title`, `ResearchArea`, `StudentID`, `Supervisor`, `Abstract`) VALUES ('$Title','$ResearchArea',$StudentID,'$Supervisor','$Abstract')";

                $stmt = $con->prepare($sql);
                $stmt->execute();

            }
            
             header("Location: studentCreateThesis.php");
             die();   
        }
       


    ?>

</body>
</html>