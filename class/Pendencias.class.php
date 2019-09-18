<?php
class Pendencias{


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