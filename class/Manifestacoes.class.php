<?php
class Manifestacoes{

    protected $idManifestacao="";
    protected $nup="";
    protected $tipoManifestacao="";
    protected $dataRecebimento="";
    protected $assunto="";
    protected $situacao="";
    protected $dataLimite="";
    protected $nomeDemandante="";
    protected $unidadeEnvolvida="";
    protected $emailDemandante="";
    protected $usuario="";
    protected $infoExtra="";
    protected $proveniencia="";
    protected $topicoManifestacao="";


    public function __construct($idManifestacao, $db_conn)
    {
        $this->idManifestacao=$idManifestacao;
        $sql = $db_conn->prepare("select * from manifestacao where idManifestacao = ?");
        $sql->bind_param("i", $this->idManifestacao);
        $sql->execute();

        $sql = $sql->get_result();
        if($sql->num_rows > 0)
        {
            $row = $sql->fetch_array();
            $this->nup = $row["nup"];
            $this->tipoManifestacao = $row["tipoManifestacao"];
            $this->dataRecebimento = $row["dataRecebimento"];
            $this->assunto = $row["assunto"];
            $this->situacao = $row["situacao"];
            $this->dataLimite = $row["dataLimite"];
            $this->nomeDemandante = $row["nomeDemandante"];
            $this->unidadeEnvolvida = $row["unidadeEnvolvida"];
            $this->emailDemandante = $row["emailDemandante"];
            $this->usuario = $row["usuario"];
            $this->infoExtra = $row["infoExtra"];
            $this->proveniencia = $row["proveniencia"];
            $this->topicoManifestacao = $row["topicoManifestacao"];
        }
    }

    public static function getStatusName($status)
    {
        switch($status)
        {
            case 1:
                return "Cadastrada";
            break;
            case 2:
                return "Complementação Solicitada";
            break;
            case 3:
                return "Complementada";
            break;
            case 4:
                return "Encaminhada por Outra Ouvidoria";
            break;
            case 5:
                return "Prorrogada";
            break;
            case 6:
                return "Arquivada";
            break;
            case 7:
                return "Concluída";
            break;
            case 8:
                return "Encaminhada para Orgão Externo - Encerrada";
            break;
        }
    }

    public static function getProvenienciaNome($id, $db_conn)
    {
        $sql = $db_conn->prepare("select * from proveniencia where id = ?");
        $sql->bind_param('i', $id);
        $sql->execute();
        if($sql)
        {
            $sql = $sql->get_result();
            $row = $sql->fetch_array();

            return $row["nomeProveniencia"];
        }
    }
    public static function getAssuntoNome($id, $db_conn)
    {
        $sql = $db_conn->prepare("select * from assuntos where id = ?");
        $sql->bind_param('i', $id);
        $sql->execute();
        if($sql)
        {
            $sql = $sql->get_result();
            $row = $sql->fetch_array();

            return $row["nomeAssunto"];
        }
    }

    public static function getCorManifestacao($tipoManifestacao)
    {
        switch($tipoManifestacao)
        {
            case 1:
                return "red-text text-darken-1";
            break;
            case 2:
                return "orange-text text-darken-2";
            break;
            case 3:
                return "green-text text-darken-1";
            break;
            case 4:
                return "yellow-text text-darken-3";
            break;
            case 5:
                return "pink-text text-accent-2";
            break;
        }
    }
    public static function getCorManifestacaoClass($tipoManifestacao)
    {
        switch($tipoManifestacao)
        {
            case 1:
                return "denunciaTag";
            break;
            case 2:
                return "reclamacaoTag";
            break;
            case 3:
                return "solicitacaoTag";
            break;
            case 4:
                return "sugestaoTag";
            break;
            case 5:
                return "elogioTag";
            break;
        }
    }

