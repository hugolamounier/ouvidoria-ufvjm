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
    protected $formaRecebimento="";


    public function __construct($idManifestacao, $db_conn)
    {
        if(!self::existeManifestacao($idManifestacao, $db_conn))
        {
            throw new Exception("Id da manifestação inexistente.");
        }
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
            $this->formaRecebimento = $row["formaRecebimento"];
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
                return "Encaminhada";
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
    
    public static function totalSituacao($tipo, $db_conn)
    {
        switch($tipo)
        {
        
            case 1:     //Cadastrado
            $sql = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 1");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 2:     //Complementação Solicitada
            $sql = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 2");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 3:  //Complementado
            $sql = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 3");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 4:    //Encaminhado por outra Ouvidoria
            $sql = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 4");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 5:  //Prorrogado
            $sql = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 5");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 6:   //Arquivad 
            $sql = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 6");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 7:  //Concluido
            $sql = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 7");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 8:   //Encaminhado para Orgão externo/encerrado
            $sql = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 8");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            
        }
    }

    public static function totalManifestacoes($tipo, $db_conn)
    {
        switch($tipo)
        {
            case 0:
            $sql = $db_conn->prepare("SELECT * from manifestacao");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 1:
            $sql = $db_conn->prepare("SELECT * from manifestacao where tipoManifestacao = 1");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 2:
            $sql = $db_conn->prepare("SELECT * from manifestacao where tipoManifestacao = 2");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 3:
            $sql = $db_conn->prepare("SELECT * from manifestacao where tipoManifestacao = 3");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 4:
            $sql = $db_conn->prepare("SELECT * from manifestacao where tipoManifestacao = 4");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
            break;
            case 5:
            $sql = $db_conn->prepare("SELECT * from manifestacao where tipoManifestacao = 5");
            $sql ->execute();
            $sql = $sql->get_result();
            return $sql->num_rows;
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

    public static function getCorStatusManifestacao($situacao)
    {
        switch($situacao)
        {
            case 7:
                return "green-text text-accent-4";
            break;
            default:
                return "blue-grey-text";
            break;
        }
    }

    public static function getNomeFormaRecebimento($formaRecebimento)
    {
        switch($formaRecebimento)
        {
            case 1:
                return "E-Ouv";
            break;
            case 2:
                return "E-mail";
            break;
            case 3:
                return "Telefone";
            break;
            case 4:
                return "Outros";
            break;
        }
    }

    public static function listarManifestacoes($tipoManifestacao, $sort, $db_conn)
    {
        if($sort == '' or null)
        {
            if($tipoManifestacao == '' or null)
            {
                $sql = $db_conn->prepare("select * from manifestacao order by idManifestacao DESC");
                $sql->execute();

                $sql = $sql->get_result();

                return $sql;
            }else{
                $sql = $db_conn->prepare("select * from manifestacao where tipoManifestacao = ? order by idManifestacao DESC");
                $sql->bind_param("i", $tipoManifestacao);
                $sql->execute();

                $sql = $sql->get_result();

                return $sql;
            }
        }else{
            if($tipoManifestacao == 0)
            {
                switch($sort)
                {
                    case "datalimiteAsc":
                        $sql = $db_conn->prepare("select * from manifestacao order by dataLimite ASC");
                    break;
                    case "datalimiteDesc":
                        $sql = $db_conn->prepare("select * from manifestacao order by dataLimite DESC");
                    break;
                    case "datarecebimentoAsc":
                        $sql = $db_conn->prepare("select * from manifestacao order by dataRecebimento ASC");
                    break;
                    case "datarecebimentoDesc":
                        $sql = $db_conn->prepare("select * from manifestacao order by dataRecebimento DESC");
                    break;
                }
                $sql->execute();
                $sql = $sql->get_result();

                return $sql;
            }else{
                switch($sort)
                {
                    case "datalimiteAsc":
                        $sql = $db_conn->prepare("select * from manifestacao where tipoManifestacao = ? order by dataLimite ASC");
                        $sql->bind_param("i", $tipoManifestacao);
                    break;
                    case "datalimiteDesc":
                        $sql = $db_conn->prepare("select * from manifestacao where tipoManifestacao = ? order by dataLimite DESC");
                        $sql->bind_param("i", $tipoManifestacao);
                    break;
                    case "datarecebimentoAsc":
                        $sql = $db_conn->prepare("select * from manifestacao where tipoManifestacao = ? order by dataRecebimento ASC");
                        $sql->bind_param("i", $tipoManifestacao);
                    break;
                    case "datarecebimentoDesc":
                        $sql = $db_conn->prepare("select * from manifestacao where tipoManifestacao = ? order by dataRecebimento DESC");
                        $sql->bind_param("i", $tipoManifestacao);
                    break;
                }
                $sql->execute();
                $sql = $sql->get_result();

                return $sql;
            }
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
    public static function novaManifestacao($nup, $tipoManifestacao, $dataRecebimento, $assunto, $situacao, $dataLimite, $nomeDemandante, $unidadeEnvolvida, $emailDemandante, $usuario, $infoExtra, $proveniencia, $topicoManifestacao, $formaRecebimento, $db_conn)
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
        $sql =  $db_conn->prepare("INSERT INTO manifestacao (nup , tipoManifestacao , dataRecebimento , assunto , situacao, dataLimite, nomeDemandante, unidadeEnvolvida, emailDemandante, usuario, infoExtra, proveniencia, topicoManifestacao, formaRecebimento)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

        //Evita o sql injection
        $sql->bind_param("sississsssssii" , $nup, $tipoManifestacao, $dataRecebimento, $assunto, $situacao, $dataLimite, $nomeDemandante, $unidadeEnvolvida, $emailDemandante, $usuario, $infoExtra, $proveniencia, $topicoManifestacao, $formaRecebimento);
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
    public static function deletarManifestacao($idManifestacao, $db_conn)
    {
        if (self::existeManifestacao($idManifestacao, $db_conn))
        {
            $sql = $db_conn->prepare("select * from pendencias where idManifestacao=?");
            $sql->bind_param("i", $idManifestacao);
            $sql->execute();
            if($sql)
            {
                $sql = $sql->get_result();
                while($row = $sql->fetch_array())
                {
                    Pendencias::deletarPendencia($row["id"], $db_conn);
                }

                $sql_1 = $db_conn->prepare("DELETE FROM manifestacao WHERE idManifestacao = ?");
                $sql_1 ->bind_param("i" , $idManifestacao);
                $sql_1->execute();
                if ($sql_1) {
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }

    public static function pesquisarManifestacao($pesquisa, $db_conn){

        $p = "%$pesquisa%";
        $sql =  $db_conn->prepare("SELECT * FROM manifestacao WHERE nup = ? OR idManifestacao = ?");
        $sql->bind_param("si" , $pesquisa, $pesquisa);
        $sql->execute();
        $sql = $sql->get_result();

        if ($sql->num_rows >0) {
            return $sql;
        }else{ //Caso não ache pelo nup
            $sql_1 = $db_conn->prepare("(SELECT * FROM manifestacao WHERE nup LIKE ? OR assunto LIKE ? OR nomeDemandante LIKE ?
                    OR unidadeEnvolvida LIKE ? OR emailDemandante LIKE ? OR usuario LIKE ? OR infoExtra LIKE ? OR proveniencia LIKE ?)
                    UNION
                    (SELECT m.* FROM manifestacao m, pendencias p WHERE p.descricaoPendencia LIKE ?)
                    ");
            $sql_1->bind_param("sssssssss" , $p, $p,$p,$p,$p,$p,$p,$p, $p);
            $sql_1->execute();
            $sql_1 = $sql_1->get_result();

            if ($sql_1->num_rows >0) {
               return $sql_1;
            }else{
                return false;
            }

        }
    }
    public static function pesquisarManifestacaoDate($pesquisa, $db_conn){
        $pesquisa = str_replace('/', '-', $pesquisa);
        $pesquisa = date("Y-m-d", strtotime($pesquisa));
        $sql_1 = $db_conn->prepare("SELECT * FROM manifestacao WHERE dataRecebimento=?");
            $sql_1->bind_param("s", $pesquisa);
            $sql_1->execute();
            $sql_1 = $sql_1->get_result();

            if ($sql_1->num_rows >0) {
               return $sql_1;
            }else{
                return false;
            }
    }

    public static function atualizarSituacao($idManifestacao, $idSituacao, $db_conn)
    {
        if(self::existeManifestacao($idManifestacao, $db_conn))
        {
            if($idSituacao == '' or null)
            {
                return false;
            }

            $sql = $db_conn->prepare("update manifestacao set situacao=? where idManifestacao=?");
            $sql->bind_param("ii", $idSituacao, $idManifestacao);
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

    public static function prorrogarManifestacao($idManifestacao, $justificativa, $usuario, $db_conn)
    {
        if(self::existeManifestacao($idManifestacao, $db_conn))
        {
           if(!Pendencias::existeProrrogacao($idManifestacao, $db_conn))
           {
                $sql = $db_conn->prepare("update manifestacao set dataLimite = DATE_ADD(dataLimite, INTERVAL 30 DAY) where idManifestacao=?");
                $sql->bind_param('i', $idManifestacao);
                $sql->execute();

                if($sql)
                {
                    if(Pendencias::addPendencia($idManifestacao, 9, $justificativa, date("Y-m-d"), $usuario, '', $db_conn))
                    {
                        if(self::atualizarSituacao($idManifestacao, 5, $db_conn))
                        {
                            return true;
                        }else{
                            return false;
                        }
                    }else{
                        return false;
                    }
                }else{
                    $sql3 = $db_conn->prepare("update manifestacao set dataLimite = DATE_SUB(dataLimite, INTERVAL 30 DAY) where idManifestacao=?");
                    $sql3->bind_param('i', $idManifestacao);
                    $sql3->execute();
                    return false;
                }
           }else{
               return false;
           }

        }else{
            return false;
        }
    }

    public static function editarManifestacao($id, $db_conn){
        if (self::existeManifestacao($id, $db_conn)) {

                    $nup = $_POST["nup"];
                    $tipoManifestacao = $_POST["tipoManifestacao"];
                    $dataRecebimento = Helper::converterDataToMysqlData($_POST["dataRecebimento"]);
                    $assunto = $_POST["assunto"];
                    $situacao = $_POST["situacao"];
                    $dataLimite = $_POST["dataLimite"];
                    if($dataLimite == '' || $dataLimite == '00/00/0000')
                    {
                        $dataLimite = null;
                    }else{
                        $dataLimite = Helper::converterDataToMysqlData($dataLimite);
                    }
                    $nomeDemandante = $_POST["nomeDemandante"];
                    $unidadeEnvolvida = $_POST["unidadeEnvolvida"];
                    $emailDemandante = $_POST["emailDemandante"];
                    $infoExtra = $_POST["infoExtra"];
                    $proveniencia = $_POST["proveniencia"];
                    $formaRecebimento = $_POST["formaRecebimento"];
                    $unidadeEnvolvida = $_POST["unidadeEnvolvida"];
                    $topicoManifestacao = $_POST["topicoManifestacao"];
    
                    $sql_1 =$db_conn->prepare("UPDATE manifestacao SET nup=?, tipoManifestacao=?, dataRecebimento=?, assunto=?, situacao=?,dataLimite=?, nomeDemandante=?, unidadeEnvolvida=?, emailDemandante=?, infoExtra=?, proveniencia=?, topicoManifestacao=?, formaRecebimento=? WHERE idManifestacao = ?");
                    $sql_1->bind_param("sississsssiiii" , $nup, $tipoManifestacao, $dataRecebimento, $assunto, $situacao, $dataLimite, $nomeDemandante, $unidadeEnvolvida, $emailDemandante, $infoExtra, $proveniencia, $topicoManifestacao, $formaRecebimento, $id);
                    $sql_1->execute();
                    if($sql_1) {
                        return true;
            
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

    /**
     * Get the value of formaRecebimento
     */ 
    public function getFormaRecebimento()
    {
        return $this->formaRecebimento;
    }
}
?>