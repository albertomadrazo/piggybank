<?php require_once("../includes/initialize.php"); ?>

<?php
// funcion que regresa un array de arrays que contienen
// los campos con las variables de cada meta
function giveVariablesForTab($id){
    $user_savings = Ahorro::get_by_user_id($id);
    $goal = array();
    $subgoal = array();

    foreach($user_savings as $meta){
        $subgoal = array();
        foreach($meta as $key=>$value){
            $subgoal[$key] = $value;
        }
        array_push($goal, $subgoal);
    }

    return json_encode($goal);
}

// echo giveVariablesForTab($_REQUEST['user_id']);

if(isset($_REQUEST['user_id'])){
    echo giveVariablesForTab($_REQUEST['user_id']);
} else{
    echo "FORBIDDEN!";
    // redirect_to("dashboard.php");
}

?>