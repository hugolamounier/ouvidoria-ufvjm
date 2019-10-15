<?php 
    class User{
        
        protected $login="";
        protected $password="";
        protected $email = "";
        protected $nome = "";
        protected $autoridade = "";
        protected $db_conn="";
        protected $ativo="";

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
                $this->ativo = $row["ativo"];
            }else{
                $this->password="";
                $this->email="";
                $this->autoridade="";
                $this->nome="";
                $this->ativo = "";
            }
            
        }

        public function addUser()
        {
            if(empty($this->login) || empty($this->password) || empty($this->nome) || empty($this->autoridade) || empty($this->email))
            {
                return false;
            }
            if(!self::existeUsuario($this->login, $this->db_conn))
            {
                $sql = $this->db_conn->prepare("insert into usuario(login, senha, nome, email, autoridade, ativo) values (?,?,?,?,?, 1)");
                $sql->bind_param("ssssi", $this->login, $this->password, $this->nome, $this->email, $this->autoridade);
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
        public function editarUser()
        {
            if(self::existeUsuario($this->login, $this->db_conn))
            {
                $sql = $this->db_conn->prepare("update usuario set senha=?, email=?, autoridade=? where login=?");
                $sql->bind_param("ssis", $this->password, $this->email, $this->autoridade, $this->login);
                $sql->execute();
                if($sql)
                {
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }
        public function desativarUsuario()
        {
            if(self::existeUsuario($this->login, $this->db_conn))
            {
                $ativo = 0;
                $sql = $this->db_conn->prepare("update usuario set ativo=? where login=?");
                $sql->bind_param('is', $ativo, $this->login);
                $sql->execute();
                if($sql)
                {
                    return true;
                }else{
                    return false;
                }
            }else{
                throw new Exception("Impossível desativar um usuário inexistente.");
                return false;
            }
        }
        public function ativarUsuario()
        {
            if(self::existeUsuario($this->login, $this->db_conn))
            {
                $ativo = 1;
                $sql = $this->db_conn->prepare("update usuario set ativo=? where login=?");
                $sql->bind_param('is', $ativo, $this->login);
                $sql->execute();
                if($sql)
                {
                    return true;
                }else{
                    return false;
                }
            }else{
                throw new Exception("Impossível ativar um usuário inexistente.");
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

        public static function getUserAutoridade($login, $db_conn)
        {
            if(self::existeUsuario($login, $db_conn))
            {
                $sql = $db_conn->prepare("select autoridade from usuario where login=?");
                $sql->bind_param('s', $login);
                $sql->execute();

                $sql = $sql->get_result();
                if($sql->num_rows > 0)
                {
                    $row = $sql->fetch_assoc();
                    return $row["autoridade"];
                }else{
                    return false;
                }
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

        /**
         * Get the value of ativo
         */ 
        public function getAtivo()
        {
                return $this->ativo;
        }

        /**
         * Set the value of ativo
         *
         * @return  self
         */ 
        public function setAtivo($ativo)
        {
                $this->ativo = $ativo;

                return $this;
        }
    }
?>