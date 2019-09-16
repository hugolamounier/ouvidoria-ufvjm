<?php
require("../config/config_scripts.php");

$tipoManifestacao = $_GET["tipo"];
$filtro = $_GET["sort"];

if($tipoManifestacao == '')
{
    $lista = Manifestacoes::listarManifestacoes('', '', $db_conn);
    while($row = $lista->fetch_array())
    {
        echo("<div class=\"manifestacoes\">");
        echo("<a onclick=\"location.href='?page=editar_manifestacao&id=".$row['idManifestacao']."'\" class=\"blue-grey tooltipped\" data-position=\"bottom\" data-tooltip=\"Editar\"><i class=\"material-icons\">edit</i></a>");
        echo("<a onclick=\"deletarManifestacao('".$row['idManifestacao']."');\" class=\"blue-grey tooltipped\" data-position=\"bottom\" data-tooltip=\"Excluir\"><i class=\"material-icons\">delete</i></a>");
            echo("<div class=\"row\">");
                echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                echo("<div class=\"col s2\"><span>Tipo de Manifestação:</span> <p class=\"orange-text text-darken-1\">".Manifestacoes::getManifestacaoName($row["tipoManifestacao"], $db_conn)."</p></div>");
                echo("<div class=\"col s3\"><span>Assunto:</span> <p>".$row["assunto"]."</p></div>");
                echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
            echo("</div>");
        echo("</div>");
    }
}else{
    switch($tipoManifestacao)
    {

    }
}

?>
<script>
    $('.tooltipped').tooltip({ delay: 50});
</script>