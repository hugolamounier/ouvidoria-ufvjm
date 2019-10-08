<?php
    $User = new User($_SESSION["logged_user"], $db_conn);

    if(!$User->checkAutoridade(100))
    {
        die("Você não possui autoridade para acessar essa página.");
    }
?>
<div class="title">
    <a onclick="location.href='?page=dashboard'" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
    <span class="blue-grey-text text-darken-3">Gerenciar Usuários</span>
    <div class="options">
    </div>
</div>
<div class="container">
    <div class='addUser'><a data-tooltip="Prorrogar" class="waves-effect waves-light btn blue-grey lighten-3 hoverable"><i class="material-icons left">add</i>Adicionar Usuário</a></div>
    <div class='row'>
        <div class='col s12'>
            <div class='gerenciar_usuarios'>
                <div class='user'>
                    <div class='row'>
                        <div class='col s3'></div>
                        <div class='col s3'></div>
                        <div class='col s3'></div>
                        <div class='col s3'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>