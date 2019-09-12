<?php


//Conexão com o Banco de dados INICIO
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "ouvidoria";

$connect = mysqli_connect($servername, $username, $password, $dbName);
//Conexão com o Bando de dados FIM

if (isset($_POST['btn_name'])) {

	$erros = array(); //Array com todos os erros

	$login = mysql_escape_string($connect, $_POST['login']); //Pega o login digitado
	$senha = mysql_escape_string($connect, $_POST['senha']);// Pega a senha digitada

	//Primeiro tratamento SE tanto o login quanto a senha estiverem vazios

	if (empty($login) or empty($senha)) {
		$erros[] = "Os campos login e senha estão vazios";

	}else{

		$sql = "SELECT login FROM usuario WHERE login = '$login'"; // Codigo sql para consulta de login
		$resultado = mysql_query($connect, $sql); // Query

		if (mysql_num_rows($resultado) > 0)  { //Verifica se o numero de linhas na variavel $resultado (consulta) é maior que 0
			
			$sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'"; 
			// Consulta para ver se existe algum usuario e senha correspondente com o digitado

			$resultado = mysql_query($connect, $sql); // Query

			if (mysql_num_rows($resultado)== 1) { //Se o numero de linhas na variavel $resultado (consulta) for exatamente a INSERIDA PELO USUARIO
				$dados = mysql_fetch_array($resultado); //Retorna uma array que corresponde a linha obtida

				$_SESSION['logado']= true; // Altera a sessão 
				header('Location: dashboard.php');


			}
		}
	}
}
