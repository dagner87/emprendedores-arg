<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">Historial de Clientes</h4> </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>">Inicio</a></li>
            <li class="active">Consultas Cartera / Historial de Cliente </li>
        </ol>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-md-12 col-lg-6 col-sm-12">
      <div class="panel panel-success">
          <div class="panel-heading"> Ficha cliente.
              <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-minus"></i></a> </div>
          </div>
          <div class="panel-wrapper collapse in" aria-expanded="true">
              <div class="panel-body">
                  <div class="row">
                         <br>
                          <div class="col-md-3 col-sm-3 text-center">
                             <img src="<?php echo base_url() ?>assets/plugins/images/users/images.png" alt="user" class="img-circle img-responsive">
                          </div>
                          <div class="col-md-9 col-sm-9">
                              <h3 class="box-title m-b-0"><?= $datos_cliente->nombre_cliente." ".$datos_cliente->apellidos  ?></h3> <small> </small>
                              <p>
                                  <address>
                                    <strong>Correo: </strong> <?= $datos_cliente->email ?>
                                      <br/>
                                      <br/>
                                    <strong>DNI: </strong> <?= $datos_cliente->dni  ?>
                                      <br/>
                                      <br/>
                                      <strong>Teléfono: </strong> <?= $datos_cliente->telefono ?>
                                      <br/>
                                      <br/>
                                      <strong>Celular: </strong> <?= $datos_cliente->celular ?>
                                      <br/>
                                      <br/>
                                        <strong>Dirección: </strong><?= $datos_cliente->direccion ?>
                                      <br/>
                                      <br/>
                                  </address>
                              </p>
                          </div>
                    </div>
              </div>
          </div>
      </div>
    </div>
    
  
    <div class="col-md-12 col-lg-6 col-sm-12">
                        <div class="panel panel-info">
                            <div class="panel-heading"> Editar datos del cliente:
                                <div class="pull-right"><a href="#" data-perform="panel-collapse"><i class="ti-plus"></i></a> </div>
                            </div>
                            <div class="panel-wrapper collapse" aria-expanded="false">
                                <div class="panel-body">
                        <form  id="add_prod" action="<?php echo base_url() ?>capacitacion/update_datosCliente" method="post" 
                            data-toggle="validator" >
                            <input type="hidden" id="id_cliente" name="id_cliente" value="<?= $datos_cliente->id_cliente ?>">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre:</label>
                                         <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control" placeholder="Escriba nombre" value="<?= $datos_cliente->nombre_cliente ?>"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Apellidos:</label>
                                         <input type="text" id="apellidos" name="apellidos" class="form-control"   value="<?= $datos_cliente->apellidos     ?>" placeholder="Escriba apellidos"> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">No.Identidad:</label>
                                         <input type="text" id="dni" name="dni" class="form-control" value="<?= $datos_cliente->dni ?>" placeholder="Escriba dni"> <span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Teléfono:</label>
                                         <input type="text" id="telefono" name="telefono" class="form-control"value="<?= $datos_cliente->telefono ?>"  placeholder="Escriba Telefono "> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Email:</label>
                                         <input type="text" id="email" name="email" class="form-control" value="<?= $datos_cliente->email ?>" placeholder="Escriba email"> <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Celular:</label>
                                         <input type="text" id="celular" name="celular" class="form-control" value="<?= $datos_cliente->celular ?>" placeholder="Escriba celular"> <span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Fecha Nacimiento:</label>
                                         <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" value="<?= $datos_cliente->fecha_nacimiento ?>" placeholder="Escriba fecha nacimiento "> <span class="help-block">  </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Provincia:</label>

                                          <select class="form-control select2"  name="id_provincia" id="id_provincia" data-placeholder="Seleccione">
                                          <?php 
                                          if(!empty($provincias))
                                                  {
                                                     
                                                    foreach($provincias as $row)
                                                      {
                                                        if ($datos_cliente->id_provincia == $row->id_provincia ) {
                                                            echo '<option value="'.$row->id_provincia.'" selected>'.$row->nombre.'</option>';
                                                          }
                                                      echo '<option value="'.$row->id_provincia.'">'.$row->nombre.'</option>';
                                                      }
                                                  }

                                                  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Localidad:</label>
                                        
                                        <input type="hidden" name="id_m" id="id_m" value="<?= $datos_cliente->id_municipio ?>">
                                         <select class="form-control select2"  name="id_municipio" id="id_municipio" data-placeholder="Seleccione">
                                        </select>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Dirección:</label>
                                         <textarea type="text" id="direccion" name="direccion" class="form-control"><?= $datos_cliente->direccion ?></textarea><span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>    


                        <div class="form-actions">
                            <button type="submit" class="btn btn-success collapseble"> <i class="fa fa-check"></i> Actualizar</button>
                            
                        </div>
        </form>
                    </div>
                </div>
            </div>
    </div>
