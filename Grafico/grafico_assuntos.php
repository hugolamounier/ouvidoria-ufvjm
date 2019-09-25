<?php 
require("Helper.class.php");
require("Graph.class.php");


$servername = "localhost";
$username = "root";
$password = "01954501";
$dbName = "ouvidoria";
$db_conn = Helper::mysqlConnect($servername, $username, $password, $dbName);

$dataPoints;
$dataPoints = Graph::consultarAssunto($db_conn);	
	
?>
<!DOCTYPE HTML>
<html>
<head>  
<script>
function graficoPizza(dataPoints){
	var chart = new CanvasJS.Chart("chartContainer", {
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "Situação atual das manifestações"
		},
		subtitles: [{
			text: "Clique para desmembrar"
		}],
		data: [{
			type: "pie",
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