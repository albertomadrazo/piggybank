<?php require_once("../includes/initialize.php"); ?>
<?php include_layout_template("header.php"); ?>

<?php
if(isset($session->user_id) && isset($_POST)){
    $user = User::find_by_id($session->user_id);
    // echo "<h3>Gracias ".$user->get_name_in_array()[0]."</h3><br>";
    // echo $user->id."<br>";
    output_message($session->get_message());

    // Obtener el row para sacarle unos datos y poder actualizar de acuerdo
    $sql = "SELECT * FROM ahorro WHERE user_id ='";
    $sql .= $user->id;
    $sql .= "' AND slug='";
    $sql .= $_POST['slug']."'";

    $user_savings = Ahorro::find_by_sql($sql);

    // print_r($user_savings);

    if(!empty($_POST['abonar_parte'])){
        $abono = $_POST['abonar_parte'];
    } else{
        $abono = (int)$_POST['abonar_todo'];
    }

    echo $user_savings[0]['meta_de_ahorro']."<br>";
    $suma = $user_savings[0]['ahorro_parcial'] + $abono;

    Ahorro::update_savings($suma, $_POST['slug'], $user->id );
    $message = "Has abonado {$abono} a tu meta de {$user_savings[0]['meta_de_ahorro']}.";
    $session->set_message($message);
    redirect_to("dashboard.php");
} else{
    redirect_to("login.php");
}
?>

<div class="container-fluid">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8 col-lg-offset-3 col-md-offset-3 col-sm-offset-3 col-xs-offset-2">
            <h3>Gracias <?php echo $user->get_name_in_array()[0]; ?>.</h3><br>

            <p>Has abonado <?php echo $abono; ?> a tu meta de <?php echo $user_savings[0]['meta_de_ahorro']; ?></p>
            <!-- <div class="btn-group" role="group" aria-label="..."> -->
                <a href="dashboard.php" class="btn btn-default">Seguir ahorrando</a>
                <a href="logout.php" class="btn btn-default">Salir</a>
            <!-- </div> -->
    </div>
</div>