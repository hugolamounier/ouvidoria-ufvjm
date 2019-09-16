<?php
class Manifestacoes{

    public static function listarManifestacoes($tipoManifestacoes, $sort, $db_conn)
    {
        if($tipoManifestacoes == '' or null)
        {
            if($sort == '' or null)
            {
                $sql = $db_conn->prepare("select * from manifestacao order by idManifestacao DESC");
                $sql->execute();

                $sql = $sql->get_result();
                
                return $sql;
            }else{
                switch($sort)
                {

                }
            }
        }else{

        }
    }
    public static function getManifestacaoName($intCode, $db_conn)
    {
        $sql = $db_conn->prepare("select nome from tipo_manifestacao where id = ? limit 1");
        $sql->bind_param("i", $intCode);
        $sql->execute();
        $sql = $sql->get_result();

        $row = $sql->fetch_array();

        return $row[0];
    }
    public static function novaManifestacao($nup,$tipoManifestacao, $dataRecebimento, $assunto, $situacao, $dataLimite, $nomeDemandante, $unidadeEnvolvida, $emailDemandante, $usuario, $infoExtra, $proveniencia, $db_conn)
    {
        $sql_1 = $db_conn->prepare("SELECT nup FROM manifestacao WHERE nup = ?");
        $sql_1->bind_param("s" , $nup); 
        $sql_1->execute();
        $sql_1 = $sql_1->get_result();
        if ($sql_1->num_rows > 0) { //Caso ja exista um nup com o msm numero do nup digitado
            die("NUP já existente");
        }

        //Insere os dados fornecidos
        $sql =  $db_conn->prepare("INSERT INTO manifestacao (nup , tipoManifestacao , dataRecebimento , assunto , situacao, dataLimite, nomeDemandante, unidadeEnvolvida, emailDemandante, usuario, infoExtra, proveniencia) 
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");

        //Evita o sql injection
        $sql->bind_param("sissississss" , $nup, $tipoManifestacao, $dataRecebimento, $assunto, $situacao, $dataLimite, $nomeDemandante, $unidadeEnvolvida, $emailDemandante, $usuario, $infoExtra, $proveniencia);
        $sql->execute();

        if ($sql) {
            return true;
        }else{
            return false;
        }
    }
    public static function existeManifestacao($id, $db_conn)
    {
        $sql = $db_conn->prepare("SELECT * FROM manifestacao WHERE idManifestacao = ?");
        $sql ->bind_param("i" , $id);
        $sql->execute();
        $sql = $sql->get_result();
        if ($sql->num_rows >0 ) { 
            return true;
        }else{
            return false;
        }
    }
    public static function deletarManifestacao($id, $db_conn)
    {
        if (self::existeManifestacao($id, $db_conn)) {
            $sql_1 = $db_conn->prepare("DELETE FROM manifestacao WHERE idManifestacao = ?");
            $sql_1 ->bind_param("i" , $id);
            $sql_1->execute();
            if ($sql_1) {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
?>