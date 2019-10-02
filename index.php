<?php
    require_once("config/config.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title><?php echo($config["website_title"]); ?></title>
<link rel="stylesheet" href="css/materialize.min.css">
<link href="css/icon.css" rel="stylesheet">
<link rel="stylesheet" href="css/jquery-ui.min.css">
<link rel="stylesheet" href="css/main.css">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">

<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
<script type='text/javascript' src='js/jquery.inputmask.min.js'></script>
<script type='text/javascript' src='js/jquery-ui.min.js'></script>
<script src="js/materialize.min.js"></script>
<script type='text/javascript' src='js/main.js'></script>
</head>

<body>
<div class="wrapper">
<?php
    if (isset($_GET["logout"]))
    {
        session_destroy();
        $_SESSION["logged_user"] = "";
        $_SESSION["logged_password"] = "";
        header("location:index.php");
    }
    if(Helper::isLogged($db_conn))
    {
?>
    <?php include("menu.php"); ?>
    <div id="indexCnt" class="cnt">
    <div id="print"></div>
    <?php
        $User = new User($_SESSION["logged_user"], $_SESSION["logged_password"], $db_conn);
        $autoridade = $User->getUserAutoridade();
        if(isset($_GET["page"]))
        {
            if(file_exists("paginas/".$_GET["page"].".php"))
            {
                include("paginas/".$_GET["page"].".php");
            }else{
                include("paginas/404.php");
            }
        }else{
            include("paginas/dashboard.php");
        }
    ?>
    </div>
        <?php
    }else{
        include("paginas/login.php");
    }
?>
</div>

<div id="loadingCnt">
    <div class="loadingWrapper">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
    </div>
</div>
</body>
<script>
    $(document).ready(function(){
        var pageParam = getUrlParameter("page");
        if(pageParam == null)
        {
            $("li[name=dashboard]").addClass("grey").addClass("lighten-3");
        }else{
            if(pageParam == 'add_manifestacao' || pageParam == 'visualizar_manifestacao')
            {
                $("li[name=dashboard]").addClass("grey").addClass("lighten-3");
            }else{
                $("li[name="+pageParam+"]").addClass("grey").addClass("lighten-3");
            }
        }
    });
</script>
</html>