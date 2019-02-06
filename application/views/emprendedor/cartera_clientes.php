<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ALTA DE CLIENTES</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Consultas Cartera</a></li>
                            <li class="active">Alta de Clientes</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
 </div>


<!-- .modal for add task -->
<div class="modal fade" id="modal-add-cap" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit"><strong id="tit"> </strong></h4>
            </div>
            <div class="modal-body" id="">
              <form  id="add_prod" action="" method="post" >
                 <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label">Nombre</label>
                                         <input type="text"  id="nombre_cliente" name="nombre_cliente" class="form-control" placeholder="Escriba nombre" required> 

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
                             <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Escriba Telefono " required> 
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
                             <input type="email" id="email" name="email" class="form-control" placeholder="Escriba email"required>
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
                            <select class="form-control select2"  name="id_provincia" id="id_provincia" data-placeholder="Seleccione" required>
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
                             <input type="date" id="fecha_incio" name="fecha_incio" class="form-control" placeholder="Escriba fecha compra " required> <span class="help-block">  </span>
                        </div>
                    </div>
                    <div class="col-md-12">
                      <div class="form-group">
                            <label class="control-label">Productos</label>
                            <select class="form-control select2"  name="id_producto" id="id_producto" data-placeholder="Seleccione" required>
                              <?=  $productos ?>
                            </select>
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
                                <th>Cantidad</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody >
                        </tbody>
                     </table>
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
<div class="modal fade" id="modal-upload-excel" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit"><strong id="tit">Importar Cartera de Clientes</strong></h4>
            </div>
            <div class="modal-body" id="">
                <div class="alert alert-danger" id="msg-error" style="display: none;">
                         <strong>¡Importante!</strong>  
                          <div  id="list_errors"></div>
                        </div>
              <form  id="import_form" action="" method="post" enctype="multipart/form-data" >

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label"></label>
                             <a  href="<?php echo base_url(); ?>download_planilla" download class="btn btn-primary fcbtn btn btn-outline btn-primary btn-1c">
                              <i class="fa fa-download"></i>
                              Dercargar Planilla Excel </a> 

                        </div>
                    </div>
                 </div> 

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="col-md-12 col-xs-12">
                                <label for="input-file-now">Importar Archivo Excel:</label>
                                <input type="file" name="file" id="file" required accept=".xls, .xlsx" />
                            </div>
                        </div>
                    </div>
                 </div>
                 <br>
                 
                <div class="row">  
                <div class="col-md-12">
                      <div class="progress progress-sm progress-striped" style="display: none;">
                          <div class="progress-bar progress-bar-success active progress-bar-striped" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" id="bar" style="width: 0%" role="progressbar"> 
                          </div>
                         </div> 
                   </div> 
                 </div> 
                 <br>
              
                 <div class="form-actions">
                   <button type="submit" class="btn btn-success" id="import"> <i class="fa fa-upload"></i> Importar</button>
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

              


