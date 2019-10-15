<?php
require("../config/config_scripts.php");
if(isset($_GET["actionId"]))
{
    $act = $_GET['actionId'];
    
    switch($act)
    {
        case "concluirManifestacao":
            if(isset($_GET["idManifestacao"]))
            {
                $idManifestacao = $_GET['idManifestacao'];
                if(Manifestacoes::atualizarSituacao($idManifestacao, 7, $db_conn))
                {
                    die("ok");
                }else{
                    die("Não foi possível atualizar a situação da manifestação.");
                }
            }else{
                die("Id da manifestação não informado.");
            }
        break;
        default:
        die("Ação incorreta.");
        break;
    }
}else{
    die("Ação não especificada.");
}
?>