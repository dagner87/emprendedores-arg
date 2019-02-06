<!DOCTYPE html>  
<html lang="es">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/plugins/images/favicon.ico">
<title>Bienvenido al Modelo de Negocios de Emprendedores</title>
<!-- Bootstrap Core CSS -->
<link href="<?php echo base_url();?>assets/ampleadmin-minimal/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- animation CSS -->
<link href="<?php echo base_url();?>assets/ampleadmin-minimal/css/animate.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?php echo base_url();?>assets/ampleadmin-minimal/css/style.css" rel="stylesheet">
<!-- color CSS -->
<link href="<?php echo base_url();?>assets/ampleadmin-minimal/css/colors/default.css" id="theme"  rel="stylesheet">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">


.login-register {
    position: absolute;

}

</style>

</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register">
 
  <div class="login-box">
     <div class="text-center">
         <img src="<?php echo base_url();?>assets/plugins/images/admin-text-logo.png" alt="home" class="light-logo p-20 di" />
      <h2 style=" color: #005596; "><strong> ¡Restrablecer Contraseña!</strong></h2>
      <p class="text-muted"> </p>
  </div>


    <div class="white-box" style=" color: #005596; ">
                  <form  data-toggle="validator" class="form-horizontal new-lg-form" id="loginform" method="post" action="<?php echo base_url();?>resetear">
                     <?= form_hidden('token',$token)?>
                     <?= form_hidden('id_emp',$id_emp)?>
                    <div class="form-group">
                      <div class="col-xs-12">
                        <label>CONTRASEÑA</label>
                        <input class="form-control" type="password" id="password" required="true" name="password"  placeholder="Contraseña">
                      <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                          <label>REPETIR</label>
                            <input class="form-control" type="password" name="confir_password"  required placeholder="Confirmar Contraseña" data-match="#password" data-match-error="La contraseña no coincide">
                            <div class="help-block with-errors"></div>
                             </div>
                    </div>
                 
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">CAMBIAR</button>
                      </div>
                    </div>
                  </form>

                  <form data-toggle="validator" class="form-horizontal" id="recoverform" 
                  action="<?php echo base_url() ?>panel_admin/forgot_pass" method="post">
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <h3>Recuperar contraseña</h3>
                        <p class="text-muted">¡Ingrese su correo electrónico y le enviaremos las instrucciones!</p>
                      </div>
                    </div>
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <input class="form-control" type="email" id="email_rest" name="email_rest" required placeholder="Correo" 
                        data-error="Escriba un correo valido">
                      <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                      <div class="col-xs-12">
                        <button   type="submit" id="forgot_pass" class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light">Reiniciar</button>
                      </div>
                    </div>
                  </form>

                
                </div>
  </div>
</section>
<!-- jQuery -->
<script src="<?php echo base_url();?>assets/plugins/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap Core JavaScript -->
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Menu Plugin JavaScript -->
<script src="<?php echo base_url();?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>

<!--slimscroll JavaScript -->
<script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/jquery.slimscroll.js"></script>
<!--Wave Effects -->
<script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/waves.js"></script>
<!-- Custom Theme JavaScript -->
<script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/custom.min.js"></script>
<script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/validator.js"></script>
<!--Style Switcher -->
<script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>
</body>
</html>
