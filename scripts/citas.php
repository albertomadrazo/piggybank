<?php require_once("../includes/initialize.php"); ?>

<?php
$citas = array(

["El más rico de todos los hombres es el ahorrativo; el más pobre, el avaro.",
"Chamfort"],

["El camino hacía la riqueza depende fundamentalmente de dos palabras: trabajo y ahorro.",
"Benjamin Franklin"],

["Ahorrar no es sólo guardar sino saber gastar.",
"Anónimo"],

["Ahorrar y más ahorra, que contigo vive quien lo ha de gastar.",
"Anónimo"],

["El que trabaja principia bien, el que ahorra termina mejor",
"Anónimo"],

["La técnica es el esfuerzo para ahorrar esfuerzo.",
"José Ortega y Gasset"]

);

foreach($citas as $cita){
    $cita = new Cita(1, $cita[0], $cita[1]);
    $cita->save();
    // $cita->save();
    print_r($cita);
    echo "<br>";
}

?>