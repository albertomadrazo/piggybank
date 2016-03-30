<?php require_once("../includes/initialize.php"); ?>

<?php

if(isset($_REQUEST['user_id'])){
    echo Ahorro::giveVariablesForTab($_REQUEST['user_id']);
} else{
    echo "FORBIDDEN!";
    // redirect_to("dashboard.php");
}

?>