<?php
    require("../config/config.php");
    require("../class/Helper.class.php");

    $db_conn = Helper::mysqlConnect($config["database_server"], $config["db_username"], $config["db_password"], $config["db_name"]);
    if (isset($_POST['login'])) {

	$erros = array(); //Array com todos os erros

	$login = $_POST["login"]; //Pega o login digitado
	$senha = $_POST["senha"]; //Pega o senha digitado

	//Primeiro tratamento SE tanto o login quanto a senha estiverem vazios

	if (empty($login) or empty($senha)) {
		echo("Os campos login e senha estão vazios.");
	}else{
        if(Helper::login($login, $senha, $db_conn))
        {
            echo("ok");
        }else{
            echo("Verifique as credênciais informadas.");
        }
	}
}
?>