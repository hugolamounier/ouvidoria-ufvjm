<?php
require("../config/config_scripts.php");
if(isset($_GET['user']))
{
    $user = $_GET['user'];
    $User = new User($user, $db_conn);
}else{
    die("Usuário não especificado.");
}
?>
<script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
<script type='text/javascript' src='../js/main.js'></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<form id="addUser" name="addUser" class="col s12">
    <div class='row'>
        <div class="input-field col s5">
            <input id="login" type="text" class="validate" name="login" value='<?php echo $User->getLogin() ?>' disabled>
            <label for="login">Nome de Usuário</label>
        </div>
        <div class="input-field col s4">
            <input id="senha" type="password" class="validate" name="senha" value='<?php echo $User->getPassword() ?>'>
            <label for="senha">Senha de Acesso</label>
        </div>
        <div class="input-field col s3">
            <select name="autoridade">
                <option value="" disabled>Selecione o tipo de Usuário</option>
                <option value="50" <?php if($User->getAutoridade() == 50){echo "selected";} ?>>Convidado</option>
                <option value="99" <?php if($User->getAutoridade() == 99){echo "selected";} ?>>Usuário Padrão</option>
                <option value="100" <?php if($User->getAutoridade() == 100){echo "selected";} ?>>Administrador</option>
            </select>
            <label>Tipo de Usuário</label>
        </div>
    </div>
    <div class='row'>
        <div class="input-field col s6">
            <input id="nome" type="text" class="validate" name="nome" value='<?php echo $User->getNome() ?>'>
            <label for="nome">Nome do Usuário</label>
        </div>
        <div class="input-field col s6">
            <input id="email" type="text" class="validate" name="email" value='<?php echo $User->getEmail() ?>'>
            <label for="email">E-mail do Usuário</label>
        </div>
    </div>
    <div class="row">
        <div id="submitBtn" class="col s12 right-align"><a class="blue darken-4 waves-effect waves-light btn-large hoverable"><i class="material-icons left">send</i>Editar Usuário</a></div>
    </div>
</form>
<script>
    $(document).ready(function(){
        setTimeout(function(){
            $('select').formSelect();
        }, 50);
        $("#addUser").submit(function(e){
            showLoading();
            e.preventDefault();
            var formData = new FormData(this);
            var user = $("#login").val();
            $.ajax({
                url: "scripts/editar_user.php?user="+user,
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
            $("#addUser").submit();
        });
    });
</script>