<?php
    require("../config/config_scripts.php");
    die("123");
    if(isset($_GET['idManifestacao']) && isset($_POST['tipoPendencia']) && isset($_POST['dataPendencia']) && isset($_POST['descricaoPendencia']))
     {
        $idManifestacao = $_GET['idManifestacao'];
        $tipoPendencia = $_POST['tipoPendencia'];
        $dataPendencia = $_POST['dataPendencia'];
        $descricaoPendencia = $_POST['descricaoPendencia'];
        $anexo = $_FILES["anexo"];
        
        $path = $_FILES["anexo"]["name"];
        $ext = pathingo($path, PATHINFO_EXTENSION);

        $anexoFileName = $idManifestacao.".".Pendencias::getNomePendencia($tipoPendencia)." - Anexo - ".$dataEncaminhamento.".".$ext;

        if($anexo != NULL)
        {
           move_uploaded_file($anexoFileName, '/anexos/');

           $filePath = '/anexos/'.$anexoFileName;
        }else{
            $filePath = "";
        }

         if($tipoPendencia == 3){
            if (isset($_POST['encaminhadoPara']) && isset($_POST['dataEncaminhamento'])  && isset($_POST['dataLimitePosicionamento'])) {
                $encaminhamentoPara = $_POST['encaminhamentoPara'];
                $dataEncaminhamento = $_POST['dataEncaminhamento'];
                $dataLimitePosicionamento = $_POST['dataLimitePosicionamento'];

                if(Pendencias::addParteEnvolvida($idManifestacao, $encaminhamentoPara, $dataEncaminhamento, $dataLimitePosicionamento, $_SESSION["logged_user"], $db_conn))
                {
                    if(Pendencias::addPendencia())
                    {
                        die("ok");
                    }else{
                        die("Erro ao adicionar a ocorrência.");
                    }
                }else{
                    die("Erro ao adicionar parte envolvida, tente novamente.");
                }                
            }else{
                if(Pendencias::addPendencia())
                {
                    die("ok");
                }else{
                    die("Erro ao adicionar a ocorrência.");
                }
            }
         }
     }
?>