<style type="text/css">
  .detalle {
         width: 810px;
      }
</style>

<div class="row bg-title">
      <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
          <h4 class="page-title">LISTA DE VENTAS</h4> </div>
      <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
          <ol class="breadcrumb">
              <li><a href="<?php echo base_url();?>">Inicio</a></li>
              <li><a href="<?php echo base_url();?>">Ventas</a></li>
              <li class="active">Lista de Ventas</li>
          </ol>
      </div>
      <!-- /.col-lg-12 -->
  </div>



<div class="row">
  <div class="col-sm-12">
      <div class="white-box">
          <h3 class="box-title">LISTADO  DE VENTAS</h3>
          <div class="table-responsive">
              <table class="table color-table info-table" id="editable-datatable">
                  <thead>
                     <tr>
                        <th>FECHA</th>
                        <th>NO VENTA</th>
                        <th>TOTAL</th>
                        <th>CLIENTE</th>
                        <th>ACCION</th> 
                    </tr>
                  </thead>
                  <tbody id="contenido_compras">
                     
                  </tbody>
              </table>
          </div>
      </div>
  </div>
</div>


<!-- .modal for add task -->
<div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Detalle de Venta </h4>
            </div>
            <div class="modal-body" id="detalle_compra">
               
            </div>
        <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- .modal for add task -->
<div class="modal fade" id="modal-add-cap" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit"><strong id="tit">Editar Venta </strong></h4>
            </div>
            <div class="modal-body" id="">
              <form  id="edit_pedido1" action="<?php echo base_url() ?>capacitacion/edit_pedido" method="post">
              <input type="hidden" id="id_pedido_edit" name="id_pedido_edit" value=" ">
              <input type="hidden" id="id_cliente_edit" name="id_cliente" value=" ">
              
                 <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                         <input type="text"  id="nombre_cliente" name="nombre_cliente" value="" class="form-control" placeholder="Escriba nombre" required> 

                                         <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Apellidos</label>
                                         <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Escriba apellidos" required> 
                                         <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">No.Identidad</label>
                                         <input type="text" id="dni" name="dni" class="form-control" placeholder="Escriba dni" required> 
                                         <span class="help-block">  </span>
                                    </div>
                                </div>
                 </div>
                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Teléfono</label>
                             <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Escriba Teléfono"> 
                             <span class="help-block">  </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Celular</label>
                             <input type="number"  required id="celular" name="celular" class="form-control" placeholder="Escriba celular"> <span class="help-block">  </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Email</label>
                             <input type="email" id="email_edit" name="email"  value="" class="form-control" placeholder="Escriba email"required>
                              <span class="help-block">  </span>
                        </div>
                    </div>
                   
                 </div>
                 <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Fecha Nacimiento</label>
                             <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" placeholder="Escriba fecha nacimiento " required> 
                             <span class="help-block">  </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                          <label class="control-label">Provincia</label>
                            <select class="form-control select2"  name="id_provincia" id="id_provincia_edit" data-placeholder="Seleccione" required>
                              <option value="" selected>Seleccione </option>
                            <?php 
                            if(!empty($provincias))
                                    {
                                      foreach($provincias as $row)
                                        {
                                        echo '<option value="'.$row->id_provincia.'">'.$row->nombre.'</option>';
                                        }
                                    }

                                    ?>
                          </select>
                      </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label">Localidad</label>
                                <input type="hidden" name="id_m" id="id_m" value="">
                                 <select class="form-control select2" required  name="id_municipio" id="id_municipio" data-placeholder="Seleccione">
                                  <option value="" selected>Seleccione *</option>
                                </select>
                            </div>
                    </div>
                 </div>
                 <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Dirección:</label>
                             <textarea type="text" id="direccion" name="direccion" class="form-control" placeholder="Escriba Dirección compra " required> </textarea><span class="help-block">  </span>
                        </div>
                    </div>
                 </div>    
                 <!--/row-->
                 <div class="row">
                   <div class="col-md-4">
                        <div class="form-group">
                            <label class="control-label">Fecha compra:</label>
                             <input type="date" id="fecha_inicio_edit" name="fecha_inicio" value="" class="form-control" required> <span class="help-block">  </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                      
                      <div class="form-group">
                            <label class="control-label">Productos</label>
                            <select class="form-control select2"  name="id_producto" id="id_producto" data-placeholder="Seleccione">
                              <?=  $productos ?>
                            </select>
                      <div class="help-block with-errors"></div>
                        </div>

                    </div>
                 </div>
                 <!--/row-->
                 <div class="row">
                   <div class="col-lg-12">
                    <div class="alert alert-danger" id="mensaje" style="display: none;"></div>
                     <table id="tbl-prod" class="table table-bordered table-striped table-hover">
                        <thead>
                           <tr>
                              <th>Producto</th>
                              <th>Cantidad</th>
                              <th>Precio</th>
                              <th>Importe</th>
                              <th></th>
                          </tr>
                        </thead>
                        <tbody >
                        	
                        </tbody>
                     </table>
                     <div class="form-group">
                                <div class="col-md-3 col-md-offset-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">Total:</span>
                                        <input type="text" class="form-control" placeholder="0.00" name="total" id="total" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                   </div>   
                 </div>
                 <div class="form-actions">
                   <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
                   <button type="button" class="btn btn-default btn-limpiar">Limpiar</button>
                </div>
              </form>
            </div>
        <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->  

