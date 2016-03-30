<?php require_once("../includes/initialize.php"); ?>

<?php include_layout_template("header.php"); ?>
<div class="container">
<div class="row">
<div class="btn-group" role="group" aria-label="...">
<?php 

if(isset($session->user_id)){
    $metas = json_decode(Ahorro::giveVariablesForTab($session->user_id));

    // Muestra links con las tablas
    foreach($metas as $meta){

            echo "<a href=\"#\" class=\"btn btn-default\">". $meta->meta_de_ahorro ."</a>";
    }
    
}
// al presionar el link
// Muestra una tabla con lo que llevas y lo que falta
// la fecha en que inicio y en la que termina

?>
</div>
<div class="well">
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Earum beatae repellendus id quo debitis possimus ipsum nam voluptas, non enim, perspiciatis atque soluta reprehenderit quis ad dolore cumque! Neque, magnam.</p>
</div>
</div>
<?php include_layout_template("footer.php"); ?>
