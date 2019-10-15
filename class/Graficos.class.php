<?php
class Graficos{
    public static function calculardata($date1, $date2, $tipoManifestacao, $db_conn){
        $datasRecebidas = array();

        if (empty($tipoManifestacao)) {
            $sql = $db_conn->prepare("SELECT * FROM Manifestacao WHERE dataRecebimento BETWEEN ? AND ? GROUP BY dataRecebimento");
            $sql->bind_param("ss", $date1, $date2);
            $sql->execute();
            $sql = $sql->get_result();
            if ($sql->num_rows > 0) { //Caso ja exista um nup com o msm numero do nup fornecido
                while ($row = $sql->fetch_array()) {
    
                   $sql_1 = $db_conn->prepare("SELECT COUNT(*) AS num_den FROM Manifestacao WHERE dataRecebimento = ?");
                    $sql_1->bind_param("s", $row["dataRecebimento"]);
                    $sql_1->execute();
                    $sql_1 = $sql_1->get_result();
                    $row_1 = $sql_1->fetch_array();
                    $datasRecebidas[] = array("label" => date("d M Y", strtotime($row['dataRecebimento'])) , "y" => $row_1['num_den'] );
    
                }
            return $datasRecebidas;
            }else{
                die("error");
            }
        }
        //Pegar intervalo de datas
        $sql = $db_conn->prepare("SELECT * FROM Manifestacao WHERE dataRecebimento BETWEEN ? AND ? && tipoManifestacao = ? GROUP BY dataRecebimento");
        $sql->bind_param("ssi", $date1, $date2, $tipoManifestacao);
        $sql->execute();
        $sql = $sql->get_result();
        if ($sql->num_rows > 0) { //Caso ja exista um nup com o msm numero do nup fornecido
            while ($row = $sql->fetch_array()) {
    
                $sql_1 = $db_conn->prepare("SELECT COUNT(*) AS num_den FROM Manifestacao WHERE dataRecebimento = ? && tipoManifestacao = ?");
                $sql_1->bind_param("si", $row["dataRecebimento"],$tipoManifestacao);
                $sql_1->execute();
                $sql_1 = $sql_1->get_result();
                $row_1 = $sql_1->fetch_array();
                $datasRecebidas[] = array("label" => date("d M Y", strtotime($row['dataRecebimento'])) , "y" => $row_1['num_den'] );
    
            }
            return $datasRecebidas;
        }else{
            die("error");
        }
    
    }

