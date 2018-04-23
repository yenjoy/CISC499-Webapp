<!DOCTYPE php>
 <?php
// Start the session
session_start();
if($_SESSION["member_status"] != "admin"){
    header("Location: index.php");
    die();
}

include_once 'connection.php'; 
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
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <link href="css/global.css" type="text/css" rel="stylesheet">
    <link href="css/adminDashboard.css" type="text/css" rel="stylesheet">
    <img src="Assets/banner.jpg" id="header">
    <script src="tableToExcel.js"></script>
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="src/jquery.table2excel.js"></script>

    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
      <ul id="navbar">
      <li><a href="<?php if($_SESSION["mph"]== true){ echo 'MPHAdminDashboard.php';} else{ echo 'MSCAdminDashboard.php';} ?>" >Back</a></li>
      <li> <a>Add Profile</a>
        <ul>
            <a href="#">Student</a>
            <a href="#">Administrator</a>
            <a href="#">Organization</a>
            <a href="#">Practicum</a>
        </ul>
        </li>
        <li style="float:right"><a class="active" href="https://idptest.queensu.ca/idp/profile/Logout">Logout</a></li>
      </ul>
    <br><br>
    <h2 class="bannerTextPosition bannerFont"> Public Health Sciences <br> Web Application </h2>

  </head>

<body>
<center>
<form  id="saveviewform" name='saveviewform'  method='post' ><br><br>
            <h4 class="headerfont boldFont">Select a View </h4><br>
    <select name="viewlist" id="viewlist" style='width: 250px; height: 25px;'  required>
        <option selected disabled></option>
        <?php
            $sql = "SELECT `Name`, `Id` FROM `View`";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            while($row = $result->fetch_assoc()){
                    echo " <option  value = ". $row['Id'] . ">" . $row['Name'] . "</option>" ; 
            }
        ?>
    </select>   <br><br>
             <center> <button class='btn btn-primary btn-md buttonColor' type='submit' name='loadview'  id='loadview'  method='post'>Load View</button><br><br> </center>

            </form>
            <iframe id="txtArea1" style="display:none"></iframe>

</center>
</body>

<?php 

//if(isset($_POST["saveview"])){  
    if(isset($_POST["loadview"])){
        $queryId = $_POST["viewlist"];

            $sql = " SELECT Query, ColumnCount FROM View WHERE Id = $queryId";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();


            // Get the number of rows returned
            $num = $result->num_rows;
            if($num<=0){
                //display en error
            }
            else{
                $row = $result->fetch_assoc();
                $query = $row["Query"];
                $columncount = $row["ColumnCount"];
                // ^ We get the column count (saved in the db) so we know how many columns to show. Mostly useful for dealing with tasks/APA

                $secondstmt = $con->prepare($query); //Now that we have that query for the view, execute it
                $secondstmt->execute();
                $secondresult = $secondstmt->get_result(); //this is the results to store in the table
                $adjustedquery = explode('FROM' , $query); //To get the table headers (fields) we need to get them from the query, this 3 lines do that
                $adjustedquery = explode ('SELECT' , $adjustedquery[0]);
                $adjustedquery = explode (',' , $adjustedquery[1]);
                $i = 0;
                //Remove the exrta spaces that were left from deleteing the commas 
                while($i < $columncount){
                    $adjustedquery[$i] = substr($adjustedquery[$i], 1);
                    if($adjustedquery[$i]== "Student.StudentID" || $adjustedquery[$i]== " Student.StudentID" ||  $adjustedquery[$i]== "Student.StudentID " ){
                        $adjustedquery[$i]= "StudentID";
                    }
                    elseif($adjustedquery[$i]== "Organization.OrganizationID"){
                        $adjustedquery[$i]= "OrganizationID";
                    }
                    $i = $i +1; 
                    
                }
                $adjustedquery[$i-1] = substr($adjustedquery[$i-1], 0, -1);
        		echo "<table id='testTable' class = 'table table-hover table2excel'>";
        	echo "<thead>";
        	echo "<tr>";
     $h = 0; 


//these tables work the exact same as the ones in the advanced search. I see no reason why it would not work...
     	while($h < $i){ //first while for the headers, this works fine
     		echo "<th>". $adjustedquery[$h] . "</th>";
     		$h = $h + 1;
     	}
     	echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
  
    $t = 0;
    $s = 0;

    while(($row = $secondresult->fetch_assoc())){ //this is filling the content, this is what's not working'
    		$t = 0;
    			echo "<tr>";
    			while($t < $i){
                    echo " <td >" . $row[$adjustedquery[$t]] . "</td>"; //LINE CAUSING THE ERROR
                    $t = $t +1;
    		}$s = $s +1;
    		echo "</tr>";
    	} 
            echo "</tbody>";
    		echo "</table>";



   }
}
    

?>

