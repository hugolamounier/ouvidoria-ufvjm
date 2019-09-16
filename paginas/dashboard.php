<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="dashboard_toolbox z-depth-1 grey lighten-4 valign-wrapper">
                <ul>
                    <li><a onclick="location.href='?page=add_manifestacao'" class="waves-effect waves-light btn blue darken-4 hoverable"><i class="material-icons left">add</i>Inserir manifestação</a></li>
                </ul>
                <div class="search">
                    <input id="searchManifestacao" name="searchManifestacao">
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col s12">
            <div class="dashboard_sort valign-wrapper">
                <ul>
                    <lt><a onclick="loadScript('scripts/lista_manifestacoes.php', 'lManifestacoes');" class="btn-floating btn-medium waves-effect light-blue darken-4 tooltipped hoverable" data-position="bottom" data-tooltip="Atualizar"><i class="material-icons">refresh</i></a></lt>
                    <lt><a onclick="" class="btn-floating btn-medium waves-effect light-blue darken-4 tooltipped hoverable" data-position="bottom" data-tooltip="Agrupar por tipo"><i class="material-icons">group_work</i></a></lt>
                    <lt><a class="dropdown-trigger btn-floating btn-medium waves-effect light-blue darken-4 tooltipped hoverable" data-target="sortdrop" data-position="bottom" data-tooltip="Ordenar"><i class="material-icons">sort</i></a></lt>
                </ul>

                <!--- dropdown itens -->
                <ul id='sortdrop' class='dropdown-content'>
                    <li><a href="#!">Data Limite</a></li>
                    <li><a href="#!">Data de Recebimento</a></li>
                    <li><a href="#!">Tipo de Manifestação</a></li>
                    <li><a href="#!">Situação da Manifestação</a></li>
                </ul>
                <!--- dropdown end -->
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

        loadScript("scripts/lista_manifestacoes.php", "lManifestacoes");
  });
</script>