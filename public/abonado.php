<?php require_once("../includes/initialize.php"); ?>
<?php include_layout_template("header.php"); ?>

<?php
if(isset($session->user_id)){
    $user = User::find_by_id($session->user_id);
    echo $user->username."<br>";
    if(isset($_POST)){
        // print_r($_POST);
    }

    $sql = "SELECT * FROM ahorro WHERE user_id ='";
    $sql .= $user->id;
    $sql .= "' AND meta_de_ahorro='";
    $sql .= $_POST['meta_de_ahorro']."'";

    $user_savings = Ahorro::find_by_sql($sql);

    // print_r($user_savings);

    // foreach($user_savings[0] as $key=>$value){
    //     echo "###<br>";
    //     // echo $key;
    //     echo $key." = ".$value;   
    //     // print_r($value);
    //     echo "###<br>";
    // }
    $suma = $user_savings[0]['ahorro_parcial'] + $_POST['abono'];
    echo"<hr>";
    // $args_array = array();
    // foreach($_POST as $key => $value){
    //     if($key == 'abono' && $key == 'meta_de_ahorro'){
    //         $args_array[] = $key => $value;
    //     }
    // }

    // llamar ahorro parcial y sumarle el abono


    Ahorro::update_savings($suma, $_POST['meta_de_ahorro'] );
}

?>