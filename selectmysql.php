<?php
$servername = "localhost";
$username = "myuser";
$password = "mypass";
$dbname = "fisat";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Persons";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   
    while($row = $result->fetch_assoc()){
        echo "id: " . $row["PersonID"]. " - Name: " . $row["LastName"]. " " . $row["FirstName"]. "\n";
    }

} 
else {
  echo "0 results";
}
$conn->close();
?> 


