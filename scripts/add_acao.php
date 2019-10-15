<?php
    require("../config/config_scripts.php");
    if(isset($_GET['idManifestacao']) && isset($_POST['tipoPendencia']) && isset($_POST['dataPendencia']) && isset($_POST['descricaoPendencia']))
    {
        $idManifestacao = $_GET['idManifestacao'];
        $tipoPendencia = $_POST['tipoPendencia'];
        $dataPendencia = $_POST['dataPendencia'];
        $descricaoPendencia = $_POST['descricaoPendencia'];
        $anexo = $_FILES["anexo"];

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
            if (isset($_POST['encaminhadoPara']) && isset($_POST['dataEncaminhamento'])  && isset($_POST['dataLimitePosicionamento'])) {
                $encaminhamentoPara = $_POST['encaminhadoPara'];
                $dataEncaminhamento = $_POST['dataEncaminhamento'];
                $dataLimitePosicionamento = $_POST['dataLimitePosicionamento'];

                if(empty($encaminhamentoPara) || empty($dataEncaminhamento))
                {
                    die("É necessário preencher os campos de encaminhamento. (Encaminhamento Para) ou (Data Encaminhamento)");
                }

                if(empty($dataLimitePosicionamento))
                {
                    $dataLimitePosicionamento = null;
                }else{
                    $dataLimitePosicionamento = Helper::converterDataToMysqlData($dataLimitePosicionamento);
                }

                $anexoFileName = $idManifestacao.".$totalAcao - ".Pendencias::getNomePendencia($tipoPendencia)." - Anexo.".$ext;
                if(!empty($path))
                {
                    if ($_FILES['anexo']['error'] != 0) {
                        die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['anexo']['error']]);
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
                    $filePath = "";
                }
                if(Pendencias::addPendencia($idManifestacao, $tipoPendencia, $descricaoPendencia, Helper::converterDataToMysqlData($dataPendencia), $_SESSION["logged_user"], $filePath, $db_conn))
                {
                    $lastId = Pendencias::getLastIdPendencia($db_conn);
                    if(Pendencias::addParteEnvolvida($idManifestacao, $lastId, $encaminhamentoPara, Helper::converterDataToMysqlData($dataEncaminhamento),
                    $dataLimitePosicionamento, $_SESSION["logged_user"], $db_conn))
                    {
                        die("ok");
                    }else{
                        die("Erro ao adicionar a ocorrência.");
                    }
                }else{
                    die("Erro ao adicionar parte envolvida, tente novamente.");
                }                
            }
        }else{
            $anexoFileName = $idManifestacao.".$totalAcao - ".Pendencias::getNomePendencia($tipoPendencia)." - Anexo.".$ext;
                if(!empty($path))
                {
                    if ($_FILES['anexo']['error'] != 0) {
                        die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['anexo']['error']]);
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
                    $filePath = "";
                }
            if(Pendencias::addPendencia($idManifestacao, $tipoPendencia, $descricaoPendencia, Helper::converterDataToMysqlData($dataPendencia), $_SESSION["logged_user"], $filePath, $db_conn))
            {
                die("ok");
            }else{
                die("Erro ao adicionar a ocorrência.");
            }
        }
    }else{
        die("Preencha os campos da ocorrência.");
    }
?>