<div class="row">
  <div class="col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Cartera de clientes</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                      
                                      <div class="m-t-15 collapseblebox dn">
                                            <div class="well">
                                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                                     <div class="panel-body">
                                                        <form  id="" action="<?php echo base_url() ?>panel_admin/insert_prod" method="post" >
                                                            <input type="hidden" name="id_producto_edit" id="id_producto_edit" value="">
                                                            <input type="hidden" name="camino" id="camino" value="">

                                                            <div class="form-body">
                                                                <div class="row">
                                                                  <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Categorías:</label>
                                                                            <select class="form-control" data-placeholder="Seleccione una Categoria" tabindex="1" name="id_categoria" id="id_categoria" required>
                                                                              <?php if(!empty($categorias))
                                                                                {
                                                                                  foreach($categorias as $row)
                                                                                    {
                                                                                     echo '<option value="'.$row->id.'">'.$row->nombre.'</option>';
                                                                                    }
                                                                                } ?>
                                                                            </select>
                                                                          
                                                                        <div class="help-block with-errors"></div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label class="control-label">Detalle:</label>
                                                                            <div class="radio-list">
                                                                                <label class="radio-inline p-0">
                                                                                    <div class="radio radio-info">
                                                                                        <input type="radio" name="es_repuesto" value="1"  checked required>
                                                                                        <label for="es_repuesto">Producto</label>
                                                                                    </div>
                                                                                </label>
                                                                                <label class="radio-inline">
                                                                                    <div class="radio radio-info">
                                                                                        <input type="radio" name="es_repuesto" value="2" required>
                                                                                        <label for="es_repuesto">Repuesto </label>
                                                                                    </div>
                                                                                </label>
                                                                            </div>
                                                                        <div class="help-block with-errors"></div>
                                                                        </div>


                                                                        <div class="form-group">
                                                                            <label class="control-label">Nombre:</label>
                                                                            <input type="text" id="nombre_prod" name="nombre_prod" class="form-control"  required data-error="Agrege Nombre Producto " > 
                                                                            <div class="help-block with-errors"></div></div>
                                                                    

                                                                    </div>
                                           
                                                                    <div class="col-md-6 col-xs-12 btn-file">
                                                                        <label for="input-file-now">Subir imagen:</label>
                                                                        <input type="file" id="" name="" class="dropify " data-default-file=""  required
                                                                        data-error="Agrege una imagen"/>
                                                                        <input type="hidden" id="" name=""  value="" class="form-control">
                                                                        <div class="help-block with-errors"></div>

                                                                    </div>
                                                                    
                                                                </div>

                                                                <!--/row-->
                                                                <div class="row">
                                                                   
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label"> Precio Costo:</label>
                                                                            <input type="text" id="costo" name="costo" class="form-control"  required data-error="Agrege  Precio costo"  > 
                                                                            <div class="help-block with-errors"></div></div>
                                                                    </div>

                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Precio:</label>
                                                                            <input type="text" id="precio" class="form-control" name="precio" required data-error="Agrege Precio ">
                                                                             <div class="help-block with-errors"></div> </div>
                                                                    </div>
                                                                    <!--/span-->
                                                                   
                                                                    <!--/span-->
                                                                </div>
                                                                <!--/row-->
                                                                <div class="row">
                                                                      <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Existencia:</label>
                                                                                <input type="text" id="existencia" name="existencia" class="form-control"
                                                                                 required data-error="Agrege Existencia"> 
                                                                                <div class="help-block with-errors"></div> 
                                                                            </div>
                                                                        </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Vencimiento:</label>
                                                                            <input type="num" id="vencimiento" name="vencimiento" class="form-control" required data-error="Agrege Vencimiento"> 
                                                                            <div class="help-block with-errors"></div> </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                      <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Alto:</label>
                                                                                <input type="text" id="alto" name="alto" class="form-control" required data-error="Agrege Alto"> <div class="help-block with-errors"></div> </div>
                                                                        </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Ancho:</label>
                                                                            <input type="text" id="ancho" name="ancho" class="form-control" required data-error="Agrege Ancho"> <div class="help-block with-errors"></div> </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                      <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">Largo:</label>
                                                                                <input type="text" id="largo" name="largo" class="form-control" required data-error="Agrege Largo "> <div class="help-block with-errors"></div> </div>
                                                                        </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Peso:</label>
                                                                            <input type="text" id="peso" name="peso" class="form-control" required data-error="Agrege Peso"> <div class="help-block with-errors"></div> </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                      <div class="col-md-6">
                                                                            <div class="form-group">
                                                                                <label class="control-label">SKU:</label>
                                                                                <input type="text" id="sku"  name="sku" class="form-control" required data-error="Agrege SKU"> 
                                                                                <div class="help-block with-errors"></div> </div>
                                                                        </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label class="control-label">Valor Declarado:</label>
                                                                            <input type="text" id="valor_declarado" name="valor_declarado" class="form-control" required data-error="Agrege Valor Declarado"> <div class="help-block with-errors"></div> </div>
                                                                    </div>
                                                                </div>

                                                            <div class="form-actions">
                                                                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
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
                      <h3 class="box-title">
                       <button type="button" id="btn-add-cap" data-toggle="modal" data-target="#modal-add-cap" class="btn btn-info btn-rounded"> <i class="fa fa-plus"></i> Agregar Alta</button>
                       <button type="button" id="btn-add-cap" data-toggle="modal" data-target="#modal-upload-excel" class="btn btn-primary btn-rounded"> <i class="fa fa-upload"></i> Importar Clientes </button>
                     </h3>

                        <div class="panel">
                            <div class="table-responsive">
                                <table class="table table-hover manage-u-table contact-list" id="editable-datatable">
                                    <thead>
                                        <tr>
                                            <th>No.Identidad</th>
                                            <th>Cliente</th>
                                            <th>Teléfono</th>
                                            <th>Celular</th>
                                            <th>Email</th>
                                            <th>Historial</th>
                                            <th>Accion</th>
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

