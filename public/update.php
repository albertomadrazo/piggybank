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

    $slug = Ahorro::slugify($meta_ahorro);
    $to_update = $_POST['to_update'];

    $ahorro = new Ahorro($user->id, $meta_ahorro, $slug, $cantidad, $calculo->abono, $periodo, $calculo->intervalo, 0, $desde, $hasta, "linear");

    $ahorro->update($to_update);

    $session->set_message("Has actualizado la meta {$meta_ahorro}.");
    redirect_to("dashboard.php");
} else{

    if(isset($_POST['logout'])){
        $session->logout();
    }

    if(!isset($session->user_id)){
        redirect_to("login.php");
    }
?>

<div class="container">

<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
<?php 
echo "<span class=\"navbar-brand\"><strong>Actualiza tus metas</span>";
output_message($session->get_message());
$session->set_message(" ");

?>  

</div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 my-form">
    <?php 
        $user = User::find_by_id($session->user_id);

        $sql = "SELECT * FROM ahorro WHERE user_id='";
        $sql .= $user->id."'";  

        $ahorro_fields = Ahorro::find_by_sql($sql);

        echo " <div class=\"btn-group\">";
        foreach($ahorro_fields as $key){
            echo "<button type=\"button\" class=\"btn btn-default meta_to_update\">{$key['meta_de_ahorro']}</button>";
            echo "<input type=\"hidden\" id=\"{$key['slug']}\" ";
            echo "data-slug=\"{$key['slug']}\" ";
            echo "data-meta_de_ahorro=\"{$key['meta_de_ahorro']}\" ";
            echo "data-total=\"{$key['total']}\" ";
            echo "data-fecha_inicial=\"{$key['fecha_inicial']}\" ";
            echo "data-fecha_final=\"{$key['fecha_final']}\" ";
            echo "/>";
        }
        echo "</div><br><br>";
    ?>
        <form action="update.php"  method="post">
            <input type="hidden" id="to_update" name="to_update">
            <input type="text" class="form-control my-input field-to-update" name="meta_ahorro" id="meta_de_ahorro" placeholder="C&oacute;mo se llama tu meta?"/><br>
            <span class="error my_message"></span>
            <input type="text" class="form-control my-input is-int field-to-update" id="total" name="cantidad" placeholder="&iquest;Cu&aacute;nto quieres ahorrar?"/><br>     
            <input type="text" class="form-control my-input is-int field-to-update date_picker1" name="fecha-inicial" id="fecha_inicial" placeholder="Desde el d&iacute;a"><br>
            <input type="text" class="form-control my-input is-int field-to-update date_picker2" name="fecha-final" id="fecha_final" placeholder="Hasta el d&iacute;a"><br>        

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

            <button class="btn btn-danger submit-button my-btn" type="submit" name="submit" >Actualiza tu Meta</button>
            <br class="my-clear">
        </form>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 visible-lg visible-md visible-sm">
        <div class="well my-well">
            <p class="cita">
                <i>
                    <q>
                    <?php 
                        $cita = Cita::get_random_quote();
                        echo $cita->texto;
                    ?>
                    </q>
                </i>
            </p>
            <p class="autor">
                <?php echo $cita->autor; ?> 
            </p>
        </div>
    </div>
</div>


<?php } ?>

<?php include_layout_template("footer.php"); ?>
<script type="text/javascript" src="js/update.js"></script>