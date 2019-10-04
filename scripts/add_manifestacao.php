<?php
require("../config/config_scripts.php");

$erros = array(); //Array com todos os erros

	$nup = $_POST['nup']; //Pega o 'nup' do formulario 
	$tipoManifestacao = $_POST['tipoManifestacao'];//Pega o 'tipoManifestacao' do formulario
	$dataRecebimento  = Helper::converterDataToMysqlData($_POST['dataRecebimento']);//Pega a 'dataRecebimento' do formulario
	$assunto = $_POST['assunto'];//Pega o 'assunto' do formulario
	$situacao = $_POST['situacao'];//Pega o 'situacao' do formulario
	$dataLimite = Helper::converterDataToMysqlData($_POST['dataLimite']);//Pega o 'dataLimite' do formulario
	$nomeDemandante = $_POST['nomeDemandante'];//Pega o 'nomeDemandante' do formulario
	$unidadeEnvolvida =  $_POST['unidadeEnvolvida'];//Pega o 'unidadeEnvolvida' do formulario
	$emailDemandante =  $_POST['emailDemandante'];//Pega o 'emailDemandante' do formulario
	$usuario =  $_SESSION["logged_user"];//Pega o 'usuario' do formulario
	$infoExtra =  $_POST['infoExtra'];//Pega o 'infoExtra' do formulario
	$proveniencia =  $_POST['proveniencia'];//Pega o 'proveniencia' do formulario
	$topicoManifestacao = $_POST["topicoManifestacao"]; //Pega o tópico
	$formaRecebimento = $_POST["formaRecebimento"];

	//Tratamentos se os campos estiverem vazios
	if (empty($tipoManifestacao)) {
			die("Existem campos que não podem ser vazios (Tipo da Manifestação)");
	
		}elseif (empty($dataRecebimento)) {
			die("Existem campos que não podem ser vazios (Data Recebimento)");
		
		}elseif (empty($assunto)) {
			die("Existem campos que não podem ser vazios(Sobre a manifestação)");
		
		}elseif (empty($situacao)) {
			die("Existem campos que não podem ser vazios(Situação)");
		}elseif(empty($formaRecebimento)){
			die("Existem campos que não podem ser vazios(Forma de Recebimento)");
		}elseif (empty($dataLimite)) {
			die("Existem campos que não podem ser vazio (Data Limite)");
		
		}elseif (empty($nomeDemandante)) {
			die("Existem campos que não podem ser vazios(Nome demandante)");
		
		}elseif (empty($unidadeEnvolvida)) {
			die("Existem campos que não podem ser vazios (Unidade Envolvida)");
	
		}elseif (empty($emailDemandante)) {
			die("Existem campos que não podem ser vazios (E-mail Demandante)");
		}elseif (empty($proveniencia)) {
			die("Existem campos que não podem ser vazios (Proveniência)");
		}elseif (empty($topicoManifestacao)){
			die("Existem campos que não podem ser vazios (Assunto)");
		}else{
			if($dataLimite == '--')
			{
				$dataLimite = null;
			}
			if (Manifestacoes::novaManifestacao($nup, $tipoManifestacao, $dataRecebimento, $assunto, $situacao, $dataLimite, $nomeDemandante, $unidadeEnvolvida, $emailDemandante, $usuario, $infoExtra, $proveniencia, $topicoManifestacao, $formaRecebimento, $db_conn)) {
				echo "ok";
			}else{
                echo("Dados não enviados ao BD");
			}
		}

?>
