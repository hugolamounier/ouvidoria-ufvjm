<?php
if(isset($_GET['di']) && isset($_GET['df']))
{
    if(empty($_GET['di']) || empty($_GET['df']))
    {
        $di = '';
        $df = '';
    }else{
        $di = Helper::converterDataToMysqlData($_GET['di']);
        $df = Helper::converterDataToMysqlData($_GET['df']);
    }
}else{
    $di = '';
    $df = '';
}
?>
<div id='fullReportWrapper' class='fullReportWrapper'>
    <div class='row'>
        <div class='col s5'>
            <div class='report_box z-depth-1 white'>
                <div class='box_title blue-grey-text text-darken-2'><span>Detalhes sobre as Manifestações</span></div>
                <div class="content">
                    <div class='item'><span style='font-size:15px;'>Total de Manifestações:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(0, $di, $df, $db_conn), 0, ',', '.') ?></span></div>
                    <div class="divider"></div>
                    <div class='item'><span class='red-text text-darken-1' style='padding:0 0 0 10px;'>Denúncias:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(1, $di, $df, $db_conn), 0, ',', '.') ?></span></div>
                    <div class='item'><span class='orange-text text-darken-2' style='padding:0 0 0 10px;'>Reclamações:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(2, $di, $df, $db_conn), 0, ',', '.') ?></span></div>
                    <div class='item'><span class='green-text text-darken-1' style='padding:0 0 0 10px;'>Solicitações:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(3, $di, $df, $db_conn), 0, ',', '.') ?></span></div>
                    <div class='item'><span class='yellow-text text-darken-3' style='padding:0 0 0 10px;'>Sugestões:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(4, $di, $df, $db_conn), 0, ',', '.') ?></span></div>
                    <div class='item'><span class='pink-text text-accent-2' style='padding:0 0 0 10px;'>Elogios:</span> <span><?php echo number_format(Manifestacoes::totalManifestacoes(5, $di, $df, $db_conn), 0, ',', '.') ?></span></div>
                    <div class="divider"></div>
                    <div class='item'><span style='font-size:15px;'>Manifestações por ano:</span></div>
                    <?php
                        $sql = $db_conn->prepare("select count(*) as total, DATE_FORMAT(dataRecebimento, '%Y') as year from manifestacao GROUP BY year ORDER BY year DESC");
                        $sql->execute();
                        $sql = $sql->get_result();
                        while($row = $sql->fetch_array())
                        {
                            echo("<div class='item'>");
                            echo("<span style='padding:0 0 0 10px;' class='light-blue-text text-darken-2'>".$row["year"].":</span> <span>".$row["total"]."</span>");
                            echo("</div>");
                        }
                    ?>
                </div>
            </div>
        </div>
        <div class='col s7'>
            <div class='report_box z-depth-2 white'>
                <div class='box_title blue-grey-text text-darken-2'><span>Manifestações</span></div>
                <div id='chartManifestacoes'></div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col s5'>
            <div class='report_box z-depth-1 white'>
                <div class='box_title blue-grey-text text-darken-1'><span>Detalhes sobre Situação das Manifestações</span></div>
                <div class="content">
                <div class='item'><span class='red-text text-darken-3' style='padding:0 0 0 10px;'>Cadastradas:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(1, $di, $df, $db_conn), 0, ',', '.');?></span></div>
                    <div class='item'><span class='blue-text text-darken-2' style='padding:0 0 0 10px;'>Complementação Solicitada:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(2, $di, $df, $db_conn), 0, ',', '.');?></span></div>
                    <div class='item'><span class='green-text text-darken-1' style='padding:0 0 0 10px;'>Complementados:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(3, $di, $df, $db_conn), 0, ',', '.');?></span></div>
                    <div class='item'><span class='yellow-text text-darken-3' style='padding:0 0 0 10px;'>Encaminhado por outra Ouvidoria:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(4, $di, $df, $db_conn), 0, ',', '.'); ?></span></div>
                    <div class='item'><span class='orange-text text-darken-3' style='padding:0 0 0 10px;'>Prorrogado:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(5, $di, $df, $db_conn), 0, ',', '.'); ?></span></div>
                    <div class='item'><span class='amber-text text-darken-4' style='padding:0 0 0 10px;'>Arquivado:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(6, $di, $df, $db_conn), 0, ',', '.');?></span></div>
                    <div class='item'><span class='purple-text text-darken-2' style='padding:0 0 0 10px;'>Concluido:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(7, $di, $df, $db_conn), 0, ',', '.'); ?></span></div>
                    <div class='item'><span class='indigo-text text-accent-1' style='padding:0 0 0 10px;'>Encaminhado para Orgão externo/encerrado:</span> <span><?php echo number_format(Manifestacoes::totalSituacao(8, $di, $df, $db_conn), 0, ',', '.');?></span></div>
                </div>
            </div>
        </div>
        <div class='col s7'>
            <div class='report_box z-depth-2 white'>
                <div class='box_title blue-grey-text text-darken-2'><span>Situação das Manifestações</span></div>
                <div id="chartSituacao"></div>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col s6'>
            <div class='report_box z-depth-2 white hoverable'>
                <div class='box_title blue-grey-text text-darken-2'><span>Origem das Manifestações</span></div>
                <div id="chartOrigem"></div>
            </div>
        </div>
        <div class='col s6'>
            <div class='report_box z-depth-2 white hoverable'>
                <div class='box_title blue-grey-text text-darken-2'><span>Proveniência</span></div>
                <div id="chartProveniencia"></div>
            </div>
        </div>
    </div>
    <div class='row'>
            <div class='col s12'>
                <div class='report_box z-depth-2 white hoverable'>
                    <div class='box_title blue-grey-text text-darken-2'><span>Unidades Envolvidas</span></div>
                    <div id="chartUnidadeEnvolvida"></div>
                </div>
            </div>
        </div>
</div>

<script>
$(document).ready(function(){
    $(".report_box").css("cursor", "default");
    grafico(<?php echo json_encode(Graficos::consultarManifestacao($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#e53935","#f57c00","#43a047","#ffee58","#ff4081"], 'chartManifestacoes', '', '', 'doughnut', 16);
    grafico(<?php echo json_encode(Graficos::consultarSituacao($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12","#E67E22","#884EA0","#7FB3D5","#76D7C4","#D5F5E3","#7D6608","#7E5109","#DC7633"], 'chartSituacao', '', '', 'doughnut', 15);
    grafico(<?php echo json_encode(Graficos::consultarNup($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#3FFF00"], 'chartOrigem', '', '', 'doughnut', 16);
    grafico(<?php echo json_encode(Graficos::consultarProveniencia($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#3FFF00"], 'chartProveniencia', '', '', 'doughnut', 16);
    grafico(<?php echo json_encode(Graficos::consultaCampus($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#884ea0","#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12", "#76D7C4"], 'chartUnidadeEnvolvida', '', '', 'doughnut', 15);
});
</script>