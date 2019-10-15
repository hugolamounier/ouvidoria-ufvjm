<?php
require("../config/config_scripts.php");

if(User::getUserAutoridade($_SESSION["logged_user"], $db_conn) < 100)
{
    die("Você não tem permissão para efetuar esta ação.");
}

if(isset($_GET['user']))
{
    $user = $_GET["user"];
}else{
    die("Usuário não definido.");
}

if(isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['nome']) && isset($_POST['autoridade']))
{
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $nome = $_POST["nome"];
    $autoridade = $_POST["autoridade"];
    $User = new User($user, $db_conn);

    if(!empty($user) && !empty($email) && !empty($senha) && !empty($nome) && !empty($autoridade))
    {
        $User->setEmail($email);
        $User->setPassword($senha);
        $User->setNome($nome);
        $User->setAutoridade($autoridade);
        if($User->editarUser())
        {
            die("ok");
        }else{
            die("Erro ao editar o usuário, tente novamente.");
        }
    }else{
        die("Os campos não podem estar vazios.");
    }


}else{
    die("Todos os campos são obrigatórios.");
}
?>