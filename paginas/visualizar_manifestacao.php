<?php
    if(isset($_GET["id"]))
    {
        $id = $_GET["id"];
        $Manifestacao = new Manifestacoes($id, $db_conn);
    }else{
        die("Id da manifestação não definido.");
    }
?>
<div class="title">
    <a onclick="location.href='?page=dashboard'" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
    <span class="blue-grey-text text-darken-3">Assunto: <span class='blue-grey-text'><?php echo $Manifestacao->getAssunto(); ?></span></span>
    <div class="options">
        <a class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Adicionar Ação"><i class="material-icons">add</i></a>  
        <a onclick="location.href='?page=editar_manifestacao&id=<?php echo $Manifestacao->getIdManifestacao(); ?>'" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Editar"><i class="material-icons">edit</i></a>
        <a onclick="deletarManifestacao('<?php echo $Manifestacao->getIdManifestacao(); ?>');" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Excluir"><i class="material-icons">delete</i></a>  
    </div>
</div>
<div class="container">
    <div class="manifestacaoInfo <?php echo Manifestacoes::getCorManifestacaoClass($Manifestacao->getTipoManifestacao())."Top" ?>">
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
            <div class='col s2'><span>Unidade Envolvida:</span> <span><?php echo $Manifestacao->getUnidadeEnvolvida() ?></span></div>
            <div class='col s4'><span>Proveniência:</span> <span><?php echo $Manifestacao->getProveniencia() ?></span></div>
        </div>
    </div>

<!-- Pendências -->
    <div class="pendencias_wrapper">
        <div class='pendencia z-depth-2'>
            <div class='header blue-grey darken-1'><span>Informações Adicionais</span></div>
            <div class='info_body'><span><?php echo $Manifestacao->getInfoExtra() ?></span></div>
        </div>

        <div class="division"></div>

        <div class='pendencia z-depth-1'>
            <div class='header light-green darken-1'><span>Requerimento Inicial</span></div>
            <div class='info_body'><span>AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA<BR> AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA <BR></span></div>
            <div class='footer grey lighten-3'></div>
        </div>

        <div class='pendencia z-depth-1'>
            <div class='header lime accent-3'><span>Resposta Inicial</span></div>
            <div class='info_body'><span>NADA!</span></div>
            <div class='footer grey lighten-3'></div>
        </div>

        <div class='pendencia z-depth-1'>
            <div class='header cyan accent-4'><span>Encaminhamento</span></div>
            <div class='info_body'><span>Encaminhado para PROGRAD.</span></div>
            <div class='footer grey lighten-3'></div>
        </div>

    </div>
</div>
<script>
$(document).ready(function(){
        $('.tooltipped').tooltip();

        $("a[data-tooltip='Adicionar Ação']").on("click", function(e){
            loadPageOnWindow('Adicionar Ação', '80%', '80vh', 'd_paginas/add_acao.php?id=<?php echo $id ?>');
        });
});
</script>