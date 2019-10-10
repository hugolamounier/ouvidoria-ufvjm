<?php $User = new User($_SESSION["logged_user"], $db_conn); ?>
<div class="menu_wrapper z-depth-3 grey lighten-5">
        <div onclick="location.href='?page=dashboard'" class="logo_mini"></div>
        <div class="division"></div>
        <div class="menu">
            <ul>
                <li onclick="location.href='?page=dashboard'" class="valign-wrapper" name="dashboard"><span><i class="material-icons left">list</i>Demandas<span></li>
                <li onclick="location.href='?page=relatorios'" class="valign-wrapper" name="relatorios"><span><i class="material-icons left">content_paste</i>Relatórios<span></li>
                <?php
                    if($User->getAutoridade() == 100)
                    {
                        echo("<li onclick=\"location.href='?page=gerenciar_usuarios'\" class=\"valign-wrapper\" name=\"gerenciar_usuarios\"><span><i class=\"material-icons left\">people</i>Gerenciar Usuários<span></li>");
                    }
                ?>
                <li class="valign-wrapper" onclick="location.href='?logout=1'"><span><i class="material-icons left">exit_to_app</i>Sair<span></li>
            </ul>
        </div>
        <div class="menu_footer">
            <div class="userInfo">
                <div><span><b style='font-size:11.5px;'>Usuário:</b> <small><?php echo $User->getNome() ?></small>    </span></div>
            </div>
            <div class="division"></div>
            <div class="logo_ufvjm"></div>
        </div>
</div>