<!-- .modal for add task -->
<div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit"> <strong>Comprobante de Venta </strong></h4>
            </div>
            <div class="modal-body" id="comprobante_venta">
               
            </div>
            <hr>
            <div class="text-center">
                <button id="print" class="btn btn-info btn-outline" type="button"> <span><i class="fa fa-print"></i> Imprimir</span> </button>
            </div>
             <hr>
             <br>
<!-- /.modal-content -->
        </div>
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
        load_data_cap();
        $('#edit_pedido').submit(function(e) {
            e.preventDefault();
             // contar las filas de la tbl
              var rowCount =  $("#tbl-prod tbody").children().length; 
              console.log("contar filas"+rowCount );
              if (rowCount == 0){
                 $("#id_producto").attr("required", "true");
                 $('#id_producto').addClass('has-error');
                 $('#mensaje').html("Debe seleccionar al menos un producto");
                 $('#mensaje').show().fadeIn().delay(5000).fadeOut('slow');
                 
              }
            var url = '<?php echo base_url() ?>capacitacion/edit_pedido';
            var data = $('#edit_pedido').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#edit_pedido")[0].reset();
                      }
                 })
                  .done(function(data){
                      //mostrar_comprobante(data);
                     
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                     alert("A ocurrido un error. Intente mas tarde");
                  }) 
                  .always(function(){
                    refres_tbl();
                  });
        });



    });//onready

    var base_url= "<?php echo base_url();?>";

     $(document).on("click",".view-detalle-compra",function(){
        var valor_id = $(this).attr('data');
        console.log(valor_id);
        $.ajax({
            url: base_url + "capacitacion/view_detalleVenta",
            type:"POST",
            dataType:"html",
            data:{id:valor_id},
            success:function(data){
                $("#detalle_compra").html(data);
            }
        });
    });

     function  mostrar_comprobante(id){
            $("#detalleModal").modal("show");
            $.ajax({
            url: "<?php echo base_url();?>capacitacion/comprobanteVenta",
            type:"POST",
            dataType:"html",
            data:{id:id},
            success:function(data){
               // console.log(data);
                $("#comprobante_venta").html(data);
                
            }
        });


        } 

     $(document).on("click",".edit-row-btn",function(){
      var id = $(this).attr('data');
       $('#id_pedido_edit').val(id);
       $.ajax({
            url: "<?php echo base_url();?>capacitacion/getdatos_pedido_emp",
            type:"POST",
            dataType: 'json',
             data:{id:id},
            success:function(data){
                console.log(data.result);
                $('#id_cliente_edit').val(data.result.id_cliente);
                $('#fecha_inicio_edit').val(data.result.fecha_solicitud);
                $('#nombre_cliente').val(data.result.nombre_cliente);
                $('#apellidos').val(data.result.apellidos);
                $('#dni').val(data.result.dni);
                $('#celular').val(data.result.celular);
                $('#email_edit').val(data.result.email);
                $('#direccion').text(data.result.direccion);
                $('#fecha_nacimiento').val(data.result.fecha_nacimiento);
                $('select[name=id_provincia]').val(data.result.id_provincia).attr('selected','selected');
                $('input[name=id_m]').val(data.result.id_municipio);
                $('#total').val(data.result.total);
                armar_selec();
            }
        });
       load_dataPedido(id);

    });


