<?php
    if(isset($_GET["id"]))
    {
        $id = $_GET["id"];
        if(Manifestacoes::existeManifestacao($id, $db_conn))
        {
            $Manifestacao = new Manifestacoes($id, $db_conn);
        }else{
            die("O id informado não existe.");
        }
           
    }else{
        die("Id não definido");
    }
?>
<div class="title"><a onclick="location.href='?page=visualizar_manifestacao&id=<?php echo $id ?>'" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a><span class="blue-grey-text text-darken-3">Editar Manifestação</span></div>
<div class="container">
<div class="row">
    <form id="formManifestacao" name="formManifestacao" class="col s12">
        <div class="row">
            <div class="input-field col s4">
                <input id="nup" type="text" class="validate" name="nup" value="<?php $Manifestacao->getNup() ?>">
                <label for="nup">NUP</label>
                </div>
                <div class="input-field col s4">
                    <select name="tipoManifestacao">
                        <option value="" disabled>Selecione o tipo</option>
                        <option value="1" <?php if($Manifestacao->getTipoManifestacao() == 1){echo "selected";} ?> >Denúncia</option>
                        <option value="2" <?php if($Manifestacao->getTipoManifestacao() == 2){echo "selected";} ?> >Reclamação</option>
                        <option value="3" <?php if($Manifestacao->getTipoManifestacao() == 3){echo "selected";} ?> >Solicitação</option>
                        <option value="4" <?php if($Manifestacao->getTipoManifestacao() == 4){echo "selected";} ?> >Sugestão</option>
                        <option value="5" <?php if($Manifestacao->getTipoManifestacao() == 5){echo "selected";} ?> >Elogio</option>
                    </select>
                    <label>Tipo de Manifestação</label>
                </div>
                <div class="input-field col s2">
                    <input id="datarecebimento" type="text" class="validate" name="dataRecebimento" value='<?php 
                    echo Helper::converterMysqlDataToData($Manifestacao->getDataRecebimento());  ?>'>
                    <label for="datarecebimento">Data de Recebimento</label>
                </div>
                <div class="input-field col s2">
                    <input id="datalimite" type="text" class="validate" name="dataLimite" value=

                    '<?php if (Helper::converterMysqlDataToData($Manifestacao->getDataLimite()) == "---") {
                            echo "00/00/0000";
                    }else{
                        echo Helper::converterMysqlDataToData($Manifestacao->getDataLimite());
                    }  
                    ?>'>


                    <label for="datalimite">Data Limite</label>
                </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="assunto" type="text" class="validate" name="assunto" value='<?php echo $Manifestacao->getAssunto(); ?>'>
                <label for="assunto">Título da manifestação</label>
            </div>
            <div class="input-field col s3">
                <select name="formaRecebimento">
                    <option value="" disabled selected>Forma de recebimento</option>
                    <option value="1" <?php if($Manifestacao->getFormaRecebimento()==1){echo "selected";} ?> >E-Ouv</option>
                    <option value="2" <?php if($Manifestacao->getFormaRecebimento()==2){echo "selected";} ?>>E-mail</option>
                    <option value="3" <?php if($Manifestacao->getFormaRecebimento()==3){echo "selected";} ?>>Telefone</option>
                    <option value="4" <?php if($Manifestacao->getFormaRecebimento()==4){echo "selected";} ?>>Outros</option>
                </select>
                <label>Recebida por</label>
            </div>
            <div class="input-field col s3">
                <select name="situacao">
                    <option value="" disabled selected>Selecione a situação</option>
                    <option value="1" <?php if($Manifestacao->getSituacao()==1){echo "selected";} ?> >Cadastrada</option>
                    <option value="2" <?php if($Manifestacao->getSituacao()==2){echo "selected";} ?>>Complementação Solicitada</option>
                    <option value="3" <?php if($Manifestacao->getSituacao()==3){echo "selected";} ?>>Complementada</option>
                    <option value="4" <?php if($Manifestacao->getSituacao()==4){echo "selected";} ?>>Encaminhada</option>
                    <option value="5" <?php if($Manifestacao->getSituacao()==5){echo "selected";} ?>>Prorrogada</option>
                    <option value="6" <?php if($Manifestacao->getSituacao()==6){echo "selected";} ?>>Arquivada</option>
                    <option value="7" <?php if($Manifestacao->getSituacao()==7){echo "selected";} ?>>Concluída</option>
                    <option value="8" <?php if($Manifestacao->getSituacao()==8){echo "selected";} ?>>Encaminhada para Orgão Externo - Encerrada</option>
                </select>
                <label>Situação da Manifestação</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s4">
                    <select name="unidadeEnvolvida">
                        <option value="" disabled selected>Selecione a situação</option>
                        <option value="Campus JK" <?php if($Manifestacao->getUnidadeEnvolvida() == "Campus JK"){echo "selected";} ?>>Campus JK</option>
                        <option value="Campus I" <?php if($Manifestacao->getUnidadeEnvolvida() == "Campus I"){echo "selected";} ?> >Campus I</option>
                        <option value="Campus Janaúba"<?php if($Manifestacao->getUnidadeEnvolvida() == "Campus Janaúba"){echo "selected";} ?>>Campus Janaúba</option>
                        <option value="Campus Unaí" <?php if($Manifestacao->getUnidadeEnvolvida() == "Campus Unaí"){echo "selected";} ?>>Campus Unaí</option>
                        <option value="Campus Mucuri" <?php if($Manifestacao->getUnidadeEnvolvida() == "Campus Mucuri"){echo "selected";} ?>>Campus Mucuri</option>
                        <option value="Desconhecido" <?php if($Manifestacao->getUnidadeEnvolvida() == "Desconhecido"){echo "selected";} ?>>Desconhecido</option>
                    </select>
                    <label>Campus</label>
            </div>
            <div class="input-field col s4">
            <select name="proveniencia">
                    <option value="" disabled selected>Selecione a proveniência</option>
                    <option value="1" <?php if($Manifestacao->getProveniencia() == 1){echo "selected";} ?>>Comunidade Interna</option>
                    <option value="2" <?php if($Manifestacao->getProveniencia() == 2){echo "selected";} ?>>Comunidade Externa</option>
                    <option value="3" <?php if($Manifestacao->getProveniencia() == 3){echo "selected";} ?>>Anonimo</option>
                </select>
                <label>Proveniência</label>
            </div>
            <div class="input-field col s4">
                <select name="topicoManifestacao">
                    <option value="" disabled selected>Selecione o assunto</option>
                    <option value="1" <?php if($Manifestacao->getTopicoManifestacao() ==1){echo "selected";} ?>>Graduação</option>
                    <option value="2" <?php if($Manifestacao->getTopicoManifestacao()==2){echo "selected";} ?>>Pos-Graduação</option>
                    <option value="3" <?php if($Manifestacao->getTopicoManifestacao()==3){echo "selected";} ?>>Extensão</option>
                    <option value="4" <?php if($Manifestacao->getTopicoManifestacao()==4){echo "selected";} ?>>Serviços</option>
                    <option value="5" <?php if($Manifestacao->getTopicoManifestacao()==5){echo "selected";} ?>>Conduta</option>
                    <option value="6" <?php if($Manifestacao->getTopicoManifestacao()==6){echo "selected";} ?>>Pessoal</option>
                    <option value="7" <?php if($Manifestacao->getTopicoManifestacao()==7){echo "selected";} ?>>Gestão</option>
                    <option value="8" <?php if($Manifestacao->getTopicoManifestacao()==8){echo "selected";} ?>>Acesso à Graduação</option>
                    <option value="9" <?php if($Manifestacao->getTopicoManifestacao()==9){echo "selected";} ?>>Assistência Estudantil</option>
                    <option value="10" <?php if($Manifestacao->getTopicoManifestacao()==10){echo "selected";} ?>>Legislação e Normas</option>
                    <option value="11" <?php if($Manifestacao->getTopicoManifestacao()==11){echo "selected";} ?>>Concursos</option>
                    <option value="12" <?php if($Manifestacao->getTopicoManifestacao()==12){echo "selected";} ?>>Outros</option>


                </select>
                <label>Assunto</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="nomeDemandante" type="text" name="nomeDemandante" value='<?php echo $Manifestacao->getNomeDemandante() ?>'>
                <label for="nomeDemandante">Nome demandante</label>
            </div>
            <div class="input-field col s6">
                <input id="email" type="email" class="validate" name="emailDemandante" value='<?php echo $Manifestacao->getEmailDemandante() ?>'>
                <label for="email">E-mail</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
            <textarea id="infoextra" class="materialize-textarea" name="infoExtra"><?php echo $Manifestacao->getInfoExtra() ?></textarea>
            <label for="infoextra">Informações adicionais</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12 right-align">
            <a class="blue darken-4 waves-effect waves-light btn-large hoverable"><i class="material-icons left">send</i>Editar</a>
            </div>
        </div>
    </form>
  </div>
</div>
<script>$(document).ready(function(){
    $('.tooltipped').tooltip();
    
    $('select').formSelect();
    $('#nup').inputmask("99999.999999/9999-99");  
    $('#datarecebimento').inputmask("99/99/9999"); 
    $('#datalimite').inputmask("99/99/9999");


    $("#formManifestacao").on("click", "a", function(){
        postForm("scripts/edit_manifestacao.php?id="+<?php echo $id ?>, "formManifestacao", '?page=visualizar_manifestacao&id='+<?php echo $id ?>);
    });

  });
  </script>