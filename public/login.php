<?php
require_once("../includes/initialize.php");
if($session->is_logged_in()){ redirect_to("index.php"); }

if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $found_user = User::authenticate($username, $password);

    if($found_user){
        $session->login($found_user);
        redirect_to("index.php");
    } else{
        echo "Nombre de usuario o contrase&ntilde;a equivocados.";
        $message = "Nombre de usuario o contrase&ntilde;a equivocados.";
    }
} else {
    $username = "";
    $password = "";
}

?>

<form action="login.php" method="post">
    usuario<br>
    <input type="text" name="username"><br>
    contrase&ntilde;a<br>
    <input type="password" name="password"><br>
    <button name="submit">Entrar</button>
</form>

<?php if(isset($database)) { $database->close_connection(); } ?>
