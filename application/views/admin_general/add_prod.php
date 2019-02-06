 <div class="panel-body">
 <form  id="add_prod" action="<?php echo base_url() ?>panel_admin/insert_prod" method="post" >
     <input type="hidden" name="id_producto_edit" id="id_producto_edit" value="<?= $id_producto_edit ?>">
     <input type="hidden" name="camino" id="camino" value="<?= $camino ?>">
 
    <div class="form-body">
         <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Categorías:</label>
                        <select class="form-control" data-placeholder="Seleccione una Categoria" tabindex="1" name="id_categoria" id="id_categoria" required>
                          <?php if(!empty($categorias))
                            {
                              $select = "";
                              foreach($categorias as $row):

                                 if ($datos->id_categoria == $row->id ) {
                                    echo '<option value="'.$row->id.'" selected>'.$row->nombre.'</option>';
                                    }
                                   echo '<option value="'.$row->id.'">'.$row->nombre.'</option>';
                              
                              endforeach;
                            } ?>
                      </select>
                      <div class="help-block with-errors"></div>
                    </div>
            <div class="form-group">
                <label class="control-label">Detalle:</label>
                 
                
                <div class="radio-list">
                    <label class="radio-inline p-0">
                        <div class="radio radio-info">
                            <input type="radio" name="es_repuesto" value="1" 

                            <?php 
                            if (!empty($datos->es_repuesto))
                             {

                             if ($datos->es_repuesto == 1):echo "checked"; endif;  
                            } ?> required>
                            <label for="es_repuesto">Producto</label>
                        </div>
                    </label>
                    <label class="radio-inline">
                        <div class="radio radio-info">
                            <input type="radio" name="es_repuesto" value="2" 
                            <?php if (!empty($datos->es_repuesto))
                             {
                             if ($datos->es_repuesto == 2):echo "checked"; endif;   
                              
                            } ?> required>
                            <label for="es_repuesto">Repuesto </label>
                        </div>
                    </label>
                </div>
            <div class="help-block with-errors"></div>
            </div>


            <div class="form-group">
                <label class="control-label">Nombre:</label>
                <input type="text" id="nombre_prod" name="nombre_prod" class="form-control"  required data-error="Agrege Nombre Producto " value="<?php if (!empty($datos->nombre_prod))echo $datos->nombre_prod; ?>" > 
                <div class="help-block with-errors"></div></div>
        

        </div>

        <div class="col-md-6 col-xs-12 btn-file">
            <label for="input-file-now">Subir imagen:</label>
            <input type="file" id="url_imagen" name="url_imagen" class="dropify " data-default-file="<?php if (!empty($datos->url_imagen))echo base_url()."assets/uploads/img_productos/".$datos->url_imagen; ?>"  
            data-error="Agrege una imagen"/>
            <input type="hidden" id="nombre_archivo" name="nombre_archivo"  value="<?php if (!empty($datos->url_imagen))echo $datos->url_imagen; ?>" class="form-control">
            <div class="help-block with-errors"></div>
        </div>
        
    </div>

        <!--/row-->
        <div class="row">
           
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label"> Precio Costo:</label>
                    <input type="text" id="costo" name="costo" class="form-control"  required data-error="Agrege  Precio costo" value="<?php if (!empty($datos->costo))echo $datos->costo; ?>" > 
                    <div class="help-block with-errors"></div></div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Precio:</label>
                    <input type="text" id="precio" class="form-control" name="precio" required data-error="Agrege Precio " value="<?php if (!empty($datos->precio))echo $datos->precio; ?>">
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
                         required data-error="Agrege Existencia" value="<?php if (!empty($datos->existencia))echo $datos->existencia; ?>"> 
                        <div class="help-block with-errors"></div> 
                    </div>
                </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Vencimiento:</label>
                    <input type="num" id="vencimiento" name="vencimiento" class="form-control" required data-error="Agrege Vencimiento" value="<?php if (!empty($datos->vencimiento))echo $datos->vencimiento; ?>"> 
                    <div class="help-block with-errors"></div> </div>
            </div>
        </div>
        <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Alto:</label>
                        <input type="text" id="alto" name="alto" class="form-control" required data-error="Agrege Alto" value="<?php if (!empty($datos->alto))echo $datos->alto; ?>"> <div class="help-block with-errors"></div> </div>
                </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Ancho:</label>
                    <input type="text" id="ancho" name="ancho" class="form-control" required data-error="Agrege Ancho" value="<?php if (!empty($datos->ancho))echo $datos->ancho; ?>"> <div class="help-block with-errors"></div> </div>
            </div>
        </div>
        <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">Largo:</label>
                        <input type="text" id="largo" name="largo" class="form-control" required data-error="Agrege Largo " value="<?php if (!empty($datos->largo))echo $datos->largo; ?>"> <div class="help-block with-errors"></div> </div>
                </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Peso:</label>
                    <input type="text" id="peso" name="peso" class="form-control" required data-error="Agrege Peso" value="<?php if (!empty($datos->peso))echo $datos->peso; ?>"> <div class="help-block with-errors"></div> </div>
            </div>
        </div>
        <div class="row">
              <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label">SKU:</label>
                        <input type="text" id="sku"  name="sku" class="form-control" required data-error="Agrege SKU" value="<?php if (!empty($datos->sku))echo $datos->sku; ?>"> 
                        <div class="help-block with-errors"></div> </div>
                </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label">Valor Declarado:</label>
                    <input type="text" id="valor_declarado" name="valor_declarado" class="form-control" required data-error="Agrege Valor Declarado" value="<?php if (!empty($datos->valor_declarado))echo $datos->valor_declarado; ?>"> <div class="help-block with-errors"></div> </div>
            </div>
        </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Guardar</button>
        <button type="button" class="btn btn-default">Limpiar</button>
    </div>
</form>
</div>

<script>



$(document).ready(function() {

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
    var url = '<?php echo base_url() ?>panel_admin/insert_prod';
    var url_up = '<?php echo base_url() ?>panel_admin/update_prod';
    var data = $('#add_prod').serialize();

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
                          heading: 'Producto Agregado',
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
                       $('#modal-add-cap').modal('hide');
                    $.toast({
                          heading: 'Producto Editado',
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
                  });
        

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
        replace: nombre_archivo ,
        remove: 'Remover',
        error: 'No se pudo mostrar'
    }
});

});//onready
</script>