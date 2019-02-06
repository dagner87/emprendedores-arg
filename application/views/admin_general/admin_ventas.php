
<style type="text/css">
  @media (max-width: 800px) {
   .table tr:first-child{
    border-top: 0;
    font-size: small;
    }
}
</style>

<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTRACION DE VENTAS</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Tienda</a></li>
                            <li class="active">Ventas</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                  
                </div>

<!-- .modal for add task -->
<div class="modal fade" id="confirmar_compra" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Definir Metodo de Pago y Envio</h4>
            </div>
            <div class="modal-body">
            <form id="add_penvio" action="<?php echo base_url() ?>panel_admin/add_p_envio" method="post">
                   <input type="hidden" name="id_compra" id="id_compra" value="">
                  <div class="form-group">
                      <label class="control-label">Seleccione Método de Pago</label>
                      <div class="radio-list">
                          <label class="radio-inline">
                              <div class="radio radio-info">
                                  <input type="radio" name="medio_pago" id="pago_transf" value="pago_transf" required>
                                  <label for="radio2">Transferencia Bancaria </label>
                              </div>
                          </label>
                          <label class="radio-inline">
                              <div class="radio radio-info">
                                  <input type="radio" name="medio_pago" id="mercado_pago" value="mercado_pago" required>
                                  <label for="radio2">Mercado Pago </label>
                              </div>
                          </label>
                          <label class="radio-inline">
                              <div class="radio radio-info">
                                  <input type="radio" name="medio_pago" id="pago_efectivo" value="pago_efectivo" required>
                                  <label for="radio2">Pago en Efectivo </label>
                              </div>
                          </label>
                      </div>
                  </div>
                 
            <div class="form-group">
                <label for="exampleInputphone">Precio Envio</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-truck"></i></div>
                    <input type="text" class="form-control" name="precio_envio" id="precio_envio" placeholder="Escriba Precio de envio" required > </div>
            </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Confirmar</button>
            </div>
             </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- .modal for add task -->
<div class="modal fade" id="modal-confirpago" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit"> <strong>Confirmación de Pago</strong></h4>
            </div>
            <div class="modal-body">
            <form id="update_pago" action="" method="post">
                   <input type="hidden" name="id_compra_pago" id="id_compra_pago" value="">
            <div class="form-group">
                <label for="exampleInputphone">Fecha Pago</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="date" class="form-control" name="fecha_pago" id="fecha_pago" placeholder="" required > </div>
            </div>
       

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Confirmar</button>
            </div>
             </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- .modal for add task -->
<div class="modal fade" id="modal-mapaEnvios" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit"> <strong>Mapa de Envios</strong></h4>
            </div>
            <div class="modal-body">
                <div class="text-center">
                  <img align="center" src="<?php echo base_url();?>assets/mapa_envios/mapa_zona.jpg" alt="gallery" class="" /> 
                </div>


                

           
            </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
</div>
<!-- /.modal -->


<div class="row">
  <div class="col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Lista de Ventas</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                  <h3 class="box-title"><button type="button" title="Click para Ver Mapa" id="btn-add-cap" data-toggle="modal" data-target="#modal-mapaEnvios" class="btn btn-info btn-rounded"> <i class="ti-location-pin"></i> Ver Mapa Envios</button></h3>
                                    
                                  <div class="m-t-15 collapseblebox dn">
                                        <div class="well">
                                          <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form  id="add_prod" action="<?php echo base_url() ?>panel_admin/insert_promo" method="post" data-toggle="validator">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nombre de Promoción</label>
                                         <input type="text" id="nombre_promo" name="nombre_promo" class="form-control" placeholder="Escriba nombre " required data-error="Agrege Nombre de Promoción"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Descuento</label>
                                         <input type="text" id="descuento" name="descuento" class="form-control" placeholder="Escriba descuento " required data-error="Agrege Descuento"> <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fecha inicio</label>
                                         <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" placeholder="Escriba fecha inicio" required data-error="Agrege Fecha inicio"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fecha fin</label>
                                         <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" placeholder="Escriba fecha_fin" required data-error="Agrege Fecha fin"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                
                                
                            </div>
                           
                            <!--/row-->
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                        <label class="control-label">Productos</label>
                                        <select class="form-control select2"  name="id_producto" id="id_producto" data-placeholder="Seleccione" required data-error="Agrege Productos">
                                          <?=  $productos ?>
                                        </select>
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                
                            </div>
                            <!--/row-->
                            <div class="row">
                               <div class="col-lg-12">
                                 <table id="tb-combo" class="table table-bordered table-striped table-hover">
                                  <thead>
                                      <tr>
                                          <th>Producto</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    
                                  
                                  </tbody>
                              </table>
                            </div>   
                            </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-success collapseble"> <i class="fa fa-check"></i> Guardar</button>
                            <button type="button" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
            </div>
          </div>
     </div>
   </div>
   <div class="row">
        <div class="col-md-12">
            <div class="panel">
                <div class="table-responsive">
                 <br>
                <table class="table table-striped" id="adminventa_table">
                        <thead>
                            <tr>
                              <th><button class="btn btn-info  btn-sm" id="btn-despacho" disabled title="Marcar como despachado"><i class="fa fa-check"></i> Despachar</button></th>
                                <th>No. Compra</th>
                                <th>Fecha Compra</th>
                                <th>Emprendedor</th>
                                <th>Productos</th>
                                <th>Total compra</th>
                                <th>Precio Envio</th>
                                <th>Estado</th>
                                <th>Despacho</th>
                                <th>Medio d' Pago</th>
                                <th>Accion</th>
                            </tr>

                        </thead>
                        <tbody id="contenido_tabla">
                            
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


  <!-- Editable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>
    <script>


    
    $(document).ready(function() {
        load_data_cap();
          $('.selectpicker').selectpicker();


        $('#add_penvio').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/add_p_envio'; 
            var data = $('#add_penvio').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#add_penvio")[0].reset();
                        $("#confirmar_compra").modal('hide');
                        //console.log("enviando....");
                        sweetalertclick();
                      }
                 })
                  .done(function(data){
                    console.log(data);
                    if (data.comprobador =='pago_efectivo'){
                      estado_success();
                    }else{
                          EmailSendsuccess(); 
                         }
      
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                  }) 
                  .always(function(){
                    if ($.fn.DataTable.isDataTable('#adminventa_table')) {
                      table = $('#adminventa_table').DataTable();
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

         $('#update_pago').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/update_estado';
            var data = $('#update_pago').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#update_pago")[0].reset();
                        $("#modal-confirpago").modal('hide');
                        sweetalertclick();
                      }
                 })
                  .done(function(data){
                    console.log(data);
                    estado_success();
                     
                     
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                  }) 
                  .always(function(){
                    if ($.fn.DataTable.isDataTable('#adminventa_table')) {
                      table = $('#adminventa_table').DataTable();
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



        $("#id_producto").on("change",function(){
         $(this).find('select :first').attr("disabled",'true');
         data = $(this).val();
         var option        = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_prod   =  $('select[name="id_producto"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='productos[]' value='"+data+"'>"+nombre_prod+"</td>";
            html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tb-combo tbody").append(html);
           
        }else{
            alert("seleccione un producto...");
        }
    });



     $('#id_provincia').on("click", function(evt){
          var id = $('#id_provincia').val();
          console.log(id);
          $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>capacitacion/select_municipio",
            data: {id: id},
            success: function (data) {
              $('#id_municipio').html(data);
             }
          });
    }); 

    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        
    }); 



        
    });//onready

