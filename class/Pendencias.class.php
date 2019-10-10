<?php
class Pendencias{

    protected $idPendencia="";
    protected $idManifestacao = "";
    protected $tipoPendencia = "";
    protected $descricaoPendencia = "";
    protected $dataPendencia = "";
    protected $usuario = "";
    protected $anexo = "";
    protected $db_conn = "";

    protected $encaminhadoPara = "";
    protected $dataEncaminhamento = "";
    protected $dataLimitePosicionamento = "";

    public function __construct($idPendencia, $db_conn)
    {
        if(!self::existePendenciaId($idPendencia, $db_conn))
        {
            throw new Exception("Id da pendência inexistente.");
        }
        $this->db_conn = $db_conn;
        $this->idPendencia = $idPendencia;
        $sql = $db_conn->prepare("select * from pendencias where id=?");
        $sql->bind_param("i", $idPendencia);
        $sql->execute();

        $sql = $sql->get_result();
        $row = $sql->fetch_assoc();
        $this->idManifestacao = $row["idManifestacao"];
        $this->tipoPendencia = $row["tipoPendencia"];
        $this->descricaoPendencia = $row["descricaoPendencia"];
        $this->dataPendencia = $row["dataPendencia"];
        $this->usuario = $row["usuario"];
        $this->anexo = $row["anexo"];

        if(empty($this->getDataLimitePosicionamento()))
        {
            $this->setDataLimitePosicionamento(null);
        }
    }

    public function editarPendencia()
    {
        if(!empty($this->getIdPendencia()) || !empty($this->getDataPendencia()) || !empty($this->getTipoPendenciaId()) || !empty($this->usuario()))
        {
            $sql = $this->db_conn->prepare("update pendencias set tipoPendencia=?, descricaoPendencia=?, dataPendencia=?, anexo=? where id=?");
            $sql->bind_param("isssi", $this->getTipoPendenciaId(), $this->getDescricaoPendencia(), $this->getDataPendencia(), $this->getanexo(), $this->getIdPendencia());
            $sql->execute();

            if($sql)
            {
                if($this->getTipoPendenciaId() == 3)
                {
                    $sql2 = $this->db_conn->prepare("update partes_envolvidas set encaminhadoPara=?, dataEncaminhamento=?, dataLimitePosicionamento=? where idPendencia=?");
                    $sql2->bind_param('sssi', $this->getEncaminhadoPara(), $this->getDataEncaminhamento(), $this->getDataLimitePosicionamento(), $this->getIdPendencia());
                    $sql2->execute();
                    if($sql2)
                    {
                        return true;
                    }else{
                        throw new Exception("Erro ao atualizar a parte envolvida na ação.");
                        return false;
                    }
                }else{
                    return true;
                }
            }else{
                throw new Exception("Erro ao atualizar a ação.");
                return false;
            }
        }else{
            throw new Exception("Objeto inconsistente.");
            return false;
        }
    }

