<!doctype html>

<html>
	<head>
	    <!--   
         Exercise 02_08_01
         Author: Tabitha Siclovan
         Date: October 30, 2018
        
         MySQLinfo.php
        -->
		<title>MySQL Info</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="modernizr.custom.65897.js"></script>
	</head>

	<body>
        <h2>MySQL Database Server Information</h2>
        <?php
        $hostName = "localhost";
        $userName = "adminer";
        $password = "after-water-49";
        $DBConnect = mysqli_connect($hostName, $userName, $password);
        //If else if or if not create connection
        if (!$DBConnect) {
            //Failure
            echo "<p>Connection Failed.</p>\n";
        }
        else {
            //Success
            echo "<p>Connection Successful.</p>\n";
            mysqli_close($DBConnect);
        }
        ?>
	</body>
</html>