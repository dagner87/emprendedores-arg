 <?php
  $exibirModal = false;  
  if(!isset($_COOKIE['Modal']))
  {
   
    //$expirar = 3600; // muestra cada 1 hora
    //$expirar = 10800; // muestra cada 3 horas
    //$expirar = 21600; //muestra cada 6 horas
    //$expirar = 43200; //muestra cada 12 horas
    $expirar = 86400;  // muestra cada 24 horas
    setcookie('Modal', 'SI', (time() + $expirar)); // mostrara 2 veces al dia o cada 12 horas.
    # Ahora nuestra variable de control pasará a tener el valor TRUE (Verdadero)
    $exibirModal = true;
  }
?>
<!--script>
	<?php if($exibirModal === true) : // Si nuestra variable de control "$exibirModal" es igual a TRUE activa nuestro modal y será visible a nuestro usuario. ?>
	  setTimeout ("cargar_form();", 1000); 
		 function cargar_form(){
			$('#modal_bienvenido').modal("show");
			};
	  <?php endif; ?>
</script-->
 </div>
 <!-- /.container-fluid -->

            <footer class="footer text-center"> 2018 &copy; SOFTCOM SAS </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>
   
   
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/register-steps/jquery.easing.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/register-steps/register-init.js"></script>

    <!-- Calendar JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/calendar/jquery-ui.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/moment/moment.js"></script>
    <script src='<?php echo base_url();?>assets/plugins/bower_components/calendar/dist/fullcalendar.min.js'></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/calendar/dist/jquery.fullcalendar.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/calendar/dist/cal-init.js"></script>
    
    <!--slimscroll JavaScript -->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/jquery.slimscroll.js"></script>
   
    <!--Counter js -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!-- chartist chart -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/chartist-js/dist/chartist.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js"></script>
   	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- Sparkline chart JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
      <!-- Sweet-Alert  -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/sweetalert/sweetalert.min.js"></script>
    <!--script src="<?php echo base_url();?>assets/plugins/bower_components/sweetalert/jquery.sweet-alert.custom.js"></script-->

    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/custom.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/switchery/dist/switchery.min.js"></script>
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/dashboard1.js"></script>
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/validator.js"></script>
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/jasny-bootstrap.js"></script>
     <!-- jQuery file upload -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/dropify/dist/js/dropify.min.js"></script>

     <!-- Date Picker Plugin JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- jQuery peity -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/peity/jquery.peity.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/peity/jquery.peity.init.js"></script>

    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

     <!-- Footable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/footable/js/footable.all.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <!--FooTable init-->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/footable-init.js"></script>

    <script src="<?php echo base_url();?>assets/plugins/bower_components/toast-master/js/jquery.toast.js"></script>
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/toastr.js"></script>  
    
    
    <script src="<?php echo base_url();?>assets/plugins/bower_components/custom-select/custom-select.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-select/bootstrap-select.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js" type="text/javascript"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/multiselect/js/jquery.multi-select.js"></script>

     <!-- Magnific popup JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/Magnific-Popup-master/dist/jquery.magnific-popup-init.js"></script>

        
    <!--Wave Effects -->
    <script src="<?php echo base_url();?>assets/ampleadmin-minimal/js/waves.js"></script>

    <!-- jQuery for carousel -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/owl.carousel/owl.carousel.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/owl.carousel/owl.custom.js"></script>  
    <!-- Form Wizard JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-wizard-master/dist/jquery-wizard.min.js"></script>
    <!-- FormValidation -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/plugins/bower_components/jquery-wizard-master/libs/formvalidation/formValidation.min.css">
    <!-- FormValidation plugin and the class supports validating Bootstrap form -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-wizard-master/libs/formvalidation/formValidation.min.js"></script>

    <!-- Sparkline chart JavaScript -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
    

    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/gallery/js/animated-masonry-gallery.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/gallery/js/jquery.isotope.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/fancybox/ekko-lightbox.min.js"></script>


    <script type="text/javascript">
    

       $(document).ready(function($) {
        $('.dataTables_filter').addClass("form-group has-success");
  
     
       $('#view_car').click(function(e) {
            window.location.href = "<?php echo base_url();?>carrito";
        });

      //$('#modal_bienvenido').modal("show");
       $(".select2").select2();

      });


     

    $(document).ready(function($) {
       //Bootstrap-TouchSpin
            $(".vertical-spin").TouchSpin({
                verticalbuttons: true,
                verticalupclass: 'ti-plus',
                verticaldownclass: 'ti-minus'
            });
            var vspinTrue = $(".vertical-spin").TouchSpin({
                verticalbuttons: true
            });
            if (vspinTrue) {
                $('.vertical-spin').prev('.bootstrap-touchspin-prefix').remove();
            }

        //Programatically call
        $('#open-image').click(function(e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });
        $('#open-youtube').click(function(e) {
            e.preventDefault();
            $(this).ekkoLightbox();
        });
        // navigateTo
        $(document).delegate('*[data-gallery="navigateTo"]', 'click', function(event) {
            event.preventDefault();
            var lb;
            return $(this).ekkoLightbox({
                onShown: function() {
                    lb = this;
                    $(lb.modal_content).on('click', '.modal-footer a', function(e) {
                        e.preventDefault();
                        lb.navigateTo(2);
                    });
                }
            });
        });
    });
    </script>

    <script>

    $(document).ready(function(){
      load_data();

       // console.log("cargo");
        $('#add_asoc').submit(function(e) {
        e.preventDefault();
         enviardatos();
        
      });

      function load_data_emp()
     {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_dataemp",
            method:"POST",
            success:function(data)
            {
             $('#contenido_admin').html(data);
            }
        })
     }   


     

 //enviar solicitud a asociado
     $('#add_emp_asoc').submit(function(e) {
        e.preventDefault();
        
        var url = '<?php echo base_url() ?>capacitacion/invitacion_asoc';
        var data = $('#add_emp_asoc').serialize();
          $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        sweetalertclick();
                        
                      }
                 })
                  .done(function(data){
                    console.log(data);
                    console.log(data.comprobador);
                    if (data.comprobador == "existe"){
                        sweetalertexiste();
                    }else if(data.comprobador){
                      $('#enviarInvitacion_asoc').modal('hide');
                       sweetalertsuccess();
                      }else{
                            sweetalerterror();
                            }
                   })
                  .fail(function(){
                    alert("A ocurrido un error");
                     //sweetalertclickerror();
                  }) 
                  .always(function(){
                     load_data();
                     load_data_emp();
                  });
        
      }); 

      //enviar solicitud a asociado
        
       $('#add_emp').submit(function(e) {
        e.preventDefault();
        
        var url = '<?php echo base_url() ?>panel_admin/insert_emp';
        var data = $('#add_emp').serialize();
          $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function(data) {
                       console.log(data);
                        sweetalertclick();
                        
                      }
                 })
                  .done(function(data){
                   console.log(data.comprobador);
                    if (data.comprobador == "existe"){
                      sweetalertexiste();
                    }else if(data.comprobador){
                      $('#enviarInvitacion').modal('hide');
                       sweetalertsuccess();
                      }else{
                            sweetalerterror();
                            }
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                  }) 
                  .always(function(){
                     load_data();
                     load_data_emp();
                  });
        
      }); 


    });

     function sweetalertclick() {
       var img = '<?php echo base_url();?>assets/ajax-cargando.gif';
        swal({
          title: "Procesando",
          text: "Por favor espere...",
          imageUrl: img,
          timer: 20000,   
          showConfirmButton: false
        });
     }

   function sweetalertsuccess() {
        swal({
          title: "Buen Trabajo!!",
          text: "Invitación enviada",
          type: "success", 
          timer: 2000,   
          showConfirmButton: false
        });
     } 

   
    function sweetalertexiste() {
        swal({
          title: "",
          text: "El email ya está registrado en el sistema",
          type: "info", 
          // timer: 20000,   
          showConfirmButton: true
        });
     }   

    function sweetalerterror() {
        swal({
          title: "A ocurrido un error!!",
          text: "Intente mas tarde",
          type: "error", 
          timer: 2000,   
          showConfirmButton: false
        });
     }    

    function load_data()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_dataemp",
            method:"POST",
            success:function(data)
            {
             $('#contenido').html(data);
            }
        })
    }

    

     function enviardatos(){
          var url = '<?php echo base_url() ?>capacitacion/insert_add_asoc';
          var data = $('#add_asoc').serialize();
          $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        //sweetalert_proceso();
                        console.log("enviando....");
                      }
                 })
                  .done(function(){
                    console.log(data);
                    
                     swal("Buen Trabajo!!", "Nuevo Asociado Agregado.", "success");
                     
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                  }) 
                  .always(function(){
                    /* setTimeout(function(){
                      redireccionar();
                     },2000);*/

                  });
        } 
    
    

    </script>


</body>
</html>
