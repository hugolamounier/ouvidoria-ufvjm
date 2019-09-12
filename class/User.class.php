<?php 
    class User{
        
        protected $user="";
        protected $password="";
        protected $db_connection="";

        public function __construct($user, $password, $db_connection)
        {
            $this->user = $user;
            $this->password = $password;
            $this->db_connection = $db_connection;
        }
    }
?>