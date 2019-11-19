<?php
    if(isset($_GET['tipo']))
    {
        $tipo = $_GET['tipo'];

        switch($tipo)
        {
            case "manifestacoesFullReport":
                if(isset($_GET['di']) && isset($_GET['df']) && !empty($_GET['df']) && !empty($_GET['di']))
                {
                    $di = $_GET['di'];
                    $df = $_GET['df'];
                    $titulo = "Relatório de Manifestações - $di até $df";
                }else{
                    $titulo = "Relatório de Manifestações";
                }
                
            break;
            default:
                $titulo = "Relatórios";
            break;
        }
    }else{
        $titulo = "Relatórios";
    }
?>
<script src="js/canvasjs.min.js"></script>
<script src="js/graficos.js"></script>
<div class="title">
    <?php
    if(isset($_GET['tipo']))
    {
        echo("<a onclick=\"location.href='?page=relatorios'\" class=\"btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0\" data-position=\"bottom\" data-tooltip=\"Voltar\"><i class=\"material-icons\">arrow_back</i></a>");
    } 
    ?>
    <i class="material-icons left">content_paste</i>
    <span class="blue-grey-text text-darken-3"><?php echo $titulo ?></span>
    <div class="options">
    <?php
        if(isset($_GET['tipo']))
        {
            echo("<a onclick=\"window.open('imprimir_relatorio.php?di=$di&df=$df');\" class=\"btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0\" data-position=\"bottom\" data-tooltip=\"Gerar relatório em PDF\"><i class=\"material-icons\">print</i></a>
            ");
        } 
    ?>
    </div>
</div>
<div class="container">
    <div class='row'>
        <div style='display: flex; justify-content:space-between;' class='col s12'>
        <?php
            if(!isset($tipo))
            {
                if(isset($_GET['di']) && isset($_GET['df']))
                {
                    $di = $_GET['di'];
                    $df = $_GET['df'];
                }else{
                    $di = '';
                    $df = '';
                }
                echo("<div style='margin:0 0 20px 0; display: inline-flex;'><a href='?page=relatorios&tipo=manifestacoesFullReport&di=$di&df=$df' class=\"waves-effect waves-light btn light-blue darken-4\"><i class=\"material-icons left\">description</i>Relatório Detalhado</a></div>");
                echo("<div class=\"dateRangeReport\">
                <i class='material-icons'>date_range</i>
                <input id=\"dataInicial\" type=\"text\"  name=\"dataInicial\" placeholder=\"De\">
                <input id=\"dataFinal\" type=\"text\"  name=\"dataFinal\" placeholder=\"Até\">
                <a class=\"btn-floating btn-small waves-effect waves-light light-blue darken-4 tooltipped\" data-position=\"bottom\" data-tooltip=\"Relatório por data\"><i class=\"material-icons\">send</i></a>
            </div>");
            } 
        ?>
        </div>
    </div>
    <?php
    if(isset($_GET['di']) && isset($_GET['df']) && !isset($_GET['tipo']))
    {
        $di = $_GET['di'];
        $df = $_GET['df'];

        echo("<script>$(document).ready(function(){
            $('#dataInicial').val('$di'); $('#dataFinal').val('$df');
        })</script>");

        $di = Helper::converterDataToMysqlData($di);
        $df = Helper::converterDataToMysqlData($df);
    ?>
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
        grafico(<?php echo json_encode(Graficos::consultarManifestacao($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#e53935","#f57c00","#43a047","#ffee58","#ff4081"], 'chartManifestacoes', '', '', 'doughnut', 15);
        grafico(<?php echo json_encode(Graficos::consultarAssunto($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12","#E67E22","#884EA0","#7FB3D5","#76D7C4","#D5F5E3", "#7D6608","#7E5109","#DC7633"], 'chartAssuntos', '', '', 'pie', 14);
        grafico(<?php echo json_encode(Graficos::consultarNup($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#3FFF00"], 'chartOrigem', '', '', 'doughnut', 15);
        grafico(<?php echo json_encode(Graficos::consultarProveniencia($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#3FFF00"], 'chartProveniencia', '', '', 'doughnut', 15);
        grafico(<?php echo json_encode(Graficos::consultarSituacao($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12","#E67E22","#884EA0","#7FB3D5","#76D7C4","#D5F5E3","#7D6608","#7E5109","#DC7633"], 'chartSituacao', '', '', 'doughnut', 17);
        grafico(<?php echo json_encode(Graficos::consultaCampus($db_conn, $di, $df), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12", "#76D7C4"], 'chartUnidadeEnvolvida', '', '', 'doughnut', 15);

    });
    </script>
    <?php
        }else{
            if(!isset($_GET['tipo']) || $_GET['tipo'] == '')
            {
    ?>
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
        grafico(<?php echo json_encode(Graficos::consultarManifestacao($db_conn, '', ''), JSON_NUMERIC_CHECK) ?>, ["#e53935","#f57c00","#43a047","#ffee58","#ff4081"], 'chartManifestacoes', '', '', 'doughnut', 15);
        grafico(<?php echo json_encode(Graficos::consultarAssunto($db_conn, '', ''), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12","#E67E22","#884EA0","#7FB3D5","#76D7C4","#D5F5E3", "#7D6608","#7E5109","#DC7633"], 'chartAssuntos', '', '', 'pie', 14);
        grafico(<?php echo json_encode(Graficos::consultarNup($db_conn, '', ''), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#3FFF00"], 'chartOrigem', '', '', 'doughnut', 15);
        grafico(<?php echo json_encode(Graficos::consultarProveniencia($db_conn, '', ''), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#3FFF00"], 'chartProveniencia', '', '', 'doughnut', 15);
        grafico(<?php echo json_encode(Graficos::consultarSituacao($db_conn, '', ''), JSON_NUMERIC_CHECK) ?>, ["#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12","#E67E22","#884EA0","#7FB3D5","#76D7C4","#D5F5E3","#7D6608","#7E5109","#DC7633"], 'chartSituacao', '', '', 'doughnut', 17);
        grafico(<?php echo json_encode(Graficos::consultaCampus($db_conn, '', ''), JSON_NUMERIC_CHECK) ?>, ["#884ea0","#CB4335","#2E86C1","#28B463","#F1C40F","#F39C12", "#76D7C4"], 'chartUnidadeEnvolvida', '', '', 'doughnut', 15);

    });
    </script>
        <?php }else{
            include("relatorios/".$tipo.".php");
        } 
    }   
        ?>
</div>
<script>
    
    $(document).ready(function(){
        $('.tooltipped').tooltip();
        $('#dataInicial').inputmask("99/99/9999");
        $('#dataFinal').inputmask("99/99/9999");
        $("#status_box").css("height", '60px');

        $("a[data-tooltip='Relatório por data']").on('click', function(){
            var dataInicial = $("#dataInicial");
            var dataFinal = $("#dataFinal");

            if(dataInicial.val() === '' || dataFinal.val() === '')
            {
                alert("É necessário inserir o intervalo de data para gerar o relatório.");
            }else{
                window.location.href='?page=relatorios&di='+dataInicial.val()+'&df='+dataFinal.val();
            }

        });
    });
</script>