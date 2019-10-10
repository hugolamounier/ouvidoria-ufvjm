<?php
require("../config/config_scripts.php");

if(isset($_POST['login']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['nome']) && isset($_POST['autoridade']))
{
    $login = $_POST["login"];
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $nome = $_POST["nome"];
    $autoridade = $_POST["autoridade"];

    if(!empty($login) && !empty($email) && !empty($senha) && !empty($nome) && !empty($autoridade))
    {
        $newUser = new User($login, $db_conn);
        $newUser->setEmail($email);
        $newUser->setPassword($senha);
        $newUser->setNome($nome);
        $newUser->setAutoridade($autoridade);
        
        if($newUser->addUser())
        {
            die("ok");
        }else{
            die("Erro ao adicionar o novo usuário, tente novamente.");
        }
    }else{
        die("Os campos não podem estar vazios.");
    }

}else{
    die("Todos os campos são obrigatórios.");
}
?>