function armar_selec(){
       var id = $('#id_m').val();
      $.ajax({
              type: 'ajax',
              method: 'get',
              url: '<?php echo base_url() ?>capacitacion/armar_municipio',
              data: {id: id},
              async: false,
              dataType: 'json',
            success: function(data){
                console.log(data);
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
    function load_dataPedido(id){

     	$.ajax({
            url:"<?php echo base_url(); ?>capacitacion/load_dataPedido",
            method:"POST",
            data: {id:id},
            dataType: 'html',
            success:function(data)
            {
              $('#tbl-prod tbody').html(data);
              // contar las filas de la tbl
              var rowCount =  $("#tbl-prod tbody").children().length; 
              console.log("contar filas"+rowCount );
              if (rowCount == 0){
                 $("#id_producto").attr("required", "true");
                 $('#id_producto').addClass('has-error');
                 $('#mensaje').html("Debe seleccionar al menos un producto");
                 $('#mensaje').show().fadeIn().delay(5000).fadeOut('slow');
                 sumar();
                 
              }
            }
        })
     }



    $(document).on("change","#id_provincia_edit",function(){
        id = $(this).val();
        $.ajax({
              type: 'ajax',
              method: 'get',
              url: '<?php echo base_url() ?>capacitacion/select_municipiolistado',
              data: {id: id},
              async: false,
              dataType: 'json',
            success: function(data){
               // console.log(data);
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

    $(document).on("change","#id_producto",function(){
         $(this).find('select :first').attr("disabled",'true');
         data = $(this).val();
         infoproducto = data.split("*");

         console.log(infoproducto);

         var option        = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_prod   =  $('select[name="id_producto"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
          
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='productos[]' value='"+infoproducto[0]+"'>"+nombre_prod+"</td>";
            html += "<td><input type='text' name='cantidad[]' value='' class='cantidades' required data-parsley-minlength='1'></td>";
            html += "<td><input type='text' name='precios[]' value='' class='precios' required data-parsley-minlength='1'></td>";
            html += "<td><input type='hidden' name='importes[]' value=''><p></p></td>";
            html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tbl-prod tbody").append(html);
            sumar();
           
        }else{
            alert("seleccione un producto...");
        }
    });



    $(document).on("keyup","#tbl-prod input.precios", function(){
        precio = $(this).val();
        cantidad = $(this).closest("tr").find("td:eq(1)").children("input").val();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(3)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(3)").children("input").val(importe.toFixed(2));
        sumar();
    });

    $(document).on("keyup","#tbl-prod input.cantidad", function(){
        cantidad = $(this).val();
        precio = $(this).closest("tr").find("td:eq(2)").children("input").val();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(3)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(3)").children("input").val(importe.toFixed(2));
        sumar();
    });

  function sumar(){
        total = 0;
        $("#tbl-prod tbody tr").each(function(){
            total = total + Number($(this).find("td:eq(3)").text());
        });
        $("input[name=total]").val(total.toFixed(2));
   }



    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        sumar();
       // contar las filas de la tbl
        var rowCount =  $("#tbl-prod tbody").children().length; 
        console.log("contar filas"+rowCount );
        if (rowCount == 0){
           $("#id_producto").attr("required", "true");
           $('#id_producto').addClass('has-error');
           $('#mensaje').html("Debe seleccionar al menos un producto");
           $('#mensaje').show().fadeIn().delay(5000).fadeOut('slow');

           
        }
  
    });

    

    $(document).on("click",".elim-row-btn", function(){
      sumar();
    	var id = $(this).attr('data');
        swal({   
            title: "¿Estás seguro?",   
            text: "La venta será eliminada de forma permanente!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#DD6B55",   
            confirmButtonText: "¡Sí, bórralo!",   
            cancelButtonText: "No, cancelar!",   
            closeOnConfirm: false,   
            closeOnCancel: false 
        }, function(isConfirm){   
            if (isConfirm) {   

              $(this).closest("tr").remove();
			        $.ajax({
			                type: 'ajax',
			                method: 'get',
			                url: '<?php echo base_url() ?>capacitacion/eliminar_pedidoCli',
			                data: {id: id},
			                async: false,
			                dataType: 'json',
			                success: function(data){
			                  console.log(data);
			                  if (data.comprobador) {
			                  	 swal("Eliminado! "," Su venta ha sido eliminada.", "success");  
			                     refres_tbl();
			                  }
			                },
			                error: function(){
			                  alert('No se pudo eliminar');
			                }
			        }); 
            } else {     
                swal("Cancelado "," Tu archivo  es seguro :)", "error");   
            } 
        });
    
       

       
        
    });


       function refres_tbl(){
          if ($.fn.DataTable.isDataTable('#editable-datatable' ) )
                     {
                      table = $('#editable-datatable').DataTable();
                      table.destroy();
                      load_data_cap();
                    }else {
                           load_data_cap();
                          }
      }



    $(document).on("click",".deletecomb-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        var rowCount =  $("#tbl-prod tbody").children().length;  //$('#tbl-prod tbody tr').length; 
              console.log("contar filas"+rowCount );
              if (rowCount == 0){
                 $("#id_producto").attr("required", "true");
                 $('#id_producto').addClass('has-error');
                 $('#mensaje').html("Debe seleccionar al menos un producto");
                 $('#mensaje').show().fadeIn().delay(5000).fadeOut('slow');
                 
              }

        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>capacitacion/eliminar_prod_pedido',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  console.log(data);
                  if (data.comprobador) {
                    $.toast({
                        heading: 'Producto eliminado',
                        text: 'El Producto eliminado exitosamente.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 2500
                    });
                  }
                  refres_tbl();
                  
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        
    });


    


       function load_data_cap()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/load_mis_Ventas",
            method:"POST",
            success:function(data)
            {
             $('#contenido_compras').html(data);
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
    </script>
    <!--Style Switcher -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>