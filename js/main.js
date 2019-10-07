function login(url, formId)
{
    loadLogin();
    $.ajax({
        url: 'scripts/login.php',
        type: 'POST',
        data: $("#loginForm").serialize(),
        success: function(data)
        {
            if(data == "ok")
            {
                closeLoadLogin();
                window.location.reload();
            }else{
                alert(data);
                closeLoadLogin();
            }
        }
    });
}
function loadScript(url, container)
{
    showLoading();
    $.ajax({
        url: url,
        type: 'GET',
        success: function(data)
        {
            closeLoading();
            $("#"+container).html(data);
        }
    });
}
function postForm(url, formId, page)
{
    showLoading();
    $.ajax({
        url: url,
        type: 'POST',
        data: $("#"+formId).serialize(),
        success: function(data)
        {
            if(data == "ok")
            {
                closeLoading();
                $(location).attr('href', page);
            }else{
                alert(data);
                closeLoading();
            }
        }
    });
}

function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
};
function getUrlHash(hashName) {
    var sPageURL = window.location.hash.substr(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
    
            if (sParameterName[0] === hashName) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
};

function createFloatingWindow(windowTitle, width, height)
{
    $("#indexCnt").append('<div id="floatingWindow" class="floatingWindow z-depth-3 white"><div class="header z-depth-1 grey lighten-4"><span class="blue-text text-darken-4">'+windowTitle+'</span><a onclick="destroyFloatingWindow();" class="btn-floating btn-small waves-effect red lighten-1 tooltipped hoverable" data-position="bottom" data-tooltip="Fechar"><i class="material-icons">close</i></a></div><div class="floatingWindowContent"></div></div>');
    $("#floatingWindow").css("width", width);
    $("#floatingWindow").css("height", height);

    var windowHeight = $("#floatingWindow").height();
    windowHeight = windowHeight - 70;
    $(".floatingWindowContent").css("height",  windowHeight+"px");
    $("#floatingWindow").fadeIn(500);
}
function destroyFloatingWindow()
{
    $("#floatingWindow").fadeOut(500).complete(function(){
        $("#floatingWindow").remove();
    });
}
function loadPageOnWindow(windowTitle, width, height, url)
{
    $.ajax({
        url: url,
        type: 'GET',
        success: function(data)
        {
            createFloatingWindow(windowTitle, width, height);
            $("#floatingWindow .floatingWindowContent").html(data);
            $("#floatingWindow").resizable();
            $("#floatingWindow").draggable();
        }
    });
}
function deletarManifestacao(id)
{
    var conf = "Tem certeza que deseja excluir a manifestação de Id '"+id+"'?";
    if(confirm(conf))
    {
        showLoading();
        $.ajax({
            url: "scripts/deletar_manifestacao.php?id="+id,
            type: 'POST',
            success: function(data)
            {
                if(data == "ok")
                {
                    alert("Manifestação deletada com sucesso.");
                    closeLoading();
                    $(location).attr('href', '?page=dashboard');
                }else{
                    alert(data);
                    closeLoading();
                }
            }
        });
    }else{
        closeLoading();
    }
}
function deleterAcao(id)
{
    var conf = "Tem certeza que deseja excluir esta ação?";
    showLoading();
    if(confirm(conf))
    {
        $.ajax({
            url: 'scripts/deletar_acao.php?id='+id,
            type: 'POST',
            success: function(data)
            {
                if(data == 'ok')
                {
                    alert("Ação deletada com sucesso.");
                    window.location.reload();
                }else{
                    alert("Erro ao deletar a ação.\nAções de prorrogação de prazo não podem ser deletadas.");
                    closeLoading();
                }
            }
        });
    }else{
        closeLoading();
    }
}
function showLoading()
{
    $('#loadingCnt').fadeIn(300);
}
function closeLoading()
{
    $('#loadingCnt').fadeOut(300);
}
function loadLogin()
{
    $("#loginLoading").html('<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
}
function closeLoadLogin()
{
    $("#loginLoading").html('');
}