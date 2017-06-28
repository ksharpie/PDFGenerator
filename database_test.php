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
  $yesterday = $date_today->subDays(1);
  $engagement = array("5-20mins"=> 0,"20-60mins"=> 0,"1-6hrs"=> 0,"6+hrs"=> 0);
  $loyalty  = array("firstTime" => 0 ,"daily" => 0 , "weekly" => 0 , "occasionaly" => 0);
  $proximity  = array("connected" => 0 ,"visitors" => 0 , "passersBy" => 0);

  $dailyAnalysis = array();

  $date_array = array(
      "engagement" => $engagement,
      "loyalty" => $loyalty,
      "proximity" => $proximity,
      "repeatVisitorRate" => 0,
      "medianVisitLength" => 0,
      "captureRate" => 0,
      "totalVisitors" => 0,
      "totalRepeatVisitors" => 0,
      "totalTimeSpentByAllVisitors" => 0)

  //Initializing of array used to store
  for ($count = 0; $count < 7; $count++){
    $dailyAnalysis[$date_today->subDays($count)] = $date_array;
  }

  //Retrive data from database
  $date_seven_days_ago = $date_today->subDays(7);
  $sql = "SELECT *
          FROM Observations
          WHERE (date_field BETWEEN '$date_seven_days_ago' AND '$date_today')";

  $result = $conn->query($sql);

  // if results exist, iterate through result
  if($result){
    while ($obervation = mysql_fetch_array($query)){

      $obeservation_date = $obervation['date_time_seen'] // TODO
      //Tallies used to calculate median visit time
      $dailyAnalysis[$obeservation_date]['totalTimeSpentByAllVisitors'] += $obervation['seenEpoch'];
      $dailyAnalysis[$obeservation_date]['totalVisitors']++;

      //visitor is automatically stored as a repeat visitor but later removed if they are first timers
      $dailyAnalysis[$obeservation_date]['totalRepeatVisitors']++;

      /*******************************Engagement analysis*****************************************/

      if ( $obervation['seenEpoch'] > 300 and $obervation['seenEpoch'] <= 1200 ){
        $dailyAnalysis[$obeservation_date]['engagement']['5-20mins']++;
      }
      elseif ( $obervation['seenEpoch'] > 1200 and $obervation['seenEpoch'] <= 3600 ){
        $dailyAnalysis[$obeservation_date]['engagement']['20-60mins']++;
      }
      elseif ( $obervation['seenEpoch'] > 3600 and $obervation['seenEpoch'] <= 21600){
        $dailyAnalysis[$obeservation_date]['engagement']['1-6hrs']++;
      }
      elseif ( $obervation['seenEpoch'] > 21600){
        $dailyAnalysis[$obeservation_date]['engagement']['6+hrs']++;
      }

      /*********************************Loyalty analysis*****************************************/

      //Checks if visitor is a daily visitor
      $date_seven_days_ago = $date_today->subDays(7);
      $sql = "SELECT *
              FROM Observations
              WHERE client_mac = '$obervation['client_mac']'
              AND (date_field BETWEEN '$date_seven_days_ago' AND '$yesterday')";

      $result_temp = $conn->query($sql);

      if ($result_temp){
        $dailyAnalysis[$obeservation_date]['loyalty']['daily']++;
      }
      else{
        //Checks if visitor is a weekly visitor
        $date_fourteen_days_ago = $date_today->subDays(14);
        $sql = "SELECT *
                FROM Observations
                WHERE client_mac = '$obervation['client_mac']'
                AND (date_field BETWEEN '$date_fourteen_days_ago' AND '$yesterday')";

        $result_temp = $conn->query($sql);

        if ($result_temp){
          $dailyAnalysis[$obeservation_date]['loyalty']['weekly']++;
        }
        else{
          //Checks if visitor is a monthly visitor
          $date_thirty_days_ago = $date_today->subDays(30);
          $sql = "SELECT *
                  FROM Observations
                  WHERE client_mac = '$obervation['client_mac']'
                  AND (date_field BETWEEN '$date_thirty_days_ago' AND '$yesterday')";

          $result_temp = $conn->query($sql);

          if ($result_temp){
            $dailyAnalysis[$obeservation_date]['loyalty']['monthly']++;
          }
          else{
            //Checks if visitor is a first time visitor
            $sql = "SELECT *
                    FROM Observations
                    WHERE client_mac = '$obervation['client_mac']'";

            $result_temp = $conn->query($sql);

            if (mysql_num_rows($result_temp) == 1){
              $dailyAnalysis[$obeservation_date]['loyalty']['firstTime']++;
              //removed repeat visitor as this is a first timer
              $dailyAnalysis[$obeservation_date]['totalRepeatVisitors']--;
            }
            else{
              //if the visitor is in any other category then
              $dailyAnalysis[$obeservation_date]['loyalty']['occasionaly']++;
            }
          }
        }
      }

      /*********************************Proximity analysis*****************************************/

      if ($obervation['ipv4']) {
        $dailyAnalysis[$obeservation_date]['proximity']['connected']++;
      }
      elseif ($obervation['seenEpoch'] > 300 and $obervation['rssi'] > -70){
        $dailyAnalysis[$obeservation_date]['proximity']['visitor']++;
      }
      else{
        $dailyAnalysis[$obeservation_date]['proximity']['passersBy']++;
      }
    }

    /*******************************medianVisitLength analysis**************************************/

    for ($count = 0; $count < 7; $count++){
      $dailyAnalysis[$date_today->subDays($count)]['medianVisitLength'] = ($dailyAnalysis["$date_today-$count"]['totalTimeSpentByAllVisitors'] / $dailyAnalysis["$date_today-$count"]['totalVisitors']) * 100;
    }

    /******************************repeatVisitorRate analysis*****************************************/

    for ($count = 0; $count < 7; $count++){
      $dailyAnalysis[$date_today->subDays($count)]['repeatVisitorRate'] = ($dailyAnalysis["$date_today-$count"]['totalRepeatVisitors'] / $dailyAnalysis["$date_today-$count"]['totalVisitors']) * 100;
    }

    /******************************captureRate analysis*****************************************/

    for ($count = 0; $count < 7; $count++){
      $dailyAnalysis[$date_today->subDays($count)]['captureRate'] = ($dailyAnalysis[$obeservation_date]['proximity']['visitor'] / $dailyAnalysis["$date_today-$count"]['totalVisitors']) * 100;
    }

    /*******************************************Creating csv Files*****************************************/

    //Capture Rate CSV
    $myFile = "cv/daily/CaptureRate.csv";
  	$fh = fopen($myFile, 'w');

    fwrite($fh, "Network,time,Capture rate\n");

    for ($count = 0; $count < 7; $count++){
      fwrite($fh, "Sovereign Centre - wireless,$date_today->subDays($count),$dailyAnalysis[$date_today->subDays($count)]['captureRate']\n");
    }

    fclose($fh);

    //Repeat Visitor Rate CSV
    $myFile = "cv/daily/RepeatVisitorRate.csv";
  	$fh = fopen($myFile, 'w');

    fwrite($fh, "Network,time,Repeat visitor rate\n");

    for ($count = 0; $count < 7; $count++){
      fwrite($fh, "Sovereign Centre - wireless,$date_today->subDays($count),$dailyAnalysis[$date_today->subDays($count)]['repeatVisitorRate']\n");
    }

    fclose($fh);

    //Median Visit Length CSV
    $myFile = "cv/daily/MedianVisitLength.csv";
  	$fh = fopen($myFile, 'w');

    fwrite($fh, "Network,time,Median visit length\n");

    for ($count = 0; $count < 7; $count++){
      $visitLengthInMiniutes = $dailyAnalysis[$date_today->subDays($count)]['medianVisitLength'] / 60;
      fwrite($fh, "Sovereign Centre - wireless,$date_today->subDays($count),$visitLengthInMiniutes\n");
    }

    fclose($fh);
  }

?>
