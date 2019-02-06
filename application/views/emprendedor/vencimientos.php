<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">ADMINISTACION DE VENCIMIENTOS</h4> </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Vencimientos</a></li>
            <li class="active">Venc. Productos</li>
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
                <h4 class="modal-title" id="titulo_invit"><strong>Reposición de unidades filtrantes </strong> </h4>
            </div>
            <div class="modal-body">
           
            <div class="row">
              <div class="col-md-12">
                 <div class="alert alert-danger" id="mensaje" style="display: none;"> No hay stock  de este producto en almacen </div>
                 <div class="table-responsive">
                 
                   <table id="tb-exist_resp" class="table table-bordered table-striped table-hover color-bordered-table info-bordered-table ">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Vencimientos sugeridos</th>
                            <th>Fecha Vencimiento</th>
                            <th>Cantidad</th>
                             <th>Precio</th>
                            <th>Importe</th>
                            <th>Agregar</th>
                        </tr>

                    </thead>
                    <tbody id="contenido_vencimientos">
                     
                    
                    </tbody>
                </table>
                <div class="form-group">
                  <div class="col-md-3 col-md-offset-9">
                      <div class="input-group">
                          <span class="input-group-addon">SubTotal:</span>
                          <input type="text" class="form-control" placeholder="0.00" name="resp_total" readonly="readonly">
                      </div>
                  </div>
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

<div class="row">
      <div class="col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Vencimientos sugeridos</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                  <div class="row">
                                <div class="col-md-4">
                                </div>
                               
                            </div>

                            <div class="row " id="existencia_respuesto" style="">
                               <div class="table-responsive  block2">
                                <h3 class="box-title">Cliente con vencimientos</h3>
                                 <div class="alert alert-danger mensaje"  style="display: none;"> No hay stock  de este producto en almacen </div>
                                 <table id="tb-lista_cli" class="table table-striped table-hover color-bordered-table warning-bordered-table">
                                  <thead>
                                      <tr>
                                          <th>Cliente</th>
                                          <th>Producto Vencido</th>
                                          <th>Almacen</th>
                                          <th>Fecha Vencimiento</th>
                                          <th>Seleccionar</th>
                                      </tr>

                                  </thead>
                                  <tbody id="listaCli_vencimientos">
                                  
                                  </tbody>
                                 
                              </table>
                            </div>   
                            </div>
                              <br><br>
                    <form  id="add_prod" action="" method="post" >

                        <div class="form-body">
                          <h3 class="box-title"></h3>

                       <div class="row mostrar-btn-clientes" style="display: none;" id="">
                           <div class="col-md-6">
                              <span class="text-left">
                                <a href="#"  id="agregar_prod" class="fcbtn  btn btn-primary btn-outline m-b-2">
                                <i class="fa fa-plus"></i> Agregar otros productos</a>
                              </span>
                           </div>
                           <div class="col-md-6">
                                <span class="text-left">
                                <a class=" fcbtn  btn btn-primary btn-outline m-b-20 mostrar_clientes">
                                  Cambiar de Cliente <i class="fa fa-refresh"></i></a></span>
                           </div>
                        </div>


                          

                             <div class="row" id="mas_prod" style="display: none;">
                                <div class="col-md-6">
                                  <div class="form-group">
                                        <label class="control-label">Categorías</label>
                                        <select class="form-control select2"  name="id_categoria" id="id_categoria" data-placeholder="Seleccione" >
                                          <option value="" selected>Seleccione *</option>
                                          <?=  $categorias ?>
                                        </select>
                                    </div>
                                 </div>

                                 <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Productos</label>
                                        <select class="form-control"  name="id_producto_alm" id="id_producto_alm" data-placeholder="Seleccione" disabled="true">
                                          <option value="" selected>Seleccione *</option>
                                          
                                        </select>
                                    </div>
                                 </div>
                            </div>


                            <div class="row">
                               <div class=" table-responsive col-lg-12">
                                 <table id="tb-combo" class="table table-bordered table-striped table-hover color-bordered-table success-bordered-table">
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
                                  <tbody id="compra">
                                    
                                  
                                  </tbody>

                              </table>
                              <div class="form-group">
                                <div class="col-md-3 col-md-offset-9">
                                    <div class="input-group">
                                        <span class="input-group-addon">Total:</span>
                                        <input type="text" class="form-control" placeholder="0.00" name="total" readonly="readonly">
                                        <input type='hidden' name='id_cliente' id="id_cliente" value=''>
                                    </div>
                                </div>
                            </div>
                            </div> 


                            </div>
                            <!--/row-->
                  
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success collapseble" id="confirmar_pedido" disabled="true"> <i class="fa fa-check"></i> Guardar</button>
                            <button type="button" class="btn btn-default">Limpiar</button>
                        </div>
                    </form>
                </div>
 

</div>
        </div>
    </div>

