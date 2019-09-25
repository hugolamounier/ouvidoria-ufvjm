<?php 
require("Helper.class.php");


$servername = "localhost";
$username = "root";
$password = "";
$dbName = "ouvidoria2";
$db_conn = Helper::mysqlConnect($servername, $username, $password, $dbName);

$dataPoints;
$dataPoints = Helper::consultarManifestacao($db_conn);
	
	
?>
<!DOCTYPE HTML>
<html>
<head>  
<script>
function graficoPizza(dataPoints){
    CanvasJS.addColorSet("manifestacoesColors",
                [//colorSet Array

                "#e53935",
                "#f57c00",
                "#43a047",
                "#ffee58",
                "#ff4081"                
                ]);
	var chart = new CanvasJS.Chart("chartContainer", {
        colorSet: "manifestacoesColors",
		animationEnabled: true,
		exportEnabled: true,
		title:{
			text: "Numeros totais de Manifestações"
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
    // public static function consultarManifestacao($db_conn){

    //     //Denuncias
    //     $sqlDenuncias = $db_conn->prepare("SELECT tipoManifestacao FROM manifestacao WHERE tipoManifestacao = 1");
    //     $sqlDenuncias ->execute();
    //     $sqlDenuncias = $sqlDenuncias->get_result();
    //     $totalDenuncias = $sqlDenuncias->num_rows;

    //     //Reclamações
    //     $sqlReclamacoes = $db_conn->prepare("SELECT tipoManifestacao FROM manifestacao WHERE tipoManifestacao = 2");
    //     $sqlReclamacoes ->execute();
    //     $sqlReclamacoes = $sqlReclamacoes->get_result();
    //     $totalReclamacoes = $sqlReclamacoes->num_rows;

    //     //Solicitações
    //     $sqlSolicitacoes = $db_conn->prepare("SELECT tipoManifestacao FROM manifestacao WHERE tipoManifestacao = 3");
    //     $sqlSolicitacoes ->execute();
    //     $sqlSolicitacoes = $sqlSolicitacoes->get_result();
    //     $totalSolicitacoes = $sqlSolicitacoes->num_rows;

    //     //Sugestões
    //     $sqlSugestoes = $db_conn->prepare("SELECT tipoManifestacao FROM manifestacao WHERE tipoManifestacao = 4");
    //     $sqlSugestoes ->execute();
    //     $sqlSugestoes = $sqlSugestoes->get_result();
    //     $totalSugestoes = $sqlSugestoes->num_rows;

    //     //Elogios
    //     $sqlElogios = $db_conn->prepare("SELECT tipoManifestacao FROM manifestacao WHERE tipoManifestacao = 5");
    //     $sqlElogios ->execute();
    //     $sqlElogios = $sqlElogios->get_result();
    //     $totalElogios = $sqlElogios->num_rows;


          
    //     $dataPoints = array(
    //         array("label"=> "Denuncias", "y"=> $totalDenuncias),
    //         array("label"=> "Reclamações", "y"=> $totalReclamacoes),
    //         array("label"=> "Solicitações", "y"=> $totalSolicitacoes),
    //         array("label"=> "Sugestões", "y"=> $totalSugestoes),
    //         array("label"=> "Elogios", "y"=> $totalElogios),

            
    //     );

    //     return $dataPoints;
    // }
?>