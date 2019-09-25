<?php
class Graph {


public static function calculardata($date1, $date2, $tipoManifestacao, $db_conn){
    $datasRecebidas = array();


    if (empty($tipoManifestacao)) {
        $sql = $db_conn->prepare("SELECT * FROM Manifestacao WHERE dataRecebimento BETWEEN ? AND ? GROUP BY dataRecebimento");
        $sql->bind_param("ss", $date1, $date2);
        $sql->execute();
        $sql = $sql->get_result();
        if ($sql->num_rows > 0) { //Caso ja exista um nup com o msm numero do nup fornecido
            while ($row = $sql->fetch_array()) {

               $sql_1 = $db_conn->prepare("SELECT COUNT(*) AS num_den FROM Manifestacao WHERE dataRecebimento = ?");
                $sql_1->bind_param("s", $row["dataRecebimento"]);
                $sql_1->execute();
                $sql_1 = $sql_1->get_result();
                $row_1 = $sql_1->fetch_array();
                $datasRecebidas[] = array("label" => date("d M Y", strtotime($row['dataRecebimento'])) , "y" => $row_1['num_den'] );

            }
        return $datasRecebidas;
    }else{
        die("error");
    }
        
    }


    //Pegar intervalo de datas
    $sql = $db_conn->prepare("SELECT * FROM Manifestacao WHERE dataRecebimento BETWEEN ? AND ? && tipoManifestacao = ? GROUP BY dataRecebimento");
    $sql->bind_param("ssi", $date1, $date2, $tipoManifestacao);
    $sql->execute();
    $sql = $sql->get_result();
    if ($sql->num_rows > 0) { //Caso ja exista um nup com o msm numero do nup fornecido
        while ($row = $sql->fetch_array()) {

            $sql_1 = $db_conn->prepare("SELECT COUNT(*) AS num_den FROM Manifestacao WHERE dataRecebimento = ? && tipoManifestacao = ?");
            $sql_1->bind_param("si", $row["dataRecebimento"],$tipoManifestacao);
            $sql_1->execute();
            $sql_1 = $sql_1->get_result();
            $row_1 = $sql_1->fetch_array();
            $datasRecebidas[] = array("label" => date("d M Y", strtotime($row['dataRecebimento'])) , "y" => $row_1['num_den'] );

        }
        return $datasRecebidas;
    }else{
        die("error");
    }

}




public static function consultarManifestacao($db_conn){

        //Denuncias
        $sqlDenuncias = $db_conn->prepare("SELECT tipoManifestacao FROM manifestacao WHERE tipoManifestacao = 1");
        $sqlDenuncias ->execute();
        $sqlDenuncias = $sqlDenuncias->get_result();
        $totalDenuncias = $sqlDenuncias->num_rows;

        //Reclamações
        $sqlReclamacoes = $db_conn->prepare("SELECT tipoManifestacao FROM manifestacao WHERE tipoManifestacao = 2");
        $sqlReclamacoes ->execute();
        $sqlReclamacoes = $sqlReclamacoes->get_result();
        $totalReclamacoes = $sqlReclamacoes->num_rows;

        //Solicitações
        $sqlSolicitacoes = $db_conn->prepare("SELECT tipoManifestacao FROM manifestacao WHERE tipoManifestacao = 3");
        $sqlSolicitacoes ->execute();
        $sqlSolicitacoes = $sqlSolicitacoes->get_result();
        $totalSolicitacoes = $sqlSolicitacoes->num_rows;

        //Sugestões
        $sqlSugestoes = $db_conn->prepare("SELECT tipoManifestacao FROM manifestacao WHERE tipoManifestacao = 4");
        $sqlSugestoes ->execute();
        $sqlSugestoes = $sqlSugestoes->get_result();
        $totalSugestoes = $sqlSugestoes->num_rows;

        //Elogios
        $sqlElogios = $db_conn->prepare("SELECT tipoManifestacao FROM manifestacao WHERE tipoManifestacao = 5");
        $sqlElogios ->execute();
        $sqlElogios = $sqlElogios->get_result();
        $totalElogios = $sqlElogios->num_rows;


          
        $dataPoints = array(
            array("label"=> "Denuncias", "y"=> $totalDenuncias),
            array("label"=> "Reclamações", "y"=> $totalReclamacoes),
            array("label"=> "Solicitações", "y"=> $totalSolicitacoes),
            array("label"=> "Sugestões", "y"=> $totalSugestoes),
            array("label"=> "Elogios", "y"=> $totalElogios),

            
        );

        return $dataPoints;
    }



