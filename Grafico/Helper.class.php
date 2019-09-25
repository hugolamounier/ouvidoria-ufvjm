<?php
class Helper {

    public static function mysqlConnect($db_server, $db_username, $db_password, $db_name)
    {
        $connection = new MySQLi($db_server, $db_username, $db_password, $db_name);
        if ($connection->connect_error) {
            die("Erro ao conectar ao banco de dados.");
            }else{
                return $connection;
        }
    }
    public static function isLogged($db_conn)
    {
        if(!isset($_SESSION['logged_user']) || !isset($_SESSION['logged_password']))
        {
            return false;
        }
        $db = $db_conn;
        $sql = $db->prepare("SELECT * FROM usuario WHERE login = ? AND senha = ?");
        $sql->bind_param('ss', $_SESSION['logged_user'], $_SESSION['logged_password']);
        $sql->execute();
        $sql = $sql->get_result();
        $row = $sql->fetch_array();
        $hash = $_SERVER['HTTP_USER_AGENT'];
        $hash .= "$#@$#^@#!di91ue1he3413E!#RGVswd14@";
        $fingerprint = sha1(md5($hash));
        
        if($sql->num_rows > 0 && $_SESSION['ouvidoria'] == $fingerprint)
        {
            return true;
        }else{
            return false;
        }
    }
    public static function login($user, $password, $db_conn)
        {
            $sql = $db_conn->prepare("select * from usuario WHERE login = ? AND senha = ?");
            $sql->bind_param("ss", $user, $password);
            $sql->execute();        
            $sql = $sql->get_result();

            if ($sql->num_rows > 0) {
                $row = $sql->fetch_array();
                $_SESSION["logged_user"] = $row["login"];
                $_SESSION["logged_password"] = $row["senha"];
                $hash = $_SERVER['HTTP_USER_AGENT'];
                $hash .= "$#@$#^@#!di91ue1he3413E!#RGVswd14@";
                $fingerprint = sha1(md5($hash));
                $_SESSION['ouvidoria'] = $fingerprint;
                return true;
            }else{
                return false;
            }
        }

  public static function novaManifestacao($nup,$tipoManifestacao, $dataRecebimento, $assunto, $situacao, $dataLimite, $nomeDemandante, $unidadeEnvolvida, $emailDemandante, $usuario, $infoExtra, $proveniencia, $db_conn)
    {

        $sql_1 = $db_conn->prepare("SELECT nup FROM manifestacao WHERE nup = ?");
        $sql_1->bind_param("s" , $nup); 
        $sql_1->execute();
        $sql_1 = $sql_1->get_result();
        if ($sql_1->num_rows > 0) { //Caso ja exista um nup com o msm numero do nup digitado
            die("Nup ja existente");
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


    public static function deletar($id, $db_conn){


            $sql = $db_conn->prepare("SELECT nup FROM manifestacao WHERE id = ?");
            $sql ->bind_param("i" , $id);
            $sql->execute();
            $sql = $sql->get_result();
            if ($sql->num_rows >0 ) { //Se achar algum id igual
                $sql_1 = $db_conn->prepare("DELETE FROM manifestacao WHERE id = ?");
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





    public static function pesquisar ($pesquisa, $db_conn){

        $p = "%$pesquisa%";
        $sql =  $db_conn->prepare("SELECT * FROM manifestacao WHERE nup = ?");
        $sql->bind_param("s" , $pesquisa);
        $sql->execute();
        $sql = $sql->get_result();

        if ($sql->num_rows >0) { //Caso ache algo

            while ($dados = $sql->fetch_assoc()) {
            $nup = $dados["nup"];
            $tipoManifestacao = $dados["tipoManifestacao"];
            $dataRecebimento = $dados["dataRecebimento"];
            $assunto = $dados["assunto"];
            $situacao = $dados["situacao"];
            $dataLimite = $dados["dataLimite"];
            $nomeDemandante = $dados["nomeDemandante"];
            $unidadeEnvolvida = $dados["unidadeEnvolvida"];
            $emailDemandante = $dados["emailDemandante"];
            $usuario = $dados["usuario"];
            $infoExtra = $dados["infoExtra"];
            $proveniencia = $dados["proveniencia"];
             }

            echo "$nup"; echo "$tipoManifestacao \n"; echo "$dataRecebimento\n"; echo "$assunto\n"; echo "$situacao\n"; echo "$dataLimite\n"; echo "$nomeDemandante\n"; echo "$unidadeEnvolvida\n"; echo "$emailDemandante\n"; echo "$usuario\n"; echo "$infoExtra\n"; echo "$proveniencia\n";
            return true;

        }else{ //Caso não ache pelo nup 
            $sql_1 = $db_conn->prepare("SELECT * FROM manifestacao WHERE  assunto LIKE ? OR nomeDemandante LIKE ? OR unidadeEnvolvida LIKE ? OR emailDemandante LIKE ? OR usuario LIKE ? OR infoExtra LIKE ? OR proveniencia LIKE ?");
            $sql_1->bind_param("sssssss" , $p,$p,$p,$p,$p,$p,$p);
            $sql_1->execute();
            $sql_1 = $sql_1->get_result();

            if ($sql_1->num_rows >0) { //Caso ache algo
                while ($dados = $sql_1->fetch_assoc()) {
                $nup = $dados["nup"];
                $tipoManifestacao = $dados["tipoManifestacao"];
                $dataRecebimento = $dados["dataRecebimento"];
                $assunto = $dados["assunto"];
                $situacao = $dados["situacao"];
                $dataLimite = $dados["dataLimite"];
                $nomeDemandante = $dados["nomeDemandante"];
                $unidadeEnvolvida = $dados["unidadeEnvolvida"];
                $emailDemandante = $dados["emailDemandante"];
                $usuario = $dados["usuario"];
                $infoExtra = $dados["infoExtra"];
                $proveniencia = $dados["proveniencia"];
                }
                echo "$nup\n"; echo "$tipoManifestacao\n"; echo "$dataRecebimento\n"; echo "$assunto\n"; echo "$situacao\n"; echo "$dataLimite\n"; echo "$nomeDemandante\n"; echo "$unidadeEnvolvida\n"; echo "$emailDemandante\n"; echo "$usuario\n"; echo "$infoExtra\n"; echo "$proveniencia\n";
                return true;
            }else{

                echo "Error";
                return false;
            }

        }

    }
}

?>