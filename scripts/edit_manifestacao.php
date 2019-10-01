<?php

require("../config/config_scripts.php");

	$id = $_GET['id'];

if (empty($id)) {
	echo "ERROR";
}else{
	if (Manifestacoes::editarManifestacao($id, $db_conn)) {
		echo "ok";
	}else{
		echo "error";
	}
}

?>