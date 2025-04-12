<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "ez_mart"; 

try {
    // Fix: Use the correct variable name $servername in the PDO connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optionally, print a success message
    // echo "Connected successfully"; 

} catch (PDOException $e) {
    // Handle any connection errors
    die("Connection failed: " . $e->getMessage());
}
?>
