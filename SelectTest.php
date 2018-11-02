<!doctype html>

<html>
	<head>
	    <!--   
         Exercise 02_08_01
         Author: Tabitha Siclovan
         Date: November 01, 2018
        
         SelectTest.php
        -->
		<title>Select Test</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="modernizr.custom.65897.js"></script>
	</head>

	<body>
        <h2>Select Test</h2>
        <?php
        $hostName = "localhost";
        $userName = "adminer";
        $password = "after-water-49";
        $DBName = "newsletter2";
        $DBConnect = mysqli_connect($hostName, $userName, $password);
        //If else if or if not create connection
        if (!$DBConnect) {
            //Failure (doesn't connect)
            echo "<p>Connection Failed.</p>\n";
        }
        else {
            //set a command
            if (mysqli_select_db($DBConnect, $DBName)) {
                //Success
                echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
            }
            else {
                //Failure
                echo "<p>Could not select the \"$DBName\" database: " . mysqli_error($DBConnect) . "</p>\n";
            }
            mysqli_close($DBConnect);
        }
        ?>
	</body>
</html>