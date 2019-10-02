<?php
require("config/config.php");
?>
<link rel="stylesheet" href="css/materialize.min.css">
<link rel="stylesheet" href="css/print.css">
<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script type='text/javascript' src='js/main.js'></script>
<script src="js/materialize.min.js"></script>
<script src="js/canvasjs.min.js"></script>
<script src="js/graficos.js"></script>


<div class='printReport'>
    <p class='pageTitle'><span>Relatório de Manifestações</span></p>
    <div class='wrapper'>
        <div class='row'>
            <div class='col s4'>
                <div class='box'>
                    <p class='title'><span class='blue-grey-text text-darken-3'>Detalhes sobre as Manifestações</span></p>
                    <p class='subtitle'><span class='blue-grey-text text-darken-2'>Total de Manifestações: </span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(0, $db_conn), 0, ',', '.') ?></span></p>
                    <div class="divisor"></div>
                        <div class='item'><span class='red-text text-darken-1'>Denúncias:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(1, $db_conn), 0, ',', '.') ?></span></div>
                        <div class='item'><span class='orange-text text-darken-2'>Reclamações:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(2, $db_conn), 0, ',', '.') ?></span></div>
                        <div class='item'><span class='green-text text-darken-1'>Solicitações:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(3, $db_conn), 0, ',', '.') ?></span></div>
                        <div class='item'><span class='yellow-text text-darken-3'>Sugestões:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(4, $db_conn), 0, ',', '.') ?></span></div>
                        <div class='item'><span class='pink-text text-accent-2'>Elogios:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(5, $db_conn), 0, ',', '.') ?></span></div>
                    <div class="divisor"></div>
                    <p class='subtitle'><span class='blue-grey-text text-darken-2'>Manifestações por ano: </span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(0, $db_conn), 0, ',', '.') ?></span></p>
                    <?php
                        $sql = $db_conn->prepare("select count(*) as total, DATE_FORMAT(dataRecebimento, '%Y') as year from manifestacao GROUP BY year ORDER BY year DESC");
                        $sql->execute();
                        $sql = $sql->get_result();
                        while($row = $sql->fetch_array())
                        {
                            echo("<div class='item'>");
                            echo("<span class='light-blue-text text-darken-2'>".$row["year"].":</span> <span>".$row["total"]."</span>");
                            echo("</div>");
                        }
                    ?>
                </div>
            </div>
            <div class='col s7 left_border'>
                <div class='box'>
                <p class='title'><span class='blue-grey-text text-darken-3'>Manifestações</span></p>
                    <div id='chartManifestacoes'></div>
                </div>
            </div>
        </div>
        <div class="divisor"></div>
        <div class='row'>
            <div class='col s4'>
                <div class='box'>
                    <p class='title'><span class='blue-grey-text text-darken-3'>Detalhes sobre Situação das Manifestações</span></p>
                        <div class='item'><span class='red-text text-darken-3'>Cadastradas:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(1, $db_conn), 0, ',', '.');?></span></div>
                        <div class='item'><span class='blue-text text-darken-2'>Complementação Solicitada:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(2, $db_conn), 0, ',', '.');?></span></div>
                        <div class='item'><span class='green-text text-darken-1'>Complementados:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(3, $db_conn), 0, ',', '.');?></span></div>
                        <div class='item'><span class='yellow-text text-darken-3'>Encaminhado por outra Ouvidoria:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(4, $db_conn), 0, ',', '.'); ?></span></div>
                        <div class='item'><span class='orange-text text-darken-3'>Prorrogado:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(5, $db_conn), 0, ',', '.'); ?></span></div>
                        <div class='item'><span class='amber-text text-darken-4'>Arquivado:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(6, $db_conn), 0, ',', '.');?></span></div>
                        <div class='item'><span class='purple-text text-darken-2'>Concluido:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(7, $db_conn), 0, ',', '.'); ?></span></div>
                        <div class='item'><span class='indigo-text text-accent-1'>Encaminhado para Orgão externo/encerrado:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(8, $db_conn), 0, ',', '.');?></span></div>
                </div>
            </div>
            <div class='col s7 left_border'>
                <div class='box'>
                    <p class='title'><span class='blue-grey-text text-darken-3'>Situação das Manifestações</span></p>
                    <div id="chartSituacao"></div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
$(document).ready(function(){
    grafico(<?php echo json_encode(Graficos::consultarManifestacao($db_conn), JSON_NUMERIC_CHECK) ?>, ["#e53935","#f57c00","#43a047","#ffee58","#ff4081"], 'chartManifestacoes', '', '', 'doughnut', 14);
    grafico(<?php echo json_encode(Graficos::consultarSituacao($db_conn), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12","#E67E22","#884EA0","#7FB3D5","#76D7C4","#D5F5E3","#7D6608","#7E5109","#DC7633"], 'chartSituacao', '', '', 'doughnut', 14);
});
</script>