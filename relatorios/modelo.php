<?php


?>
<div class='fullReportWrapper z-depth-1'>
    <div class='row'>
        <div class='col s6'></div>
        <div class='col s6'><div id='chartManifestacoes'></div></div>
    </div>
</div>

<script>
$(document).ready(function(){
    grafico(<?php echo json_encode(Graficos::consultarManifestacao($db_conn), JSON_NUMERIC_CHECK) ?>, ["#e53935","#f57c00","#43a047","#ffee58","#ff4081"], 'chartManifestacoes', '', '', 'doughnut', 16);
});
</script>