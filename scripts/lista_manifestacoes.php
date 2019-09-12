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
            echo("<div class=\"row\">");
                echo("<div class=\"col s2\"><span>Cód. Manifestação:</span> <p>".$row["idManifestacao"]."</p></div>");
                echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                echo("<div class=\"col s2\"><span>Tipo de Manifestação:</span> <p class=\"orange-text text-darken-1\">Reclamação</p></div>");
                echo("<div class=\"col s3\"><span>Assunto:</span> <p>".$row["assunto"]."</p></div>");
                echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".$row["dataRecebimento"]."</p></div>");
                echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".$row["dataLimite"]."</p></div>");
            echo("</div>");
            echo("<a class=\"dropdown-trigger blue-grey tooltipped\" data-position=\"bottom\" data-tooltip=\"Visualização rápida\"><i class=\"material-icons\">pageview</i></a>");
        echo("</div>");
    }
}else{
    switch($tipoManifestacao)
    {

    }
}

?>