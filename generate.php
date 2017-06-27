<?php


	$myFile = "html/js/weekly_generate.js";
	$fh = fopen($myFile, 'w');

	fwrite($fh, "		window.matchMedia('print').addListener(function() {
		proximityChart.update();
		engagementChart.update();
		loyaltyChart.update();
		captureRateChart.update();
		medianVisitLengthChart.update();
		repeatVisitorRateChart.update();
	});

	");

	if ( 1 == file_exists("csv/weekly/Proximity.csv")){
		$file_handle = fopen("csv/weekly/Proximity.csv", "r");

		$date = array();
		$connected = array();
		$visitors = array();
		$passers = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 7 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $connected_temp, $visitors_temp, $passers_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,11));
			array_push($connected,$connected_temp);
			array_push($visitors,$visitors_temp);
			array_push($passers,substr($passers_temp,0,-1));
		}

		fwrite($fh, "		var proximityChart = new Chartist.Line('#proximity', {
			labels: [");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$connected[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 		[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$visitors[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 		[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$passers[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);
	}

	if ( 1 == file_exists("csv/weekly/Engagement.csv")){
		$file_handle = fopen("csv/weekly/Engagement.csv", "r");

		unset($date);
		$date = array();
		$fifteen_twenty_mins = array();
		$twenty_sixty_mins = array();
		$one_six_hours = array();
		$six_plus_hours = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 7 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $fifteen_twenty_mins_temp, $twenty_sixty_mins_temp, $one_six_hours_temp, $six_plus_hours_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,11));
			array_push($fifteen_twenty_mins,$fifteen_twenty_mins_temp);
			array_push($twenty_sixty_mins,$twenty_sixty_mins_temp);
			array_push($one_six_hours,$one_six_hours_temp);
			array_push($six_plus_hours,substr($six_plus_hours_temp,0,-1));
		}

		fwrite($fh, "

		var engagementChart = new Chartist.Bar('#engagement', {
			labels: [");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
				[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$fifteen_twenty_mins[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$twenty_sixty_mins[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$one_six_hours[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$six_plus_hours[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
  			]
  	},{
    	stackBars: true,
    	axisY: {
      	labelInterpolationFnc: function(value) {
        	return (value / 1000) + 'k';
      	}
    	}
  	}).on('draw', function(data) {
    	if(data.type === 'bar') {
      	data.element.attr({
        	style: 'stroke-width: 30px'
      	});
    	}
    	if(data.type === 'grid' && data.index !== 0) {
      	data.element.remove();
    	}
		});");

		fclose($file_handle);
	}

	if ( 1 == file_exists("csv/weekly/Loyalty.csv")){
		$file_handle = fopen("csv/weekly/Loyalty.csv", "r");

		unset($date);
		$date = array();
		$first_time = array();
		$daily = array();
		$weekly = array();
		$occasional = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 7 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $first_time_temp, $daily_temp, $weekly_temp, $occasional_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,11));
			array_push($first_time,$first_time_temp);
			array_push($daily,$daily_temp);
			array_push($weekly,$weekly_temp);
			array_push($occasional,substr($occasional_temp,0,-1));
		}

		fwrite($fh, "

		var loyaltyChart = new Chartist.Bar('#loyalty', {
			labels: [");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
				[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$first_time[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$daily[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$weekly[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$occasional[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
  			]
  	},{
    	stackBars: true,
    	axisY: {
      	labelInterpolationFnc: function(value) {
        	return (value / 1000) + 'k';
      	}
    	}
  	}).on('draw', function(data) {
    	if(data.type === 'bar') {
      	data.element.attr({
        	style: 'stroke-width: 30px'
      	});
    	}
    	if(data.type === 'grid' && data.index !== 0) {
      	data.element.remove();
    	}
		});");

		fclose($file_handle);

	}

	if ( 1 == file_exists("csv/weekly/CaptureRate.csv")){
		$file_handle = fopen("csv/weekly/CaptureRate.csv", "r");

		unset($date);
		$date = array();
		$capture_rate = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 7 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $capture_rate_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,11));
			array_push($capture_rate,substr($capture_rate_temp,0,-1));
		}

		fwrite($fh, "

		var captureRateChart = new Chartist.Line('#captureRate', {
			labels: [");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$capture_rate[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);

	}

	if ( 1 == file_exists("csv/weekly/MedianVisitLength.csv")){
		$file_handle = fopen("csv/weekly/MedianVisitLength.csv", "r");

		unset($date);
		$date = array();
		$median_visit_length = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 7 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $median_visit_length_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,11));
			array_push($median_visit_length,substr($median_visit_length_temp,0,-1));
		}

		fwrite($fh, "

		var medianVisitLengthChart = new Chartist.Line('#medianVisitLength', {
			labels: [");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$median_visit_length[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);

	}

	if (1 == file_exists("csv/weekly/RepeatVisitorRate.csv")){
		$file_handle = fopen("csv/weekly/RepeatVisitorRate.csv", "r");

		unset($date);
		$date = array();
		$repeat_visitor_rate = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 7 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $repeat_visitor_rate_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,11));
			array_push($repeat_visitor_rate,substr($repeat_visitor_rate_temp,0,-1));
		}

		fwrite($fh, "

		var repeatVisitorRateChart = new Chartist.Line('#repeatVisitorRate', {
			labels: [");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <7; $count++){
			fwrite($fh, "'".$repeat_visitor_rate[$count]."'");
			if ($count != 6){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);

	}

	fclose($fh);

	$myFile = "html/js/monthly_generate.js";
	$fh = fopen($myFile, 'w');

	fwrite($fh, "		window.matchMedia('print').addListener(function() {
		proximityChart.update();
		engagementChart.update();
		loyaltyChart.update();
		captureRateChart.update();
		medianVisitLengthChart.update();
		repeatVisitorRateChart.update();
	});

	");

	if ( 1 == file_exists("csv/monthly/Proximity.csv")){
		$file_handle = fopen("csv/monthly/Proximity.csv", "r");

		$date = array();
		$connected = array();
		$visitors = array();
		$passers = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 30 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $connected_temp, $visitors_temp, $passers_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,6));
			array_push($connected,$connected_temp);
			array_push($visitors,$visitors_temp);
			array_push($passers,substr($passers_temp,0,-1));
		}

		fwrite($fh, "		var proximityChart = new Chartist.Line('#proximity', {
			labels: [");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$connected[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 		[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$visitors[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 		[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$passers[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);
	}

	if ( 1 == file_exists("csv/monthly/Engagement.csv")){
		$file_handle = fopen("csv/monthly/Engagement.csv", "r");

		unset($date);
		$date = array();
		$fifteen_twenty_mins = array();
		$twenty_sixty_mins = array();
		$one_six_hours = array();
		$six_plus_hours = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 30 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $fifteen_twenty_mins_temp, $twenty_sixty_mins_temp, $one_six_hours_temp, $six_plus_hours_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,6));
			array_push($fifteen_twenty_mins,$fifteen_twenty_mins_temp);
			array_push($twenty_sixty_mins,$twenty_sixty_mins_temp);
			array_push($one_six_hours,$one_six_hours_temp);
			array_push($six_plus_hours,substr($six_plus_hours_temp,0,-1));
		}

		fwrite($fh, "

		var engagementChart = new Chartist.Bar('#engagement', {
			labels: [");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
				[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$fifteen_twenty_mins[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$twenty_sixty_mins[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$one_six_hours[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$six_plus_hours[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
  			]
  	},{
    	stackBars: true,
    	axisY: {
      	labelInterpolationFnc: function(value) {
        	return (value / 1000) + 'k';
      	}
    	}
  	}).on('draw', function(data) {
    	if(data.type === 'bar') {
      	data.element.attr({
        	style: 'stroke-width: 30px'
      	});
    	}
    	if(data.type === 'grid' && data.index !== 0) {
      	data.element.remove();
    	}
		});");

		fclose($file_handle);
	}

	if ( 1 == file_exists("csv/monthly/Loyalty.csv")){
		$file_handle = fopen("csv/monthly/Loyalty.csv", "r");

		unset($date);
		$date = array();
		$first_time = array();
		$daily = array();
		$weekly = array();
		$occasional = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 30 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $first_time_temp, $daily_temp, $weekly_temp, $occasional_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,6));
			array_push($first_time,$first_time_temp);
			array_push($daily,$daily_temp);
			array_push($weekly,$weekly_temp);
			array_push($occasional,substr($occasional_temp,0,-1));
		}

		fwrite($fh, "

		var loyaltyChart = new Chartist.Bar('#loyalty', {
			labels: [");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
				[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$first_time[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$daily[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$weekly[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$occasional[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
  			]
  	},{
    	stackBars: true,
    	axisY: {
      	labelInterpolationFnc: function(value) {
        	return (value / 1000) + 'k';
      	}
    	}
  	}).on('draw', function(data) {
    	if(data.type === 'bar') {
      	data.element.attr({
        	style: 'stroke-width: 30px'
      	});
    	}
    	if(data.type === 'grid' && data.index !== 0) {
      	data.element.remove();
    	}
		});");

		fclose($file_handle);

	}

	if ( 1 == file_exists("csv/monthly/CaptureRate.csv")){
		$file_handle = fopen("csv/monthly/CaptureRate.csv", "r");

		unset($date);
		$date = array();
		$capture_rate = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 30 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $capture_rate_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,6));
			array_push($capture_rate,substr($capture_rate_temp,0,-1));
		}

		fwrite($fh, "

		var captureRateChart = new Chartist.Line('#captureRate', {
			labels: [");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$capture_rate[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);

	}

	if ( 1 == file_exists("csv/monthly/MedianVisitLength.csv")){
		$file_handle = fopen("csv/monthly/MedianVisitLength.csv", "r");

		unset($date);
		$date = array();
		$median_visit_length = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 30 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $median_visit_length_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,6));
			array_push($median_visit_length,substr($median_visit_length_temp,0,-1));
		}

		fwrite($fh, "

		var medianVisitLengthChart = new Chartist.Line('#medianVisitLength', {
			labels: [");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$median_visit_length[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);

	}

	if (1 == file_exists("csv/monthly/RepeatVisitorRate.csv")){
		$file_handle = fopen("csv/monthly/RepeatVisitorRate.csv", "r");

		unset($date);
		$date = array();
		$repeat_visitor_rate = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 30 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $repeat_visitor_rate_temp) = split(',', $line);
			array_push($date,substr($date_temp,0,6));
			array_push($repeat_visitor_rate,substr($repeat_visitor_rate_temp,0,-1));
		}

		fwrite($fh, "

		var repeatVisitorRateChart = new Chartist.Line('#repeatVisitorRate', {
			labels: [");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <30; $count++){
			fwrite($fh, "'".$repeat_visitor_rate[$count]."'");
			if ($count != 29){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);

	}

	fclose($fh);

	$myFile = "html/js/daily_generate.js";
	$fh = fopen($myFile, 'w');

	fwrite($fh, "		window.matchMedia('print').addListener(function() {
		proximityChart.update();
		engagementChart.update();
		loyaltyChart.update();
		captureRateChart.update();
		medianVisitLengthChart.update();
		repeatVisitorRateChart.update();
	});

	");
	if ( 1 == file_exists("csv/daily/Proximity.csv")){
		$file_handle = fopen("csv/daily/Proximity.csv", "r");

		$date = array();
		$connected = array();
		$visitors = array();
		$passers = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 24 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $connected_temp, $visitors_temp, $passers_temp) = split(',', $line);
			array_push($date,substr($date_temp,12,-3));
			array_push($connected,$connected_temp);
			array_push($visitors,$visitors_temp);
			array_push($passers,substr($passers_temp,0,-1));
		}

		fwrite($fh, "		var proximityChart = new Chartist.Line('#proximity', {
			labels: [");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$connected[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 		[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$visitors[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 		[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$passers[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);
	}

	if ( 1 == file_exists("csv/daily/Engagement.csv")){
		$file_handle = fopen("csv/daily/Engagement.csv", "r");

		unset($date);
		$date = array();
		$fifteen_twenty_mins = array();
		$twenty_sixty_mins = array();
		$one_six_hours = array();
		$six_plus_hours = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 24 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $fifteen_twenty_mins_temp, $twenty_sixty_mins_temp, $one_six_hours_temp, $six_plus_hours_temp) = split(',', $line);
			array_push($date,substr($date_temp,12,-3));
			array_push($fifteen_twenty_mins,$fifteen_twenty_mins_temp);
			array_push($twenty_sixty_mins,$twenty_sixty_mins_temp);
			array_push($one_six_hours,$one_six_hours_temp);
			array_push($six_plus_hours,substr($six_plus_hours_temp,0,-1));
		}

		fwrite($fh, "

		var engagementChart = new Chartist.Bar('#engagement', {
			labels: [");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
				[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$fifteen_twenty_mins[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$twenty_sixty_mins[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$one_six_hours[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$six_plus_hours[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
  			]
  	},{
    	stackBars: true,
    	axisY: {
      	labelInterpolationFnc: function(value) {
        	return (value / 1000) + 'k';
      	}
    	}
  	}).on('draw', function(data) {
    	if(data.type === 'bar') {
      	data.element.attr({
        	style: 'stroke-width: 30px'
      	});
    	}
    	if(data.type === 'grid' && data.index !== 0) {
      	data.element.remove();
    	}
		});");

		fclose($file_handle);
	}

	if ( 1 == file_exists("csv/daily/Loyalty.csv")){
		$file_handle = fopen("csv/daily/Loyalty.csv", "r");

		unset($date);
		$date = array();
		$first_time = array();
		$daily = array();
		$weekly = array();
		$occasional = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 24 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $first_time_temp, $daily_temp, $weekly_temp, $occasional_temp) = split(',', $line);
			array_push($date,substr($date_temp,12,-3));
			array_push($first_time,$first_time_temp);
			array_push($daily,$daily_temp);
			array_push($weekly,$weekly_temp);
			array_push($occasional,substr($occasional_temp,0,-1));
		}

		fwrite($fh, "

		var loyaltyChart = new Chartist.Bar('#loyalty', {
			labels: [");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
				[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$first_time[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$daily[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$weekly[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
				[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$occasional[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
  			]
  	},{
    	stackBars: true,
    	axisY: {
      	labelInterpolationFnc: function(value) {
        	return (value / 1000) + 'k';
      	}
    	}
  	}).on('draw', function(data) {
    	if(data.type === 'bar') {
      	data.element.attr({
        	style: 'stroke-width: 30px'
      	});
    	}
    	if(data.type === 'grid' && data.index !== 0) {
      	data.element.remove();
    	}
		});");

		fclose($file_handle);

	}

	if ( 1 == file_exists("csv/daily/CaptureRate.csv")){
		$file_handle = fopen("csv/daily/CaptureRate.csv", "r");

		unset($date);
		$date = array();
		$capture_rate = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 24 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $capture_rate_temp) = split(',', $line);
			array_push($date,substr($date_temp,12,-3));
			array_push($capture_rate,substr($capture_rate_temp,0,-1));
		}

		fwrite($fh, "

		var captureRateChart = new Chartist.Line('#captureRate', {
			labels: [");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$capture_rate[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);

	}

	if ( 1 == file_exists("csv/daily/MedianVisitLength.csv")){
		$file_handle = fopen("csv/daily/MedianVisitLength.csv", "r");

		unset($date);
		$date = array();
		$median_visit_length = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 24 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $median_visit_length_temp) = split(',', $line);
			array_push($date,substr($date_temp,12,-3));
			array_push($median_visit_length,substr($median_visit_length_temp,0,-1));
		}

		fwrite($fh, "

		var medianVisitLengthChart = new Chartist.Line('#medianVisitLength', {
			labels: [");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$median_visit_length[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);

	}

	if (1 == file_exists("csv/daily/RepeatVisitorRate.csv")){
		$file_handle = fopen("csv/daily/RepeatVisitorRate.csv", "r");

		unset($date);
		$date = array();
		$repeat_visitor_rate = array();

		$line = fgets($file_handle);
		for ($count = 0; $count < 24 ; $count++){
			$line = fgets($file_handle);
			list($temp1, $date_temp, $repeat_visitor_rate_temp) = split(',', $line);
			array_push($date,substr($date_temp,12,-3));
			array_push($repeat_visitor_rate,substr($repeat_visitor_rate_temp,0,-1));
		}

		fwrite($fh, "

		var repeatVisitorRateChart = new Chartist.Line('#repeatVisitorRate', {
			labels: [");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$date[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh, "],
			series: [
		   	[");

		for ($count = 0; $count <24; $count++){
			fwrite($fh, "'".$repeat_visitor_rate[$count]."'");
			if ($count != 23){
				fwrite($fh, ",");
			}
		}

		fwrite($fh,"],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});");

		fclose($file_handle);

	}

	fclose($fh);

	header("Location: http://localhost/html/monthly_index.html");
	die();


?>
