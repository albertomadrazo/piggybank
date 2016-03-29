<?php require_once("../includes/initialize.php"); ?>
<?php include_layout_template("header.php"); ?>

<?php
if(isset($session->user_id)){
    $user = User::find_by_id($session->user_id);
    echo $user->username."<br>";
    echo $user->id."<br>";
    output_message($session->get_message());
    if(isset($_POST)){
        print_r($_POST);
    }

    $sql = "SELECT * FROM ahorro WHERE user_id ='";
    $sql .= $user->id;
    $sql .= "' AND slug='";
    $sql .= $_POST['meta_de_ahorro']."'";

    $user_savings = Ahorro::find_by_sql($sql);

    if(!empty($_POST['abonar_parte'])){
        echo "true<br>";
        echo $_POST['abonar_parte']."<br>";
        $abono = $_POST['abonar_parte'];
    } else{
        echo "Vergas";
        echo "false<br>".$_POST['abonar_todo']."<br>";
        echo gettype($_POST['abonar_parte'])."<br>";

        $abono = (int)$_POST['abonar_todo'];
    }

    echo "<br>abono = ".$abono."<br>";
    $suma = $user_savings[0]['ahorro_parcial'] + $abono;
    echo"<hr>";

    Ahorro::update_savings($suma, $_POST['meta_de_ahorro'], $user->id );
}

?>