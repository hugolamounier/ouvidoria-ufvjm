<?php
    require_once("config/config.php");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0"> 
<title><?php echo($config["website_title"]); ?></title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="css/main.css">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<link rel="icon" href="/favicon.ico" type="image/x-icon">

<script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
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
    <div class="cnt">
    <?php
        $User = new User($_SESSION["login"], $_SESSION["senha"], $db_conn);
        if(isset($_GET["page"]))
        {
            
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
</body>
<script>
    $(document).ready(function(){
        var pageParam = getUrlParameter("page");
        if(pageParam == null)
        {
            $("li[name=dashboard]").addClass("grey").addClass("lighten-3");
        }else{
            $("li[name="+pageParam+"]").addClass("grey").addClass("lighten-3");
        }
    });
</script>
</html>