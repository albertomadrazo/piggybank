<?php require_once("../includes/initialize.php"); ?>
<?php if($session->is_logged_in()){ redirect_to("index.php"); }

if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $first_name = trim($_POST['first_name']);

    $new_user = User::sign_up($username, $password, $first_name);
    if($new_user){
        $session->login($username);
        redirect_to("index.php");
        // $message = "Hola {$username}, bienvenido.";
    } else{
        $message = "Este nombre de usuario ya fue tomado, elige otro.";
    }
} else{
    $username = "";
    $password = "";
    $first_name = "";
    $message = "";
}

?>


<h2>Sign Up</h2>

<form action="signup.php" method="post">
    Nombre de usuario<br>
    <input type="text" name="username"><br>
    Nombre<br>
    <input type="text" name="first_name"><br>
    Contrase&ntilde;a<br>
    <input type="password" name="password"><br>
    <button name="submit">Sign Up</button>
</form>