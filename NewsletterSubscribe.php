<!doctype html>

<html>
	<head>
	    <!--   
         Exercise 02_08_01
         Author: Tabitha Siclovan
         Date: November 01, 2018
        
         NewsletterSubscribe.php
        -->
		<title>Newsletter Subscribe</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="modernizr.custom.65897.js"></script>
	</head>

	<body>
        <h2>Newsletter Subscribe</h2>
        <?php
        $hostName = "localhost";
        $userName = "adminer";
        $password = "after-water-49";
        $DBName = "newsletter2";
        $tableName = "subscribers";
        $subscriberName = "";
        $subscriberEmail = "";
        $showForm = false;
        if (isset($_POST['submit'])) {
            $formErrorCount = 0;
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
    }
    else {
        $showForm = true;
    }
        
        if ($showForm) {
        ?>
        <form action="NewsletterSubscribe.php" method="post">
            <p><strong>Your Name:</strong><br>
                <input type="text" name="subName" value="<?php echo $subscriberName; ?>">
            </p>
            <p><strong>Your Email Address:</strong><br>
                <input type="email" name="subEmail" value="<?php echo $subscriberEmail; ?>">
            </p>
            <p>
                <input type="submit" name="submit" value="Submit">
            </p>
        </form>
	</body>
</html>
<?php
    }
?>