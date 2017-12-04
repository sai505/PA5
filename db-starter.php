<!-- db-starter.php
     A PHP script to demonstrate database programming.
-->
<html>
<head>
    <title> Database Programming with PHP </title>
    <style type = "text/css">
    td, th, table {border: thin solid black;}
    </style>
</head>
<body>

<?php
    
// Get input data
    $id = $_POST["id"];
    $type = $_POST["type"];
    $miles = $_POST["miles"];
    $year = $_POST["year"];
    $state = $_POST["state"];
    $action = $_POST["action"];
    $statement = $_POST["statement"];
    
    // If any of numerical values are blank, set them to zero
    if ($id == "") $id = 0;
    if ($miles == "") $miles = 0.0;
    if ($year == "") $year = 0;
    if ($state == "") $state = 0;

// Connect to MySQL
//$link = mysqli_connect("127.0.0.1", "my_user", "my_password", "my_db");
$db = mysqli_connect("db1.cs.uakron.edu:3306", "sl50", "Eekuf8sa", "ISP_sl50");
if (!$db) {
     print "Error - Could not connect to MySQL";
     exit;
}

// Select the database
$er = mysqli_select_db($db,"ISP_sl50");
if (!$er) {
    print "Error - Could not select the database";
    exit;
}

// print "<b> The action is: </b> $action <br />";

if($action == "display")
    $query = "";
else if ($action == "insert")
    $query = "insert into PA5 values($id, '$type', $miles, $year, $state)";
else if ($action == "update")
    $query = "update PA5 set Body_style = '$type', Miles = $miles, Year = $year, State = $state where Vette_id = $id";
else if ($action == "delete")
    $query = "delete from PA5 where Vette_id = $id";
else if ($action == "user")
    $query = $statement;


if($query != ""){
    trim($query);
    $query_html = htmlspecialchars($query);
    print "<b> The query is: </b> " . $query_html . "<br />";
    
    // Don't remove or comment out the line below untill you switched to your own database. VIOLATORS WILL BE SEVERELY PUNISHED!!! :-).
    //$query = "SELECT * FROM Corvettes";
    
    $result = mysqli_query($db,$query);
    if (!$result) {
        print "Error - the query could not be executed";
        $error = mysqli_error();
        print "<p>" . $error . "</p>";
    }
}
    
// Final Display of All Entries
$query = "SELECT * FROM PA5";
$result = mysqli_query($db,$query);
if (!$result) {
    print "Error - the query could not be executed";
    $error = mysqli_error();
    print "<p>" . $error . "</p>";
    exit;
}

// Get the number of rows in the result, as well as the first row
//  and the number of fields in the rows
$num_rows = mysqli_num_rows($result);
//print "Number of rows = $num_rows <br />";

print "<table><caption> <h2> Cars ($num_rows) </h2> </caption>";
print "<tr align = 'center'>";

$row = mysqli_fetch_array($result);
$num_fields = mysqli_num_fields($result);

// Produce the column labels
$keys = array_keys($row);
for ($index = 0; $index < $num_fields; $index++) 
    print "<th>" . $keys[2 * $index + 1] . "</th>";
print "</tr>";
    
// Output the values of the fields in the rows
for ($row_num = 0; $row_num < $num_rows; $row_num++) {
    print "<tr align = 'center'>";
    $values = array_values($row);
    for ($index = 0; $index < $num_fields; $index++){
        $value = htmlspecialchars($values[2 * $index + 1]);
        print "<th>" . $value . "</th> ";
    }
    print "</tr>";
    $row = mysqli_fetch_array($result);
}
print "</table>";
?>
</body>
</html>
