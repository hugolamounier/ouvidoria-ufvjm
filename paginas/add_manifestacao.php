<?php

?>
<div class="title"><a onclick="location.href='?page=dashboard'" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a><span class="blue-grey-text text-darken-3">Adicionar Manifestação</span></div>
<div class="container">
<div class="row">
    <form id="formManifestacao" name="formManifestacao" class="col s12">
        <div class="row">
            <div class="input-field col s4">
                <input id="nup" type="text" class="validate" name="nup">
                <label for="nup">NUP</label>
                </div>
                <div class="input-field col s4">
                    <select name="tipoManifestacao">
                        <option value="" disabled selected>Selecione o tipo</option>
                        <option value="1">Denúncia</option>
                        <option value="2">Reclamação</option>
                        <option value="3">Solicitação</option>
                        <option value="4">Sugestão</option>
                        <option value="5">Elogio</option>
                    </select>
                    <label>Tipo de Manifestação</label>
                </div>
                <div class="input-field col s2">
                    <input id="datarecebimento" type="text" class="validate" name="dataRecebimento">
                    <label for="datarecebimento">Data de Recebimento</label>
                </div>
                <div class="input-field col s2">
                    <input id="datalimite" type="text" class="validate" name="dataLimite">
                    <label for="datalimite">Data Limite</label>
                </div>
        </div>
        <div class="row">
            <div class="input-field col s9">
                <input id="assunto" type="text" class="validate" name="assunto">
                <label for="assunto">Sobre a manifestação</label>
            </div>
            <div class="input-field col s3">
                <select name="situacao">
                    <option value="" disabled selected>Selecione a situação</option>
                    <option value="1">Cadastrada</option>
                    <option value="2">Complementação Solicitada</option>
                    <option value="3">Complementada</option>
                    <option value="4">Encaminhada por Outra Ouvidoria</option>
                    <option value="5">Prorrogada</option>
                    <option value="6">Arquivada</option>
                    <option value="7">Concluída</option>
                    <option value="8">Encaminhada para Orgão Externo - Encerrada</option>
                </select>
                <label>Situação da Manifestação</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s4">
                <input id="unidadeEnvolvida" type="text" class="validate" name="unidadeEnvolvida">
                <label for="unidadeEnvolvida">Unidade Envolvida</label>
            </div>
            <div class="input-field col s4">
            <select name="proveniencia">
                    <option value="" disabled selected>Selecione a proveniência</option>
                    <?php
                        $sql = Helper::genListaProveniencia($db_conn);
                        while($row = $sql->fetch_array())
                        {
                            echo("<option value=\"".$row['id']."\">".$row['nomeProveniencia']."</option>");
                        }
                    ?>
                </select>
                <label>Proveniência</label>
            </div>
            <div class="input-field col s4">
                <select name="topicoManifestacao">
                    <option value="" disabled selected>Selecione o assunto</option>
                    <?php
                        $sql = Helper::genListaAssuntos($db_conn);
                        while($row = $sql->fetch_array())
                        {
                            echo("<option value=\"".$row['id']."\">".$row['nomeAssunto']."</option>");
                        }
                    ?>
                </select>
                <label>Assunto</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="nomeDemandante" type="text" class="validate" name="nomeDemandante">
                <label for="nomeDemandante">Nome demandante</label>
            </div>
            <div class="input-field col s6">
                <input id="email" type="email" class="validate" name="emailDemandante">
                <label for="email">E-mail</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
            <textarea id="infoextra" class="materialize-textarea" name="infoExtra"></textarea>
            <label for="infoextra">Informações adicionais</label>
            </div>
        </div>
        <div class="row">
            <div class="col s12 right-align">
            <a class="blue darken-4 waves-effect waves-light btn-large hoverable"><i class="material-icons left">send</i>Adicionar</a>
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
        postForm("scripts/add_manifestacao.php", "formManifestacao");
    });

  });
  </script>