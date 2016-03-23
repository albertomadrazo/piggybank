<?php require_once("../includes/initialize.php"); ?>

<?php include_layout_template("header.php"); ?>

<div class="container-fluid">
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">

    <?php
    if(isset($session->user_id)){
        $user = User::find_by_id($session->user_id);

        echo "<div style=\"visibility:hidden\"id=\"user-id\">{$user->id}</div>";

        if($user){
            echo "<strong>Hola {$user->username}</strong><br>";

            $user_savings = Ahorro::get_by_user_id($user->id);
            $goal = array();
    ?>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <ul class="nav nav-pills" id="metas_tabs"></ul>
        <div id="metas" class="tab-content"></div>   
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <h3>&iquest;Cu&aacute;nto deseas depositar?</h3>
    <form action="abonado.php" method="post">
        <input type="hidden" id="hidden-meta_de_ahorro" name="meta_de_ahorro" value="">
        <input type="checkbox" id="hidden-abonar_todo" name="abono" value="">
                    Todo lo que debo ($<span id="tab-deuda"></span>).<br>
        <input type="checkbox" id="una_parte"> Una parte.
        <input type="text" id="una_parte_cantidad" class="form-control my-input">
        <button class="btn btn-danger submit-button">Ahorrar!</button>
    </form>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <div class="tabla-estadistica">
            <div class="tabla-de-ahorros">
                <div><h4>Estad&iacute;sticas <span id="tab-meta_de_ahorro"></span> </h4></div>
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
    </div>
</div>
</div>
        <?php
        } else{
            redirect_to("login.php");
        }
    } else{
        redirect_to("login.php");
    }

?>
    
<?php include_layout_template("footer.php"); ?>
<script type="text/javascript" src="js/dashboard.js"></script>

