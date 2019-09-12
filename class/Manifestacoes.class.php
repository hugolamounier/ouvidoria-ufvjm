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

}
?>