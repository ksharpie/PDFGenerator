		window.matchMedia('print').addListener(function() {
		proximityChart.update();
		engagementChart.update();
		loyaltyChart.update();
		captureRateChart.update();
		medianVisitLengthChart.update();
		repeatVisitorRateChart.update();
	});

			var proximityChart = new Chartist.Line('#proximity', {
			labels: ['15 Jun 2017','16 Jun 2017','17 Jun 2017','18 Jun 2017','19 Jun 2017','20 Jun 2017','21 Jun 2017'],
			series: [
		   	['53.00','90.00','74.00','58.00','75.00','75.00','60.00'],
		 		['2422.00','3306.00','2770.00','2178.00','2192.00','2506.00','2509.00'],
		 		['3301.00','4699.00','2720.00','3571.00','2677.00','3817.00','3836.00'],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});

		var engagementChart = new Chartist.Bar('#engagement', {
			labels: ['15 Jun 2017','16 Jun 2017','17 Jun 2017','18 Jun 2017','19 Jun 2017','20 Jun 2017','21 Jun 2017'],
			series: [
				['1277.00','1629.00','1359.00','1082.00','1069.00','1265.00','1321.00'],
				['818.00','1169.00','997.00','711.00','739.00','835.00','816.00'],
				['271.00','445.00','368.00','349.00','338.00','354.00','323.00'],
				['56.00','63.00','46.00','36.00','46.00','52.00','49.00'],
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
		});

		var loyaltyChart = new Chartist.Bar('#loyalty', {
			labels: ['15 Jun 2017','16 Jun 2017','17 Jun 2017','18 Jun 2017','19 Jun 2017','20 Jun 2017','21 Jun 2017'],
			series: [
				['991.00','1495.00','1063.00','1167.00','870.00','963.00','846.00'],
				['313.00','301.00','318.00','181.00','304.00','330.00','353.00'],
				['999.00','1348.00','1235.00','686.00','905.00','1049.00','1031.00'],
				['119.00','162.00','154.00','144.00','113.00','164.00','279.00'],
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
		});

		var captureRateChart = new Chartist.Line('#captureRate', {
			labels: ['15 Jun 2017','16 Jun 2017','17 Jun 2017','18 Jun 2017','19 Jun 2017','20 Jun 2017','21 Jun 2017'],
			series: [
		   	['42.00','41.00','50.00','38.00','45.00','40.00','40.00'],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});

		var medianVisitLengthChart = new Chartist.Line('#medianVisitLength', {
			labels: ['15 Jun 2017','16 Jun 2017','17 Jun 2017','18 Jun 2017','19 Jun 2017','20 Jun 2017','21 Jun 2017'],
			series: [
		   	['22.76','22.81','22.42','26.96','27.11','27.43','27.56'],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});

		var repeatVisitorRateChart = new Chartist.Line('#repeatVisitorRate', {
			labels: ['15 Jun 2017','16 Jun 2017','17 Jun 2017','18 Jun 2017','19 Jun 2017','20 Jun 2017','21 Jun 2017'],
			series: [
		   	['59.00','55.00','62.00','46.00','60.00','62.00','66.00'],
		 	]
		 }).on('draw', function(data) {
		 	if(data.type === 'grid' && data.index !== 0) {
	     	data.element.remove();
	   	}
		});