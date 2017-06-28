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

  //Adds each observation recieved to the database
  foreach($observations as $observation){
    $client_mac = $observation->clientMac;
    $rssi = $observation->rssi;
    $date_time_seen = 1970-01-01T00:00:00Z //TODO
    $seen_epoch = $observation->seenEpoch;
    $ipv4 = $obervation->ipv4;

    $sql = "INSERT INTO Observations (client_mac, rssi, seenEpoch, date_time_seen, ipv4)
            VALUES ('$client_mac', '$rssi', '$seen_epoch', ''$date_time_seen', '$ipv4')";

    $result = $conn->query($sql);
  }

  /*************************Daily analysis of data*********************************/
  $date_today = ?;
  $date_seven_days_ago = ?;

  $engagement = array("5-20mins"=> 0,"20-60mins"=> 0,"1-6hrs"=> 0,"6+hrs"=> 0);
  $loyalty  = array("firstTime" => 0 ,"daily" => 0 , "weekly" => 0 , "occasionaly" => 0);
  $proximity  = array("connected" => 0 ,"visitors" => 0 , "passersBy" => 0);
  $totalTimeSpentByAllVisitors = 0;
  $totalVisitors = 0;

  //array to store all the results of the data analysis
  $dailyAnalysis = array(
      "$date_today" => array(
          "engagement" => $engagement,
          "loyalty" => $loyalty,
          "proximity" => $proximity,
          "repeatVisitorRate" => 0,
          "medianVisitLength" => 0,
          "captureRate" => 0,
          "totalVisitors" => 0,
          "totalRepeatVisitors" => 0,
          "totalTimeSpentByAllVisitors" => 0),
      "$date_today-1" => array(
          "engagement" => $engagement,
          "loyalty" => $loyalty,
          "proximity" => $proximity,
          "repeatVisitorRate" => 0,
          "medianVisitLength" => 0,
          "captureRate" => 0,
          "totalVisitors" => 0,
          "totalRepeatVisitors" => 0,
          "totalTimeSpentByAllVisitors" => 0),
      )
      "$date_today-2" => array(
          "engagement" => $engagement,
          "loyalty" => $loyalty,
          "proximity" => $proximity,
          "repeatVisitorRate" => 0,
          "medianVisitLength" => 0,
          "captureRate" => 0,
          "totalVisitors" => 0,
          "totalRepeatVisitors" => 0,
          "totalTimeSpentByAllVisitors" => 0),
      "$date_today-3" => array(
          "engagement" => $engagement,
          "loyalty" => $loyalty,
          "proximity" => $proximity,
          "repeatVisitorRate" => 0,
          "medianVisitLength" => 0,
          "captureRate" => 0,
          "totalVisitors" => 0,
          "totalRepeatVisitors" => 0,
          "totalTimeSpentByAllVisitors" => 0),
      "$date_toda-4" => array(
          "engagement" => $engagement,
          "loyalty" => $loyalty,
          "proximity" => $proximity,
          "repeatVisitorRate" => 0,
          "medianVisitLength" => 0,
          "captureRate" => 0,
          "totalVisitors" => 0,
          "totalRepeatVisitors" => 0,
          "totalTimeSpentByAllVisitors" => 0),
     "$date_today-5" => array(
          "engagement" => $engagement,
          "loyalty" => $loyalty,
          "proximity" => $proximity,
          "repeatVisitorRate" => 0,
          "medianVisitLength" => 0,
          "captureRate" => 0,
          "totalVisitors" => 0,
          "totalRepeatVisitors" => 0,
          "totalTimeSpentByAllVisitors" => 0),
    "$date_today-6" => array(
          "engagement" => $engagement,
          "loyalty" => $loyalty,
          "proximity" => $proximity,
          "repeatVisitorRate" => 0,
          "medianVisitLength" => 0,
          "captureRate" => 0,
          "totalVisitors" => 0,
          "totalRepeatVisitors" => 0,
          "totalTimeSpentByAllVisitors" => 0),
  );

  //Retrive data from database
  $sql = "SELECT *
          FROM Observations
          WHERE (date_field BETWEEN '$date_seven_days_ago' AND '$date_today')";

  $result = $conn->query($sql);

  // if results exist, iterate through result
  if($result){
    while ($row = mysql_fetch_array($query)){

      //Tallies used to calculate median visit time
      $dailyAnalysis["$row['date_time_seen']"]['totalTimeSpentByAllVisitors'] += $row['seenEpoch'];
      $dailyAnalysis["$row['date_time_seen']"]['totalVisitors']++;

      //visitor is automatically stored as a repeat visitor but later removed if they are first timers
      $dailyAnalysis["$row['date_time_seen']"]['totalRepeatVisitors']++;

      /*******************************Engagement analysis*****************************************/

      if ( $row['seenEpoch'] > 300 and $row['seenEpoch'] <= 1200 ){
        $dailyAnalysis["$row['date_time_seen']"]['engagement']['5-20mins']++;
      }
      elseif ( $row['seenEpoch'] > 1200 and $row['seenEpoch'] <= 3600 ){
        $dailyAnalysis["$row['date_time_seen']"]['engagement']['20-60mins']++;
      }
      elseif ( $row['seenEpoch'] > 3600 and $row['seenEpoch'] <= 21600){
        $dailyAnalysis["$row['date_time_seen']"]['engagement']['1-6hrs']++;
      }
      elseif ( $row['seenEpoch'] > 21600){
        $dailyAnalysis["$row['date_time_seen']"]['engagement']['6+hrs']++;
      }

      /*********************************Loyalty analysis*****************************************/

      //Checks if visitor is a daily visitor
      $sql = "SELECT *
              FROM Observations
              WHERE client_mac = '$row['client_mac']'
              AND (date_field BETWEEN '$date_seven_days_ago' AND '$yesterday')";

      $result_temp = $conn->query($sql);

      if ($result_temp){
        $dailyAnalysis["$row['date_time_seen']"]['loyalty']['daily']++;
      }
      else{
        //Checks if visitor is a weekly visitor
        $sql = "SELECT *
                FROM Observations
                WHERE client_mac = '$row['client_mac']'
                AND (date_field BETWEEN '$date_fourteen_days_ago' AND '$yesterday')";

        $result_temp = $conn->query($sql);

        if ($result_temp){
          $dailyAnalysis["$row['date_time_seen']"]['loyalty']['weekly']++;
        }
        else{
          //Checks if visitor is a monthly visitor
          $sql = "SELECT *
                  FROM Observations
                  WHERE client_mac = '$row['client_mac']'
                  AND (date_field BETWEEN '$date_thirty_days_ago' AND '$yesterday')";

          $result_temp = $conn->query($sql);

          if ($result_temp){
            $dailyAnalysis["$row['date_time_seen']"]['loyalty']['monthly']++;
          }
          else{
            //Checks if visitor is a first time visitor
            $sql = "SELECT *
                    FROM Observations
                    WHERE client_mac = '$row['client_mac']'";

            $result_temp = $conn->query($sql);

            if (mysql_num_rows($result_temp) == 1){
              $dailyAnalysis["$row['date_time_seen']"]['loyalty']['firstTime']++;
              //removed repeat visitor as this is a first timer
              $dailyAnalysis["$row['date_time_seen']"]['totalRepeatVisitors']++;
            }
            else{
              //if the visitor is in any other category then
              $dailyAnalysis["$row['date_time_seen']"]['loyalty']['occasionaly']++;
            }
          }
        }
      }

      /*********************************Proximity analysis*****************************************/

      if ($row['ipv4']) {
        $dailyAnalysis["$row['date_time_seen']"]['proximity']['connected']++;
      }
      elseif ($row['seenEpoch'] > 300 and $row['rssi'] > -70){
        $dailyAnalysis["$row['date_time_seen']"]['proximity']['visitor']++;
      }
      else{
        $dailyAnalysis["$row['date_time_seen']"]['proximity']['passersBy']++;
      }
    }

    /*******************************medianVisitLength analysis**************************************/

    for ($count = 0; $count < 7; $count++){
      $dailyAnalysis["$date_today-$count"]['medianVisitLength'] = $dailyAnalysis["$date_today-$count"]['totalTimeSpentByAllVisitors'] / $dailyAnalysis["$date_today-$count"]['totalVisitors'];
    }

    /*******************************repeatVisitorRate***********************************************/
  }

?>
