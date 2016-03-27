<?php require_once("../includes/initialize.php"); ?>

<?php
    if(isset($session->user_id)){
        $session->logout();
        redirect_to("login.php");
    }
?>