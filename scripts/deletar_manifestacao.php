<?php
require("../config/config_scripts.php");

if (isset($_GET['id'])) {	
	$id = $_GET['id'];

	if (empty($id)) {
		die("Campo vazio");
	}else{
		if (Manifestacoes::deletarManifestacao($id, $db_conn)) {
			echo "ok";
		}else{
			die("Erro ao entrar no Helper");
		}
	}
}
?>