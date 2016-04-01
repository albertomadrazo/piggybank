<?php 
require_once("initialize.php");

if(empty($_GET)){
    // TODO: que te diga forbidden
    redirect_to("..public/indeeex.php");
}else{
    // print_r($_GET);
    $redirect = "../public/".$_GET['redirect'];
    echo "/public/".$redirect;
    redirect_to($redirect);
}

?>