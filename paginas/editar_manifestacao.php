<?php
    if(isset($_GET["id"]))
    {
        $id = $_GET["id"];
        if(Manifestacoes::existeManifestacao($id, $db_conn))
        {
            $sql = $db_conn->prepare("SELECT * FROM manifestacao WHERE idManifestacao = ?");
            $sql ->bind_param("i" , $id);
            $sql->execute();
            $sql = $sql->get_result();

            if ($sql->num_rows > 0) 
            { //Caso ja exista um nup com o msm numero do nup fornecido
                $dados = $sql->fetch_array();
                $nup = $dados["nup"];
                $tipoManifestacao = $dados["tipoManifestacao"];
                $dataRecebimento = $dados["dataRecebimento"];
                $assunto = $dados["assunto"];
                $situacao = $dados["situacao"];
                $dataLimite = $dados["dataLimite"];
                $nomeDemandante = $dados["nomeDemandante"];
                $unidadeEnvolvida = $dados["unidadeEnvolvida"];
                $emailDemandante = $dados["emailDemandante"];
                $usuario = $dados["usuario"];
                $infoExtra = $dados["infoExtra"];
                $proveniencia = $dados["proveniencia"];
            }
        }else{
            die("O id informado não existe.");
        }
           
    }else{
        die("Id não definido");
    }
?>
<div class="title"><a onclick="location.href='?page=visualizar_manifestacao&id=<?php echo  $id ?>'" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a><span class="blue-grey-text text-darken-e">Editar Manifestação - Id: <?php echo($id); ?></span></div>
<div class="container">
<div class="row">
    <form id="formManifestacao" name="formManifestacao" class="col s12">
        <div class="row">
            <div class="input-field col s4">
                <input id="nup" type="text" class="validate" name="nup" value="<?php echo($nup); ?>">
                <label for="nup">NUP</label>
                </div>
                <div class="input-field col s4">
                    <select name="tipoManifestacao" >
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
                    <input id="datarecebimento" type="text" class="validate" name="dataRecebimento" value="<?php echo(Helper::converterMysqlDataToData($dataRecebimento)) ?>">
                    <label for="datarecebimento">Data de Recebimento</label>
                </div>
                <div class="input-field col s2">
                    <input id="datalimite" type="text" class="validate" name="dataLimite" value="<?php echo(Helper::converterMysqlDataToData($dataLimite)) ?>">
                    <label for="datalimite">Data Limite</label>
                </div>
        </div>
        <div class="row">
            <div class="input-field col s9">
                <input id="assunto" type="text" class="validate" name="assunto" value="<?php echo($assunto) ?>">
                <label for="assunto">Assunto</label>
            </div>
            <div class="input-field col s3">
                <select name="situacao">
                    <option value="" disabled selected>Selecione a situação</option>
                    <option value="1">Cadastrada</option>
                    <option value="2">Complementação Solicitada</option>
                    <option value="3">Complementada</option>
                    <option value="4">Encaminhada por Outro Ouvidoria</option>
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
                <input id="unidadeEnvolvida" type="text" class="validate" name="unidadeEnvolvida" value="<?php echo($unidadeEnvolvida) ?>">
                <label for="unidadeEnvolvida">Unidade Envolvida</label>
            </div>
            <div class="input-field col s8">
                <input id="proveniencia" type="text" class="validate" name="proveniencia" value="<?php echo($proveniencia) ?>">
                <label for="proveniencia">Proveniência</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                <input id="nomeDemandante" type="text" class="validate" name="nomeDemandante" value="<?php echo($nomeDemandante) ?>">
                <label for="nomeDemandante">Nome demandante</label>
            </div>
            <div class="input-field col s6">
                <input id="email" type="email" class="validate" name="emailDemandante" value="<?php echo($emailDemandante) ?>">
                <label for="email">E-mail</label>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
            <textarea id="infoextra" class="materialize-textarea" name="infoExtra">
                <?php echo($infoExtra); ?>
            </textarea>
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
        postForm("scripts/add_manifestacao.php", "formManifestacao");
    });

  });
  </script>