$(document).on("click",".estado", function(){
                 var id = $(this).attr('data');
                 $('#id_compra_pago').val(id);
                 $("#update_pago")[0].reset();
                 $('#modal-confirpago').modal("show");
       }); 

  $(document).on("click",".checkitem", function(){

  				if ($('.checkitem:checked').length > 0) {
		            $('#btn-despacho').removeAttr('disabled');
		        } else {
		            $('#btn-despacho').attr('disabled',true);
		        }

  	          // $("#btn-despacho").attr("disabled",false);
                array = [];
               $('.checkitem:checked').map(function(){
                  id = ($(this).val());
                  console.log(id);
                   array.push(id);
                 });
                
   });



  $(document).on("click","#btn-despacho", function(){
                console.log(array);
                if (array.length === 0)
                   {
                    alert("Debe seleccionar un producto");
                   }

                 $.ajax({
                      url:"<?php echo base_url(); ?>panel_admin/update_estadoDespacho",
                      method:"get",
                      data:{id:array},
                      dataType: 'json',
                      success:function(data)
                      {
                       //console.log(data.success);
                      if (data.success){
                          $.toast({
                            heading: 'Mercadería Despachada',
                            text: 'Datos actualizados.',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 2500
                          });
                        if ($.fn.DataTable.isDataTable( '#adminventa_table' ) ) {
                            table = $('#adminventa_table').DataTable();
                            table.destroy();
                            console.log("estoy dentro el if");
                            load_data_cap();
                            }
                            else {
                                 console.log("estoy en el else");
                                load_data_cap();
                                }
                            }
                       }
                       
                    }); 
   }); 



    function EmailSendsuccess() {
        swal({
          title: "Buen Trabajo!!",
          text: "Email enviado",
          type: "success", 
          timer: 5000,   
          showConfirmButton: false
        });
     }

     function estado_success() {
        swal({
          title: "Pago confirmado!!",
          text: "",
          type: "success", 
          timer: 5000,   
          showConfirmButton: false
        });
     }

   

   $(document).on("click",".add_p_envio", function(){
        var id = $(this).attr('data');
        $('#id_compra').val(id);
        
    });
    
    $(document).on("click",".deletecap-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_promo',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  $.toast({
                        heading: 'Promoción eliminada ',
                        text: 'La Promoción a sido eliminada.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 2500
                    });
                  if ($.fn.DataTable.isDataTable( '#adminventa_table' ) ) {
                      table = $('#adminventa_table').DataTable();
                      table.destroy();
                      console.log("estoy dentro el if");
                      load_data_cap();
                      }
                      else {
                           console.log("estoy en el else");
                          load_data_cap();
                          }
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        
    });
       function load_data_cap()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_dataVentas",
            method:"POST",
            success:function(data)
            {
             $('#contenido_tabla').html(data);
               var table = $('#adminventa_table').DataTable({
                 order:[[ 1, "desc" ]],
                 //ordering: false,
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

    </script>
    <!--Style Switcher -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>

 