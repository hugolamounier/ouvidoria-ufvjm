<?php
class Helper{

    public static function mysqlConnect($db_server, $db_username, $db_password, $db_name)
    {
        $connection = new MySQLi($db_server, $db_username, $db_password, $db_name);
        if ($connection->connect_error) {
            die("Erro ao conectar ao banco de dados.");
            }else{
                return $connection;
        }
    }
    public static function converterDataToMysqlData($date)
    {
        return substr($date, 6, 4)."-".substr($date, 3, 2)."-".substr($date, 0, 2);
    }
    public static function converterMysqlDataToData($mysqlDate)
    {
        return substr($mysqlDate, 8, 2)."/".substr($mysqlDate, 5, 2)."/".substr($mysqlDate, 0, 4);
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
        $erros = array(); //Array de erros 

        //Tratamentos se os campos estiverem vazios
        if (empty($tipoManifestacao)) {
            $erros[] = "<li>Existem campos que não podem ser vazios (tipoManifestacao)</li>";
    
        }elseif (empty($dataRecebimento)) {
            $erros[] = "<li>Existem campos que não podem ser vazios (dataRecebimento)</li>";
    
        }elseif (empty($assunto)) {
            $erros[] = "<li>Existem campos que não podem ser vazios(assunto)</li>";
    
        }elseif (empty($situacao)) {
            $erros[] = "<li>Existem campos que não podem ser vazios(situacao)</li>";
    
        }elseif (empty($dataLimite)) {
            $erros[] = "<li>Existem campos que não podem ser vazio (dataLimite)</li>";
    
        }elseif (empty($nomeDemandante)) {
            $erros[] = "<li>Existem campos que não podem ser vazios(Nome demandante)</li>";
    
        }elseif (empty($unidadeEnvolvida)) {
            $erros[] = "<li>Existem campos que não podem ser vazios (unidadeEnvolvida)</li>";

        }elseif (empty($emailDemandante)) {
            $erros[] = "<li>Existem campos que não podem ser vazios (emailDemandante)</li>";
    
        }elseif (empty($usuario)) {
            $erros[] = "<li>Existem campos que não podem ser vazios (usuario)</li>";
    
        }elseif (empty($proveniencia)) {
            $erros[] = "<li>Existem campos que não podem ser vazios (proveniencia)</li>";
    
        }else{ 
            if (Helper::novaManifestacao($nup,$tipoManifestacao, $dataRecebimento, $assunto, $situacao, $dataLimite, $nomeDemandante, $unidadeEnvolvida, $emailDemandante, $usuario, $infoExtra, $proveniencia, $db_conn) ){
                //Manda os valores digitados para o Helper
                echo("ok");
            }else{
                echo("Dados não foram enviados");
            }

        }
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
    public static function genListaProveniencia($db_conn)
    {
        $sql = $db_conn->prepare("select * from proveniencia");
        $sql->execute();
        
        if($sql)
        {
            $sql = $sql->get_result();
            return $sql;
        }else{
            return false;
        }
    }
    public static function genListaAssuntos($db_conn)
    {
        $sql = $db_conn->prepare("select * from assuntos");
        $sql->execute();
        if($sql)
        {
            $sql = $sql->get_result();
            return $sql;
        }else{
            return false;
        }
    }
}
?>