<!doctype html>

<html>
	<head>
	    <!--   
         Exercise 02_08_01
         Author: Tabitha Siclovan
         Date: November 01, 2018
        
         CreateSubscribersTable.php
        -->
		<title>Create Subscribers Table</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="modernizr.custom.65897.js"></script>
	</head>

	<body>
        <h2>Create Subscribers Table</h2>
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
            echo "<p>Connection Failed.</p>\n";
        }
        else {
            //set a command
            if (mysqli_select_db($DBConnect, $DBName)) {
                //Success
                echo "<p>Successfully selected the \"$DBName\" database.</p>\n";
                $sql = "SHOW TABLES LIKE '$tableName'";
                $result = mysqli_query($DBConnect, $sql);
                //If number of rows is zero, it does not exist
                if (mysqli_num_rows($result) == 0) {
                    echo "The <strong>$tableName</strong>" . " table does not exist, creating it.<br>\n";
                    //subscriberID is a primary key
                    $sql = "CREATE TABLE $tableName " . 
                        "(subscriberID SMALLINT NOT NULL" . 
                        " AUTO_INCREMENT PRIMARY KEY," . 
                        " name VARCHAR(80), email VARCHAR(100)," . 
                        " subscribeDate DATE, confirmedDate DATE)";
                    $result = mysqli_query($DBConnect, $sql);
                    if (!$result) {
                        echo "<p>Unable to create the <strong>" . "$tableName</strong> table.</p>";
                        echo "<p>Error code: " . mysql_error($DBConnect) . "</p>";
                    }
                    else {
                        echo "<p>Successfully created the <strong>" . "$tableName</strong> table.</p>";
                    }
                }
                else {
                    echo "The <strong>$tableName</strong>" . " table already exists.<br>\n";
                }
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