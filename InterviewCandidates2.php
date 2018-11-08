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
       <?php
        $hostName = "localhost";
        $userName = "adminer";
        $password = "after-water-49";
        $DBName = "interviews2";
        $tableName = "interviewee";
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
        $showForm = false;
         $DBConnect = mysqli_connect($hostName, $userName, $password);
        //If else if or if not create connection
        if (!$DBConnect) {
            //Failure (doesn't connect)
            echo "<p>Connection Failed.</p>\n";
        }
        else {
            //Embed sql command into a string
            $sql = "CREATE DATABASE $DBName";
            //set a command
            if (mysqli_query($DBConnect, $sql)) {
                //Success
                echo "<p>Successfully created the \"$DBName\" database.</p>\n";
            }
            else {
                //Failure
                echo "<p>Could not create the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
            }
            mysqli_close($DBConnect);
        }
        //////////////////
         function createTable($DBConnect, $tableName) {
        $success = false;
        $sql = "SHOW TABLES LIKE '$tableName'";
        $result = mysqli_query($DBConnect, $sql);
        if (mysqli_num_rows($result) === 0) {
            echo "The <strong>$tableName</strong> table does not exist, creating table.<br>\n";
             $sql = "CREATE TABLE $tableName " . 
                        "(Interview SMALLINT NOT NULL" . 
                        " AUTO_INCREMENT PRIMARY KEY," . 
                        " firstName VARCHAR(80), lastName VARCHAR(80), position VARCHAR(100)," . 
                        " date DATE, firstName2 VARCHAR(80), lastName2 VARCHAR(80), communication VARCHAR(80),
                        appearance VARCHAR(80), cSkills VARCHAR(80), business VARCHAR(80), comments VARCHAR(80))";
            $result = mysqli_query($DBConnect, $sql);
            if ($result === false) {
                $success = false;
                echo "<p>Unable to create the $tableName table.</p>";
               echo "<p>Error code " . mysqli_errno($DBConnect) . ": " . mysqli_error($DBConnect) . "</p>";
            }
            else {
                $success = true;
               echo "<p>Successfully created the $tableName table.</p>";
            }
        }
        else {
            $success = true;
            echo "<p>The $tableName table already exists.<br>\n";
        }
        return $success;
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
                            echo "<h3>Thank you for signing our guest book!</h3>";
                            $firstName = "";
                            $lastName = "";
                        }
                    }
                }
                mysqli_close($DBConnect);
            }
        }
        //////////////////
                   
                
        
        //////////////////
        if (isset($_POST['submit'])) {
            $formErrorCount = 0;
            if (!empty($_POST['firstName'])) {
                $firstName = stripslashes($_POST['firstName']);
                $firstName = trim($firstName);
                if (strlen($firstName) === 0) {
                    ++$formErrorCount;
                    echo "<p>You must include your" . 
                    " <strong>first name</strong>!</p>\n";
                }
            }
            else {
                ++$formErrorCount;
                echo "<p>Form submittal error, no" . 
                     " <strong>first name</strong> field!</p>\n";
            }
            if (!empty($_POST['lastName'])) {
                $lastName = stripslashes($_POST['lastName']);
                $lastName = trim($lastName);
                if (strlen($lastName) === 0) {
                    ++$formErrorCount;
                    echo "<p>You must include your" . 
                    " <strong>last name</strong>!</p>\n";
                }
            }
            else {
                ++$formErrorCount;
                echo "<p>Form submittal error, no" . 
                     " <strong>last name</strong> field!</p>\n";
            }
            if ($formErrorCount == 0) {
                $showForm = false;
                $DBConnect = mysqli_connect($hostName, $userName, $password);
                //If else if or if not create connection
                if (!$DBConnect) {
                    //Failure (doesn't connect)
                    echo "<p>Connection Error: " . mysqli_connect_error() . "</p>\n";
                }
                else {
                    //set a command
                    if (mysqli_select_db($DBConnect, $DBName)) {
                        //Success
                        echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
                        $subscriberDate = date("Y-m-d");
                        $sql = "INSERT INTO $tableName" . 
                            " (name, email, subscribeDate)" . 
                            " VALUES ('$firstName'," . 
                            " '$lastName'," . 
                            " '$position'," . 
                            " '$date'," . 
                            " '$firstName2'," . 
                            " '$lastName2'," . 
                            " '$communication'," . 
                            " '$appearance'," . 
                            " '$cSkills'," . 
                            " '$business'," . 
                            " '$comments',)";
                        $result = mysqli_query($DBConnect, $sql);
                        if (!$result) {
                            echo "<p>Unable to insert the values" .
                                " into the <strong>$tableName" . 
                                "</strong> table.</p>\n";
                        }
                        else {
                            $interview = 
                                mysqli_insert_id($DBConnect);
                            echo "<p><strong>" .
                                htmlentities($firstName) .
                                "</strong>, you are now" .
                                " in the interview process.<br>";
                            echo "Your subscriber ID is" .
                                " <strong>$interview</strong>.<br>";
                            echo "Your last is <strong>" . 
                                htmlentities($lastName) . 
                                "</strong>.</p>";
                        }
                    }
                    else {
                        //Failure
                        echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
                    }
                    mysqli_close($DBConnect);
                }
            }
            else {
                $showForm = true;
            }
        }
        else {
            $showForm = true;
        }
        if ($showForm) {
        ?>
        <form action="InterviewCandidates2.php" method="post">
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
            <input type="text" name="firstName1" value="<?php echo $firstName; ?>"></p>
        <p><strong>Last Name: </strong><br>
            <input type="text" name="lastName2" value="<?php echo $lastName; ?>"></p>
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
           <textarea name="cSkills" rows="3" cols="30" style="margin: 10px 5px 5px" value="<?php echo $cSkills; ?>"></textarea></p>
        <p><strong>Business Knowledge: </strong><br>
           <textarea name="business" rows="3" cols="30" style="margin: 10px 5px 5px" value="<?php echo $business; ?>"></textarea></p>
        <p><strong>Interviewer's Comments: </strong><br>
           <textarea name="comments" rows="6" cols="80" style="margin: 10px 5px 5px" value="<?php echo $comments; ?>"></textarea></p>
           <hr>
        <p><input type="submit" name="submit" value="Submit"></p>
        <hr>
    </form>
	</body>
</html>
<?php
    }
?>