    public static function consultarProveniencia($db_conn){
        //Anonimo
        $sqlAnonimo = $db_conn->prepare("SELECT proveniencia FROM manifestacao WHERE proveniencia = 3");
        $sqlAnonimo ->execute();
        $sqlAnonimo = $sqlAnonimo->get_result();
        $totalAnonimo = $sqlAnonimo->num_rows;

        //Externa
        $sqlExterna = $db_conn->prepare("SELECT proveniencia FROM manifestacao WHERE proveniencia = 2");
        $sqlExterna ->execute();
        $sqlExterna = $sqlExterna->get_result();
        $totalExterna = $sqlExterna->num_rows;

        //Interna
        $sqlInterna = $db_conn->prepare("SELECT proveniencia FROM manifestacao WHERE proveniencia = 1");
        $sqlInterna ->execute();
        $sqlInterna = $sqlInterna->get_result();
        $totalInterna = $sqlInterna->num_rows;

        $dataPoints = array(
            array("label"=> "Comunidade Interna", "y"=> $totalInterna),
            array("label"=> "Comunidade Externa", "y"=> $totalExterna),
            array("label"=> "Anonimo", "y"=> $totalAnonimo),

            
        );
        return $dataPoints;

    }


    public static function consultarNup($db_conn){
        $sqlEouv = $db_conn->prepare("SELECT formaRecebimento FROM manifestacao WHERE formaRecebimento = 1");
        $sqlEouv->execute();
        $sqlEouv = $sqlEouv->get_result();
        $totalEouv = $sqlEouv->num_rows;

        $sqlEmail = $db_conn->prepare("SELECT formaRecebimento FROM manifestacao WHERE formaRecebimento = 2");
        $sqlEmail->execute();
        $sqlEmail = $sqlEmail->get_result();
        $totalEmail = $sqlEmail->num_rows;

        $sqlFone = $db_conn->prepare("SELECT formaRecebimento FROM manifestacao WHERE formaRecebimento = 3");
        $sqlFone->execute();
        $sqlFone = $sqlFone->get_result();
        $totalFone = $sqlFone->num_rows;

        $sqlOutros = $db_conn->prepare("SELECT formaRecebimento FROM manifestacao WHERE formaRecebimento = 4");
        $sqlOutros->execute();
        $sqlOutros = $sqlOutros->get_result();
        $totalOutros = $sqlOutros->num_rows;



        $dataPoints = array(
            array("label"=> "E-Ouv", "y"=> $totalEouv),
            array("label"=> "E-mail", "y"=> $totalEmail),
            array("label"=> "Telefone", "y"=> $totalFone),
            array("label"=> "Outros", "y"=> $totalOutros),
            
        );

        return $dataPoints;




    }


    public static function consultarAssunto($db_conn){

        //Graduacao
        $sqlGraduacao = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 1");
        $sqlGraduacao ->execute();
        $sqlGraduacao = $sqlGraduacao->get_result();
        $totalGraduacao = $sqlGraduacao->num_rows;

        //Pos-Graduacao
        $sqlPosGraduacao = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 2");
        $sqlPosGraduacao ->execute();
        $sqlPosGraduacao = $sqlPosGraduacao->get_result();
        $totalPosGraduacao = $sqlPosGraduacao->num_rows;


        //extensao
        $sqlExtensao = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 3");
        $sqlExtensao ->execute();
        $sqlExtensao = $sqlExtensao->get_result();
        $totalExtensao = $sqlExtensao->num_rows;

        //serviços
        $sqlServicos = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 4");
        $sqlServicos ->execute();
        $sqlServicos = $sqlServicos->get_result();
        $totalServicos = $sqlServicos->num_rows;

        //Conduta
        $sqlConduta = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 5");
        $sqlConduta ->execute();
        $sqlConduta = $sqlConduta->get_result();
        $totalConduta = $sqlConduta->num_rows;

        //Pessoal
        $sqlPessoal = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 6");
        $sqlPessoal ->execute();
        $sqlPessoal = $sqlPessoal->get_result();
        $totalPessoal = $sqlPessoal->num_rows;

        //Gestao
        $sqlGestao = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 7");
        $sqlGestao ->execute();
        $sqlGestao = $sqlGestao->get_result();
        $totalGestao = $sqlGestao->num_rows;

        //Acesso à Graduação
        $sqlAcesso = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 8");
        $sqlAcesso ->execute();
        $sqlAcesso = $sqlAcesso->get_result();
        $totalAcesso = $sqlAcesso->num_rows;


        //Assistencia Estudantil
        $sqlAssistencia = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 9");
        $sqlAssistencia ->execute();
        $sqlAssistencia = $sqlAssistencia->get_result();
        $totalAssistencia = $sqlAssistencia->num_rows;


        //Legislação e Normas
        $sqlNormas = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 10");
        $sqlNormas ->execute();
        $sqlNormas = $sqlNormas->get_result();
        $totalNormas = $sqlNormas->num_rows;

        //Concursos
        $sqlConcursos = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 11");
        $sqlConcursos ->execute();
        $sqlConcursos = $sqlConcursos->get_result();
        $totalConcursos = $sqlConcursos->num_rows;

        //Outros
        $sqlOutros = $db_conn->prepare("SELECT topicoManifestacao FROM manifestacao WHERE topicoManifestacao = 12");
        $sqlOutros ->execute();
        $sqlOutros = $sqlOutros->get_result();
        $totalOutros = $sqlOutros->num_rows;
          





        $dataPoints = array(
            array("label"=> "Graduação", "y"=> $totalGraduacao),
            array("label"=> "Pos-Graduação", "y"=> $totalPosGraduacao),
            array("label"=> "Extensão", "y"=> $totalExtensao),
            array("label"=> "Serviços", "y"=> $totalServicos),
            array("label"=> "Conduta", "y"=> $totalConduta),
            array("label"=> "Pessoal", "y"=> $totalPessoal),
            array("label"=> "Gestão", "y"=> $totalGestao),
            array("label"=> "Acesso à Graduação", "y"=> $totalAcesso),
            array("label"=> "Assistência Estudantil", "y"=> $totalAssistencia),
            array("label"=> "Concursos", "y"=> $totalConcursos),
            array("label"=> "Outros", "y"=> $totalOutros),

            
        );

        return $dataPoints;
    }



