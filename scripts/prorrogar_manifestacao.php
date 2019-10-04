<?php
require("../config/config_scripts.php");
if(isset($_GET["idManifestacao"]))
{
    $idManifestacao = $_GET['idManifestacao'];
    $justificative = $_POST["justificativa"];

    if(Manifestacoes::prorrogarManifestacao($idManifestacao, $justificative, $_SESSION["logged_user"], $db_conn))
    {
        die("ok");
        
    }else{
        die("Erro ao prorrogar a manifestação.\nSe uma prorrogação já tiver sido lançada, não é possível lançar uma nova prorrogação.");
    }
    
}else{
    die("Id da manifestação não informado.");
}
?>