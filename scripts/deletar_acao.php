<?php
require("../config/config_scripts.php");

if (isset($_GET['id'])) {	
	$id = $_GET['id'];

	if (empty($id)) {
		die("Campo vazio");
	}else{
		if (Pendencias::deletarPendencia($id, $db_conn)) {
			die("ok");
		}else{
			die("error");
		}
	}
}
?>