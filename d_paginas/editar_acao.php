<?php
require("../config/config_scripts.php");
    if(isset($_GET["id"]))
    {
        $idPendencia = $_GET["id"];
        try{
            $Pendencia = new Pendencias($idPendencia, $db_conn);
        }catch(Exception $e){
            die("Id da ação inexistente.");
        }

    }else{
        die("Contexto da ação não especificado.");
    }
?>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type='text/javascript' src='../js/jquery.inputmask.min.js'></script>
<script type='text/javascript' src='../js/main.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<div class='row'>
    <form id="add_acao" name="add_acao" class="col s12">
        <div class="row">
            <div class="input-field col s3">
                <input disabled value="<?php echo $Pendencia->getIdPendencia() ?>" id="idPendencia" type="text" class="validate">
                <label for="idPendencia">Cód. Pendência</label>
            </div>
            <div class="input-field col s5">
                <select name="tipoPendencia">
                    <option value="" disabled>Selecione o tipo</option>
                    <option value="1" <?php if($Pendencia->getTipoPendenciaId() == 1){ echo "selected";} ?>>Requerimento Inicial</option>
                    <option value="2" <?php if($Pendencia->getTipoPendenciaId() == 2){ echo "selected";} ?>>Resposta Inicial</option>
                    <option value="3" <?php if($Pendencia->getTipoPendenciaId() == 3){ echo "selected";} ?>>Encaminhamento</option>
                    <option value="4" <?php if($Pendencia->getTipoPendenciaId() == 4){ echo "selected";} ?>>Resposta Ouvidoria</option>
                    <option value="5" <?php if($Pendencia->getTipoPendenciaId() == 5){ echo "selected";} ?>>Resposta Demandado</option>
                    <option value="6" <?php if($Pendencia->getTipoPendenciaId() == 6){ echo "selected";} ?>>Resposta Demandante</option>
                    <option value="7" <?php if($Pendencia->getTipoPendenciaId() == 7){ echo "selected";} ?>>Solicitação de Informação Complementar</option>
                    <option value="8" <?php if($Pendencia->getTipoPendenciaId() == 8){ echo "selected";} ?>>Posicionamento Final</option>
                    <option value="9" <?php if($Pendencia->getTipoPendenciaId() == 9){ echo "selected";} ?>>Requerimento Prorrogado</option>
                </select>
                <label>Tipo da Ação</label>
            </div>
            <div class="input-field col s4">
                <input id="dataPendencia" value="<?php echo date("d/m/Y", strtotime($Pendencia->getDataPendencia())); ?>" type="text" class="validate" name="dataPendencia">
                <label for="dataPendencia">Data da Ação</label>
            </div>
        </div>

        <!-- Visível somente quando a ação for encaminhamento -->
        <?php
            $sql = $db_conn->prepare("select * from partes_envolvidas where idPendencia=?");
            $sql->bind_param('i', $idPendencia);
            $sql->execute();

            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                $row = $sql->fetch_assoc();
                $encaminhadoPara = $row["encaminhadoPara"];
                $dataEncaminhamento = $row["dataEncaminhamento"];
                $dataLimitePosicionamento = $row["dataLimitePosicionamento"];
            }else{
                $encaminhadoPara = "";
                $dataEncaminhamento = "0000-00-00";
                $dataLimitePosicionamento = "0000-00-00";
            }
        ?>
        <div id="parteEnvolvidaWrapper" class="row">
            <p style="padding:0;margin:0 0 5px 0; font-size:13px;">Partes envolvidas</p>
            <div class="input-field col s4">
                <input id="encaminhadoPara" type="text" class="validate" value="<?php echo $encaminhadoPara ?>" name="encaminhadoPara">
                <label for="encaminhadoPara">Encaminhamento para</label>
            </div>
            <div class='input-field col s4'>
                <input id="dataEncaminhamento" value="<?php echo date("d/m/Y", strtotime($dataEncaminhamento)); ?>" type="text" class="validate" name="dataEncaminhamento">
                <label for="dataEncaminhamento">Data do Encaminhamento</label>
            </div>
            <div class='input-field col s4'>
                <input id="dataLimitePosicionamento" type="text" class="validate" value="<?php if($dataLimitePosicionamento == null){echo("");}else{echo date("d/m/Y", strtotime($dataLimitePosicionamento));} ?>" name="dataLimitePosicionamento">
                <label for="dataLimitePosicionamento">Data Limite para Posicionamento</label>
            </div>
        </div>
        <!-- fim -->

        <div class="row">
            <div class="input-field col s12">
                <textarea id="descricaoPendencia" class="materialize-textarea" name="descricaoPendencia"><?php echo $Pendencia->getDescricaoPendencia() ?></textarea>
                <label for="descricaoPendencia">Descrição da Ação</label>
            </div>
        </div>
        <p><small>*Enviar um novo arquivo irá substituir o anexo atual.</small> </p>
        <div class='row'>
            <div class="file-field input-field">
                <div class="btn light-blue darken-4"> 
                    <span>Anexo</span>
                    <input type="file" name="anexo">
                </div>
                <div class="file-path-wrapper">
                    <input placeholder="Selecione o arquivo" class="file-path validate" type="text">
                </div>
            </div>
        </div>
        <div class="row">
            <div id="submitBtn" class="col s12 right-align"><a class="blue darken-4 waves-effect waves-light btn-large hoverable"><i class="material-icons left">send</i>Editar</a></div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function(){
        setTimeout(function(){
            $('select').formSelect();
            $('#dataPendencia').inputmask("99/99/9999");
            $('#dataEncaminhamento').inputmask("99/99/9999");
            $('#dataLimitePosicionamento').inputmask("99/99/9999");
            $("#parteEnvolvidaWrapper").css('display', 'none');

            if($("select[name='tipoPendencia']").children("option:selected").val() == 3)
            {
                $("#parteEnvolvidaWrapper").fadeIn(150);
            }else{
                $("#parteEnvolvidaWrapper").fadeOut(150);
            }
        }, 50);
        
        $("select[name='tipoPendencia']").on("change", function(){
            if($(this).val() == 3)
            {
                $("#parteEnvolvidaWrapper").fadeIn(150);
            }else{
                $("#parteEnvolvidaWrapper").fadeOut(150);
            }
        });
        
        $("#add_acao").submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            var id = <?php echo $idPendencia ?>;
            $.ajax({
                url: "scripts/editar_acao.php?idPendencia="+id,
                type: 'POST',
                data: formData,
                async: false,
                success: function(data)
                    {
                        if(data == "ok")
                        {
                            alert("Ocorrências editada.");
                            location.reload();
                        }else{
                            alert(data);
                        }
                    },
                cache: false,
                contentType: false,
                processData: false 
            });
        });
        $("#submitBtn a").on("click", function(){
            $("#add_acao").submit();
        });
    });
</script>