<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTACION DE VENTAS</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Ventas</a></li>
                            <li class="active">Nueva Venta</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                  
                </div>

<!-- .modal for add task -->
<div class="modal fade " id="insetcapModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit"><strong>Lista de Clientes</strong>  </h4>
            </div>
            <div class="modal-body">
               
            
            <div class="form-group">
                
              
            </div>
            <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="table-responsive">
                                <table class="table table-hover manage-u-table" id="editable-datatable">
                                    <thead>
                                        <tr>
                                          <th width="50">Seleccione</th>
                                            <th>No.Identidad</th>
                                            <th>Cliente</th>
                                            <th>Teléfono</th>
                                            <th>Celular</th>
                                            <th width="250">Email</th>
                                            
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
        <!-- /.modal-content -->
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





<div class="row">
      <div class="col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Detalle Venta</div>
                            <div class="panel-wrapper collapse in">

                                <div class="panel-body">
                                  <div class="row">
                                <div class="col-md-4">
                                    <h3 class="box-title"><button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#insetcapModal"><i class="fa fa-search"></i> Buscar Cliente</button> </h3>
                                   
                                </div>
                               
                            </div>
                    <form  id="add_prod" action="<?php echo base_url() ?>capacitacion/add_pedido" method="post" >
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre:</label>
                                         <input type="text" id="nombre_cliente" name="nombre_cliente" class="form-control" placeholder="Escriba nombre " required> 
                                         <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Apellidos:</label>
                                         <input type="text" id="apellidos" name="apellidos" class="form-control" placeholder="Escriba apellidos" required>
                                          <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">No.Identidad:</label>
                                         <input type="text" id="dni" name="dni" class="form-control" placeholder="Escriba dni" required>
                                          <span class="help-block">  
                                         </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Teléfono:</label>
                                         <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Escriba Telefono " required>
                                          <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Email:</label>
                                         <input type="text" id="email" name="email" class="form-control" placeholder="Escriba email" required> 
                                         <span class="help-block">  </span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Celular:</label>
                                         <input type="text" id="celular" name="celular" class="form-control" placeholder="Escriba celular" required> 
                                         <span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Fecha Nacimiento:</label>
                                         <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" placeholder="Escriba fecha nacimiento " > 
                                         <span class="help-block">  </span>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                  <div class="form-group">
                                      <label class="control-label">Provincia</label>
                                        <select class="form-control "  name="id_provincia" id="id_provincia" data-placeholder="Seleccione" required>
                                            <option  value="" disabled selected>Seleccione </option>
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
                                             <select class="form-control " required  name="id_municipio" id="id_municipio" data-placeholder="Seleccione">
                                              <option value="" selected>Seleccione *</option>
                                            </select>
                                        </div>
                                </div>
                                
                            </div>
                            <div class="row">
                              <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Dirección:</label>
                                         <textarea type="text" id="direccion" name="direccion" class="form-control" placeholder="Escriba Dirección compra "> </textarea><span class="help-block">  </span>
                                    </div>
                                </div>
                            </div>    
                             <div class="row">
                                <div class="col-md-6">
                                  <div class="form-group">
                                        <label class="control-label">Categorías</label>
                                        <select class="form-control"  name="id_categoria" id="id_categoria" 
                                        data-placeholder="Seleccione" required>
                                            
                                          <?=  $categorias ?>
                                        </select>
                                    </div>
                                   
                                </div>
                                <div class="col-md-6">
                                  <div class="form-group">
                                        <label class="control-label">Productos</label>
                                        <select class="form-control"  name="id_producto_alm" id="id_producto_alm" data-placeholder="Seleccione" required disabled="true">
                                              <option value="" selected>Seleccione *</option>
                                        </select>
                                    </div>
                                   
                                </div>
                                
                            </div>
                            <div class="row">
                               <div class="col-lg-12">
                                 <table id="tb-combo" class="table table-bordered table-striped table-hover">
                                  <thead>
                                      <tr>
                                          <th>Producto</th>
                                          <th>Existencia</th>
                                          <th>Cantidad</th>
                                          <th>Precio</th>
                                          <th>Importe</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody id="list_venta">
                                  
                                  </tbody>
                              </table>
                              <div class="form-group">
                                <div class="col-md-3 col-md-offset-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">Total:</span>
                                        <input type="text" class="form-control" placeholder="0.00" name="total" readonly="readonly">
                                    </div>
                                </div>
                            </div>
                            </div>   
                            </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success collapseble" id="confirmar_pedido"> <i class="fa fa-check"></i> Guardar</button>
                            <button type="button" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
 

</div>
        </div>
    </div>