    public static function listarManifestacoes($tipoManifestacao, $sort, $db_conn)
    {

        if($tipoManifestacao == '' or null)
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
            $sql = $db_conn->prepare("select * from manifestacao where tipoManifestacao = ? order by idManifestacao DESC");
            $sql->bind_param("i", $tipoManifestacao);
            $sql->execute();

            $sql = $sql->get_result();

            return $sql;
        }
    }
    public static function getManifestacaoTypeName($intCode, $db_conn)
    {
        $sql = $db_conn->prepare("select nome from tipo_manifestacao where id = ? limit 1");
        $sql->bind_param("i", $intCode);
        $sql->execute();
        $sql = $sql->get_result();
        if($sql->num_rows > 0)
        {
            $row = $sql->fetch_array();
            return $row[0];
        }else{
            die("Tipo inexistente.");
        }
    }
    public static function novaManifestacao($nup, $tipoManifestacao, $dataRecebimento, $assunto, $situacao, $dataLimite, $nomeDemandante, $unidadeEnvolvida, $emailDemandante, $usuario, $infoExtra, $proveniencia, $topicoManifestacao, $db_conn)
    {
        if($nup != '' or NULL)
        {
            $sql_1 = $db_conn->prepare("SELECT nup FROM manifestacao WHERE nup = ?");
            $sql_1->bind_param("s" , $nup);
            $sql_1->execute();
            $sql_1 = $sql_1->get_result();
            if ($sql_1->num_rows > 0) { //Caso ja exista um nup com o msm numero do nup digitado
                die("NUP já existente");
            }   
        }
        //Insere os dados fornecidos
        $sql =  $db_conn->prepare("INSERT INTO manifestacao (nup , tipoManifestacao , dataRecebimento , assunto , situacao, dataLimite, nomeDemandante, unidadeEnvolvida, emailDemandante, usuario, infoExtra, proveniencia, topicoManifestacao)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");

        //Evita o sql injection
        $sql->bind_param("sississsssssi" , $nup, $tipoManifestacao, $dataRecebimento, $assunto, $situacao, $dataLimite, $nomeDemandante, $unidadeEnvolvida, $emailDemandante, $usuario, $infoExtra, $proveniencia, $topicoManifestacao);
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

    public static function pesquisarManifestacao ($pesquisa, $db_conn){

        $p = "%$pesquisa%";
        $sql =  $db_conn->prepare("SELECT * FROM manifestacao WHERE nup = ? OR idManifestacao = ?");
        $sql->bind_param("si" , $pesquisa, $pesquisa);
        $sql->execute();
        $sql = $sql->get_result();

        if ($sql->num_rows >0) {
            return $sql;
        }else{ //Caso não ache pelo nup
            $sql_1 = $db_conn->prepare("SELECT * FROM manifestacao WHERE  assunto LIKE ? OR nomeDemandante LIKE ?
                    OR unidadeEnvolvida LIKE ? OR emailDemandante LIKE ? OR usuario LIKE ? OR infoExtra LIKE ? OR proveniencia LIKE ?");
            $sql_1->bind_param("sssssss" , $p,$p,$p,$p,$p,$p,$p);
            $sql_1->execute();
            $sql_1 = $sql_1->get_result();

            if ($sql_1->num_rows >0) { //Caso ache algo
               return $sql_1;
            }else{
                return false;
            }

        }
    }

    /**
     * Get the value of proveniencia
     */ 
    public function getProveniencia()
    {
        return $this->proveniencia;
    }

    /**
     * Get the value of infoExtra
     */ 
    public function getInfoExtra()
    {
        return $this->infoExtra;
    }

    /**
     * Get the value of usuario
     */ 
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Get the value of emailDemandante
     */ 
    public function getEmailDemandante()
    {
        return $this->emailDemandante;
    }

    /**
     * Get the value of unidadeEnvolvida
     */ 
    public function getUnidadeEnvolvida()
    {
        return $this->unidadeEnvolvida;
    }

    /**
     * Get the value of nomeDemandante
     */ 
    public function getNomeDemandante()
    {
        return $this->nomeDemandante;
    }

    /**
     * Get the value of dataLimite
     */ 
    public function getDataLimite()
    {
        return $this->dataLimite;
    }

    /**
     * Get the value of situacao
     */ 
    public function getSituacao()
    {
        return $this->situacao;
    }

    /**
     * Get the value of assunto
     */ 
    public function getAssunto()
    {
        return $this->assunto;
    }

    /**
     * Get the value of dataRecebimento
     */ 
    public function getDataRecebimento()
    {
        return $this->dataRecebimento;
    }

    /**
     * Get the value of tipoManifestacao
     */ 
    public function getTipoManifestacao()
    {
        return $this->tipoManifestacao;
    }

    /**
     * Get the value of nup
     */ 
    public function getNup()
    {
        return $this->nup;
    }

    /**
     * Get the value of idManifestacao
     */ 
    public function getIdManifestacao()
    {
        return $this->idManifestacao;
    }

    /**
     * Get the value of topicoManifestacao
     */ 
    public function getTopicoManifestacao()
    {
        return $this->topicoManifestacao;
    }
}
?>