</div>

  <script src="<?php echo base_url();?>assets/plugins/bower_components/blockUI/jquery.blockUI.js"></script>
  <!-- Editable -->
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>
    
    <script>


    $('.mostrar_clientes').click(function() {
      
        $('#insetcapModal').modal('hide');
        //$('div.block2').show();
        //$('div.block2').unblock();
        $('#existencia_respuesto').show();
        $('#contenido_vencimientos').empty();
        $('#tb-combo tbody').empty();
        $("#add_prod")[0].reset();
        $('#mas_prod').hide();
        $('#agregar_prod').hide();
        $('.mostrar_clientes').hide();
        $('#agregar_prod').html('<i class="fa fa-plus"></i> Agregar otros productos').removeClass("btn-danger").addClass("btn-primary");
        
    });


     $('#agregar_prod').click(function() {
      
        $('#mas_prod').toggle();
         $('#agregar_prod').html('<i class="fa fa-minus"></i> Ocultar productos').removeClass("btn-primary").addClass("btn-danger");


     
        
    });


    
    $(document).ready(function() {
       var verificador = 0;
        var cantida = 0;
        load_data_cap();
        load_data_vencimientos();
      
        $('#id_categoria').on("click", function(evt){
          var id = $('#id_categoria').val();
          $('#id_categoria').attr("required",true);
          $('#id_producto_alm').attr("required",true);
          $("#id_producto_alm").attr("disabled",false);
          $.ajax({
            type: "POST",
            url: "<?php echo base_url();?>capacitacion/productos_almacen",
            data: {id: id},
            success: function (data) {
              $('#id_producto_alm').html(data);
             }
          });
    });


        $("#id_producto_alm").on("change",function(){
         $(this).find('select :first').attr("disabled",'true');
         $('#id_producto_alm').attr("required",true);
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
            html += "<td><input type='hidden' name='reposicion' value='0'><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tb-combo tbody").append(html);
            sumar();
           
        }else{
            alert("seleccione un producto...");
        }
    });


    $('#add_prod').submit(function(e) {
      //alert(aq);
            e.preventDefault();
            var url = '<?php echo base_url() ?>capacitacion/add_reposicion';
            var data = $('#add_prod').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        $("#add_prod")[0].reset();
                        sweetalertclick();
                      }
                 })
                  .done(function(data){
                     console.log(data);
                     sweetalertsuccessVenta();
                     
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
                           sweetalertsuccessVenta();
                          load_data_cap();

                          }
                  });
        }); 

  function sweetalertsuccessVenta() {
        swal({
          title: "Buen Trabajo!!",
          text: "Venta Agregada",
          type: "success", 
          timer: 2000,   
          showConfirmButton: false
        });
        setTimeout('document.location.reload()',3502);
       
 
     }           

       
     
  $(document).on("click",".btn-select-cli",function(){
      
       var data = $(this).attr('data');
       var infobtn = data.split("*");
       var id       = infobtn[0];
       var stock    = infobtn[1];
       var id_prod  = infobtn[2];
       console.log(stock);
        if(stock == 0){
          console.log(stock);
          $(".btn-add-car",this).attr("disabled",true);
          if (stock == 0) {$('.mensaje').html("No hay Stock de este producto en el almacen").show();}
         
        }else{
                $('.mensaje').hide();
                $('#insetcapModal').modal('show');
                //var id = $(this).attr('data');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>capacitacion/Seccion_clientes_venc",
                    data: {id: id,id_producto:id_prod},
                    success: function (data) {
                      $('#contenido_vencimientos').html(data);
                     }
                  });
              }
 
    });


  $(document).on("click",".btn-add-car",function(){


    var cantida = 0;
    var tableData = $('tr').children("td").children("input").map(function() {
        return $(this).val();
    }).get();

        cantida     = $.trim(tableData[0]); 
    var precio      = $.trim(tableData[1]);
    if (cantida == 0) {$('#mensaje').html("Debe ser Mayor a cero").show();}

    var stock = parseInt($('#existencia_prod').val());
    if(cantida > stock){
      console.log(stock);
      $(".btn-add-car").attr("disabled",true);
      if (cantida  > stock) {$('#mensaje').html("Solo tiene "+stock+"en stock").show();}
    }
    
    if (cantida == "" && precio == ""){
      alert("Debe completar los campos vacios");
    }else{

      var stock = parseInt($('#existencia_prod').val());
    if(cantida > stock){
      console.log(stock);
      $(".btn-add-car").attr("disabled",true);
      if (cantida  > stock) {$('#mensaje').html("Solo tiene "+stock+"en stock").show();}
    }else{
       
       var data = $(this).attr('data');
       var infoproducto = data.split("*");
       var id_prod_vencimiento = infoproducto[0];
       var id_producto         = infoproducto[1];       
       var nombre_prod         = infoproducto[2];
       var existencia          = infoproducto[3];
       var id_cliente          = infoproducto[4];
       var tableData = $('tr.resingao'+id_prod_vencimiento).children("td").children("input").map(function() {
        return $(this).val();
    }).get();

      /* $('div.block2').block({
            //message: '<h3>Solo puede seleccionar un cliente a la vez</h3>',
            overlayCSS: {
                backgroundColor: '#02bec9'
            },
            css: {
                border: '1px solid #fff'
            }
        });*/
        
        $('#existencia_respuesto').attr('style', 'display:none');
        $('#insetcapModal').modal('hide');
       $('div.mostrar-btn-clientes').show();
      // $('div.block2').css('display','none');
       
     var cantida     = $.trim(tableData[0]); 
     var precio      = $.trim(tableData[1]);
     var importe     = $.trim(tableData[2]); 
     var reposicion  = $.trim(tableData[3]);
     
     $("#id_cliente").val(id_cliente);
     var  html = "<tr>";
          html += "<td><input type='hidden' name='rep_productos[]' value='"+id_prod_vencimiento+"'>"+nombre_prod+"</td>";
          html += "<td><input type='hidden' name='rep_idproductos[]' value='"+id_producto+"'>"+existencia+"</td>";
          html += "<td><input type='text' name='rep_cantidades[]' value='"+cantida+"' class='cantidades' required data-parsley-minlength='1'></td>";
          html += "<td><input type='text' name='rep_precios[]' value='"+precio+"' class='precios' required data-parsley-minlength='1'></td>";
          html += "<td><input type='hidden' name='rep_importes[]' value='"+importe+"' ><p>"+importe+"</p></td>";
          html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
          html += "</tr>";
          $("#tb-combo tbody").append(html);
          sumar();
      }
    
    }
 
    });

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

   


 $(document).on("keyup","#tb-exist_resp input.resp_cantidades", function(){

       var stock = parseInt($('#existencia_prod').val());
        if(cantida == 0 || cantida > stock){
          console.log(stock);
          $(".btn-add-car").attr("disabled",true);
          if (cantida == 0) {$('#mensaje').html("No hay Stock de este producto en el almacen").show();}
          if (cantida  > stock) {$('#mensaje').html("El valor debe ser inferior o igual a "+stock).show();}
         
        }else{
            cantidad = $(this).val();
            precio = $(this).closest("tr").find("td:eq(4)").children("input").val();
            importe = cantidad * precio;
            $(this).closest("tr").find("td:eq(5)").children("p").text(importe.toFixed(2));
            $(this).closest("tr").find("td:eq(5)").children("input").val(importe.toFixed(2));
            sumar_venc();
        }
    });

  $(document).on("keyup","#tb-exist_resp input.resp_precios", function(){

        precio = $(this).val();
        cantidad = $(this).closest("tr").find("td:eq(3)").children("input").val();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(5)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(5)").children("input").val(importe.toFixed(2));
        sumar_venc();
    });

  $(document).on("change","#tb-exist_resp input.resp_cantidades", function(){

     var stock = parseInt($('#existencia_prod').val());
     var  cantidad = $(this).val();
    if(cantida > stock){
      console.log(stock);
      $(".btn-add-car").attr("disabled",true);
      if (cantida  > stock) {$('#mensaje').html("El valor debe ser inferior o igual a "+stock).show();}
    }else{
      $(".btn-add-car").attr("disabled",false);
          cantidad = $(this).val();
          precio = $(this).closest("tr").find("td:eq(4)").children("input").val();
          importe = cantidad * precio;
          $(this).closest("tr").find("td:eq(5)").children("p").text(importe.toFixed(2));
          $(this).closest("tr").find("td:eq(5)").children("input").val(importe.toFixed(2));
          sumar_venc();
         }
    });


   $(document).on("change","#tb-exist_resp input.resp_precios", function(){

        precio = $(this).val();
        cantidad = $(this).closest("tr").find("td:eq(3)").children("input").val();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(5)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(5)").children("input").val(importe.toFixed(2));
        sumar_venc();
    });

  

   

     function sumar_venc(){
        total = 0;
        $("#tb-exist_resp tbody tr").each(function(){
            total = total + Number($(this).find("td:eq(5)").text());
            
        });
        if (total != 0.00){ $('#confirmar_pedido').attr("disabled",false);}
        $("input[name=resp_total]").val(total.toFixed(2));
      } 


   
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

    $(document).on("change","#tb-combo input.precios", function(){
        precio = $(this).val();
        cantidad = $(this).closest("tr").find("td:eq(2)").children("input").val();
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(4)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(4)").children("input").val(importe.toFixed(2));
        sumar();
    });

    $(document).on("change","#tb-combo input.cantidades", function(){
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
        if (total != 0.00){ $('#confirmar_pedido').attr("disabled",false);}
        $("input[name=total]").val(total.toFixed(2));
       
   }




   

      function load_data_vencimientos()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/clientes_vencimiento",
            method:"POST",
            success:function(data)
            {
             $('#listaCli_vencimientos').html(data);
               var table = $('#tb-lista_cli').DataTable({
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