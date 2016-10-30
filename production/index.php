<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>mirHACKle|Login</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.min.css" rel="stylesheet">

    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery-ui.js"></script>
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form class="form_login">
              <h1 style="font-size: 1.1em;"><span style="font-size : 1.3em;">mirHACKle</span> sur le serveur <span style="font-size: 1.3em;"><?= $_SERVER['SERVER_ADDR'] ?></span></h1>
              <div>
                <input type="text" id="username" class="form-control" placeholder="Utilisateur" required="true" />
              </div>
              <div>
                <input type="password" id="password" class="form-control" placeholder="Mot de passe" required="true" />
              </div>

              <div>
                <a class="btn btn-default submit" id="login_validate" href="javascript:void(0);">Se connecter</a>
              </div>

              <div>
                <span id="error_login" style="visibility:hidden; color:red;">Nom d'utilisateur ou mot de passe incorrect</span>
              </div>
              

              <div class="clearfix"></div>

              <div class="separator">
                

                <div class="clearfix"></div>
                <br />

                <div>
                  <div>
                    <img src="../src/images/mirhackle/mirhackle_logo_text.png" style="width:150px; margin-right:20px;">
                  </div>
                  <p style="font-size: 0.8em; margin-top: 30px;">© Copyright mirHACKle 2016</p>
                </div>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
    <script type="text/javascript">
      $(function(){
          $("#login_validate").click(function(){
            username = $("#username").val();
            password = $("#password").val();

            if(username=="admin" && password=="admin"){
              window.location.href="/mirhackle/production/home.php";
            }
            else{
                $( ".login_content" ).effect( "shake" );
                $("#error_login").css("visibility", "visible");
            }
          });
      });
    </script>
  </body>
</html>
