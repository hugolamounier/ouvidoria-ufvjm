<?php
class Pendencias{

    public static function addPendencia($idManifestacao, $tipoPendencia, $descricaoPendencia, $dataPendencia, $usuario, $anexo, $db_conn)
    {
        if(empty($idManifestacao) || empty($tipoPendencia) || empty($dataPendencia) || empty($usuario))
        {
            die("Preencha todos os campos obrigatórios.");
        }

        
    }
    public static function getNomePendencia($codPendencia)
    {
        switch($codPendencia)
        {
            case 1:
                return "Requerimento Inicial";
            break;
            case 2:
                return "Resposta Inicial";
            break;
            case 3:
                return "Encaminhamento";
            break;
            case 4:
                return "Resposta Ouvidoria";
            break;
            case 5:
                return "Resposta Demandado";
            break;
            case 6:
                return "Resposta Demandante";
            break;
            case 7:
                return "Solicitação de Informação Complementar";
            break;
            case 8:
                return "Posicionamento Final";
            break;

        }
    }
}
?>