    public static function consultarSituacao($db_conn){

        //Cadastrado
        $sqlCadastrado = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 1");
        $sqlCadastrado ->execute();
        $sqlCadastrado = $sqlCadastrado->get_result();
        $totalCadastrado = $sqlCadastrado->num_rows;

        //Complementação Solicitada
        $sqlComplementacao = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 2");
        $sqlComplementacao ->execute();
        $sqlComplementacao = $sqlComplementacao->get_result();
        $totalComplementacao = $sqlComplementacao->num_rows;

        //Complementado
        $sqlComplentado = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 3");
        $sqlComplentado ->execute();
        $sqlComplentado = $sqlComplentado->get_result();
        $totalComplementado = $sqlComplentado->num_rows;

        //Encaminhado por outra Ouvidoria
        $sqlEncaminhado = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 4");
        $sqlEncaminhado ->execute();
        $sqlEncaminhado = $sqlEncaminhado->get_result();
        $totalEncaminhado = $sqlEncaminhado->num_rows;

        //Prorrogado
        $sqlProrrogado = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 5");
        $sqlProrrogado ->execute();
        $sqlProrrogado = $sqlProrrogado->get_result();
        $totalProrrogado = $sqlProrrogado->num_rows;

        //Arquivado
        $sqlArquivado = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 6");
        $sqlArquivado ->execute();
        $sqlArquivado = $sqlArquivado->get_result();
        $totalArquivado = $sqlArquivado->num_rows;

        //Concluido
        $sqlConcluido = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 7");
        $sqlConcluido ->execute();
        $sqlConcluido = $sqlConcluido->get_result();
        $totalConcluido = $sqlConcluido->num_rows;

        //Encaminhado para Orgão externo/encerrado
        $sqlEncerrado = $db_conn->prepare("SELECT situacao FROM manifestacao WHERE situacao = 8");
        $sqlEncerrado ->execute();
        $sqlEncerrado = $sqlEncerrado->get_result();
        $totalEncerrado = $sqlEncerrado->num_rows;


        $dataPoints = array(
            array("label"=> "Cadastrado", "y"=> $totalCadastrado),
            array("label"=> "Complementação Solicitada", "y"=> $totalComplementacao),
            array("label"=> "Complementado", "y"=> $totalComplementado),
            array("label"=> "Encaminhado por outra Ouvidoria", "y"=> $totalEncaminhado),
            array("label"=> "Prorrogado", "y"=> $totalProrrogado),
            array("label"=> "Arquivado", "y"=> $totalArquivado),
            array("label"=> "Concluido", "y"=> $totalConcluido),
            array("label"=> "Encaminhado para Orgão Externo/Encerrado", "y"=> $totalEncerrado),

            
        );

        return $dataPoints;

    }





}
?>