var  options= '';

var ls_ajax_url = llsp_ajax_custom.ajax_call;




jQuery.ajax({
							type : "post",
							url : ls_ajax_url,
					        async: false,
							data : {action: "get_citation",layout:true},
							dataType: "json",
							success: function(response) 
							{   
							
						
							  create_chart(	response);
								
								
								}
							
							
					})
		




	
	
function create_chart(chart_data)
{

var chart=AmCharts.makeChart("citation-timeline",
{
		"type": "serial",
		"categoryField": "date",
		"dataDateFormat": "YYYY-MM",
		"autoMarginOffset": 12,
		"marginBottom": 24,
		"marginLeft": 24,
		"marginRight": 24,
		"marginTop": 24,
		"colors": [
		"#393E46",
		"#00ADB5",
		"#B0DE09",
		"#0D8ECF",
		"#2A0CD0",
		"#CD0D74",
		"#CC0000",
		"#00CC00",
		"#0000CC",
		"#DDDDDD",
		"#999999",
		"#333333",
		"#990000"
	],
	"startDuration": 1,
	"color": "#393E46",
	"fontFamily": "Roboto",
	"fontSize": 12,
	"categoryAxis": {
		"gridPosition": "start",
		"minPeriod": "MM",
		"parseDates": true,
		"axisAlpha": 0.1,
		"axisColor": "#393E46",
		"color": "#393E46",
		"fontSize": 14,
		"gridAlpha": 0.1,
		"gridColor": "#393E46",
		"tickLength": 0
	},
	"trendLines": [],
	"graphs": [
		{
			"balloonText": "[[title]] of [[category]]:[[value]]",
			"color": "#393E46",
			"fillAlphas": 0.1,
			"fillColors": "#393E46",
			"fontSize": 10,
			"id": "AmGraph-1",
			"labelPosition": "inside",
			"labelText": "[[value]]",
			"lineAlpha": 0,
			"title": "Average Citation Relvancy",
			"type": "column",
			"valueAxis": "ValueAxis-2",
			"valueField": "column-2"
		},
		{
			"animationPlayed": true,
			"balloonText": "[[title]] of [[category]]:[[value]]",
			"bullet": "round",
			"bulletBorderThickness": 0,
			"bulletSize": 12,
			"color": "#00ADB5",
			"fontSize": 14,
			"id": "AmGraph-2",
			"labelOffset": 6,
			"labelText": "[[value]]",
			"lineColor": "#00ADB5",
			"lineThickness": 4,
			"title": "Number of Citations",
			"type": "smoothedLine",
			"valueAxis": "ValueAxis-1",
			"valueField": "column-1"
		}
	],
	"guides": [],
	"valueAxes": [
		{
			"axisTitleOffset": 12,
			"id": "ValueAxis-1",
			"zeroGridAlpha": 0,
			"axisAlpha": 0.1,
			"axisColor": "#393E46",
			"color": "#393E46",
			"fontSize": 10,
			"gridAlpha": 0.1,
			"gridColor": "#393E46",
			"gridCount": 6,
			"tickLength": 0,
			 'axisX':0,
			"title": "Citations"
		},
		{
			"axisTitleOffset": 12,
			"id": "ValueAxis-2",
			"position": "right",
			"zeroGridAlpha": 0,
			"axisAlpha": 0.1,
			"axisColor": "#393E46",
			"color": "#393E46",
			"fontSize": 10,
			"gridAlpha": 0,
			"gridColor": "#393E46",
			"gridCount": 6,
			"tickLength": 0,
			'axisY':0,
			"title": "Relvancy"
		}
	],
	"allLabels": [],
	"balloon": {
		"color": "#393E46",
		"horizontalPadding": 12,
		"shadowAlpha": 0,
		"shadowColor": "#FFFFFF",
		"verticalPadding": 6
	},
	"legend": {
		"enabled": true,
		"borderColor": "#393E46",
		"color": "#393E46",
		"fontSize": 12,
		"horizontalGap": 8,
		"marginLeft": 24,
		"marginRight": 24,
		"spacing": 12,
		"useGraphSettings": true,
		"useMarkerColorForLabels": true,
		"useMarkerColorForValues": true,
		"verticalGap": 12
	},
	
	"titles": [],
	"dataProvider": chart_data
		
	}
);




}

 


