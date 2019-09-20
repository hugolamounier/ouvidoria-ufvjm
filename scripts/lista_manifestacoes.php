<?php
require("../config/config_scripts.php");

$tipoManifestacao = $_GET["tipo"];
$filtro = $_GET["sort"];

if(isset($_GET["p"]))
{
    $pesquisa = $_GET["p"];
    if(empty($pesquisa))
    {
        goto sempesquisa;
    }
    echo("<div class=\"group_title blue-grey-text\"><span>Resultado pesquisa: $pesquisa</span></div>");
    $resutlado_pesquisa = Manifestacoes::pesquisarManifestacao($pesquisa, $db_conn);
    if($resutlado_pesquisa->num_rows > 0)
    {
        while($row = $resutlado_pesquisa->fetch_array())
        {
            echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                echo("<div class=\"row\">");
                    echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                    echo("<div class=\"col s2\"><span>NUP:</span> <p>".($row["nup"]==''?("---") : ($row["nup"]))."</p></div>");
                    echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p >".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                    echo("<div class=\"col s3\"><span>Assunto:</span> <p>".$row["assunto"]."</p></div>");
                    echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                    echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                echo("</div>");
            echo("</div>");
        }
    }
    
}else{
    sempesquisa:
    if($tipoManifestacao == '')
    {
        $lista = Manifestacoes::listarManifestacoes('', '', $db_conn);
        echo("<div class=\"group_title blue-grey-text\"><span>Lista de demandas</span></div>");
        while($row = $lista->fetch_array())
        {
            echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                echo("<div class=\"row\">");
                    echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                    echo("<div class=\"col s2\"><span>NUP:</span> <p>".($row["nup"]==''?("---") : ($row["nup"]))."</p></div>");
                    echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p >".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                    echo("<div class=\"col s3\"><span>Assunto:</span> <p>".$row["assunto"]."</p></div>");
                    echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                    echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                echo("</div>");
            echo("</div>");
        }
    }else{
        switch($tipoManifestacao)
        {
            case 1:
            $denuncia = Manifestacoes::listarManifestacoes(1, '', $db_conn);
            echo("<div class=\"group_title blue-grey-text\"><span>Denúncia</span></div>");
            while($row = $denuncia->fetch_array())
            {
                echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                    echo("<div class=\"row\">");
                        echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                        echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class=\"orange-text text-darken-1\">".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                        echo("<div class=\"col s3\"><span>Assunto:</span> <p>".$row["assunto"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                        echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                    echo("</div>");
                echo("</div>");
            }
            break;
            case 2:
            $reclamacao = Manifestacoes::listarManifestacoes(2, '', $db_conn);
            echo("<div class=\"group_title blue-grey-text\"><span>Reclamação</span></div>");
            while($row = $reclamacao->fetch_array())
            {
                echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                    echo("<div class=\"row\">");
                        echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                        echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class=\"orange-text text-darken-1\">".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                        echo("<div class=\"col s3\"><span>Assunto:</span> <p>".$row["assunto"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                        echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                    echo("</div>");
                echo("</div>");
            }
            break;
            case 3:
            $solicitacao = Manifestacoes::listarManifestacoes(3, '', $db_conn);
            echo("<div class=\"group_title blue-grey-text\"><span>Solicitação</span></div>");
            while($row = $solicitacao->fetch_array())
            {
                echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                    echo("<div class=\"row\">");
                        echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                        echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class=\"orange-text text-darken-1\">".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                        echo("<div class=\"col s3\"><span>Assunto:</span> <p>".$row["assunto"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                        echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                    echo("</div>");
                echo("</div>");
            }
            break;
            case 4:
            $sugestao = Manifestacoes::listarManifestacoes(4, '', $db_conn);
            echo("<div class=\"group_title blue-grey-text\"><span>Sugestão</span></div>");
            while($row = $sugestao->fetch_array())
            {
                echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                    echo("<div class=\"row\">");
                        echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                        echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class=\"orange-text text-darken-1\">".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                        echo("<div class=\"col s3\"><span>Assunto:</span> <p>".$row["assunto"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                        echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                    echo("</div>");
                echo("</div>");
            }
            break;
            case 5:
            $elogio = Manifestacoes::listarManifestacoes(5, '', $db_conn);
            echo("<div class=\"group_title blue-grey-text\"><span>Elogio</span></div>");
            while($row = $elogio->fetch_array())
            {
                echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                    echo("<div class=\"row\">");
                        echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                        echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class=\"orange-text text-darken-1\">".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                        echo("<div class=\"col s3\"><span>Assunto:</span> <p>".$row["assunto"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                        echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                    echo("</div>");
                echo("</div>");
            }
            break;

        }
    }
}
?>