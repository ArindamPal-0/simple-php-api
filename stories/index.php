<?php

require_once realpath(__DIR__ . "/../vendor/autoload.php");
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/..");
$dotenv->load();

// Database credentials from `.env` file
$dbHost = $_ENV["DB_HOST"];
$dbUsername = $_ENV["DB_USERNAME"];
$dbPassword = $_ENV["DB_PASSWORD"];
$dbName = $_ENV["DB_NAME"];

// Connect to the database
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);
if($conn->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}


$jsonData = NULL;

if (isset($_GET["id"])) {
    // Prepare the query
    $stmt = $conn->prepare("SELECT * FROM stories WHERE id = ?");

    // Set the value of the variable
    $idQuery = (int)$_GET["id"];
    // Bind the data
    $stmt->bind_param("i", $idQuery);


    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // put the data into array
    $data = NULL;
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data = $row;
            break;
        }
    }

    if(isset($data)) {
        // Convert data into JSON format
        $jsonData = json_encode($data);
    } else {
        header("HTTP/1.0 404 Not Found");
        $jsonData = json_encode(array(
            "msg" => "invalid id in query paramter"
        ));
    }

    // check if query param `search` exists
} else if (isset($_GET["search"])) {
    // Prepare the query
    $stmt = $conn->prepare("SELECT * FROM stories WHERE title LIKE ?");

    // Set the value of the variable
    $searchQuery = "%" . $_GET["search"] . "%";
    // Bind the data
    $stmt->bind_param("s", $searchQuery);


    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // put the data into array
    $data = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    // Convert data into JSON format
    $jsonData = json_encode($data);

} else {
    // Query to get data from the `stories` table
    $query = "SELECT * FROM stories";
    
    // Fetch data from the database
    $result = $conn->query($query);
    
    
    // put the data into array
    $data = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    
    // Convert data into JSON format
    $jsonData = json_encode($data);
}

// Output json data
header("Content-Type: application/json");
echo $jsonData;

?>