<?php 
require("Helper.class.php");
require("Graph.class.php");


$servername = "localhost";
$username = "root";
$password = "";
$dbName = "ouvidoria2";
$db_conn = Helper::mysqlConnect($servername, $username, $password, $dbName);

$dataPoints;
$dataPoints = Graph::consultarNup($db_conn);
	
	
?>
<!DOCTYPE HTML>
<html>
<head>  
<script>
function graficoPizza(dataPoints){
	CanvasJS.addColorSet("nupColors",
                [//colorSet Array

                "#FF0000",
                "#0086FF",
                "#FFFB00",
                "#3FFF00",
                "#3FFF00"                
                ]);
	var chart = new CanvasJS.Chart("chartContainer", {
		colorSet: "nupColors",
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "E-Ouv ou Email"
		},
		subtitles: [{
			text: ""
		}],
		data: [{
			type: "doughnut",
			showInLegend: "true",
			legendText: "{label}",
			indexLabelFontSize: 16,
			indexLabel: "{label} - #percent%",
			yValueFormatString: "฿#,##0",
			dataPoints: dataPoints
		}]
	});
chart.render();




}
window.onload = function () {
 
 graficoPizza(<?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>)
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>                 
<?php  