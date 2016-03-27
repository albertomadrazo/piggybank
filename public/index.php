<?php require_once("../includes/initialize.php"); ?>

<?php include_layout_template("header.php"); ?>


<?php

if(isset($_POST['submit'])){
    if(isset($session->user_id)){
        $user = User::find_by_id($session->user_id);
    } else {
        redirect_to("login.php");
    }

    $cantidad = $_POST['cantidad'];

    $desde = $_POST['fecha-inicial'];
    $hasta = $_POST['fecha-final'];

    $intervalo = $_POST['intervalo'];

    $meta_ahorro = $_POST['meta_ahorro'];

    $periodo = Tiempo::calcular_periodo($desde, $hasta);

    $calculo = new Calculo($cantidad, $periodo, $intervalo);
    $calculo->linear_savings();

    $tiempo = new Tiempo();

    $ahorro = new Ahorro($user->id, $meta_ahorro, $cantidad, $calculo->abono, $periodo, $calculo->intervalo, 0, $desde, $hasta, "linear");

    $ahorro->save();

    echo "Intervalo: $" . $calculo->abono . " cada ";
    echo Tiempo::convertir_intervalo_a_texto($calculo->intervalo);
    echo ($calculo->residuo > 0) ?" y un abono extra de {$calculo->residuo}" : "";
} else{

    if(isset($_POST['logout'])){
        $session->logout();
    }

    if(!isset($session->user_id)){
        redirect_to("login.php");
    } else{
        $user = User::find_by_id($session->user_id);
    }
?>

<div class="container">

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php 
echo "<span class=\"navbar-brand\"><strong>Hola {$user->username}</strong></span>";
echo "<span class=\"error\">{$session->get_message()}</span>";
$session->set_message("");
?>  

</div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 my-form">
        <form action="index.php"  method="post">
            <input type="text" class="form-control my-input" name="meta_ahorro" placeholder="C&oacute;mo se llama tu meta?" /><br>
            <input type="text" class="form-control my-input" name="cantidad" placeholder="&iquest;Cu&aacute;nto quieres ahorrar?" /><br>     

            <!-- Desde el d&iacute;a: <br> -->
            <input type="text" class="form-control my-input" name="fecha-inicial" id="date_picker1" placeholder="Desde el d&iacute;a"><br>
            <input type="text" class="form-control my-input" name="fecha-final" id="date_picker2" placeholder="Hasta el d&iacute;a"><br>        

            <strong>&iquest;Cada cu&aacute;ndo vas a abonar?</strong><br>
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    Diario<br class="visible-md visible-lg">
                    <label for="radio-diario">
                    <input type="radio" id="radio-diario" name="intervalo" value="1">
                    </label><br class="visible-md visible-lg"> 
                </div>    
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    Semanal<br class="visible-md visible-lg">
                    <label for="radio-semanal">
                    <input type="radio" id="radio-semanal" name="intervalo" value="7">
                    </label><br>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    Mensual<br class="visible-md visible-lg">
                    <label for="radio-mensual">
                    <input type="radio" id="radio-mensual" name="intervalo" value="30">
                    </label><br>                    
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    Anual<br class="visible-md visible-lg">
                    <label for="radio-anual">
                    <input type="radio" id="radio-anual" name="intervalo" value="365">
                    </label><br>        
                </div>
            </div>

            <button class="btn btn-danger submit-button my-btn" type="submit" name="submit">Guardar Meta</button>
            <br class="my-clear">
        </form>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 visible-lg visible-md visible-sm">
        <div class="well my-well"><p><i>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident repellat nesciunt unde, impedit, vel repellendus quo ipsum, error non adipisci vero! Rerum aperiam, nisi tempora perferendis in quia accusamus. <br><br>
        At, porro, assumenda incidunt facere qui sit dicta accusantium unde, adipisci quasi id est nesciunt sunt, et sed deserunt reiciendis nisi!</i></p></div>
    </div>
</div>

<?php
}
?>

<?php include_layout_template("footer.php"); ?>