</div>

<div class="row">
   <div class="col-md-12">
    <h4 class="box-title m-b-20"></h4>
    <div class="panel-group" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="font-bold"> Historial de Compras</a> </h4> </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="table-responsive">
                            <br>
                                    <table class="table table-hover manage-u-table" id="editable-datatable">
                                        <thead>
                                            <tr>
                                                <th>No.operación</th>
                                                <th>Productos</th>
                                                <th>Cantidad</th>
                                                <th>Importe</th>
                                                <th>Fecha compra</th>
                                                <th>Garantía</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenido_video">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                     </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingFour"> <a class="collapsed font-bold panel-title" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour"> Gestión de Reposición de Unidades Filtrantes </a> </div>
            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour">
                <div class="panel-body"> 
                    <div class="row">
                            <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="table-responsive">
                            <br>
                                    <table id="tb-exist_resp" class="table table-bordered table-striped table-hover">
                                  <thead>
                                      <tr>
                                          <th>Repuesto</th>
                                          <th>Fecha compra</th>
                                          <th>Vencimiento</th>
                                          <th>Fecha vencimiento</th>
                                           <th>Estado</th>
                                      </tr>
                                  </thead>
                                  <tbody id="contenido_vencimientos">
                                    
                                  
                                  </tbody>
                              </table>
                                </div>
                            </div>
                            </div>
                     </div>

                </div>
            </div>
        </div>
    </div>
    </div>
</div>
      <script>
    
    $(document).ready(function() {
        load_data_cap();
        load_data_vencimientos();
     
        $('#add_prod').submit(function(e) {
                e.preventDefault();
                var url = '<?php echo base_url() ?>capacitacion/update_datosCliente';
                var data = $('#add_prod').serialize();
                $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: url,
                        data: data,
                        dataType: 'json',
                        beforeSend: function() {
                            
                            console.log("enviando....");
                          }
                     })
                      .done(function(data){

                        console.log(data);
                          $.toast({
                              heading: 'Cliente Actualizado',
                              text: 'Se actualizó correctamente la información.',
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
                        if ($.fn.DataTable.isDataTable('#editable-datatable')) {
                          table = $('#editable-datatable').DataTable();
                          table.destroy();
                          console.log("estoy dentro el if");
                          load_data_cap();
                          }
                          else {
                               console.log("estoy en el else");
                              load_data_cap();
                              }
                      });
        });
         armar_selec();
        
    });//onready


    $(document).on("change","#id_provincia",function(){
        id = $(this).val();
        $.ajax({
              type: 'ajax',
              method: 'get',
              url: '<?php echo base_url() ?>capacitacion/select_municipiolistado',
              data: {id: id},
              async: false,
              dataType: 'json',
            success: function(data){
                console.log(data);
                var html = '';
                var i;
                var dataProducto ='';
                html +='<option value="" style="color:red" disabled selected>Seleccione *</option >';
                for(i=0; i<data.length; i++){
                    html +='<option value="'+data[i].id_municipio+'"</option>'+data[i].nombre+'</option>';
                  }
                $('#id_municipio').html(html);
            },
            error: function(){
                 alert('No hay datos que mostrar');
              }
        });
  });

    function armar_selec(){
       var id = $('#id_m').val();
       //console.log(id_m);
      $.ajax({
              type: 'ajax',
              method: 'get',
              url: '<?php echo base_url() ?>capacitacion/armar_municipio',
              data: {id: id},
              async: false,
              dataType: 'json',
            success: function(data){
                //console.log(data.nombre);
                var html = '';
                var i;
                var dataProducto ='';
                html +='<option value="'+data.id_municipio+'" selected>'+data.nombre+'</option >';
                $('#id_municipio').html(html);
            },
            error: function(){
                 alert('No hay datos que mostrar');
              }
        });
    }


   
    function load_data_cap()
    {
        id = $('#id_cliente').val();
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/listado_DetallepedidosCli",
            method:"post",
            data:{id:id},
            success:function(data)
            {
             $('#contenido_video').html(data);
            
              var table = $('#editable-datatable').DataTable({
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

    function load_data_vencimientos()
    { 
       id = $('#id_cliente').val();
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/vencimientosRepuestosCli",
            method:"POST",
            data:{id:id},
            success:function(data)
            {
             $('#contenido_vencimientos').html(data);
               var table = $('#tb-exist_resp').DataTable({
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
              // var cont = $('#editable-datatable').editableTableWidget().numericInputExample().find('td:first').focus();
              // console.log(cont.text());
            }
        })
    }

    </script>            