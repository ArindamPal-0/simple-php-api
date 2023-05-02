<?php
// data
$data = array(
    "msg" => "Hello, World!"
);

// Convert data into JSON format
$jsonData = json_encode($data);

// Output json data
header("Content-Type: application/json");
echo $jsonData;
?>