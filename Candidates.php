<!doctype html>

<html>
	<head>
	    <!--   
         Exercise 02_08_01
         Author: Tabitha Siclovan
         Date: November 05, 2018
        
         Candidates.php
        -->
		<title>Candidates</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="modernizr.custom.65897.js"></script>
	</head>
	<body style="text-align:center; background-color: rgb(237, 222, 230);">
    <h2>Interviewer Name</h2>
    <?php
    //Function to connect to the database
    function connectToDB($hostname, $userName, $password) {
        $DBConnect = mysqli_connect($hostname, $userName, $password);
        if (!$DBConnect) {
            echo "<p>Connection Error: " . mysqli_connect_error() . "</p>\n";
        }
        //Return the database connection
        return $DBConnect;
    }
    function selectDB($DBConnect, $DBName) {
        $success = mysqli_select_db($DBConnect, $DBName);
        if ($success) {
            //echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
        }
        else {
            //echo "<p>Could not select the \"$DBName\" database: " . 
                //mysqli_error($DBConnect) . ", creating it.</p>\n";
            $sql = "CREATE DATABASE $DBName";
            if (mysqli_query($DBConnect, $sql)) {
                //echo "<p>Successfully created the \"$DBName\" database.</p>\n";
                $success = mysqli_select_db($DBConnect, $DBName);
                if ($success) {
                    //echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
                }
            }
            else {
              //  echo "<p>Could not create the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
            }
        }
        return $success;
    }
    //Function to create the table
    function createTable($DBConnect, $tableName) {
        $success = false;
        //Show the table
        $sql = "SHOW TABLES LIKE '$tableName'";
        $result = mysqli_query($DBConnect, $sql);
        if (mysqli_num_rows($result) === 0) {
            echo "The <strong>$tableName</strong> table does not exist, creating table.<br>\n";
            //The different table fields
            $sql = "CREATE TABLE $tableName (countID SMALLINT" . 
            " NOT NULL AUTO_INCREMENT PRIMARY KEY," .  
            " lastName VARCHAR(40)," .  
            " firstName VARCHAR(40), position VARCHAR(100)," . 
            " date DATE, firstName2 VARCHAR(80), lastName2 VARCHAR(80), communication VARCHAR(80)," . 
            " appearance VARCHAR(80), cSkills VARCHAR(80), business VARCHAR(80), comments VARCHAR(80))";
            $result = mysqli_query($DBConnect, $sql);
            if ($result === false) {
                $success = false;
                //echo "<p>Unable to create the $tableName table.</p>";
               echo "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
            }
            else {
                $success = true;
               //echo "<p>Successfully created the $tableName table.</p>";
            }
        }
        else {
            $success = true;
           // echo "<p>The $tableName table already exists.<br>\n";
        }
        return $success;
    }
    //All of the required variables with the form
    $hostname = "localhost";
    $userName = "adminer";
    $password = "after-water-49";
    $DBName = "candidate";
    $tableName = "interview";
    $firstName = "";
    $lastName = "";
        $position = "";
        $date = "";
        $firstName2 = "";
        $lastName2 = "";
        $communication = "";
        $appearance = "";
        $cSkills = "";
        $business = "";
        $comments = "";
        $formErrorCount = 0;
    $formErrorCount = 0;
    //The submit
    if (isset($_POST['submit'])) {
        //Strip and trim each of the variables individually
        $firstName = stripslashes($_POST['firstName']);
        $firstName = trim($firstName);
        $lastName = stripslashes($_POST['lastName']);
        $lastName = trim($lastName);
        $position = stripslashes($_POST['position']);
        $position = trim($position);
        $date = stripslashes($_POST['date']);
        $date = trim($date);
        $firstName2 = stripslashes($_POST['firstName2']);
        $firstName2 = trim($firstName2);
        $lastName2 = stripslashes($_POST['lastName2']);
        $lastName2 = trim($lastName2);
        $communication = stripslashes($_POST['communication']);
        $communication = trim($communication);
        $appearance = stripslashes($_POST['appearance']);
        $appearance = trim($appearance);
        $cSkills = stripslashes($_POST['cSkills']);
        $cSkills = trim($cSkills);
        $business = stripslashes($_POST['business']);
        $business = trim($business);
        $comments = stripslashes($_POST['comments']);
        $comments = trim($comments);
        if (empty($firstName) || empty($lastName)) {
            echo "<p>You must enter your first and last <strong>name</strong>.</p>\n";
            ++$formErrorCount;
        }
        //If there are no errors
        if ($formErrorCount === 0) {
            $DBConnect = connectToDB($hostname, $userName, $password);
            if ($DBConnect) {
                if (selectDB($DBConnect, $DBName)) {
                    if (createTable($DBConnect, $tableName)) {
                   // echo "<p>Connection Successful!</p>\n";
                    //$sql = "INSERT INTO $tableName VALUES(NULL, '$lastName', '$firstName')";
                         $sql = "INSERT INTO $tableName" . 
                            " VALUES(NULL," .
                            " '$firstName'," . 
                            " '$lastName'," . 
                            " '$position'," . 
                            " '$date'," . 
                            " '$firstName2'," . 
                            " '$lastName2'," . 
                            " '$communication'," . 
                            " '$appearance'," . 
                            " '$cSkills'," . 
                            " '$business'," . 
                            " '$comments')";
                        //result variable
                    $result = mysqli_query($DBConnect, $sql);
                    if ($result === false) {
                        //Error, Query cannot execute
                        echo "<p>Unable to execute the query.</p>";
                        echo "<p>Error code " . mysqli_errno($DBConnect) . ": " . 
                            mysqli_error($DBConnect) . "</p>";
                    }
                        else {
                            //Will echo after form filled out completely when interview is completed
                            echo "<h3>Thank you for taking an interview!</h3>";
                            $firstName = "";
                            $lastName = "";
                        }
                    }
                }
                //Close the database connection
                mysqli_close($DBConnect);
            }
        }
    }
    ?>
    <!--Form containing fields for the interviewer and interviewee-->
      <form action="Candidates.php" method="post">
        <p><strong>First Name: </strong><br>
            <input type="text" name="firstName" value="<?php echo $firstName; ?>"></p>
        <p><strong>Last Name: </strong><br>
            <input type="text" name="lastName" value="<?php echo $lastName; ?>"></p>
        <p><strong>Position: </strong><br>
            <input type="text" name="position" value="<?php echo $position; ?>"></p>
         <p><strong>Date of Interview: </strong><br>
            <input type="date" name="date" value="<?php echo $date; ?>"></p>
            <hr>
        <h2>Candidate's Name</h2>
        <p><strong>First Name: </strong><br>
            <input type="text" name="firstName2" value="<?php echo $firstName; ?>"></p>
        <p><strong>Last Name: </strong><br>
            <input type="text" name="lastName2" value="<?php echo $lastName; ?>"></p>
        <p><strong>Communication Abilities: </strong><br>
          <textarea name="communication" rows="3" cols="30" style="margin: 10px 5px 5px; resize:none;" value="<?php echo $communication; ?>"></textarea>
           </p>
        <p><strong>Professional Appearance: </strong><br>
         <textarea name="appearance" rows="3" cols="30" style="margin: 10px 5px 5px; resize:none;" value="<?php echo $appearance; ?>"></textarea>
          </p>
        <p><strong>Computer Skills: </strong><br>
           <textarea name="cSkills" rows="3" cols="30" style="margin: 10px 5px 5px; resize:none;" value="<?php echo $cSkills; ?>"></textarea></p>
        <p><strong>Business Knowledge: </strong><br>
           <textarea name="business" rows="3" cols="30" style="margin: 10px 5px 5px; resize:none;" value="<?php echo $business; ?>"></textarea></p>
        <p><strong>Interviewer's Comments: </strong><br>
           <textarea name="comments" rows="6" cols="80" style="margin: 10px 5px 5px; resize:none;" value="<?php echo $comments; ?>"></textarea></p>
           <hr>
        <p><input type="submit" name="submit" value="Submit"></p>
        <hr>
    </form>
    <?php
        
        $DBConnect = connectToDB($hostname, $userName, $password);
        if ($DBConnect) {
            //If statement to make sure the database connects
            if (selectDB($DBConnect, $DBName)) {
                if (createTable($DBConnect, $tableName)) {
                    //echo "<p>Connection Successful!</p>\n";
                    echo "<h2>Interview Reports</h2>";
                    $sql = "SELECT * FROM $tableName";
                    $result = mysqli_query($DBConnect, $sql);
                    if (mysqli_num_rows($result) == 0) {
                        //If no interviews are submitted, this error will pop up
                        echo "<p>There are no interview entries!</php>";
                    }
                    else {
                        //Styles for the table and table structure
                        echo "<table width='100%' border='1' style='background-color:rgb(221, 164, 218)'>";
                        echo "<tr>";
                        //Different table headers
                        echo "<th>Visitor</th>";
                        echo "<th>Interviewer First Name</th>";
                        echo "<th>Interviewer Last Name</th>";
                        echo "<th>Position</th>";
                        echo "<th>Date of Interview</th>";
                        echo "<th>Candidate First Name</th>";
                        echo "<th>Candidate Last Name</th>";
                        echo "<th>Communication</th>";
                        echo "<th>Appearance</th>";
                        echo "<th>Computer Skills</th>";
                        echo "<th>Business Skills</th>";
                        echo "<th>Comments</th>";
                        echo "</tr>";
                        //While loop to loop through the different rows in the table
                        while ($row = mysqli_fetch_row($result)) {
                            echo "<tr>";
                            echo "<td width='5%' style='text-align:center'>$row[0]</td>";
                            echo "<td>$row[1]</td>";
                            echo "<td>$row[2]</td>";
                            echo "<td>$row[3]</td>";
                            echo "<td>$row[4]</td>";
                            echo "<td>$row[5]</td>";
                            echo "<td>$row[6]</td>";
                            echo "<td>$row[7]</td>";
                            echo "<td>$row[8]</td>";
                            echo "<td>$row[9]</td>";
                            echo "<td>$row[10]</td>";
                            echo "<td>$row[11]</td>";
                            echo "</tr>";
                        }
                        //Echos out the table result
                        echo "</table>";
                        mysqli_free_result($result);
                    }
                }
            }
            //Closes the database connection
            mysqli_close($DBConnect);
        }
    ?>
	</body>
</html>