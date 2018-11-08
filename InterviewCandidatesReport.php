<!doctype html>

<html>
	<head>
	    <!--   
         Exercise 02_08_01
         Author: Tabitha Siclovan
         Date: November 07, 2018
        
         InterviewCandidatesReport.php
        -->
		<title>Interview Candidates Report</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="initial-scale=1.0">
		<script src="modernizr.custom.65897.js"></script>
	</head>

	<body style="background-color: rgb(237, 222, 230); text-align:center;">
         <h2>Newsletter Subscribers 2</h2>
        <?php
         $hostName = "localhost";
        $userName = "adminer";
        $password = "after-water-49";
        $DBName = "interviews";
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
        //Variables
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
                //data query and result set
                $result = mysqli_query($DBConnect, $sql);
                echo "<p>Number of rows in" . 
                    " <strong>$tableName</strong>: " . 
                    mysqli_num_rows($result) . ".</p>\n";
                //Put everything into a table
                echo "<table width='100%' border='1'>";
                echo "<tr>";
                echo "<th>Subscriber ID</th>";
                echo "<th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Subscribe Date</th>";
                echo "<th>Confirmed Date</th>";
                echo "</tr>\n";
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $field) {
                         echo "<td>{$field}</td>";
                    }
                    echo "</tr>\n";
                }
                echo "</table>\n";
                //Result: the table
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