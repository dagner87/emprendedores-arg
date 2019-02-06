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
<link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bower_components/dropify/dist/css/dropify.min.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">


.login-register {
   position: absolute
    /*height: 100% !important;*/

}
@media (min-width: 800px) {
 .login-box{

  width: 40%;
  padding-top: 1;
   

}



</style>

</head>
<body>
<!-- Preloader -->
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper" class="login-register1">
 
  <div class="login-box">
     <div class="text-center">
         <img src="<?php echo base_url();?>assets/plugins/images/admin-text-logo.png" alt="home" class="light-logo p-20 di" />
      <h2 style=" color: #005596; "><strong> ¡Bienvenido al Modelo de Negocios de Emprendedores!</strong></h2>
      <p class="text-muted"> </p>
  </div>
    <div class="white-box" style=" color: #005596; ">
                    <h3 style=" color: #005596; " class="box-title m-b-0">Actualice sus datos</h3>
                            <?php 
                if($this->session->flashdata('usuario_incorrecto'))
                {
                ?>
                <div class="alert alert-danger">
                 <p><?=$this->session->flashdata('usuario_incorrecto')?></p>
                </div>
                <?php
                }
                ?>
                <form  data-toggle="validator" class="form-horizontal new-lg-form" id="loginform" method="post" 
                action="<?php echo base_url();?>login/update_registro">
                     <?=form_hidden('token',$token)?>
                     <?=form_hidden('id_emp',$id_emp)?>

                  <div class="form-group ">
                   <div class="col-md-6 col-xs-12 btn-file">
                        <label for="input-file-now">Subir imagen:</label>
                        <input type="file" id="url_imagen" name="url_imagen" class="dropify " data-default-file="" data-show-loader = "true"
                        data-error="Agrege una imagen"/ required="true">
                        <input type="hidden" id="nombre_archivo" name="nombre_archivo"  value="" class="form-control">
                        <div class="help-block with-errors"></div>
                   </div>
                    </div>
                     
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <label>Nombre</label>
                        <input class="form-control" type="text" required="true" name="nombre_emp" placeholder="Escriba Nombre" required="true">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>

                      <div class="form-group ">
                      <div class="col-xs-12">
                        <label>Apellido</label>
                        <input class="form-control" type="text" required="true" name="apellido" placeholder="Escriba Apellido" required="true">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <label>DNI</label>
                        <input class="form-control" type="text" required="true" name="dni_emp" placeholder="Escriba DNI" required="true">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group ">
                      <div class="col-xs-12">
                        <label>Teléfono</label>
                        <input class="form-control" type="tel" required="true" name="telefono_emp" placeholder="Escriba Teléfono" required="true">
                        <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                        <label>CONTRASEÑA</label>
                        <input class="form-control" type="password" id="password" required="true" name="password"  placeholder="Contraseña" >
                      <div class="help-block with-errors"></div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                           <label>REPETIR CONTRASEÑA</label>
                            <input class="form-control" type="password" name="confir_password"  required placeholder="Confirmar Contraseña" data-match="#password" data-match-error="La contraseña no coincide">
                            <div class="help-block with-errors"></div>
                             </div>
                    </div>
                    <div class="form-group text-center">
                      <div class="col-xs-12">
                        <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Registrar</button>
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
 <!-- jQuery file upload -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/dropify/dist/js/dropify.min.js"></script>
<!--Style Switcher -->
<script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

    <script>
    $(document).ready(function() {
      $('.btn-file').on("change", function(evt){
            var base_url= "<?php echo base_url();?>";
            // declaro la variable formData e instancio el objeto nativo de javascript new FormData
            var formData = new FormData(document.getElementById("loginform"));
           // iniciar el ajax
            $.ajax({
                url: base_url + "panel_admin/subir_imgPerfil",
                // el metodo para enviar los datos es POST
                type: "POST",
                // colocamos la variable formData para el envio de la imagen
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function(data) 
                {
                 $('#cargando').html('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                },
                success: function(data)
                {
                   let objJson = JSON.parse(data);
                   console.log(objJson.imagen);
                   $('.btn-file').addClass('btn btn-info');
                  var nombre_archivo = $('#nombre_archivo').val(objJson.imagen); //agrego el nombre del archivo subido
                   $('#cargando').fadeOut("fast",function(){
                   $('#cargando').html('<i class=""> </i>');
                    });
                   $('#cargando').fadeIn("slow");
                } 
            }); 
          }); 

       // Basic
        $('.dropify').dropify({
            messages: {
                default: 'No hay archivo seleccionado',
                replace: nombre_archivo ,
                remove: 'Remover',
                error: 'No se pudo mostrar'
            }
        });
       
   }); 
</script>        
</body>
</html>
