<?php
require("../config/config_scripts.php");

if(isset($_GET["tipo"]))
{
    $tipoManifestacao = $_GET["tipo"];
}else{
    $tipoManifestacao = '';
}

if(isset($_GET["p"]))
{
    $pesquisa = $_GET["p"];
    if(empty($pesquisa))
    {
        goto sempesquisa;
    }
    echo("<div class=\"group_title blue-grey-text\"><span>Resultado pesquisa: $pesquisa</span></div>");
    if(isset($_GET['tipoP']) && $_GET['tipoP'] == 'date')
    {
        $resutlado_pesquisa = Manifestacoes::pesquisarManifestacaoDate($pesquisa, $db_conn);
    }else{
        $resutlado_pesquisa = Manifestacoes::pesquisarManifestacao($pesquisa, $db_conn);
    }
    if($resutlado_pesquisa->num_rows > 0)
    {
        while($row = $resutlado_pesquisa->fetch_array())
        {
            if(strlen($row["assunto"]) > 38)
                {
                    $titulo = mb_substr($row['assunto'],0,38, "utf-8")."...";
                }else{
                    $titulo = $row["assunto"];
                }
            echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                echo("<div class=\"row\">");
                    echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                    echo("<div class=\"col s2\"><span>NUP:</span> <p>".($row["nup"]==''?("---") : ($row["nup"]))."</p></div>");
                    echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class='".Manifestacoes::getCorStatusManifestacao($row["situacao"])."'>".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                    echo("<div class=\"col s3\"><span>Título:</span> <p>$titulo</p></div>");
                    echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                    echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                echo("</div>");
            echo("</div>");
        }
    }
    
}else{
    sempesquisa:
    if(isset($_GET["sort"]))
    {
        $filtro = $_GET["sort"];
    }else{
        $filtro = '';
    }
    if($tipoManifestacao == '' || $tipoManifestacao == 0)
    {
        $lista = Manifestacoes::listarManifestacoes('', $filtro, $db_conn);
        echo("<div class=\"group_title blue-grey-text\"><span>Lista de demandas</span></div>");
        while($row = $lista->fetch_array())
        {
            if(strlen($row["assunto"]) > 38)
                {
                    $titulo = mb_substr($row['assunto'],0,38, "utf-8")."...";
                }else{
                    $titulo = $row["assunto"];
                }
            echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                echo("<div class=\"row\">");
                    echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                    echo("<div class=\"col s2\"><span>NUP:</span> <p>".($row["nup"]==''?("---") : ($row["nup"]))."</p></div>");
                    echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class='".Manifestacoes::getCorStatusManifestacao($row["situacao"])."'>".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                    echo("<div class=\"col s3\"><span>Título:</span> <p>$titulo</p></div>");
                    echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                    echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                echo("</div>");
            echo("</div>");
        }
    }else{
        switch($tipoManifestacao)
        {
            case 1:
            $denuncia = Manifestacoes::listarManifestacoes(1, $filtro, $db_conn);
            echo("<div class=\"group_title blue-grey-text\"><span>Denúncia</span></div>");
            while($row = $denuncia->fetch_array())
            {
                if(strlen($row["assunto"]) > 38)
                {
                    $titulo = mb_substr($row['assunto'],0,38, "utf-8")."...";
                }else{
                    $titulo = $row["assunto"];
                }
                echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                    echo("<div class=\"row\">");
                        echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                        echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class='".Manifestacoes::getCorStatusManifestacao($row["situacao"])."'>".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                        echo("<div class=\"col s3\"><span>Título:</span> <p>$titulo</p></div>");
                        echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                        echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                    echo("</div>");
                echo("</div>");
            }
            break;
            case 2:
            $reclamacao = Manifestacoes::listarManifestacoes(2, $filtro, $db_conn);
            echo("<div class=\"group_title blue-grey-text\"><span>Reclamação</span></div>");
            while($row = $reclamacao->fetch_array())
            {
                if(strlen($row["assunto"]) > 38)
                {
                    $titulo = mb_substr($row['assunto'],0,38, "utf-8")."...";
                }else{
                    $titulo = $row["assunto"];
                }
                echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                    echo("<div class=\"row\">");
                        echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                        echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class='".Manifestacoes::getCorStatusManifestacao($row["situacao"])."'>".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                        echo("<div class=\"col s3\"><span>Título:</span> <p>$titulo</p></div>");
                        echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                        echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                    echo("</div>");
                echo("</div>");
            }
            break;
            case 3:
            $solicitacao = Manifestacoes::listarManifestacoes(3, $filtro, $db_conn);
            echo("<div class=\"group_title blue-grey-text\"><span>Solicitação</span></div>");
            while($row = $solicitacao->fetch_array())
            {
                if(strlen($row["assunto"]) > 38)
                {
                    $titulo = mb_substr($row['assunto'],0,38, "utf-8")."...";
                }else{
                    $titulo = $row["assunto"];
                }
                echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                    echo("<div class=\"row\">");
                        echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                        echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class='".Manifestacoes::getCorStatusManifestacao($row["situacao"])."'>".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                        echo("<div class=\"col s3\"><span>Título:</span> <p>$titulo</p></div>");
                        echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                        echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                    echo("</div>");
                echo("</div>");
            }
            break;
            case 4:
            $sugestao = Manifestacoes::listarManifestacoes(4, $filtro, $db_conn);
            echo("<div class=\"group_title blue-grey-text\"><span>Sugestão</span></div>");
            while($row = $sugestao->fetch_array())
            {
                if(strlen($row["assunto"]) > 38)
                {
                    $titulo = mb_substr($row['assunto'],0,38, "utf-8")."...";
                }else{
                    $titulo = $row["assunto"];
                }
                echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                    echo("<div class=\"row\">");
                        echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                        echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class='".Manifestacoes::getCorStatusManifestacao($row["situacao"])."'>".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                        echo("<div class=\"col s3\"><span>Título:</span> <p>$titulo</p></div>");
                        echo("<div class=\"col s2\"><span>Data de Recebimento:</span> <p>".Helper::converterMysqlDataToData($row["dataRecebimento"])."</p></div>");
                        echo("<div class=\"col s1\"><span>Data Limite:</span> <p>".Helper::converterMysqlDataToData($row["dataLimite"])."</p></div>");
                    echo("</div>");
                echo("</div>");
            }
            break;
            case 5:
            $elogio = Manifestacoes::listarManifestacoes(5, $filtro, $db_conn);
            echo("<div class=\"group_title blue-grey-text\"><span>Elogio</span></div>");
            while($row = $elogio->fetch_array())
            {
                if(strlen($row["assunto"]) > 38)
                {
                    $titulo = substr($row['assunto'], 0, 38)."...";
                }else{
                    $titulo = $row["assunto"];
                }
                echo("<div class=\"manifestacoes z-depth-1 ".Manifestacoes::getCorManifestacaoClass($row['tipoManifestacao'])."\" onclick=\"location.href='?page=visualizar_manifestacao&id=".$row["idManifestacao"]."'\">");
                    echo("<div class=\"row\">");
                        echo("<div class=\"col s1\"><span>Cód.:</span> <p>".$row["idManifestacao"]."</p></div>");
                        echo("<div class=\"col s2\"><span>NUP:</span> <p>".$row["nup"]."</p></div>");
                        echo("<div class=\"col s2\"><span>Estado da Manifestação:</span> <p class='".Manifestacoes::getCorStatusManifestacao($row["situacao"])."'>".Manifestacoes::getStatusName($row["situacao"], $db_conn)."</p></div>");
                        echo("<div class=\"col s3\"><span>Título:</span> <p>$titulo</p></div>");
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