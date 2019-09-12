function login(url, formId)
{
    $.ajax({
        url: 'scripts/login.php',
        type: 'POST',
        data: $("#loginForm").serialize(),
        success: function(data)
        {
            if(data == "ok")
            {
                window.location.reload();
            }else{
                alert(data);
            }
        }
    });
}
function postForm(url, formId)
{
    $.ajax({
        url: '',
        type: 'POST',
        data: $("#"+formId).serialize(),
        success: function(data)
        {

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