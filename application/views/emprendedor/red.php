<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Mis EPATs</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li class="active">Mis EPATs</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

  <!-- .modal for add task -->
<div class="modal fade" id="modal-list-inv" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit"> <strong id="tit"> Lista de invitaciones </strong></h4>
            </div>
            <div class="modal-body" id="">

              <div class="">
                        <div class="panel">
                            <div class="sk-chat-widgets">
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                      <div class="table-responsive">
                                        <table id="example" class="table display manage-u-table" style="font-family:Arial; font-size:70%">
                                           <thead >
                                              <tr > 
                                                <th> Email</th>
                                                <th>Estado </th>
                                                <th>Acción </th>
                                              </tr>
                                            </thead>
                                              <tbody id="lista_inv" >
                                              </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               
            </div>
        <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal --> 

               

 <div class="row">
  <div class="col-sm-12">
      <div class="white-box">
          <h3 class="box-title">Mis Patrocinados 
            <button type="button" id="show-list-btn" data-toggle="modal" data-target="#modal-list-inv" class="btn btn-info btn-rounded"> <i class="fa fa-user"></i> Ver Invitaciones</button>
</h3>

           
          <div class="table-responsive management-hierarchy contact-list">

         <br>
        <div class="hv-container">
            <div class="hv-wrapper">
               <!-- Emprendedor -->
                <div class="hv-item">

                      <!-- Promotor padre Primer nivel-->    
                    <div class="hv-item-parent">
                        <div class="person">
                            <img src="<?php echo base_url();?>assets/plugins/images/users/<?= $datos_emp->foto_emp ?>" alt="" class="">
                            <p class="name">

                                <?= $this->session->userdata('nombre') ; ?>
                            </p>
                        </div>
                    </div>
                        <?php 
                       if (!empty($asociados)):?>
                          <!-- asociados 1 nivel-->
                    <div class="hv-item-children">

                        <?php foreach ($asociados as $key) { ?>
                            <div class="hv-item-child">
                             <!--1 er asociado -->
                            <div class="hv-item">
                                <div class="person">
                                    <img src="<?php echo base_url();?>assets/plugins/images/users/<?= $key->foto_emp ?>" alt="">
                                    <p class="name ">
                                        <?= $key->nombre_emp ;?> 
                                        <?php 
                                              $estado   =  $this->modelogeneral->Estado_emp_asoc($key->id_emp);
                                             
                                              if ($estado == 0){
                                                echo '<b> <span class=" fa fa-circle text-danger m-r-10"></span></b>';
                                              }else{
                                                echo '<b> <span class=" fa fa-circle text-success m-r-10"></span></b>';
                                              }
                                             
                                              $con_vencimiento   =  $this->modelogeneral->Count_vencimiento($key->id_emp);
                                              $total_cli         =  $this->modelogeneral->CountTotalCli($key->id_emp);
                                              $sin_venciento     =   $total_cli - $con_vencimiento;
                                              if (!empty($sin_venciento)) {
                                                $atendidos_porc    =  round(($sin_venciento / $total_cli)*100);
                                              }else{
                                                $atendidos_porc    =  0;
                                              }

                                               if (!empty($con_vencimiento)) {
                                                 $no_atendidos_porc =  round(($con_vencimiento / $total_cli)*100);
                                              }else{
                                                $no_atendidos_porc    =  0;
                                              }

                                              
                                             
                                         ?>

                                       

                                        <b> <span id=""><?= $sin_venciento."/".$total_cli  ?></span></b>

                                    </p>
                                </div>
                           </div>
                            <!--/Key component -->
                        </div>
                        <?php }  ?>   
                     </div>
                 <?php endif ?>   
                 
                </div>
               <!--Fin Primer nivel-->

            </div>
        </div>
        <br>
        <br>

              
          </div>
      </div>
  </div>
</div>   

<script type="text/javascript">

  $(document).ready(function() {
           // load_lista_inv();
    });



    function load_lista_inv()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/load_lista_inv",
            method:"POST",
            success:function(data)
            {
             $('#lista_inv').html(data);
             var table = $('#example').DataTable({
                responsive: true,
                language: {
                            "lengthMenu": "Mostrar _MENU_ registros por pagina",
                            "zeroRecords": "No se encontraron resultados en su busqueda",
                            "searchPlaceholder": "Buscar registros",
                            "info": "Mostrando  _START_ al _END_ de un total de  _TOTAL_ registros",
                            "infoEmpty": "No existen registros",
                            "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                            "search": "Buscar:",
                            "paginate": {
                                          "first": "Primero",
                                          "last": "Último",
                                          "next": "Siguiente",
                                          "previous": "Anterior"
                                        },
                          }
                          
                      });
            }
        })
    }


  $(document).on("click","#show-list-btn", function(){  
                if ($.fn.DataTable.isDataTable('#example')){
                      table = $('#example').DataTable();
                      table.destroy();
                      load_lista_inv();
                      }
                      else {
                            load_lista_inv();
                          }
     
        
  });


  $(document).on("click",".delet-inv", function(){
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_emp',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  console.log(data);
                  if ($.fn.DataTable.isDataTable('#example')){
                      table = $('#example').DataTable();
                      table.destroy();
                      load_lista_inv();
                      }
                      else {
                            load_lista_inv();
                          }
                  
                   $.toast({
                          heading: 'Emprendedor Eliminado ',
                          text: ' El emprendedor a sido eliminado.',
                          position: 'top-right',
                          loaderBg: '#ff6849',
                          icon: 'error',
                          hideAfter: 2500
                    });
                    
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        
    });

 


</script>            

 
