<div class="container">
    <div class="row">
        <div class="col s12">
            <div class="dashboard_toolbox z-depth-1 grey lighten-4 valign-wrapper">
                <ul>
                    <li><a class="waves-effect waves-light btn blue darken-4 hoverable"><i class="material-icons left">add</i>Inserir manifestação</a></li>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col s12">
            <div class="dashboard_sort valign-wrapper">
                <ul>
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
                <div class="manifestacoes_wrapper">
                    <!-- Lista de manifestações -->
                    <div class="manifestacoes">
                        <div class="row">
                            <div class="col s2"><span>Cód. Manifestação:</span> <p>1032304</p></div>
                            <div class="col s2"><span>NUP:</span> <p>08231.123410/2019-01</p></div>
                            <div class="col s2"><span>Tipo de Manifestação:</span> <p class="orange-text text-darken-1">Reclamação</p></div>
                            <div class="col s3"><span>Assunto:</span> <p>12324434343</p></div>
                            <div class="col s2"><span>Data de Recebimento:</span> <p>20/10/2019</p></div>
                            <div class="col s1"><span>Data Limite:</span> <p>20/11/2019</p></div>
                        </div>
                        <a class="dropdown-trigger blue-grey tooltipped" data-position="bottom" data-tooltip="Visualização rápida"><i class="material-icons">pageview</i></a>
                    </div>

                    <div class="manifestacoes">
                        <div class="row">
                            <div class="col s2"><span>Cód. Manifestação:</span> <p>1032304</p></div>
                            <div class="col s2"><span>NUP:</span> <p>08231.123410/2019-01</p></div>
                            <div class="col s2"><span>Tipo de Manifestação:</span> <p class="orange-text text-darken-1">Reclamação</p></div>
                            <div class="col s3"><span>Assunto:</span> <p>12324434343</p></div>
                            <div class="col s2"><span>Data de Recebimento:</span> <p>20/10/2019</p></div>
                            <div class="col s1"><span>Data Limite:</span> <p>20/11/2019</p></div>
                        </div>
                        <a class="dropdown-trigger blue-grey tooltipped" data-position="bottom" data-tooltip="Visualização rápida"><i class="material-icons">pageview</i></a>
                    </div>
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
  });
  $(".manifestacoes").on("click", function(e){
      
  });
</script>