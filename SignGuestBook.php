<!doctype html>

<html>
	<head>
	    <!--   
         Exercise 02_08_01
         Author: Tabitha Siclovan
         Date: November 05, 2018
        
         SignGuestBook.php
        -->
		<title>Sign Guest Book</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="modernizr.custom.65897.js"></script>
	</head>

	<body>
    <h1>Sign Guest Book</h1>
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
            echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
        }
        else {
            echo "<p>Could not select the \"$DBName\" database: " . 
                mysqli_error($DBConnect) . ", creating it.</p>\n";
            $sql = "CREATE DATABASE $DBName";
            if (mysqli_query($DBConnect, $sql)) {
                echo "<p>Successfully created the \"$DBName\" database.</p>\n";
                $success = mysqli_select_db($DBConnect, $DBName);
                if ($success) {
                    echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
                }
            }
            else {
                echo "<p>Could not create the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
            }
        }
        return $success;
    }
    function createTable($DBConnect, $tableName) {
        $success = false;
        $sql = "SHOW TABLES LIKE '$tableName'";
        $result = mysqli_query($DBConnect, $sql);
        if (mysqli_num_rows($result) === 0) {
            echo "The <strong>$tableName</strong> table does not exist, creating table.<br>\n";
            $sql = "CREATE TABLE $tableName (countID SMALLINT 
            NOT NULL AUTO_INCREMENT PRIMARY KEY, 
            lastName VARCHAR(40), 
            firstName VARCHAR(40))";
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
    $hostname = "localhost";
    $userName = "adminer";
    $password = "after-water-49";
    $DBName = "guestbook";
    $tableName = "visitors";
    $firstName = "";
    $lastName = "";
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
                    echo "<p>Connection Successful!</p>\n";
                    $sql = "INSERT INTO $tableName
                        VALUES(NULL '$lastName',
                        '$firstName')";
                    $result = mysqli_query($DBConnect, $sql);
                    if ($result === false) {
                        echo "<p>Unable to execute the query.</p>";
                        echo "<p>Error code " . mysqli_errno($DBConnect) . ": " . 
                            mysqli_error($DBConnect) . "</p>";
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
    }
    ?>
    <form action="SignGuestBook.php" method="post">
        <p><strong>First Name: </strong><br>
            <input type="text" name="firstName" value="<?php echo $firstName; ?>"></p>
        <p><strong>Last Name: </strong><br>
            <input type="text" name="lastName" value="<?php echo $lastName; ?>"></p>
        <p><input type="submit" name="submit" value="Submit"></p>
    </form>
	</body>
</html>