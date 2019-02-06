<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTRADORES</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Configuración</a></li>
                            <li class="active">Administradores</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
              <div class="row">
                     <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">ADMINISTRADORES DE PAICES</h3>
                            <p class="text-muted m-b-30"></p>
                            <h3 class="box-title"><button type="button"  id="btn-agregar" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#insetcapModal" ><i class="fa fa-plus"></i> Agregar Administrador</button></h3>
                            <div class="table-responsive">
                                <table id="example" class="table display manage-u-table">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>Email</th>
                                            <th>TELEFONO</th>
                                            <th>PAIS </th>
                                            <th>ACCION</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody id="contenido_admin">
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


<!-- .modal for add task -->
<div class="modal fade" id="insetcapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Nuevo Administrador </h4>
            </div>
            <div class="modal-body">
                <form id="add_cap" action="" method="post" > <!-- data-toggle="validator"-->
                  <input type="hidden" name="camino" id="camino" value="">
                  <input type="hidden" name="id_emp" id="id_emp" value="">
                  

                  <div class="form-group">
                      <label for="nombre_emp">Nombre y Apellidos</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="ti-user"></i></div>
                          <input type="text" class="form-control" id="nombre_emp" name="nombre_emp" placeholder="Nombre y Apellidos" required> 
                      </div>
                       <div class="help-block with-errors"></div>
                  </div>    
                  <div class="form-group">
                      <label for="email">Email</label>
                      <div class="input-group">
                          <div class="input-group-addon"><i class="ti-email"></i></div>
                          <input type="email" class="form-control" id="email" name="email" placeholder="Escriba  email" required>
                      </div>
                    <div class="help-block with-errors"> </div>
                 </div>

                <div class="form-group">
                    <label for="dni_emp">DNI</label>
                      <div class="input-group">
                        <div class="input-group-addon"><i class=" fa fa-barcode"></i></div>
                        <input type="number" class="form-control" id="dni_emp"  name="dni_emp" placeholder="Escriba DNI" required> 
                      </div>
                      <div class="help-block with-errors"> </div>
                </div>
                <div class="form-group">
                    <label for="telefono_emp">TELEFONO</label>
                    <div class="input-group">
                        <div class="input-group-addon"><i class="ti-mobile"></i></div>
                        <input type="number" class="form-control" id="telefono_emp"  name="telefono_emp" placeholder="Escriba telefono" required>
                    </div>
                     <div class="help-block with-errors"> </div>
               </div>
                <div class="form-group">
                <label for="id_pais">Pais</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-crosshairs"></i>
                   </div>
                   <select class="form-control" id="id_pais" name="id_pais" required>
                    <option value="0">Seleccione</option>
                    <?php foreach ($paices as $key ) { ?>
                       <option value="<?= $key->id  ?>"><?= $key->nombre  ?></option>
                    <?php } ?>
                  </select>
               </div>
               <div class="help-block with-errors"></div>
            </div>
              <div id="no_mostrar" style="">
                <div class="form-group">
                  <label for="password">Contraseña</label>
                  <div class="input-group">
                      <div class="input-group-addon"><i class="ti-lock"></i></div>
                      <input type="password" class="form-control" id="password" name="password"  placeholder="Escriba Contraseña" required>
                   </div>
                <div class="help-block with-errors"> </div>
             </div>
              <div class="form-group">
                  <label for="confirm_password">Confirmar Contraseña</label>
                  <div class="input-group">
                      <div class="input-group-addon"><i class="ti-lock"></i></div>
                      <input type="password" class="form-control" id="confirm_password"  data-match="#password" data-match-error="La contraseña no coincide" name="confirm_password" placeholder="Escriba Contraseña" required> </div> 
                      <div class="help-block with-errors"> </div>
             </div>
            </div> 
              <button type="submit" class="btn btn-success waves-effect waves-light m-r-10">Guardar</button>
              <button  type="button" data-dismiss="modal" class="btn btn-inverse waves-effect waves-light">Cerrar</button>
              
             </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


  <!-- Editable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>
    <script>
    
     $(document).ready(function() {
            load_data_emp();

            $('#add_cap').submit(function(e) {
            e.preventDefault();
            var url    = '<?php echo base_url() ?>general/insert_administrador';
            var url_up = '<?php echo base_url() ?>general/update_emp';
            var data   = $('#add_cap').serialize();
            var camino = $('#camino').val();

            if (camino == 'insertar')
              {
                
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
                          $.toast({
                              heading: 'Nuevo Administrador Agregado',
                              text: 'Se agregó correctamente la información.',
                              position: 'top-right',
                              loaderBg: '#ff6849',
                              icon: 'success',
                              hideAfter: 3500,
                              stack: 6
                          });
                         
                      })
                      .fail(function(){
                         //sweetalertclickerror();
                      }) 
                      .always(function(){
                        if ($.fn.DataTable.isDataTable( '#example' ) ) {
                          table = $('#example').DataTable();
                          table.destroy();
                          console.log("estoy dentro el if");
                          load_data_emp();
                          }
                          else {
                               console.log("estoy en el else");
                              load_data_emp();
                              }
                      });
               }else{
                     console.log("editar");
                       
                        $.ajax({
                                type: 'ajax',
                                method: 'post',
                                url: url_up,
                                data: data,
                                dataType: 'json',
                                beforeSend: function() {
                                    //sweetalert_proceso();
                                    console.log("editando....");
                                  }
                             })
                              .done(function(data){
                                
                              if (data.comprobador) {

                                $.toast({
                                      heading: 'Administrador Editado',
                                      text: 'Se ha editado correctamente la información.',
                                      position: 'top-right',
                                      loaderBg: '#ff6849',
                                      icon: 'info',
                                      hideAfter: 3500,
                                      stack: 6
                                  });


                              }
                                  
                                 
                              })
                              .fail(function(){
                                 //sweetalertclickerror();
                              }) 
                              .always(function(){
                                if ($.fn.DataTable.isDataTable( '#example' ) ) {
                                  table = $('#example').DataTable();
                                  table.destroy();
                                  console.log("estoy dentro el if");
                                  load_data_emp();
                                  }
                                  else {
                                       console.log("estoy en el else");
                                      load_data_emp();
                                      }
                              });
                

                    }                  
        });



          
        });//fin onready
 
     $(document).on("change","select", function(){
         //var perfil = $(this).find(':selected')[0];
         var perfil = $(this).val();
        console.log(perfil);

      });

     $(document).on("click",".deletecap-row-btn", function(){
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>general/eliminar_admin',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  console.log(data);
                  $.toast({
                        heading: 'Administrador eliminado ',
                        text: 'El Administrador a sido eliminado.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 2500
                    });
                  if ($.fn.DataTable.isDataTable( '#editable-datatable' ) ) {
                      table = $('#editable-datatable').DataTable();
                      table.destroy();
                      console.log("estoy dentro el if");
                      load_data_emp();
                      }
                      else {
                           console.log("estoy en el else");
                          load_data_emp();
                          }
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        
    });

     $(document).on("click","#btn-agregar", function(){
        $("#add_cap")[0].reset();
        $('#camino').val("insertar");
        //$('#no_mostrar').css("display", "block");
        $('#no_mostrar').css("display", "block");
        
    });

    $(document).on("click",".edit-row-btn", function(){
        var id = $(this).attr('data');
        
        $('#no_mostrar').css("display","none");
        $('#insetcapModal').modal("show");

        $('#camino').val("editar");
        $('#id_emp').val(id);
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>general/getdatos_emp',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  console.log(data);
                   $('#nombre_emp').val(data.nombre_emp);
                   $('input[name=email]').val(data.email);
                   $('#dni_emp').val(data.dni_emp);
                   $('#telefono_emp').val(data.telefono_emp);
                   $('select[name=id_pais]').val(data.id_pais).attr('selected','selected');
                 },
                error: function(){
                  alert('No se pudo mostrar');
                }
        });
        
    }); 

   
        function load_data_emp()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>general/load_data_admin_gls",
            method:"POST",
            success:function(data)
            {
             $('#contenido_admin').html(data);
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

     $(document).on("click",".firmo", function(){
        var id = $(this).val();
       
         $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/update_firma",
            method:"GET",
            data:{id_emp:id},
            success:function(data)
            {
             var obj = jQuery.parseJSON(data);
             
              console.log(obj.comprobador);

              if ($.fn.DataTable.isDataTable('#example')) {
                      table = $('#example').DataTable();
                      table.destroy();
                      console.log("limpio tabla");
                       load_data_emp();
                      }
                      else {
                           console.log("tabla cargada");
                          load_data_emp();
                          }
             //$('#span'+id).text(obj.comprobador);              
             
             
              
            }

        })
    });

    $(document).on("click",".mostrar-asoc", function(){
        var id = $(this).attr('data');

        if ($.fn.DataTable.isDataTable('#lista-asoc')) {
                      table = $('#lista-asoc').DataTable();
                      table.destroy();
                      console.log("limpio tabla");
                      
                      }
                      else {
                           console.log("tabla cargada");
                         
                          }
        
         $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_listaPatrocinados",
            method:"POST",
            data:{id_emp:id},
            success:function(data)
            {
             $('#lista_patrocinados').html(data);
               var table = $('#lista-asoc').DataTable({
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
    });
</script>            

