<?php 
$User = new User($_SESSION["logged_user"], $db_conn); 
$nome = $User->getNome();
?>
<div class='userDesativado grey '>
    <div class="avisoWrapper white z-depth-3">
        <div><i class="material-icons">error</i></div>
        <div><span><?php echo $nome ?> sua conta está desativada.<br>Contate os administradores do sistema.</span></div>
    </div>
</div>