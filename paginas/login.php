<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="logo"></div>
        </div>
    </div>

    <div class="row ">
        <form id="loginForm" type="POST" onsubmit="return false;">
            <div class="col s8 offset-s2">
                <div class="login z-depth-2 valign-wrapper">
                    <div class="loginInfo">
                        <div class="row">
                            <form class="col s12">
                                <div class="row">
                                    <div class="input-field col s11">
                                    <i class="material-icons prefix">account_box</i>
                                    <input id="login" type="text" name="login" class="validate">
                                    <label for="login">Usuário</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s11">
                                        <i class="material-icons prefix">lock</i>
                                        <input id="password" type="password" name="senha" class="validate">
                                        <label for="password">Senha</label>
                                    </div>
                                </div>
                                </form>
                        </div>
                        <div class="row">
                            <div class="col s12 right-align"><a class="blue darken-4 waves-effect waves-light btn-large hoverable" onClick="login();"><i class="material-icons left">send</i>Entrar</a></div>
                        </div>
                    </div>
                </div>
            </div>
        <form>
    </div>

</div>
<script>
$(document).on("keypress", "input", function(e){
    if(e.which == 13)
    {
        login();
    }
});
</script>