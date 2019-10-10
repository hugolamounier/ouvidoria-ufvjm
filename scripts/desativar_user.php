<?php
require("../config/config_scripts.php");

if(isset($_GET["user"]))
{
    $user = $_GET["user"];
    if(User::existeUsuario($user, $db_conn))
    {
        $User = new User($user, $db_conn);
        if($User->getAtivo() == 1)
        {
            if($User->desativarUsuario())
            {
                die("ok");
            }else{
                die("Erro ao tentar desativar o usuário, tente novamente.");
            }
        }else{
            die("O usuário selecionado já está desativado.");
        }
    }else{
        die("Usuário inexistente.");
    }
}else{
    die("Usuário não definido.");
}
?>