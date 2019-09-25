<?php 

require("Helper.class.php");
require("Graph.class.php");
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "ouvidoria2";
$db_conn = Helper::mysqlConnect($servername, $username, $password, $dbName);

if (isset($_POST['btn-entrar'])) {
	$date1 = $_POST['data1'];
	$date2 = $_POST['data2'];
	$tipoManifestacao = $_POST['tipoManifestacao'];
	$datasRecebidas= Graph::calcularData($date1 , $date2, $tipoManifestacao, $db_conn);
}


 ?>
<script>
function graficoData(dataPoints) {

    CanvasJS.addColorSet("dataColors",
                [//colorSet Array

                "#1150DC",
                "#0086FF",
                "#FFFB00",
                "#3FFF00",
                "#3FFF00"                
                ]);
var chart = new CanvasJS.Chart("chartContainer", {

    colorSet: "dataColors",
	animationEnabled: true,
	exportEnabled: true,
	theme: "light1", // "light1", "light2", "dark1", "dark2"
	title:{
		text: "Manifestações"
	},
	data: [{
		type: "area", //change type to bar, line, area, pie, etc
		//indexLabel: "{y}", //Shows y value on all Data Points
		indexLabelFontColor: "#5A5757",
		indexLabelPlacement: "outside",   
		dataPoints: dataPoints
	}]
});
chart.render();
 
}
	window.onload = function () {
	 graficoData(<?php echo json_encode($datasRecebidas, JSON_NUMERIC_CHECK); ?>)
	}

</script>
<html>
<head>
	<title>Teste</title>
</head>
<body>
	<h1> Entradas </h1>
	 <form action="" method="POST">
	 	Tipo de Manifestacao  <input type="numeric" name="tipoManifestacao">
		Data1: <input type="date" name="data1">
		Data2: <input type="date" name="data2"><br>
		<button type="submit" name="btn-entrar">Entrar</button>
</form>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html>



<!-- public static function calculardata($date1, $date2, $tipoManifestacao, $db_conn){
    $datasRecebidas = array();


    if (empty($tipoManifestacao)) {
        $sql = $db_conn->prepare("SELECT * FROM Manifestacao WHERE dataRecebimento BETWEEN ? AND ? GROUP BY dataRecebimento");
        $sql->bind_param("ss", $date1, $date2);
        $sql->execute();
        $sql = $sql->get_result();
        if ($sql->num_rows > 0) { //Caso ja exista um nup com o msm numero do nup fornecido
            while ($row = $sql->fetch_array()) {

               $sql_1 = $db_conn->prepare("SELECT COUNT(*) AS num_den FROM Manifestacao WHERE dataRecebimento = ?");
                $sql_1->bind_param("s", $row["dataRecebimento"]);
                $sql_1->execute();
                $sql_1 = $sql_1->get_result();
                $row_1 = $sql_1->fetch_array();
                $datasRecebidas[] = array("label" => date("d M Y", strtotime($row['dataRecebimento'])) , "y" => $row_1['num_den'] );

            }
        return $datasRecebidas;
    }else{
        die("error");
    }
        
    }


    //Pegar intervalo de datas
    $sql = $db_conn->prepare("SELECT * FROM Manifestacao WHERE dataRecebimento BETWEEN ? AND ? && tipoManifestacao = ? GROUP BY dataRecebimento");
    $sql->bind_param("ssi", $date1, $date2, $tipoManifestacao);
    $sql->execute();
    $sql = $sql->get_result();
    if ($sql->num_rows > 0) { //Caso ja exista um nup com o msm numero do nup fornecido
        while ($row = $sql->fetch_array()) {

            $sql_1 = $db_conn->prepare("SELECT COUNT(*) AS num_den FROM Manifestacao WHERE dataRecebimento = ? && tipoManifestacao = ?");
            $sql_1->bind_param("si", $row["dataRecebimento"],$tipoManifestacao);
            $sql_1->execute();
            $sql_1 = $sql_1->get_result();
            $row_1 = $sql_1->fetch_array();
            $datasRecebidas[] = array("label" => date("d M Y", strtotime($row['dataRecebimento'])) , "y" => $row_1['num_den'] );

        }
        return $datasRecebidas;
    }else{
        die("error");
    }

} -->
