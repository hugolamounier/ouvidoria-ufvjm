<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="dashboard_toolbox valign-wrapper">
                <ul>
                    <li><a onclick="location.href='?page=add_manifestacao'" class="waves-effect waves-light btn blue darken-4 hoverable"><i class="material-icons left">add</i>Inserir manifestação</a></li>
                </ul>
                <div class="search">
                    <input id="searchManifestacao" type="text"  name="searchManifestacao" placeholder="Digite sua pesquisa">
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col s12">
            <div class="dashboard_sort valign-wrapper">
                <ul class="z-depth-1">
                    <lt><a onclick="loadScript('scripts/lista_manifestacoes.php', 'lManifestacoes');" class="btn-floating btn-medium waves-effect light-blue darken-4 tooltipped hoverable" data-position="bottom" data-tooltip="Atualizar"><i class="material-icons">refresh</i></a></lt>
                    <!-- <lt><a class="dropdown-trigger btn-floating btn-medium waves-effect light-blue darken-4 tooltipped hoverable" data-target="groupdrop" data-position="bottom" data-tooltip="Agrupar por tipo"><i class="material-icons">group_work</i></a></lt> -->
                    <lt><a class="dropdown-trigger btn-floating btn-medium waves-effect light-blue darken-4 tooltipped hoverable" data-target="sortdrop" data-position="bottom" data-tooltip="Ordenar"><i class="material-icons">sort</i></a></lt>
                <!--- dropdown itens -->
                    <ul id='sortdrop' class='dropdown-content'>
                        <li><a onclick="loadScript('scripts/lista_manifestacoes.php', 'lManifestacoes');">Ordenar por Código</a></li>
                        <li><a sort='datalimiteAsc'>Data Limite (Crescente)</a></li>
                        <li><a sort='datalimiteDesc'>Data Limite (Decrescente)</a></li>
                        <li><a sort='datarecebimentoAsc'>Data de Recebimento (Crescente)</a></li>
                        <li><a sort='datarecebimentoDesc'>Data de Recebimento (Decrescente)</a></li>
                    </ul>
                </ul>

                <!-- <ul id='groupdrop' class='dropdown-content'>
                    <li><a onclick="loadScript('scripts/lista_manifestacoes.php', 'lManifestacoes');">Todos os tipos</a></li>
                    <li><a onclick="loadScript('scripts/lista_manifestacoes.php?tipo=1', 'lManifestacoes');">Denúncia</a></li>
                    <li><a onclick="loadScript('scripts/lista_manifestacoes.php?tipo=2', 'lManifestacoes');">Reclamação</a></li>
                    <li><a onclick="loadScript('scripts/lista_manifestacoes.php?tipo=3', 'lManifestacoes');">Solicitação</a></li>
                    <li><a onclick="loadScript('scripts/lista_manifestacoes.php?tipo=4', 'lManifestacoes');">Sugestão</a></li>
                    <li><a onclick="loadScript('scripts/lista_manifestacoes.php?tipo=5', 'lManifestacoes');">Elogio</a></li>
                </ul> -->
                <!--- dropdown end -->
                <div class='legenda z-depth-1'>
                    <div class="tipo_manifestacao" onclick="loadScript('scripts/lista_manifestacoes.php', 'lManifestacoes');location.href='#tipo=0'"><div class="grey lighten-1"></div><span>Todas</span></div>
                    <div class="tipo_manifestacao" onclick="loadScript('scripts/lista_manifestacoes.php?tipo=1', 'lManifestacoes');location.href='#tipo=1'"><div class="red darken-1"></div><span>Denúncia</span></div>
                    <div class="tipo_manifestacao" onclick="loadScript('scripts/lista_manifestacoes.php?tipo=2', 'lManifestacoes');location.href='#tipo=2'"><div class="orange darken-2"></div><span>Reclamação</span></div>
                    <div class="tipo_manifestacao" onclick="loadScript('scripts/lista_manifestacoes.php?tipo=3', 'lManifestacoes');location.href='#tipo=3'"><div class="green darken-1"></div><span>Solicitação</span></div>
                    <div class="tipo_manifestacao" onclick="loadScript('scripts/lista_manifestacoes.php?tipo=4', 'lManifestacoes');location.href='#tipo=4'"><div class="yellow lighten-1"></div><span>Sugestão</span></div>
                    <div class="tipo_manifestacao" onclick="loadScript('scripts/lista_manifestacoes.php?tipo=5', 'lManifestacoes');location.href='#tipo=5'"><div class="pink accent-2"></div><span>Elogio</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Container das manifestações -->
    <section id="listaManifestacoes">
        <div class="row">
            <div class="col s12 m12 l12 xl12">
                <div class="manifestacoes_wrapper" id="lManifestacoes">
                    <!-- Lista de manifestações -->
                    <!-- Fim -->
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function(){
        $('.tooltipped').tooltip();
        $('.dropdown-trigger').dropdown({
            constrainWidth: false,
            alignment: "right",
        });

        if(getUrlHash('tipo') == null || getUrlHash('tipo') == 0)
        {
            loadScript("scripts/lista_manifestacoes.php", "lManifestacoes");
        }else{
            loadScript("scripts/lista_manifestacoes.php?tipo="+getUrlHash('tipo'), "lManifestacoes");
        }


        $("#searchManifestacao").keyup(function(){
            if($(this).val() == '')
            {
                loadScript("scripts/lista_manifestacoes.php", "lManifestacoes");
            }
        //         loadScript("scripts/lista_manifestacoes.php?p="+$(this).val(), "lManifestacoes");
        //         $("#pesquisaQuery span").html("Resultado pesquisa: "+$(this).val());
        //     }
        });

        $(document).on("keypress", function(e){
            if(e.which == 13)
            {
                loadScript("scripts/lista_manifestacoes.php?p="+$("#searchManifestacao").val(), "lManifestacoes");
            }
        });

        $("a[sort='datalimiteAsc']").on("click", function(e){
            e.preventDefault();
            var tipo = getUrlHash('tipo');
            if(tipo == null)
            {
                tipo = 0;
            }
            loadScript('scripts/lista_manifestacoes.php?sort=datalimiteAsc&tipo='+tipo, 'lManifestacoes');
        });
        $("a[sort='datalimiteDesc']").on("click", function(e){
            e.preventDefault();
            var tipo = getUrlHash('tipo');
            if(tipo == null)
            {
                tipo = 0;
            }
            loadScript('scripts/lista_manifestacoes.php?sort=datalimiteDesc&tipo='+tipo, 'lManifestacoes');
        });
        $("a[sort='datarecebimentoAsc']").on("click", function(e){
            e.preventDefault();
            var tipo = getUrlHash('tipo');
            if(tipo == null)
            {
                tipo = 0;
            }
            loadScript('scripts/lista_manifestacoes.php?sort=datarecebimentoAsc&tipo='+tipo, 'lManifestacoes');
        });
        $("a[sort='datarecebimentoDesc']").on("click", function(e){
            e.preventDefault();
            var tipo = getUrlHash('tipo');
            if(tipo == null)
            {
                tipo = 0;
            }
            loadScript('scripts/lista_manifestacoes.php?sort=datarecebimentoDesc&tipo='+tipo, 'lManifestacoes');
        });

  });
</script>