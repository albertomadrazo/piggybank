<?php require_once("../includes/initialize.php"); ?>

<?php include_layout_template("header.php"); ?>

<div class="container-fluid">
    <div class="row">

        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 joco col-md-offset-1 col-lg-offset-1 col-sm-offset-1 col-xs-8 col-xs-offset-2">
            <span class="msg"></span>
            <?php
            if(isset($session->user_id)){
                $user = User::find_by_id($session->user_id);        

                echo "<div style=\"visibility:hidden\" id=\"user-id\">{$user->id}</div>";

                if($user){
                    $contar_metas = count(json_decode(Ahorro::giveVariablesForTab($user->id)));
                    if($contar_metas == 0){
                        $session->set_message("Escribe una meta de ahorro.");
                        redirect_to("index.php");
                    }

                    echo "<strong>Hola {$user->get_name_in_array()[0]}</strong>";
                        $om = output_message($session->get_message());
                        $session->set_message(" ");
                        echo $om;
                    "<br>";
                    $user_savings = Ahorro::get_by_user_id($user->id);
                    $goal = array();

                } else{
                    redirect_to("login.php");
                }
            } else{
                redirect_to("login.php");
            }
            ?>
            <br><span id="al_dia"> </span>
            <h3>&iquest;Cu&aacute;nto deseas depositar?</h3>
            <form action="abonado.php" method="post" onsubmit="canSubmit();">
                <input type="hidden" class="is-int" id="hidden-meta_de_ahorro" name="slug" value="">
                <input type="checkbox" id="abonar_todo">
                <input type="hidden" id="hidden-abonar_todo" name="abonar_todo" value="0">
                            <label for="abonar_todo" class="my-p">Todo lo que debo (<span id="tab-deuda"></span>).</label><br>
                <input type="checkbox" id="una_parte"> <label for="una_parte" class="my-p">Una parte.</label>
                <span class="error my_message"></span>
                <input type="number" min="0" step="1" id="una_parte_cantidad" class="form-control my-input is-int" name="abonar_parte">
                <br class="visible-md visible-lg visible-sm visible-xs">
                <button class="btn btn-danger submit-button">Ahorrar!</button>
            </form>
        </div>

        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-10 col-xs-offset-1 joco" >

            <div id="metas" class="tab-content"></div>   
            <ul class="nav nav-tabs " id="metas_tabs"></ul>

            <div class="tabla-estadistica">
                <div class="tabla-de-ahorros">
                    <div><h4><span id="tab-meta_de_ahorro"></span> </h4></div>
                    <div>
                    <span id="tab-intervalo_a_texto"></span>
                     <b style="float: right"><span id="tab-intervalo_actual"></span></b>
                    </div>
                    <div>
                    Restantes:
                    <b style="float: right"><span id="tab-intervalos_faltantes"></span></b>
                    </div>
                    <div>
                    Tienes:
                    <b style="float: right"><span id="tab-ahorro_parcial"></span></b>
                    </div>
                    <div>
                    Faltan:
                    <b style="float: right"><span id="tab-cantidad_faltante"></span></b>
                    </div>
                </div>
            </div>
                
        </div>

    </div>
</div>


        <?php


?>

<?php include_layout_template("footer.php"); ?>
<script type="text/javascript" src="js/dashboard.js"></script>
