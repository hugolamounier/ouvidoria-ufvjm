<?php 
    class User{
        
        protected $login="";
        protected $password="";
        protected $email = "";
        protected $nome = "";
        protected $autoridade = "";
        protected $db_conn="";

        public function __construct($login, $db_conn)
        {
            $this->login = $login;
            $this->db_conn = $db_conn;
            $sql = $db_conn->prepare("select * from usuario where login=? limit 1");
            $sql->bind_param('s', $login);
            $sql->execute();
            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                $row = $sql->fetch_assoc();
                $this->password = $row["senha"];
                $this->email = $row["email"];
                $this->nome = $row["nome"];
                $this->autoridade = $row["autoridade"];
            }else{
                $this->password="";
                $this->email="";
                $this->autoridade="";
                $this->nome="";
            }
            
        }

        public function addUser()
        {
            if(empty($login) || empty($senha) || empty($nome) || empty($autoridade) || empty($email))
            {
                return false;
            }
            if(!self::existeUsuario($this->login, $this->db_conn))
            {
                $sql = $this->db_conn->prepare("insert into usuario(login, senha, nome, email, autoridade) values (?,?,?,?,?)");
                $sql->bind_param("ssssi", $login, $senha, $nome, $email, $autoridade);
                $sql->execute();
                if($sql)
                {
                    return true;
                }else{
                    throw new Exception("Não foi possível adicionar o usuário, tente novamente.");
                    return false;
                }
            }else{
                throw new Exception("Usuário já existente.");
                return false;
            }
        }
        public static function existeUsuario($login, $db_conn)
        {
            $sql = $db_conn->prepare("select * from usuario where login=?");
            $sql->bind_param('s', $login);
            $sql->execute();

            $sql = $sql->get_result();
            if($sql->num_rows > 0)
            {
                return true;
            }else{
                return false;
            }
        }
        public function checkAutoridade($auth_level)
        {
            if($this->getAutoridade() >= $auth_level)
            {
                return true;
            }else{
                return false;
            }
        }

        /**
         * Get the value of login
         */ 
        public function getLogin()
        {
                return $this->login;
        }

        /**
         * Get the value of password
         */ 
        public function getPassword()
        {
                return $this->password;
        }

        /**
         * Set the value of password
         *
         * @return  self
         */ 
        public function setPassword($password)
        {
                $this->password = $password;

                return $this;
        }

        /**
         * Get the value of email
         */ 
        public function getEmail()
        {
                return $this->email;
        }

        /**
         * Set the value of email
         *
         * @return  self
         */ 
        public function setEmail($email)
        {
                $this->email = $email;

                return $this;
        }

        /**
         * Get the value of nome
         */ 
        public function getNome()
        {
                return $this->nome;
        }

        /**
         * Set the value of nome
         *
         * @return  self
         */ 
        public function setNome($nome)
        {
                $this->nome = $nome;

                return $this;
        }

        /**
         * Get the value of autoridade
         */ 
        public function getAutoridade()
        {
                return $this->autoridade;
        }

        /**
         * Set the value of autoridade
         *
         * @return  self
         */ 
        public function setAutoridade($autoridade)
        {
                $this->autoridade = $autoridade;

                return $this;
        }
    }
?>