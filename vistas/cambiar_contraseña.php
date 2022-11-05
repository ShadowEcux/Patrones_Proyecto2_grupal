<?php
if ($_GET['token'] == $_COOKIE['token']) {
    echo '
    <!DOCTYPE html>
      <html>
        <head>
          <meta charset="utf-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <title>APP Inventario | www.incanatoit.com</title>
          <!-- Tell the browser to be responsive to screen width -->
          <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
          <!-- Bootstrap 3.3.5 -->
          <link rel="stylesheet" href="../public/css/bootstrap.min.css">
          <!-- Font Awesome -->
          <link rel="stylesheet" href="../public/css/font-awesome.css">
         
          <!-- Theme style -->
          <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
          <!-- iCheck -->
          <link rel="stylesheet" href="../public/css/blue.css">
      
          <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
          <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
          <!--[if lt IE 9]>
              <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
              <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
          <![endif]-->
        </head>
        <body class="hold-transition login-page">
          <div class="login-box">
            <div class="login-logo">
              <a href="../../index2.html"><b>APP Inventario</b></a>
            </div><!-- /.login-logo -->
            <div class="login-box-body">
            <form method="post" action="../ajax/usuario.php?op=cambiarContraseña" id="formCambiar">
            <div class="form-group has-feedback d-flex ">
                    <p class="login-box-msg">Ingrese su contraseña</p>
                  <input type="password" id="password" name="password" class="form-control">
                </div>
                <div class="form-group has-feedback d-flex ">
                    <p class="login-box-msg">Confirme su contraseña</p>
                  <input type="password" id="password_confirmed" name="password_confirmed" class="form-control">
                </div>
                  <div class="">
                    <button type="submit" id="btnCambiar"class="btn btn-primary btn-block btn-flat">Cambiar Contraseña</button>
                  </div><!-- /.col -->
                </div>
              </form>
              
      
            </div><!-- /.login-box-body -->
          </div><!-- /.login-box -->
      
          <!-- jQuery -->
          <script src="../public/js/jquery-3.1.1.min.js"></script>
          <!-- Bootstrap 3.3.5 -->
          <script src="../public/js/bootstrap.min.js"></script>
           <!-- Bootbox -->
          <script src="../public/js/bootbox.min.js"></script>
          <script src="./scripts/cambiar_contrasenia.js"></script>  
      
        </body>
      </html> 
    ';
}
else{
    header('Location: ../ajax/index.php');
}