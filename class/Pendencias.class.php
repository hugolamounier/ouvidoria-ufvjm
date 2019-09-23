<?php
class Pendencias{

    public static function addPendencia($idManifestacao, $tipoPendencia, $descricaoPendencia, $dataPendencia, $usuario, $anexo, $db_conn)
    {
        if(empty($idManifestacao) || empty($tipoPendencia) || empty($dataPendencia) || empty($usuario))
        {
            die("Preencha todos os campos obrigatórios.");
        }

        $sql = $db_conn->prepare("insert into pendencias (idManifestacao, tipoPendencia, descricaoPendencia, dataPendencia, usuario, anexo)
        values (?,?,?,?,?,?)");
        $sql->bind_param("iissss", $idManifestacao, $tipoPendencia, $descricaoPendencia, $dataPendencia, $usuario, $anexo);
        $sql->execute();

        if($sql)
        {
            return true;
        }else{
            return false;
        }

        
    }
    public static function addParteEnvolvida($idManifestacao, $encaminhadoPara, $dataEncaminhamento, $dataLimitePosicionamento, $usuario, $db_conn)
    {
        if(Manifestacoes::existeManifestacao($idManifestacao, $db_conn))
        {
            if(empty($idManifestacao) || empty($encaminhadoPara) || empty($dataEncaminhamento) || empty($dataLimitePosicionamento) || empty($usuario))
            {
               return false;
            }
            $sql = $db_conn->prepare("insert into partes_envolvidas (idManifestacao, encaminhadoPara, dataEncaminhamento, dataLimitePosicionamento, usuario)
            values (?, ?, ?, ?, ?)");
            $sql->bind_param('issss', $idManifestacao, $encaminhadoPara, Helper::converterDataToMysqlData($dataEncaminhamento), Helper::converterDataToMysqlData($dataLimitePosicionamento), $usuario);
            $sql->execuite();
            $sql = $sql->get_result();

            if($sql)
            {
                return true;
            }else{
                return false;
            }

        }else{
            die("O código da manifestação não existe.");
        }
    }
    public static function getListaPendencias($idManifestacao, $db_conn)
    {
        $sql = $db_conn->prepare("select * from pendencias where idManifestacao=? order by dataPendencia ASC");
        $sql->bind_param("i", $idManifestacao);
        $sql->execute();
        $sql = $sql->get_result();
        if($sql->num_rows > 0)
        {
            return $sql;
        }else{
            return false;
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