</div>


  <!-- Editable -->
   <script src="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-table/dist/bootstrap-table.min.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/bootstrap-table/dist/bootstrap-table.ints.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
   

   
    <script>


    
    $(document).ready(function() {
        load_data_cap();
        
         $("#id_repuesto").on("change",function(){
        // $(this).find('select :first').attr("disabled",'true');
         data = $(this).val();
         var option        = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_prod   =  $('select[name="id_repuesto"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='respuestos[]' value='"+data+"'>"+nombre_prod+"</td>";
            html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tb-combo tbody").append(html);
           
        }else{
            alert("seleccione un producto...");
        }
    });

     $('#add_respuesto').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/insert_repuesto';
            var data = $('#add_respuesto').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        
                      $('#asociar-respuesto').modal("hide");
                        console.log("enviando....");
                      }
                 })
                  .done(function(){
                    console.log(data);
                      $.toast({
                          heading: 'Respuesto Agregado',
                          text: 'Se agregó corectamente la información.',
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



        $('#add_prod').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>capacitacion/insert_cliente';
            var data = $('#add_prod').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {

                        $("#add_prod")[0].reset();
                        $("#tb-combo tbody").empty();
                        $("#modal-add-cap").modal("hide");
                        }
                 })
                  .done(function(data){

                    console.log(data);
                      $.toast({
                          heading: 'Cliente Agregado',
                          text: 'Se agregó corectamente la información.',
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
     
 $("#id_producto").on("change",function(){
         $(this).find('select :first').attr("disabled",'true');
         data = $(this).val();
         var option        = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_prod   =  $('select[name="id_producto"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='productos[]' value='"+data+"'>"+nombre_prod+"</td>";
            html += "<td><input type='text' name='cantidades[]' value='' class='cantidades' required data-parsley-minlength='2'></td>";
            html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tb-combo tbody").append(html);
           
        }else{
            alert("seleccione un producto...");
        }
    });

 $('.btn-file').on("change", function(evt){
var base_url= "<?php echo base_url();?>";
$('#url_imagen').attr('required',true);
// declaro la variable formData e instancio el objeto nativo de javascript new FormData
var formData = new FormData(document.getElementById("add_prod"));
// iniciar el ajax
$.ajax({
    url: base_url + "panel_admin/subir_img",
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
        replace: file ,
        remove: 'Remover',
        error: 'No se pudo mostrar'
    }
});

 $("#file").click(function(){

       $("#import_form")[0].reset();
       $("#msg-error").hide();
       $("#list_errors").html("");
       $("#import").attr("disabled",false);
    });


$('#import_form').on('submit', function(event){
     event.preventDefault();
     archivo =  comprueba_extension();
     console.log(archivo);
  if (archivo == false) {
    $("#msg-error").show(); 
    $("#list_errors").html(" Comprueba la extensión de los archivos a subir. Sólo se pueden subir archivos con extensiones: .xlsx,.xls");
    $("#import").attr("disabled",true);

  }else{
    $("#import").attr("disabled",false);

    $.ajax({
      url:"<?php echo base_url(); ?>capacitacion/import",
      method:"POST",
      data:new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
        beforeSend:function(){
                $('#import').html('Importando...<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
        },
        success:function(data){
                $('#file').val('');
                $('#modal-upload-excel').modal('hide');
                console.log(data);
                if ($.fn.DataTable.isDataTable( '#editable-datatable' ) ) {
                              table = $('#editable-datatable').DataTable();
                              table.destroy();
                              console.log("estoy dentro el if");
                              load_data_cap();
                              }
                              else {
                                   console.log("estoy en el else");
                                  load_data_cap();
                                  }

                $("#import").removeClass("btn btn-primary");
                $("#import").addClass("btn btn-success");
                $('#import').html('Importación Completada  <i class="fa fa-check-circle"></i>');  
                $("#panel_datos").removeClass("btn btn-primary");
                $("#panel_datos").addClass("panel panel-success");
        }

    })

       }
    



  });


        
 });//onready

function comprueba_extension() { 
   extensiones_permitidas = new Array(".xlsx", ".xls"); 
   mierror = ""; 
   archivo = $('#file').val();
   //console.log(archivo);

      //recupero la extensión de este nombre de archivo 
      extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase(); 
      //alert (extension); 
      //compruebo si la extensión está entre las permitidas 
      permitida = false; 
      for (var i = 0; i < extensiones_permitidas.length; i++) { 
         if (extensiones_permitidas[i] == extension) { 
         permitida = true; 
         break; 
         } 
      } 
      if (!permitida) { 
         mierror = false; 
        
        }else{ 
         mierror = true; 
        } 

   return mierror;
   
}

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


  $(document).on("click","#btn-add-cap",function(){
      $("#add_prod")[0].reset();
       $("#tb-combo tbody").empty();
      var camino = "insertar";
      $('#tit').text('Nueva Alta');
    }); 

   $(document).on("click",".hist-cliente", function(){
           var id = $(this).attr('data');
            window.location.href = "<?php echo base_url();?>historial_cliente/"+id;
        });


    $(document).on("click",".edit-row-btn",function(){
      var id = $(this).attr('data');
      console.log(id);
      var camino = "editar";
      $('#tit').text('Editar Producto');
        $.ajax({
            url: "<?php echo base_url();?>panel_admin/getdatos_prod",
            type:"POST",
            dataType:"html",
             data:{id:id,camino:camino},
            success:function(data){
                $("#form_cap").html(data);
            }
        });
    });  


    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        sumar();
    });
    
    $(document).on("click",".btn-asociar-respuesto", function(){
        $(this).closest("tr").css('background-color', '#8cf2ee');
        var id = $(this).attr('data');
        $('#id_producto').val(id);
         $("#tb-combo").load(" #bodyrepuesto");
    });

    $(document).on("click",".deletecap-row-btn", function(){
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>capacitacion/eliminar_cli',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                 if (data.comprobador){
                        $.toast({
                        heading: 'Cliente eliminado ',
                        text: 'El Cliente a sido eliminado con exito.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 2500
                    });
                  if ($.fn.DataTable.isDataTable( '#editable-datatable' ) ) {
                      table = $('#editable-datatable').DataTable();
                      table.destroy();
                      load_data_cap();
                      }
                      else {
                          load_data_cap();
                          }


                    }
                
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        
    });

     $(document).on("click","#btn-agregar", function(){
        $("#add_prod")[0].reset();
        $('#camino').val("insertar");
    });

     $(document).on("click",".btn-limpiar", function(){
        $("#add_prod")[0].reset();
         $("#tb-combo tbody").empty();
         console.log("clin en limpiar");
    });



    $(document).on("click",".edit-row-btn1", function(){
        var id = $(this).attr('data');
        $('#camino').val("editar");
        $(".collapseblebox").css({'display': "block" });
       
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/getdatos_prod',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                   
                   $('#id_producto_edit').val(data.id_producto);
                   $('#nombre_prod').val(data.nombre_prod);
                   $('#costo').val(data.costo);
                   $('#precio').val(data.precio);
                   $('#es_repuesto').val(data.es_repuesto);
                   $('#existencia').val(data.existencia);
                   $('#vencimiento').val(data.vencimiento);
                   $('#reg_cancelado').val(data.reg_cancelado);
                   $('#alto').val(data.alto);
                   $('#ancho').val(data.ancho);
                   $('#largo').val(data.largo);
                   $('#peso').val(data.peso);
                   $('#sku').val(data.sku);
                  
                   $('select[name=id_categoria]').val(data.id_categoria).attr('selected','selected');
                   $('#valor_declarado').val(data.valor_declarado);
                   
                   $('#nombre_archivo').val(data.url_imagen);
                   var ruta = '<?php echo base_url();?>assets/uploads/img_productos/';
                    $('#url_imagen').attr("data-default-file",ruta+data.url_imagen); 

                    if (data.es_repuesto == 1){
                                $("input[name=es_repuesto][value='1']").prop("checked",true);
                                } else {
                                    $("input[name=es_repuesto][value='2']").prop("checked",true);
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
            url:"<?php echo base_url(); ?>capacitacion/load_dataClientes",
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