</div>


  <!-- Editable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>

    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-print/jquery.print.js"></script>  


    
 
    <script>
    
    $(document).ready(function() {

        load_data_cap();
        load_data_vencimientos();
      
        $('#id_categoria').on("change", function(evt){
          var id = $('#id_categoria').val();
         $("#id_producto_alm").attr("disabled",false);
          $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>capacitacion/productos_almacen",
            data: {id: id},
            success: function (data) {
                console.log(data);
              $('#id_producto_alm').html(data);
             }
          });
    });


        $("#id_producto_alm").on("change",function(){
         $(this).find('select :first').attr("disabled",'true');
         data = $(this).val();
         infoproducto = data.split("*");

         var option        = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_prod   =  $('select[name="id_producto_alm"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
          
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='productos[]' value='"+infoproducto[0]+"'>"+nombre_prod+"</td>";
            html += "<td>"+infoproducto[1]+"</td>";
            html += "<td><input type='text' name='cantidades[]' value='' class='cantidades' required data-parsley-minlength='1'></td>";
            html += "<td><input type='text' name='precios[]' value='' class='precios' required data-parsley-minlength='1'></td>";
            html += "<td><input type='hidden' name='importes[]' value=''><p></p></td>";
            html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tb-combo tbody").append(html);
            sumar();
           
        }else{
            alert("seleccione un producto...");
        }
    });


        $('#add_prod').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>capacitacion/add_pedido';
            var data = $('#add_prod').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#add_prod")[0].reset();
                        //sweetalertclick();
                      $("#list_venta").empty(); 

                      }
                 })
                  .done(function(data){
                      mostrar_comprobante(data);
                     
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                     alert("A ocurrido un error. Intente mas tarde");
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

        $(document).on("click","#print",function(){

        $("#detalleModal .modal-body").print({
            title:"Comprobante de Venta"
        });
    });

     


      

       
     
     $(document).on("click",".btn-check",function(){
        var id = $(this).attr('data');

        $.ajax({
              type: 'ajax',
              method: 'get',
              url: '<?php echo base_url() ?>capacitacion/datos_cliente',
              data: {id:id},
              async: false,
              dataType: 'json',
            success: function(data){

                $('input[name=nombre_cliente]').val(data.nombre_cliente);
                $('input[name=apellidos]').val(data.apellidos);
                $('input[name=dni]').val(data.dni);
                $('input[name=telefono]').val(data.telefono);
                $('input[name=email]').val(data.email); 
                $('input[name=celular]').val(data.celular); 
                $('input[name=fecha_nacimiento]').val(data.fecha_nacimiento);
                $('select[name=id_provincia]').val(data.id_provincia).attr('selected','selected');
                $('input[name=id_m]').val(data.id_municipio);
                $('textarea[name=direccion]').val(data.direccion);
                $("#insetcapModal").modal("hide");
                armar_selec();

                 
            },
            error: function(){
                 alert('No hay datos q mostrar');
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


    $(document).on("click",".btn-vista-previa",function(){
     var nombre_cliente = $('input[name=nombre_cliente]').val();
     var apellidos      = $('input[name=apellidos]').val();
     var dni            =  $('input[name=dni]').val();
     var telefono       =  $('input[name=telefono]').val();
     var celular        =  $('input[name=celular]').val();
     var email          =  $('input[name=email]').val();
     var fecha_incio    =  $('input[name=fecha_incio]').val();
     var direccion      =  $('textarea[name=direccion]').val();
     
      $('#v_nombre_cliente').text(nombre_cliente+" "+apellidos);  
      $('#v_dni').text(dni);
      $('#v_telefono').text(telefono);
      $('#v_email').text(celular); 
      $('#v_name=celular').text(email); 
      $('#v_direccion').text(direccion);
      $('#v_fecha_incio').text(fecha_incio); 
      
      

    });   


     
        
           
        
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


    
    $(document).on("keyup","#tb-combo input.precios", function(){
        precio = $(this).val();
        cantidad = $(this).closest("tr").find("td:eq(2)").children("input").val();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(4)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(4)").children("input").val(importe.toFixed(2));
        sumar();
    });

    $(document).on("keyup","#tb-combo input.cantidades", function(){
        cantidad = $(this).val();
        precio = $(this).closest("tr").find("td:eq(3)").children("input").val();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(4)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(4)").children("input").val(importe.toFixed(2));
        sumar();
    });

    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        sumar();
    });

     function sumar(){
        total = 0;
        $("#tb-combo tbody tr").each(function(){
            total = total + Number($(this).find("td:eq(4)").text());
        });
        $("input[name=total]").val(total.toFixed(2));
   }


    function load_data_vencimientos()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/load_data_vencimientos",
            method:"POST",
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
            
            }
        })
    }
       function load_data_cap()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/load_dataClientesVentas",
            method:"POST",
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
    </script>
    <!--Style Switcher -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/styleswitcher/jQuery.style.switcher.js"></script>