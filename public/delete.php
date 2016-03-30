<?php require_once("../includes/initialize.php"); ?>

<?php include_layout_template("header.php"); ?>
<div class="container">
<div class="row">

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
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

                echo "<h2><strong>Hola {$user->get_name_in_array()[0]}</strong>,<br> &iquest;Qu&eacute; meta quieres borrar?<br></h2>";
                $om = output_message($session->get_message());
                echo $om;
                "<br>";
                $user_savings = Ahorro::get_by_user_id($user->id);
                $goal = array();

                if(isset($_POST['slug'])){
                    $slug = $_POST['slug'];

                    $deleted_goal = Ahorro::delete_goal($user->id, $slug);

                    if($deleted_goal){
                        $session->set_message("Has borrado la tabla {$_POST['slug']}.");
                        redirect_to("dashboard.php");
                    } else{
                        $session->set_message("No se ha podido borrar la tabla {$_POST['slug']}");
                    }
                }

            } else{
                redirect_to("login.php");
            }
        } else{
            redirect_to("login.php");
        }
        ?>

        <div id="metas" class="tab-content"></div>   
        <ul class="nav nav-tabs " id="metas_tabs"></ul>

        <div class="tabla-estadistica">
            <div class="tabla-de-ahorros">
                <div><h4>Estad&iacute;sticas <span id="tab-meta_de_ahorro"></span> </h4>
                <!-- <input type="hidden" id="hidden-meta_de_ahorro" name="slug" value=""> -->
                </div>
                <div>
                <span id="tab-intervalo_a_texto"></span>:
                 <b style="float: right"><span id="tab-intervalo_actual"></span></b>
                </div>
                <div>
                Restantes:
                <b style="float: right"><span id="tab-intervalos_faltantes"></span></b>
                </div>
                <div>
                Tienes:
                <b style="float: right">$<span id="tab-ahorro_parcial"></span></b>
                </div>
                <div>
                Faltan:
                <b style="float: right">$<span id="tab-cantidad_faltante"></span></b>
                </div>
            </div>
        </div>
        <form method="post" action="delete.php">
            <button class="btn btn-default submit-button" id="hidden-meta_de_ahorro" name="slug" value="">Eliminar</button>
        </form>
    </div>

</div> <!-- row -->
</div> <!-- container -->


<?php include_layout_template("footer.php"); ?>
<script type="text/javascript" src="js/delete.js"></script>