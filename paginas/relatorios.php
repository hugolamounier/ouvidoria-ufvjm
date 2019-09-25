<?php

?>
<script src="js/canvasjs.min.js"></script>
<div class="title">
    <i class="material-icons left">content_paste</i>
    <span class="blue-grey-text text-darken-3">Relatórios</span>
</div>
<div class="container">
    <div class='row'>
        <div class='col s12'><div id='status_box' class='report_box z-depth-1'></div></div>
        
    </div>
    <div class="row">
        <div class="col s4">
            <div class='report_box z-depth-1'>
                <div class='box_title blue-grey-text text-darken-2'><span>Manifestações</span></div>
            </div>
        </div>
        <div class="col s4">
            <div class='report_box z-depth-1'>

            </div>
        </div>
        <div class="col s4"><div class='report_box z-depth-1'></div></div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $("#status_box").css("height", '60px');
    });
</script>