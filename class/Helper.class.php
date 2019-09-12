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
}
?>