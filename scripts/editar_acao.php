<?php
    require("../config/config_scripts.php");
    if(isset($_GET['idPendencia']) && isset($_POST['tipoPendencia']) && isset($_POST['dataPendencia']) && isset($_POST['descricaoPendencia']))
    {
        $idPendencia = $_GET['idPendencia'];
        $tipoPendencia = $_POST['tipoPendencia'];
        $dataPendencia = Helper::converterDataToMysqlData($_POST['dataPendencia']);
        $descricaoPendencia = $_POST['descricaoPendencia'];
        $anexo = $_FILES["anexo"];

        $Pendencia = new Pendencias($idPendencia, $db_conn);

        $path = $_FILES["anexo"]["name"];
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        $_UP['erros'][0] = 'Não houve erro';
        $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
        $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
        $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
        $_UP['erros'][4] = 'Não foi feito o upload do arquivo';


        $sql_num = $db_conn->prepare("select count(*) as totalAcao from pendencias where idManifestacao=?");
        $sql_num->bind_param("i", $idManifestacao);
        $sql_num->execute();

        $sql_num = $sql_num->get_result();
        $r = $sql_num->fetch_array();
        $totalAcao = $r["totalAcao"];
        $totalAcao++;
    
        if($tipoPendencia == 3){
            $encaminhamentoPara = $_POST['encaminhadoPara'];
            $dataEncaminhamento = Helper::converterDataToMysqlData($_POST['dataEncaminhamento']);
            $dataLimitePosicionamento = $_POST['dataLimitePosicionamento'];

            if(empty($dataLimitePosicionamento))
            {
                $dataLimitePosicionamento = null;
            }else{
                $dataLimitePosicionamento = Helper::converterDataToMysqlData($dataLimitePosicionamento);
            }

            $anexoFileName = $idManifestacao.".$totalAcao - ".Pendencias::getNomePendencia($tipoPendencia)." - Anexo.".$ext;
            if(!empty($path))
            {
                if ($_FILES['arquivo']['error'] != 0) {
                    die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
                    exit;
                    }
                    
                if(move_uploaded_file($_FILES['anexo']['tmp_name'], '/var/www/html/anexos/'.$anexoFileName))
                {
                    $filePath = 'anexos/'.$anexoFileName;
                }else{
                    $error = error_get_last();
                    die ($error['message']);
                }
            }else{
                $filePath = $Pendencia->getAnexo();
            }
            $Pendencia->setUsuario($_SESSION['logged_user']);
            $Pendencia->setTipoPendencia($tipoPendencia);
            $Pendencia->setDataPendencia($dataPendencia);
            $Pendencia->setDescricaoPendencia($descricaoPendencia);
            $Pendencia->setAnexo($filePath);
            $Pendencia->setEncaminhadoPara($encaminhamentoPara);
            $Pendencia->setDataLimitePosicionamento($dataLimitePosicionamento);
            $Pendencia->setDataEncaminhamento($dataEncaminhamento);
            if($Pendencia->editarPendencia())
            {
                die("ok");
            }else{
                die("Erro ao editar a ação.");
            } 
        }else{
            $anexoFileName = $idManifestacao.".$totalAcao - ".Pendencias::getNomePendencia($tipoPendencia)." - Anexo.".$ext;
                if(!empty($path))
                {
                    if ($_FILES['arquivo']['error'] != 0) {
                        die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
                        exit;
                        }
                        
                    if(move_uploaded_file($_FILES['anexo']['tmp_name'], '/var/www/html/anexos/'.$anexoFileName))
                    {
                        $filePath = 'anexos/'.$anexoFileName;
                    }else{
                        $error = error_get_last();
                        die ($error['message']);
                    }
                }else{
                    $filePath = $Pendencia->getAnexo();
                }
                $Pendencia->setUsuario($_SESSION['logged_user']);
                $Pendencia->setTipoPendencia($tipoPendencia);
                $Pendencia->setDataPendencia($dataPendencia);
                $Pendencia->setDescricaoPendencia($descricaoPendencia);
                $Pendencia->setAnexo($filePath);
                if($Pendencia->editarPendencia())
                {
                    die("ok");
                }else{
                    die("Erro ao editar a ação.");
                } 
        }
    }else{
        die("Preencha os campos da ocorrência.");
    }
?>