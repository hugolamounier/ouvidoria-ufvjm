<?php
require("../config/config_scripts.php");
if(isset($_GET["id"]))
{
    $idManifestacao = $_GET['id'];
    
}else{
    die("Manifestação não informada.");
}
?>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type='text/javascript' src='../js/jquery.inputmask.min.js'></script>
<script type='text/javascript' src='../js/main.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<form id="prorrogarManifestacao" name="prorrogarManifestacao" class="col s12">
<div class='row'>
    <div class="input-field col s12">
        <textarea id="justificativa" class="materialize-textarea" name="justificativa"></textarea>
        <label for="justificativa">Justificativa da Prorrogação</label>
    </div>
</div>
<div class="row">
    <div id="submitBtn" class="col s12 right-align"><a class="blue darken-4 waves-effect waves-light btn-large hoverable"><i class="material-icons left">send</i>Prorrogar Manifestação</a></div>
</div>
</form>
<script>
    $(document).ready(function(){
        $("#prorrogarManifestacao").submit(function(e){
            showLoading();
            e.preventDefault();
            var formData = new FormData(this);
            var id = <?php echo $idManifestacao ?>;
            $.ajax({
                url: "scripts/prorrogar_manifestacao.php?idManifestacao="+id,
                type: 'POST',
                data: formData,
                async: true,
                success: function(data)
                    {
                        if(data == "ok")
                        {
                            closeLoading();
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
            $("#prorrogarManifestacao").submit();
        });
    });
</script>