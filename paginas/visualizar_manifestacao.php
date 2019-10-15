<?php
    if(isset($_GET["id"]))
    {
        $id = $_GET["id"];
        try{
            $Manifestacao = new Manifestacoes($id, $db_conn);
            $User = new User($Manifestacao->getUsuario(), $db_conn);
        }catch(Exception $e){
            die("Id da manifestação inexistente.");
        }
    }else{
        die("Id da manifestação não definido.");
    }
?>
<div class="title">
    <a onclick="location.href='?page=dashboard'" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
    <span class="blue-grey-text text-darken-3">Título: <span class='blue-grey-text'><?php echo $Manifestacao->getAssunto(); ?></span></span>
    <div class="options">
        <a class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Adicionar Ação"><i class="material-icons">add</i></a>  
        <a onclick="location.href='?page=editar_manifestacao&id=<?php echo $Manifestacao->getIdManifestacao(); ?>'" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Editar"><i class="material-icons">edit</i></a>
        <a onclick="deletarManifestacao('<?php echo $Manifestacao->getIdManifestacao(); ?>');" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Excluir"><i class="material-icons">delete</i></a>  
    </div>
</div>
<div class="container">
    <div class="recebida_por blue-grey lighten-3 z-depth-1"><span><?php echo Manifestacoes::getNomeFormaRecebimento($Manifestacao->getFormaRecebimento()) ?></span></div>
    <div class='adicionadaPor blue-grey lighten-3 z-depth-1 tooltipped' data-position="bottom" data-tooltip="<?php echo $User->getLogin() ?>"><span><?php echo $User->getNome() ?></span></div>
    <div class='prorrogarBtn'><a data-tooltip="Prorrogar" class="waves-effect waves-light btn blue-grey lighten-3 hoverable"><i class="material-icons left">date_range</i>Prorrogar Manifestação</a></div>
    <?php
        if($Manifestacao->getSituacao() != 7)
        {
            echo("<div class='concluirBtn'><a data-tooltip=\"Conluir Manifestação\" class=\"waves-effect waves-light btn blue-grey lighten-3 hoverable\" mid=\"".$Manifestacao->getIdManifestacao()."\"><i class=\"material-icons left\">check</i>Concluir Manifestação</a></div>");
        }
    ?>
    <div class="manifestacaoInfo z-depth-1 <?php echo Manifestacoes::getCorManifestacaoClass($Manifestacao->getTipoManifestacao())."Top" ?>">
        <div class='row'>
            <div class='col s1'><span>Cód. :</span> <span><?php echo $Manifestacao->getIdManifestacao() ?></span></div>
            <div class='col s2'><span>NUP:</span> <span>
                <?php
                    if(empty($Manifestacao->getNup()))
                    {
                        echo("---");
                    }else{
                        echo $Manifestacao->getNup();
                    }
                ?>
            </span></div>
            <div class='col s3'><span>Tipo de Manifestação:</span> 
                <span class="<?php echo Manifestacoes::getCorManifestacao($Manifestacao->getTipoManifestacao()); ?>">
                    <?php echo Manifestacoes::getManifestacaoTypeName($Manifestacao->getTipoManifestacao(), $db_conn); ?>
                </span>
            </div>
            <div class='col s2'><span>Estado da Manifestação:</span> 
                <span class='amber-text text-darken-4'>
                    <?php echo Manifestacoes::getStatusName($Manifestacao->getSituacao(), $db_conn); ?>
                </span>
            </div>
            <div class='col s2'><span>Data de Recebimento:</span> <span><?php echo Helper::converterMysqlDataToData($Manifestacao->getDataRecebimento()) ?></span></div>
            <div class='col s2'><span>Data Limite:</span> <span><?php echo Helper::converterMysqlDataToData($Manifestacao->getDataLimite()) ?></span></div>
        </div>
        <div class='row'>
            <div class='col s3'><span>Nome Demandante:</span> <span><?php echo $Manifestacao->getNomeDemandante() ?></span></div>
            <div class='col s3'><span>E-mail Demandante:</span> <span><?php echo $Manifestacao->getEmailDemandante() ?></span></div>
            <div class='col s2'><span>Assunto:</span> <span><?php echo Manifestacoes::getAssuntoNome($Manifestacao->getTopicoManifestacao(), $db_conn) ?></span></div>
            <div class='col s2'><span>Campus:</span> <span><?php echo $Manifestacao->getUnidadeEnvolvida() ?></span></div>
            <div class='col s2'><span>Proveniência:</span> <span><?php echo Manifestacoes::getProvenienciaNome($Manifestacao->getProveniencia(), $db_conn) ?></span></div>
        </div>
    </div>

