<?php
    $User = new User($_SESSION["logged_user"], $db_conn);

    if(!$User->checkAutoridade(100))
    {
        die("Você não possui autoridade para acessar essa página.");
    }
?>
<div class="title">
    <a onclick="location.href='?page=dashboard'" class="btn-floating btn-small waves-effect blue-grey lighten-3 tooltipped z-depth-0" data-position="bottom" data-tooltip="Voltar"><i class="material-icons">arrow_back</i></a>
    <span class="blue-grey-text text-darken-3">Gerenciar Usuários</span>
    <div class="options">
    </div>
</div>
<div class="container">
    <div class='addUser'>
        <a data-tooltip="Adicionar Usuário" class="waves-effect waves-light btn blue-grey lighten-3 hoverable"><i class="material-icons left">add</i>Adicionar Usuário</a>
    </div>
    <div class='row'>
        <div class='col s12'>
            <div class='gerenciar_usuarios'>
                <?php
                    $sql = $db_conn->prepare("select * from usuario order by ativo desc");
                    $sql->execute();
                    $sql = $sql->get_result();

                    while($row = $sql->fetch_assoc())
                    {
                        if($row["ativo"] == 0)
                        {
                            $desativado = "desativado";
                            $tag = '';
                        }else{
                            switch($row["autoridade"])
                            {
                                case 100:
                                    $tag = 'solicitacaoTag';
                                break;
                                case 99:
                                    $tag = "sugestaoTag";
                                break;
                                case 50:
                                    $tag = "elogioTag";
                                break;
                            }
                            $desativado = '';
                        }
                        echo("<div class='user z-depth-1 $tag $desativado'>");
                                echo("<div class='left'>");
                                    echo("<div class='row'>");
                                        echo("<div class='col s3'><span class='grey-text text-darken-1'>Usuário</span> <p>".$row["login"]."</p></div>");
                                        echo("<div class='col s4'><span class='grey-text text-darken-1'>Nome</span> <p>".$row["nome"]."</p></div>");
                                        echo("<div class='col s3'><span class='grey-text text-darken-1'>E-mail</span> <p>".$row["email"]."</p></div>");
                                        echo("<div class='col s2'><span class='grey-text text-darken-1'>Autoridade</span> <p>".$row['autoridade']."</p></div>");
                                    echo("</div>");
                                echo("</div>");
                                echo("<div class='right white z-depth-2'>");
                                    if($row['ativo'] == 1)
                                    {
                                        echo("<a class='tooltipped' data-position='bottom' data-tooltip='Desativar Usuário' user='".$row['login']."'><i class='material-icons'>block</i></a>");
                                        echo("<a class='tooltipped' data-position='bottom' data-tooltip='Editar Usuário' user='".$row['login']."'><i class='material-icons'>edit</i></a>");
                                    }else{
                                        echo("<a class='tooltipped' data-position='bottom' data-tooltip='Reativar Usuário' user='".$row['login']."'><i class='material-icons'>autorenew</i></a>");
                                    }
                                echo("</div>");
                        echo("</div>");
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<script>
    $('.tooltipped').tooltip();

    $("a[data-tooltip='Adicionar Usuário']").on('click', function(){
        loadPageOnWindow('Adicionar Usuário', '80%', '52vh', 'd_paginas/add_user.php');
    });
    $("a[data-tooltip='Desativar Usuário']").on('click', function(){
        showLoading();
        var id = $(this).attr("user");
        $.ajax({
            url: 'scripts/desativar_user.php',
            type: 'GET',
            data: {
                user: id, 
            },
            success: function(data)
            {
                if(data == "ok")
                {
                    window.location.reload();
                    closeLoading();
                }else{
                    alert(data);
                    closeLoading();
                }
            }
        });
    });
    $("a[data-tooltip='Reativar Usuário']").on('click', function(){
        showLoading();
        var id = $(this).attr("user");
        $.ajax({
            url: 'scripts/ativar_user.php',
            type: 'GET',
            data: {
                user: id, 
            },
            success: function(data)
            {
                if(data == "ok")
                {
                    window.location.reload();
                    closeLoading();
                }else{
                    alert(data);
                    closeLoading();
                }
            }
        });
    });
</script>