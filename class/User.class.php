<?php 
    class User{
        
        protected $user="";
        protected $password="";
        protected $db_conn="";

        public function __construct($user, $password, $db_conn)
        {
            $this->user = $user;
            $this->password = $password;
            $this->db_conn = $db_conn;
        }

        public static function addUser($login, $senha, $email, $autoridade, $db_conn)
        {
            if(empty($login) || empty($senha) || empty($autoridade) || empty($email))
            {
                return false;
            }

            $sql = $db_conn->prepare("select * from usuario where login=? or email=?");
            $sql->bind_param("ss", $login, $email);
            $sql->execute();
            $sql = $sql->get_result();

            if($sql->num_rows > 0)
            {
                return false;
            }else{
                $sql2 = $db_conn->prepare("insert into usuario(login, senha, email, autoridade) values (?,?,?,?)");
                $sql2->bind_param('sssi', $login, $senha, $email, $autoridade);
                $sql2->execute();

                if($sql2)
                {
                    return true;
                }else{
                    error_log("Erro ao inserir usuário no banco de dados.", 0);
                    return false;
                }
            }
        }
        public function getUserAutoridade()
        {
            $sql = $this->db_conn->prepare("select * from usuario where login=?");
            $sql->bind_param("s", $this->user);
            $sql->execute();

            $sql = $sql->get_result();
            $row = $sql->fetch_array();

            return $row["autoridade"];
        } 

        public function checkAutoridade($auth_level)
        {
            if(getUserAutoridade() >= $auth_level)
            {
                return true;
            }else{
                return false;
            }
        }
    }
?>