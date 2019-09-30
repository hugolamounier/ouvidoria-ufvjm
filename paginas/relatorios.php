<?php

?>
<script src="js/canvasjs.min.js"></script>
<script src="js/graficos.js"></script>
<div class="title">
    <i class="material-icons left">content_paste</i>
    <span class="blue-grey-text text-darken-3">Relatórios</span>
    <div class="options">
    <a class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Gerar relatório em PDF"><i class="material-icons">picture_as_pdf</i></a>

    </div>
</div>
<div class="container">
    <div id="chartReportPreview">
        <div class='row'>
            <div class='col s6'>
                <div class='report_box z-depth-2 white hoverable' trigger='manifestacoesFullReport'>
                    <div class='box_title blue-grey-text text-darken-2'><span>Manifestações</span></div>
                    <div id="chartManifestacoes"></div>
                </div>
            </div>
            <div class='col s6'>
                <div class='report_box z-depth-2 white hoverable'>
                    <div class='box_title blue-grey-text text-darken-2'><span>Assuntos</span></div>
                    <div id="chartAssuntos"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s6">
                <div class='report_box z-depth-2 white hoverable'>
                    <div class='box_title blue-grey-text text-darken-2'><span>Origem das Manifestações</span></div>
                    <div id="chartOrigem"></div>
                </div>
            </div>
            <div class="col s6">
                <div class='report_box z-depth-2 white hoverable'>
                    <div class='box_title blue-grey-text text-darken-2'><span>Proveniência</span></div>
                    <div id="chartProveniencia"></div>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class='col s12'>
                <div class='report_box z-depth-2 white hoverable'>
                    <div class='box_title blue-grey-text text-darken-2'><span>Situação das Manifestações</span></div>
                    <div id="chartSituacao"></div>
                </div>
            </div>
        </div>
    </div>
    <div id="dReport">
    </div>
</div>
<script>
    
    $(document).ready(function(){
        $('.tooltipped').tooltip();
        $("#status_box").css("height", '60px');
        grafico(<?php echo json_encode(Graficos::consultarManifestacao($db_conn), JSON_NUMERIC_CHECK) ?>, ["#e53935","#f57c00","#43a047","#ffee58","#ff4081"], 'chartManifestacoes', '', '', 'doughnut', 16);
        grafico(<?php echo json_encode(Graficos::consultarAssunto($db_conn), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12","#E67E22","#884EA0","#7FB3D5","#76D7C4","#D5F5E3", "#7D6608","#7E5109","#DC7633"], 'chartAssuntos', '', '', 'pie', 16);
        grafico(<?php echo json_encode(Graficos::consultarNup($db_conn), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#3FFF00"], 'chartOrigem', '', '', 'doughnut', 16);
        grafico(<?php echo json_encode(Graficos::consultarProveniencia($db_conn), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#3FFF00"], 'chartProveniencia', '', '', 'doughnut', 16);
        grafico(<?php echo json_encode(Graficos::consultarSituacao($db_conn), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12","#E67E22","#884EA0","#7FB3D5","#76D7C4","#D5F5E3","#7D6608","#7E5109","#DC7633"], 'chartSituacao', '', '', 'doughnut', 17);

        

        $(".report_box").on("click", function(){
            $("#chartReportPreview").fadeOut(900);
            showLoading();
            switch($(this).attr('trigger'))
            {
                case "manifestacoesFullReport":
                    loadScript('relatorios/manifestacoes.php', 'dReport');
                break;
            }
        });

    });
</script>