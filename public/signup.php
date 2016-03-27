<?php require_once("../includes/initialize.php"); ?>
<?php if($session->is_logged_in()){ redirect_to("index.php"); }

if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $first_name = trim($_POST['first_name']);
    // $email = trim()

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

<?php include_layout_template("header.php"); ?>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-md-offset-4 col-lg-offset-4 col-sm-offset-4 col-xs-8 col-xs-offset-2 my-form">
    <h2>Reg&iacute;strate</h2>    

    <form action="signup.php" method="post" role="form" id="signup-form">
        <div class="form-group">
            <label for="first_name">
            Nombre Completo<br>
            </label>
            <input type="text" class="form-control" name="first_name" id="first_name"><br>
        </div>
        <div class="form-group">
            <label for="username">
            Nombre de usuario<br>
            </label>
            <input type="text" class="form-control" name="username" id="username" ><br>
        </div>        
        <div class="form-group">
            <label for="email">
            Correo electr&oacute;nico<br>
            </label>
            <input type="email" class="form-control" name="email" id="email" ><br>
        </div>
        <div class="form-group">
            <label for="password">
            Contrase&ntilde;a<br>
            </label>
            <input type="password" class="form-control" name="password" id="password"><br>
        </div>
        <div class="form-group">
            <label for="confirm_password">
            Confirmar Contrase&ntilde;a<br>
            </label>
            <input type="password" class="form-control" name="confirm_password" id="confirm_password"><br>
        </div>
        <button class="btn btn-danger signup-button" type="submit" name="submit">Registrarse</button>
    </form>
    </div>
</div>
<?php include_layout_template("footer.php"); ?>
