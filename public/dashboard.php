<?php require_once("../includes/initialize.php"); ?>

<?php include_layout_template("header.php"); ?>

<div class="container-fluid">
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

    <?php
    if(isset($session->user_id)){
        $user = User::find_by_id($session->user_id);

        echo "<div style=\"visibility:hidden\"id=\"user-id\">{$user->id}</div>";

        if($user){
            echo "<strong>Hola {$user->username}</strong><br>";

            $user_savings = Ahorro::get_by_user_id($user->id);
            $goal = array();

            foreach($user_savings as $meta){
                if($meta["meta_de_ahorro"] == "changos"){
                    // echo "<div>";
                    foreach($meta as $key => $value){
                        $goal[$key] = $value;
                    }
                    // echo "</div>";
                }
                $subgoal = array();
                foreach($meta as $key=>$value){
                    $subgoal[$key] = $value;
                }
                array_push($goal, $subgoal);
            }

            // $goal[] =
            // id, meta_de_ahorro, 
            // user_id, total, 
            // cantidad_a_abonar, periodo, 
            // intervalo, ahorro_parcial,
            // fecha_inicial, fecha_final,
            // tipo_de_ahorro

            $hoy = time();
            // $hoy = strtotime('+3 months');

            $num_de_intervalos = Tiempo::cantidad_de_intervalos(
                $goal['fecha_inicial'], 
                $goal['fecha_final'], 
                $goal['intervalo']
            );

            $intervalo_actual = (Tiempo::cantidad_de_intervalos($goal['fecha_inicial'], 
                strftime("%Y-%m-%d", $hoy), $goal['intervalo'])) + 1;

            $intervalos_faltantes = $num_de_intervalos - $intervalo_actual;
            $cantidad_faltante = $goal['total'] - $goal['ahorro_parcial'];

            // Calcula el tiempo desde el inicio hasta el ultimo intervalo
            $ultimo_intervalo = strtotime($goal['fecha_inicial']) + 
                                                (Tiempo::dia($goal['intervalo']));

            $plazo_vencido = Tiempo::plazo_vencido($ultimo_intervalo, 
                Tiempo::convertir_intervalo_a_texto($goal['intervalo']));

            $plazo_vencido = $hoy;

            if($plazo_vencido){
                echo "&iexcl;Es hora de ahorrar!<br><hr>";
            } else{
                echo "&iexcl;Est&aacute;s al d&iacute;a!<br>";
            }

            // echo $intervalo_actual;
            $deuda = 0;
            $abonos_al_corriente = $goal['cantidad_a_abonar'] * ($intervalo_actual);
            // echo "<br>{$abonos_al_corriente} -{$goal['ahorro_parcial']}<br>";

            if((int)$goal['ahorro_parcial'] >= (int)$abonos_al_corriente){
                $deuda = $abonos_al_corriente;


                if($deuda > $cantidad_faltante){
                    $deuda = $cantidad_faltante;
                }
                // echo "Estas al corriente<br>";
            } else{
                $deuda = $goal['cantidad_a_abonar'] + ($abonos_al_corriente - $goal['ahorro_parcial']);
                echo "Estamos aqui";
            }

    ?>

    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
    <h3>&iquest;Cu&aacute;nto deseas depositar?</h3>
    <form action="abonado.php" method="post">
        <input type="hidden" name="meta_de_ahorro" value="
                                        <?php echo $goal['meta_de_ahorro']; ?>">
        <input type="checkbox" id="abonar_todo" name="abono" value="<?php echo $deuda; ?>">
                    Todo lo que debo ($<span id="tab-deuda"><!-- $<?php echo $deuda; ?> --></span>).<br>
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
                <span id="tab-intervalo_a_texto"></span>
                <!-- <?php echo Tiempo::convertir_intervalo_a_texto($goal['intervalo']); ?> -->:
                 <b style="float: right"><span id="tab-intervalo_actual"></span><!-- <?php echo $intervalo_actual; ?> --></b>
                </div>
                <div>
                Restantes:
                <b style="float: right"><span id="tab-intervalos_faltantes"></span> <!-- <?php echo $intervalos_faltantes; ?> --></b>
                </div>
                <div>
                Tienes:
                <b style="float: right">$<span id="tab-ahorro_parcial"></span> <!-- <?php echo $goal['ahorro_parcial']; ?> --></b>
                </div>
                <div>
                Faltan:
                <b style="float: right">$<span id="tab-cantidad_faltante"></span> <!-- <?php echo $cantidad_faltante; ?> --></b>
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

    <ul class="nav nav-pills" id="metas_tabs"></ul>
    <div id="metas" class="tab-content"></div>
    
<?php include_layout_template("footer.php"); ?>
<script type="text/javascript" src="js/dashboard.js"></script>

