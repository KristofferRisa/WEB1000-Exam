<?php 
session_start();

include('./php/Logg.php');
$logg = new Logg();
  

$htmlmsg = "";

##Hent brukernavn og passord ved POST#Sjekk brukerinfo - Logg inn om bruker finnes
if ($_POST) {
    include('./php/User.php');
    $user = new User();
    
    $brukernavn = $_POST["brukernavn"];
    $password = $_POST["passord"];
    
    if ($user->Login($brukernavn, $password,$logg)) {
        $user->setUserCookie($brukernavn);
        
        $_SESSION["brukernavn"] = $brukernavn;
        
        header("Location: ./");
        
    }
    else {
        $responseMsg = "<div class='alert alert-error'>Feil brukernavn eller passord.</div>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AdminLTE 2 | Log in</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="./www/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="./www/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="./www/plugins/iCheck/square/blue.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition login-page">
    <div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>B</b>JARUM <b>A</b>IRLINES</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?php echo $htmlmsg ?>
        <p class="login-box-msg">Logg inn</p>
        <form method="POST">
        <div class="form-group has-feedback">
            <input type="email" class="form-control" placeholder="E-post" name="brukernavn">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Passord" name="passord">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
            <div class="checkbox icheck">
                <label>
                <div class="icheckbox_square-blue" aria-checked="false" aria-disabled="false" style="position: relative;">
                    <input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; border: 0px; opacity: 0; background: rgb(255, 255, 255);"></ins></div> Husk meg
                </label>
            </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat">Logg inn</button>
            </div>
            <!-- /.col -->
        </div>
        </form>
        
        <!-- /.social-auth-links -->
        <a href="#">Glemt passord</a><br>
        <a href="register.html" class="text-center">Register</a>
    </div>
    <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->
    <!-- jQuery 2.2.0 -->
    <script src="./www/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="./www/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="./www/plugins/iCheck/icheck.min.js"></script>
    <script>
    $(function () {
        $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
        });
    });
    </script>
</body>
</html>