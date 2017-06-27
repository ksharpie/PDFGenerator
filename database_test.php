<?php

//Make sure that it is a POST request.
if(strcasecmp($_SERVER['REQUEST_METHOD'], 'POST') != 0){
    throw new Exception('Request method must be POST!');
}

//Make sure that the content type of the POST request has been set to application/json
$contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
if(strcasecmp($contentType, 'application/json') != 0){
    throw new Exception('Content type must be: application/json');
}

//Receive the RAW post data.
$content = trim(file_get_contents("php://input"));

//Attempt to decode the incoming RAW post data from JSON.
$decoded = json_decode($content, true);

//If json_decode failed, the JSON is invalid.
if(!is_array($decoded)){
    throw new Exception('Received content contained invalid JSON!');
}

//Process the JSON.
$observations = $decoded->data->observations;

$servername = "localhost";
$username = "root";
$password = "secret";
$dbname = "location_analytics";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

foreach($observations as $observation){
   $client_mac = $observation->clientMac;
   $rssi = $observation->rssi;
   $date = substr($observation->date,0,-10);1970-01-01T00:00:00Z
   $time = substr($observation->date,11,-7);
   $seen_epoch = $observation->seenEpoch;

   $sql = "INSERT INTO Observations (client_mac, rssi, 'date', 'time', seenEpoch)
    VALUES ('$client_mac', '$rssi', '$date','$time', '$seen_epoch')";
}
// $sql = "INSERT INTO MyGuests (firstname, lastname, email)
// VALUES ('John', 'Doe', 'john@example.com')";
//
// if ($conn->query($sql) === TRUE) {
//     echo "New record created successfully";
// } else {
//     echo "Error: " . $sql . "<br>" . $conn->error;
// }
//
// $conn->close();
?>