    public static function consultarManifestacao($db_conn, $dataInicial, $dataFinal){

        if(empty($dataInicial) || empty($dataFinal))
        {
            $dataPoints = array();
            $sql = $db_conn->prepare("select count(*) as totalManifestacao, tipoManifestacao from manifestacao group by tipoManifestacao");
            $sql->execute();
            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                while($row = $sql->fetch_assoc())
                {
                    $dataPoints[] = array("label" => Manifestacoes::getManifestacaoTypeName($row['tipoManifestacao'], $db_conn), "y" => $row['totalManifestacao'] );
                }
            }
        }else{
            $dataPoints = array();
            $sql = $db_conn->prepare("select count(*) as totalManifestacao, tipoManifestacao from manifestacao where dataRecebimento between ? and ? group by tipoManifestacao");
            $sql->bind_param('ss', $dataInicial, $dataFinal);
            $sql->execute();
            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                while($row = $sql->fetch_assoc())
                {
                    $dataPoints[] = array("label" => Manifestacoes::getManifestacaoTypeName($row['tipoManifestacao'], $db_conn), "y" => $row['totalManifestacao'] );
                }
            }
        }
        return $dataPoints;
    }
    public static function consultarNup($db_conn, $dataInicial, $dataFinal){

        if(empty($dataInicial) || empty($dataFinal))
        {
            $dataPoints = array();
            $sql = $db_conn->prepare("select count(*) as totalForma, formaRecebimento from manifestacao group by formaRecebimento");
            $sql->execute();
            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                while($row = $sql->fetch_assoc())
                {
                    $dataPoints[] = array("label" => Manifestacoes::getNomeFormaRecebimento($row["formaRecebimento"]), "y" => $row['totalForma'] );
                }
            }
        }else{
            $dataPoints = array();
            $sql = $db_conn->prepare("select count(*) as totalForma, formaRecebimento from manifestacao where dataRecebimento between ? and ? group by formaRecebimento");
            $sql->bind_param('ss', $dataInicial, $dataFinal);
            $sql->execute();
            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                while($row = $sql->fetch_assoc())
                {
                    $dataPoints[] = array("label" => Manifestacoes::getNomeFormaRecebimento($row["formaRecebimento"]), "y" => $row['totalForma'] );
                }
            }
        }
        return $dataPoints;
    }
    public static function consultarProveniencia($db_conn, $dataInicial, $dataFinal){

        if(empty($dataInicial) || empty($dataFinal))
        {
            $dataPoints = array();
            $sql = $db_conn->prepare("select count(*) as totalProveniencia, proveniencia from manifestacao group by proveniencia");
            $sql->execute();
            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                while($row = $sql->fetch_assoc())
                {
                    $dataPoints[] = array("label" => Manifestacoes::getProvenienciaNome($row['proveniencia'], $db_conn), "y" => $row['totalProveniencia'] );
                }
            }
            return $dataPoints;
        }else{
            $dataPoints = array();
            $sql = $db_conn->prepare("select count(*) as totalProveniencia, proveniencia from manifestacao where dataRecebimento between ? and ? group by proveniencia");
            $sql->bind_param('ss', $dataInicial, $dataFinal);
            $sql->execute();
            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                while($row = $sql->fetch_assoc())
                {
                    $dataPoints[] = array("label" => Manifestacoes::getProvenienciaNome($row['proveniencia'], $db_conn), "y" => $row['totalProveniencia'] );
                }
            }
            return $dataPoints;
        }
    }
    public static function consultarAssunto($db_conn, $dataInicial, $dataFinal){
        
        if(empty($dataFinal) || empty($dataInicial))
        {
            $dataPoints = array();
            $sql = $db_conn->prepare("select count(*) as totalTopico, topicoManifestacao from manifestacao group by topicoManifestacao");
            $sql->execute();
            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                while($row = $sql->fetch_assoc())
                {
                    $dataPoints[] = array("label" => Helper::getAssuntoById($row['topicoManifestacao'], $db_conn), "y" => $row['totalTopico'] );
                }
            }
            return $dataPoints;
        }else{
            $dataPoints = array();
            $sql = $db_conn->prepare("select count(*) as totalTopico, topicoManifestacao from manifestacao where dataRecebimento between ? and ?
            group by topicoManifestacao");
            $sql->bind_param('ss', $dataInicial, $dataFinal);
            $sql->execute();
            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                while($row = $sql->fetch_assoc())
                {
                    $dataPoints[] = array("label" => Helper::getAssuntoById($row['topicoManifestacao'], $db_conn), "y" => $row['totalTopico'] );
                }
            }
            return $dataPoints;
        }
    }
    public static function consultarSituacao($db_conn, $dataInicial, $dataFinal){

        if(empty($dataFinal) || empty($dataFinal))
        {
            $dataPoints = array(
                array("label"=> "Cadastrado", "y"=> Manifestacoes::totalSituacao(1, '', '', $db_conn)),
                array("label"=> "Complementação Solicitada", "y"=> Manifestacoes::totalSituacao(2, '', '', $db_conn)),
                array("label"=> "Complementado", "y"=> Manifestacoes::totalSituacao(3, '', '', $db_conn)),
                array("label"=> "Encaminhada", "y"=> Manifestacoes::totalSituacao(4, '', '', $db_conn)),
                array("label"=> "Prorrogado", "y"=> Manifestacoes::totalSituacao(5, '', '', $db_conn)),
                array("label"=> "Arquivado", "y"=> Manifestacoes::totalSituacao(6, '', '', $db_conn)),
                array("label"=> "Concluido", "y"=> Manifestacoes::totalSituacao(7, '', '', $db_conn)),
                array("label"=> "Encaminhado para Orgão Externo/Encerrado", "y"=> Manifestacoes::totalSituacao(8, '', '',  $db_conn)),  
            );
        }else{
            $dataPoints = array();
            $sql = $db_conn->prepare("select count(*) as totalSituacao, situacao from manifestacao where dataRecebimento between ? and ? group by situacao");
            $sql->bind_param('ss', $dataInicial, $dataFinal);
            $sql->execute();
            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                while($row = $sql->fetch_assoc())
                {
                    $dataPoints[] = array("label" => Manifestacoes::getStatusName($row['situacao']), "y" => $row['totalSituacao'] );
                }
            }

        }
        return $dataPoints;

    }
    public static function consultaCampus($db_conn, $dataInicial, $dataFinal)
    {
        if(empty($dataInicial) || empty($dataFinal))
        {
            $sql = $db_conn->prepare("select unidadeEnvolvida, count(*) as total from manifestacao group by unidadeEnvolvida");
            $sql->execute();
            $sql = $sql->get_result();
            $dataPoints = array();
            while($row = $sql->fetch_assoc())
            {
                $dataPoints[] = array("label" => $row["unidadeEnvolvida"] , "y" => $row['total'] );
            }
            return $dataPoints;
        }else{
            $sql = $db_conn->prepare("select unidadeEnvolvida, count(*) as total from manifestacao where dataRecebimento between ? and ? group by unidadeEnvolvida");
            $sql->bind_param('ss', $dataInicial, $dataFinal);
            $sql->execute();
            $sql = $sql->get_result();
            $dataPoints = array();
            while($row = $sql->fetch_assoc())
            {
                $dataPoints[] = array("label" => $row["unidadeEnvolvida"] , "y" => $row['total'] );
            }
            return $dataPoints;
        }
    }
    
}
?>