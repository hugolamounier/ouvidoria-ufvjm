<?php
    if(isset($_GET["id"]))
    {
        $idManifestacao = $_GET["id"];
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
                <input disabled value="<?php echo $idManifestacao ?>" id="idManifestacao" type="text" class="validate">
                <label for="idManifestacao">Cód. Manifestação</label>
            </div>
            <div class="input-field col s5">
                <select name="tipoPendencia">
                    <option value="" disabled selected>Selecione o tipo</option>
                    <option value="1">Requerimento Inicial</option>
                    <option value="2">Resposta Inicial</option>
                    <option value="3">Encaminhamento</option>
                    <option value="4">Resposta Ouvidoria</option>
                    <option value="5">Resposta Demandado</option>
                    <option value="6">Resposta Demandante</option>
                    <option value="7">Solicitação de Informação Complementar</option>
                    <option value="8">Posicionamento Final</option>
                </select>
                <label>Tipo da Ação</label>
            </div>
            <div class="input-field col s4">
                <input id="dataPendencia" value="<?php echo date("d/m/Y"); ?>" type="text" class="validate" name="dataPendencia">
                <label for="dataPendencia">Data da Ação</label>
            </div>
        </div>

        <!-- Visível somente quando a ação for encaminhamento -->
        <div id="parteEnvolvidaWrapper" class="row">
            <p style="padding:0;margin:0 0 5px 0; font-size:13px;">Partes envolvidas</p>
            <div class="input-field col s4">
                <input id="encaminhadoPara" type="text" class="validate" name="encaminhadoPara">
                <label for="encaminhadoPara">Encaminhamento para</label>
            </div>
            <div class='input-field col s4'>
                <input id="dataEncaminhamento" value="<?php echo date("d/m/Y"); ?>" type="text" class="validate" name="dataEncaminhamento">
                <label for="dataEncaminhamento">Data do Encaminhamento</label>
            </div>
            <div class='input-field col s4'>
                <input id="dataLimitePosicionamento" type="text" class="validate" name="dataLimitePosicionamento">
                <label for="dataLimitePosicionamento">Data Limite para Posicionamento</label>
            </div>
        </div>
        <!-- fim -->

        <div class="row">
            <div class="input-field col s12">
                <textarea id="descricaoPendencia" class="materialize-textarea" name="descricaoPendencia"></textarea>
                <label for="descricaoPendencia">Descrição da Ação</label>
            </div>
        </div>
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
            <div id="submitBtn" class="col s12 right-align"><a class="blue darken-4 waves-effect waves-light btn-large hoverable"><i class="material-icons left">send</i>Adicionar</a></div>
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
            showLoading();
            var formData = new FormData(this);
            var id = <?php echo $idManifestacao ?>;
            $.ajax({
                url: "scripts/add_acao.php?idManifestacao="+id,
                type: 'POST',
                data: formData,
                async: false,
                success: function(data)
                    {
                        if(data == "ok")
                        {
                            alert("Ocorrências adicionada.");
                            location.reload();
                        }else{
                            alert(data);
                            closeLoading();
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