    public static function addPendencia($idManifestacao, $tipoPendencia, $descricaoPendencia, $dataPendencia, $usuario, $anexo, $db_conn)
    {
        if(empty($idManifestacao) || empty($tipoPendencia) || empty($dataPendencia) || empty($usuario))
        {
            die("Preencha todos os campos obrigatórios.");
        }

        $sql = $db_conn->prepare("insert into pendencias (idManifestacao, tipoPendencia, descricaoPendencia, dataPendencia, usuario, anexo)
        values (?,?,?,?,?,?)");
        $sql->bind_param("iissss", $idManifestacao, $tipoPendencia, $descricaoPendencia, $dataPendencia, $usuario, $anexo);
        $sql->execute();

        if($sql)
        {
            switch($tipoPendencia)
            {
                case 3:
                    if(Manifestacoes::atualizarSituacao($idManifestacao, 4, $db_conn))
                    {
                        return true;
                    }else{
                        return false;
                    }
                break;
                case 7:
                    if(Manifestacoes::atualizarSituacao($idManifestacao, 2, $db_conn))
                    {
                        return true;
                    }else{
                        return false;
                    }
                break;
                case 8:
                    if(Manifestacoes::atualizarSituacao($idManifestacao, 7, $db_conn))
                    {
                        return true;
                    }else{
                        return false;
                    }
                break;
            }
            return true;
        }else{
            return false;
        }

    }
    public static function getLastIdPendencia($db_conn)
    {
        $sql = $db_conn->prepare("select id from pendencias order by id DESC limit 1");
        $sql->execute();

        $sql = $sql->get_result();
        $r = $sql->fetch_array();

        return $r[0];
    }

    public static function addParteEnvolvida($idManifestacao, $idPendencia, $encaminhadoPara, $dataEncaminhamento, $dataLimitePosicionamento, $usuario, $db_conn)
    {
        if(Manifestacoes::existeManifestacao($idManifestacao, $db_conn))
        {
            if(empty($idManifestacao) || empty($idPendencia) || empty($encaminhadoPara) || empty($dataEncaminhamento) || empty($usuario))
            {
               return false;
            }
            $sql = $db_conn->prepare("insert into partes_envolvidas (idManifestacao, idPendencia, encaminhadoPara, dataEncaminhamento, dataLimitePosicionamento, usuario)
            values (?, ?, ?, ?, ?, ?)");
            $sql->bind_param('iissss', $idManifestacao, $idPendencia, $encaminhadoPara, $dataEncaminhamento, $dataLimitePosicionamento, $usuario);
            $sql->execute();

            if($sql)
            {
                return true;
            }else{
                return false;
            }

        }else{
            die("O código da manifestação não existe.");
        }
    }

    public static function getParteEnvolvida($idPendencia, $db_conn)
    {
        $sql = $db_conn->prepare("select * from partes_envolvidas where idPendencia=?");
        $sql->bind_param("i", $idPendencia);
        $sql->execute();

        if($sql)
        {
            $sql = $sql->get_result();
            return $sql;
        }else{
            return false;
        }
    }

    public static function existePendenciaId($idPendencia, $db_conn)
    {
        $sql = $db_conn->prepare("select * from pendencias where id=?");
        $sql->bind_param('i', $idPendencia);
        $sql->execute();

        $sql = $sql->get_result();

        if($sql->num_rows > 0)
        {
            return true;
        }else{
            return false;
        }
    }

    public static function getTipoPendencia($idPendencia, $db_conn)
    {
        if(self::existePendenciaId($idPendencia, $db_conn))
        {
            $sql = $db_conn->prepare("select tipoPendencia from pendencias where id=?");
            $sql->bind_param('i', $idPendencia);
            $sql->execute();

            $sql = $sql->get_result();

            if($sql->num_rows > 0)
            {
                $row = $sql->fetch_assoc();

                return $row["tipoPendencia"];
            }else{
                return false;
            }

        }else{
            return false;
        }
    }

    public static function deletarPendencia($idPendencia, $db_conn)
    {
        if(self::existePendenciaId($idPendencia, $db_conn))
        {
            if(self::getTipoPendencia($idPendencia, $db_conn) == 9)
            {
                return false;
            }
            if(self::getParteEnvolvida($idPendencia, $db_conn))
            {
                $sql = $db_conn->prepare("delete from partes_envolvidas where idPendencia=?");
                $sql->bind_param("i", $idPendencia);
                $sql->execute();

                if($sql)
                {
                    $sql2 = $db_conn->prepare("delete from pendencias where id=?");
                    $sql2->bind_param("i", $idPendencia);
                    $sql2->execute();

                    if($sql2)
                    {
                        return true;
                    }else{
                        return false;
                    }

                }else{
                    return false;
                }
            }else{
                $sql2 = $db_conn->prepare("delete from pendencias where id=?");
                $sql2->bind_param("i", $idPendencia);
                $sql2->execute();

                if($sql2)
                {
                    return true;
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
    }

    public static function getListaPendencias($idManifestacao, $db_conn)
    {
        $sql = $db_conn->prepare("select * from pendencias where idManifestacao=? order by id ASC");
        $sql->bind_param("i", $idManifestacao);
        $sql->execute();
        $sql = $sql->get_result();
        if($sql->num_rows > 0)
        {
            return $sql;
        }else{
            return false;
        }
    }

    public static function existeProrrogacao($idManifestacao, $db_conn)
    {
        $sql = $db_conn->prepare("select * from pendencias where idManifestacao=? and tipoPendencia='9'");
        $sql->bind_param('i', $idManifestacao);
        $sql->execute();

        $sql = $sql->get_result();

        if($sql->num_rows > 0)
        {
            return true;
        }else{
            return false;
        }
    }

    public static function getNomePendencia($codPendencia)
    {
        switch($codPendencia)
        {
            case 1:
                return "Requerimento Inicial";
            break;
            case 2:
                return "Resposta Inicial";
            break;
            case 3:
                return "Encaminhamento";
            break;
            case 4:
                return "Resposta Ouvidoria";
            break;
            case 5:
                return "Resposta Demandado";
            break;
            case 6:
                return "Resposta Demandante";
            break;
            case 7:
                return "Solicitação de Informação Complementar";
            break;
            case 8:
                return "Posicionamento Final";
            break;
            case 9:
                return "Requerimento Prorrogado";
            break;

        }
    }

    /**
     * Get the value of idPendencia
     */ 
    public function getIdPendencia()
    {
        return $this->idPendencia;
    }

    /**
     * Get the value of idManifestacao
     */ 
    public function getIdManifestacao()
    {
        return $this->idManifestacao;
    }

    /**
     * Get the value of descricaoPendencia
     */ 
    public function getDescricaoPendencia()
    {
        return $this->descricaoPendencia;
    }

    /**
     * Get the value of dataPendencia
     */ 
    public function getDataPendencia()
    {
        return $this->dataPendencia;
    }

    /**
     * Get the value of usuario
     */ 
    public function getUsuario()
    {
        return $this->usuario;
    }

    /**
     * Get the value of anexo
     */ 
    public function getAnexo()
    {
        return $this->anexo;
    }

    /**
     * Set the value of anexo
     *
     * @return  self
     */ 
    public function setAnexo($anexo)
    {
        $this->anexo = $anexo;

        return $this;
    }

    /**
     * Set the value of dataPendencia
     *
     * @return  self
     */ 
    public function setDataPendencia($dataPendencia)
    {
        $this->dataPendencia = $dataPendencia;

        return $this;
    }

    /**
     * Set the value of descricaoPendencia
     *
     * @return  self
     */ 
    public function setDescricaoPendencia($descricaoPendencia)
    {
        $this->descricaoPendencia = $descricaoPendencia;

        return $this;
    }

    /**
     * Set the value of tipoPendencia
     *
     * @return  self
     */ 
    public function setTipoPendencia($tipoPendencia)
    {
        $this->tipoPendencia = $tipoPendencia;

        return $this;
    }

    /**
     * Get the value of tipoPendencia
     */ 
    public function getTipoPendenciaId()
    {
        return $this->tipoPendencia;
    }

    /**
     * Get the value of dataLimitePosicionamento
     */ 
    public function getDataLimitePosicionamento()
    {
        return $this->dataLimitePosicionamento;
    }

    /**
     * Set the value of dataLimitePosicionamento
     *
     * @return  self
     */ 
    public function setDataLimitePosicionamento($dataLimitePosicionamento)
    {
        $this->dataLimitePosicionamento = $dataLimitePosicionamento;

        return $this;
    }

    /**
     * Get the value of dataEncaminhamento
     */ 
    public function getDataEncaminhamento()
    {
        return $this->dataEncaminhamento;
    }

    /**
     * Set the value of dataEncaminhamento
     *
     * @return  self
     */ 
    public function setDataEncaminhamento($dataEncaminhamento)
    {
        $this->dataEncaminhamento = $dataEncaminhamento;

        return $this;
    }

    /**
     * Get the value of encaminhadoPara
     */ 
    public function getEncaminhadoPara()
    {
        return $this->encaminhadoPara;
    }

    /**
     * Set the value of encaminhadoPara
     *
     * @return  self
     */ 
    public function setEncaminhadoPara($encaminhadoPara)
    {
        $this->encaminhadoPara = $encaminhadoPara;

        return $this;
    }

    /**
     * Set the value of usuario
     *
     * @return  self
     */ 
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;

        return $this;
    }
}
?>