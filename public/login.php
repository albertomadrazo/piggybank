<?php
require_once("../includes/initialize.php");
if($session->is_logged_in()){ redirect_to("index.php"); }

if(isset($_POST['submit'])){
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $found_user = User::authenticate($username, $password);

    if($found_user){
        $session->login($found_user);
        $session->set_message("");
        redirect_to("dashboard.php");
    } else{
        // print_r($session);
        $message = "Nombre de usuario o contrase&ntilde;a equivocados.";
        $session->set_message($message);
        output_message($session->get_message());
        // echo $message;
    }
} else {
    $username = "";
    $password = "";
    $session->set_message(" ");
}

?>

<?php include_layout_template("header.php"); ?>
<div class="row">
    <div class="col-lg-4 col-md-4 col-sm-4 col-md-offset-4 col-lg-offset-4 col-sm-offset-4 col-xs-8 col-xs-offset-2 my-form">    
        <h2>Inicia Sesi&oacute;n</h2>
        <?php echo output_message($session->get_message()); ?>
        <form action="login.php" method="post" role="form" id="signup-form">
            <div class="form-group">
                <label for="username">        
                usuario<br>
                </label>
                <input type="text" class="form-control" name="username" id="username"><br>
            </div>

            <div class="form-group">
                <label for="password">
                contrase&ntilde;a<br>
                </label>
                <input type="password" class="form-control" name="password" id="password"><br>
            </div>
            <button class="btn btn-danger signup-button" name="submit">Entrar</button>
        </form>
    </div>
</div>

<?php include_layout_template("footer.php"); ?>

<script type="text/javascript" src="js/jquery.validate.js"></script>
