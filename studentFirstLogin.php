<!DOCTYPE php>

<?php
// Start the session
session_start();
?>
<!-- start of HTML -->
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
    <center> <h1 class="headerFont"><br><?php echo "Welcome " . ($_SERVER[HTTP_QUEENSU_GIVENNAME]) . "!"; ?> </h1> </center>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>
  </head>
<!-- Start of body -->
    <body>


        <center> 
        <br><br><br><br>
        <p style = 'font-weight: bold;'>
        To get started, please select which program you are enrolled in 
        </p>
        <br><br>

<!-- This is the drop down to select programs -->
        <form method="POST" id=selectionForm>
            
        <label>Program:</label>
        <select id=program onchange="location = this.options[this.selectedIndex].value;">
        <option value="#">Select an option</option>
        <option  value="profileMPH.php">MPH</option>
        <option value="profileMSCE.php">MSc Epidemiology</option>
        <option value="profileMSCB.php">MSc Biostatistics</option>
        <option value="profilePHD.php">PHD</option>
        </select>  
        </form>
        </center>

        <?php $_SESSION['member_status']='student'; ?>

    </body>
</html>

