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
function postForm(url, formId)
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
                $(location).attr('href', '?page=dashboard');
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
(function($){
    $.fn.createPdf = function(parametros) {
        
        var config = {              
            'fileName':'html-to-pdf'
        };
        
        if (parametros){
            $.extend(config, parametros);
        }                            

        var quotes = document.getElementById($(this).attr('id'));

        html2canvas(quotes, {
            onrendered: function(canvas) {
                var pdf = new jsPDF('p', 'pt', 'letter');

                for (var i = 0; i <= quotes.clientHeight/980; i++) {
                    var srcImg  = canvas;
                    var sX      = 0;
                    var sY      = 980*i;
                    var sWidth  = 900;
                    var sHeight = 980;
                    var dX      = 0;
                    var dY      = 0;
                    var dWidth  = 900;
                    var dHeight = 980;

                    window.onePageCanvas = document.createElement("canvas");
                    onePageCanvas.setAttribute('width', 900);
                    onePageCanvas.setAttribute('height', 980);
                    var ctx = onePageCanvas.getContext('2d');
                    ctx.drawImage(srcImg,sX,sY,sWidth,sHeight,dX,dY,dWidth,dHeight);

                    var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);
                    var width         = onePageCanvas.width;
                    var height        = onePageCanvas.clientHeight;

                    if (i > 0) {
                        pdf.addPage(612, 791);
                    }

                    pdf.setPage(i+1);
                    pdf.addImage(canvasDataURL, 'PNG', 20, 40, (width*.62), (height*.62));
                }

                pdf.save(config.fileName);
            }
        });
    };
})(jQuery);
 

function createPDF(containerId) {
    $('#'+containerId).createPdf({
        'fileName' : 'testePDF'
    });
}