<!doctype html>

<html>
	<head>
	    <!--   
         Exercise 02_08_01
         Author: Tabitha Siclovan
         Date: November 02, 2018
        
         NewsletterSubscribers.php
        -->
		<title>Newsletter Subscribers</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="modernizr.custom.65897.js"></script>
	</head>

	<body>
        <h2>Newsletter Subscribers</h2>
        <?php
        $hostName = "localhost";
        $userName = "adminer";
        $password = "after-water-49";
        $DBName = "newsletter2";
        $tableName = "subscribers";
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
                $sql = "SELECT * FROM $tableName";
                $result = mysqli_query($DBConnect, $sql);
                echo "<p>Number of rows in" . 
                    " <strong>$tableName</strong>: " . 
                    mysqli_num_rows($result) . ".</p>\n";
                echo "<table width='100%' border='1'>";
                echo "<tr>";
                echo "<th>Subscriber ID</th>";
                echo "<th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Subscribe Date</th>";
                echo "<th>Confirmed Date</th>";
                echo "</tr>\n";
                while ($row = mysqli_fetch_row($result)) {
                    echo "<tr>";
                    echo "<td>{$row[0]}</td>";
                    echo "<td>{$row[1]}</td>";
                    echo "<td>{$row[2]}</td>";
                    echo "<td>{$row[3]}</td>";
                    echo "<td>{$row[4]}</td>";
                    echo "</tr>\n";
                }
                echo "</table>\n";
                mysqli_free_result($result);
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