<!-- Pendências -->
    <div class="pendencias_wrapper">
        <div class='pendencia z-depth-2'>
            <div class='header blue-grey darken-1'><span>Informações Adicionais</span></div>
            <div class='info_body'><span><?php 
            
            if(empty($Manifestacao->getInfoExtra()))
            {
                echo("Nenhuma informação adicional foi adicionada.");
            }else{
                echo $Manifestacao->getInfoExtra();
            }
            
            ?></span></div>
        </div>

        <div class="division"></div>
        <?php
            $listaPendencias = Pendencias::getListaPendencias($id, $db_conn);
            if($listaPendencias)
            {
                while($row = $listaPendencias->fetch_array())
                {
                    switch($row["tipoPendencia"])
                    {
                        case 1:
                            $color_class = "light-green darken-1";
                        break;
                        case 2:
                            $color_class = "lime accent-3";
                        break;
                        case 3:
                            $color_class = "cyan accent-4";
                        break;
                        case 4:
                            $color_class = "yellow"; 
                        break;
                        case 5:
                            $color_class = "deep-purple lighten-3";
                        break;
                        case 6:
                            $color_class = "red darken-1";
                        break;
                        case 7:
                            $color_class = "green darken-3";
                        break;
                        case 8:
                            $color_class = "pink lighten-3";
                        break;
                        case 9:
                            $color_class = "purple accent-4";
                        break;

                    }

                    if($row["tipoPendencia"] == 3)
                    {
                        $r = Pendencias::getParteEnvolvida($row["id"], $db_conn)->fetch_array();
                        $encaminhadoPara = "para ".$r["encaminhadoPara"];
                        $dataLimitePosicionamento = $r["dataLimitePosicionamento"];

                        $html_datalimite = "<p><b>Data Limite:</b> ".Helper::converterMysqlDataToData($dataLimitePosicionamento)."</p>";

                    }else{
                        $encaminhadoPara = "";
                        $dataEncaminhamento = "";
                        $dataLimitePosicionamento = "";
                        $html_datalimite = "";
                    }

                    echo("<div class='pendencia z-depth-1'>");
                        echo("<div class='left'>");
                            echo("<div class='header $color_class'><span>".Pendencias::getNomePendencia($row['tipoPendencia'])." $encaminhadoPara</span> <span>".Helper::converterMysqlDataToData($row['dataPendencia'])." </span></div>");
                            echo("<div class='info_body'>$html_datalimite<span>".$row['descricaoPendencia']."</span></div>");
                            if(!empty($row['anexo']))
                            {
                                echo("<div class='footer grey lighten-3'>");
                                    echo("<a onclick=\"window.open('".$row['anexo']."', '_blank')\" class=\"tooltipped z-depth-0\" data-position=\"bottom\" data-tooltip=\"Baixar anexo\"><i class=\"material-icons\">attachment</i><span>Baixar Anexo</span></a>");
                                    echo("");
                                echo("</div>");
                            }
                        echo("</div>");
                        echo("<div class='right z-depth-2'>");
                            echo("<a onclick=\"deleterAcao('".$row['id']."');\" class=\"tooltipped\" data-position=\"bottom\" data-tooltip=\"Deletar Ação\"><i class=\"material-icons\">delete</i></a>");
                            echo("<a id-edit=\"".$row['id']."\" class=\"tooltipped editAcao\" data-position=\"bottom\" data-tooltip=\"Editar Ação\"><i class=\"material-icons\">edit</i></a>");
                        echo("</div>");
                    echo("</div>");
                }
            }else{
                echo("<p style='text-align:center;'>Nenhuma ocorrência registrada para essa manifestação.</p>");
            }
        ?>

    </div>
</div>
<script>
$(document).ready(function(){
        $('.tooltipped').tooltip();

        $("a[data-tooltip='Adicionar Ação']").on("click", function(e){
            loadPageOnWindow('Adicionar Ação', '80%', '80vh', 'd_paginas/add_acao.php?id=<?php echo $id ?>');
        });
        $(".editAcao").on("click", function(e){
            loadPageOnWindow('Editar Ação', '80%', '85vh', 'd_paginas/editar_acao.php?id='+$(this).attr('id-edit'));
        });
        $("a[data-tooltip='Prorrogar']").on("click", function(e){
            loadPageOnWindow('Prorrogar Manifestação', '80%', '50vh', 'd_paginas/prorrogar_manifestacao.php?id=<?php echo $id ?>');
        });
        $("a[data-tooltip='Conluir Manifestação']").on("click", function(e){
            showLoading();
            $.ajax({
                url: 'scripts/update_manifestacao.php?actionId=concluirManifestacao&idManifestacao='+$(this).attr("mid"),
                type: 'POST',
                success: function(data)
                {
                    if(data == "ok")
                    {
                        alert("Manifestação concluída com sucesso.");
                        window.location.reload();
                        closeLoading();
                    }else{
                        alert(data);
                        closeLoading();
                    }
                }
            });
        });
        
});
</script>