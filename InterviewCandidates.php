<!doctype html>

<html>
	<head>
	    <!--   
         Exercise 02_08_01
         Author: Tabitha Siclovan
         Date: November 06, 2018
        
         InterviewCandidates.php
        -->
		<title>Interview Candidates</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="modernizr.custom.65897.js"></script>
	</head>

	<body style="background-color: rgb(237, 222, 230); text-align:center;">
        <h2>Interviewer's Name</h2>
        <hr>
        <?php
        function connectToDB($hostname, $userName, $password) {
        $DBConnect = mysqli_connect($hostname, $userName, $password);
        if (!$DBConnect) {
            echo "<p>Connection Error: " . mysqli_connect_error() . "</p>\n";
        }
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
    function createTable($DBConnect, $tableName) {
        $success = false;
        $sql = "SHOW TABLES LIKE '$tableName'";
        $result = mysqli_query($DBConnect, $sql);
        if (mysqli_num_rows($result) === 0) {
            //echo "The <strong>$tableName</strong> table does not exist, creating table.<br>\n";
            $sql = "CREATE TABLE $tableName (countID SMALLINT 
            NOT NULL AUTO_INCREMENT PRIMARY KEY, 
            lastName VARCHAR(40), 
            firstName VARCHAR(40))";
            $result = mysqli_query($DBConnect, $sql);
            if ($result === false) {
                $success = false;
                //echo "<p>Unable to create the $tableName table.</p>";
               // echo "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
            }
            else {
                $success = true;
               // echo "<p>Successfully created the $tableName table.</p>";
            }
        }
        else {
            $success = true;
            //echo "<p>The $tableName table already exists.<br>\n";
        }
        return $success;
    }
        //Variables
        $hostName = "localhost";
        $userName = "adminer";
        $password = "after-water-49";
        $DBName = "interviews";
        $tableName = "interviewee";
        $firstName = "";
        $lastName = "";
        $position = "";
        $date = "";
        $communication = "";
        $appearance = "";
        $formErrorCount = 0;
    if (isset($_POST['submit'])) {
        $firstName = stripslashes($_POST['firstName']);
        $firstName = trim($firstName);
        $lastName = stripslashes($_POST['lastName']);
        $lastName = trim($lastName);
        if (empty($firstName) || empty($lastName)) {
            echo "<p>You must enter your first and last <strong>name</strong>.</p>\n";
            ++$formErrorCount;
        }
        if ($formErrorCount === 0) {
            $DBConnect = connectToDB($hostname, $userName, $password);
            if ($DBConnect) {
                if (selectDB($DBConnect, $DBName)) {
                    if (createTable($DBConnect, $tableName)) {
                   // echo "<p>Connection Successful!</p>\n";
                    $sql = "INSERT INTO $tableName VALUES(NULL, '$lastName', '$firstName')";
                    $result = mysqli_query($DBConnect, $sql);
                    if ($result === false) {
                        //echo "<p>Unable to execute the query.</p>";
//                        echo "<p>Error code " . mysqli_errno($DBConnect) . ": " . 
//                            mysqli_error($DBConnect) . "</p>";
                    }
                        else {
                            echo "<h3>Thank you for completing the interview!</h3>";
                            $firstName = "";
                            $lastName = "";
                        }
                    }
                }
                mysqli_close($DBConnect);
            }
        }
    }
        ?>
        <form action="InterviewCandidates.php" method="post">
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
            <input type="text" name="firstName" value="<?php echo $firstName; ?>"></p>
        <p><strong>Last Name: </strong><br>
            <input type="text" name="lastName" value="<?php echo $lastName; ?>"></p>
        <p><strong>Communication Abilities: </strong><br><br>
           <input type="checkbox" name="communication" value="<?php echo $communication; ?>"> Listening <br>
           <input type="checkbox" name="communication" value="<?php echo $communication; ?>"> Eye Contact<br>
           <input type="checkbox" name="communication" value="<?php echo $communication; ?>"> Clear/Concise <br>
           <input type="checkbox" name="communication" value="<?php echo $communication; ?>"> Friendly <br>
           <input type="checkbox" name="communication" value="<?php echo $communication; ?>"> Confident<br>
           <input type="checkbox" name="communication" value="<?php echo $communication; ?>"> Empathetic<br>
           <input type="checkbox" name="communication" value="<?php echo $communication; ?>"> Other <input type="text" size="10"></p>
        <p><strong>Professional Appearance: </strong><br>
           <input type="checkbox" name="appearance" value="<?php echo $appearance; ?>"> Clean & Neat <br>
           <input type="checkbox" name="appearance" value="<?php echo $appearance; ?>"> Conservative<br>
           <input type="checkbox" name="appearance" value="<?php echo $appearance; ?>"> Business Clothing<br>
           <input type="checkbox" name="appearance" value="<?php echo $appearance; ?>"> Clean Shaven <br>
           <input type="checkbox" name="appearance" value="<?php echo $appearance; ?>"> Groomed<br>
           <input type="checkbox" name="appearance" value="<?php echo $appearance; ?>"> Other <input type="text" size="10">
        <p><strong>Computer Skills: </strong><br>
           <textarea name="cSkills" rows="3" cols="30" style="margin: 10px 5px 5px"></textarea></p>
        <p><strong>Business Knowledge: </strong><br>
           <textarea name="business" rows="3" cols="30" style="margin: 10px 5px 5px"></textarea></p>
        <p><strong>Interviewer's Comments: </strong><br>
           <textarea name="comments" rows="6" cols="80" style="margin: 10px 5px 5px"></textarea></p>
           <hr>
        <p><input type="submit" name="submit" value="Submit"></p>
        <hr>
    </form>
     <?php
        $DBConnect = connectToDB($hostname, $userName, $password);
        if ($DBConnect) {
            if (selectDB($DBConnect, $DBName)) {
                if (createTable($DBConnect, $tableName)) {
                    //echo "<p>Connection Successful!</p>\n";
                    echo "<h2>Visitors Log</h2>";
                    $sql = "SELECT * FROM $tableName";
                    $result = mysqli_query($DBConnect, $sql);
                    if (mysqli_num_rows($result) == 0) {
                        echo "<p>There are no entries in the quest book!</php>";
                    }
                    else {
                        echo "<table width='60%' border='1'>";
                        echo "<tr>";
                        echo "<th>Visitor</th>";
                        echo "<th>First Name</th>";
                        echo "<th>Last Name</th>";
                        echo "</tr>";
                        while ($row = mysqli_fetch_row($result)) {
                            echo "<tr>";
                            echo "<td width='10%' style='text-align:center'>$row[0]</td>";
                            echo "<td>$row[1]</td>";
                            echo "<td>$row[2]</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                        mysqli_free_result($result);
                    }
                }
            }
            mysqli_close($DBConnect);
        }
    ?>
	</body>
</html>