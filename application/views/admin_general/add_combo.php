 <div class="panel-body">
                    <form  id="add_prod" action="<?php echo base_url() ?>panel_admin/update_combo" method="post" >
                        <input type="hidden" name="id_combo_edit" id="id_combo_edit" value="<?= $id_combo ?>">
                        <input type="hidden" name="camino" id="camino" value="<?= $camino ?>">
                        <div class="form-body">
                          
                            <div class="row">
                              <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nombre Combo:</label>
                                         <input type="text" id="nombre_combo" name="nombre_combo" class="form-control" placeholder="Escriba nombre del combo" required value="<?php if (!empty($datos->nombre_combo))echo $datos->nombre_combo; ?>"> <span class="help-block">  </span>
                                    </div>

                                    
                                    <div class="form-group">
                                        <label class="control-label">Precio:</label>
                                        <input type="num" id="precio_combo" class="form-control" name="precio_combo" placeholder=""  required value="<?php if (!empty($datos->precio_combo))echo $datos->precio_combo; ?>"> <span class="help-block"> </span>
                                     </div>
                                     <div class="form-group">
                                        <label class="control-label">Costo:</label>
                                        <input type="num" id="costo" required class="form-control" name="costo" placeholder="" value="<?php if (!empty($datos->costo))echo $datos->costo; ?>"> <span class="help-block"> </span>
                                     </div>

                                      <div class="form-group">
                                        <label class="control-label">Existencia:</label>
                                        <input type="num" id="existencia" required class="form-control" name="existencia" placeholder="" value="<?php if (!empty($datos->existencia))echo $datos->existencia; ?>"> <span class="help-block"> </span> </div>

                                </div>
       
                                <div class="col-md-6 col-xs-12 btn-file">
                                    <label for="input-file-now">Subir imagen:</label>
                                    <input type="file" id="url_imagen"
                                      
                                    <?php if (empty($datos->url_imagen))echo "required"; ?>
                                    name="url_imagen" value="<?php if (!empty($datos->url_imagen))echo $datos->url_imagen; ?>" class="dropify" data-default-file="<?php if (!empty($datos->url_imagen))echo base_url()."assets/uploads/img_productos/".$datos->url_imagen; ?>"  />

                                    <input type="hidden" id="nombre_archivo" name="nombre_archivo"  value="<?php if (!empty($datos->url_imagen))echo $datos->url_imagen; ?>" class="form-control">
                                </div>
                                
                            </div>

                            <!--/row-->
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                        <label class="control-label">Productos:</label>
                                        <select class="form-control select_pro"  name="id_producto_edit" id="id_producto_edit" data-placeholder="Seleccione">
                                          <?=  $productos ?>
                                        </select>
                                    </div>
                                   
                                </div>
                                
                            </div>
                            <!--/row-->
                            
                            <div class="row">
                               <div class="col-lg-12">
                                 <table id="tb-combo-edit" class="table table-bordered table-striped table-hover">
                                  <thead>
                                      <tr>
                                          <th>Producto</th>
                                          <th>Cantidad</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    <?php if (!empty($productos_selec)):?>
                                    <tr>
                                    <?php 

                                    foreach($productos_selec as $prod):?>
                                      <tr>
                                      <td><?= $prod->nombre_prod ?></td>
                                      <td><div class=form-group>
                                      	<input type='hidden' name='productos[]' value='<?= $prod->id_producto ?>'>
                                      	<input type='num' class='form-control cantidades col-xs-2' data-minlength='1' name='cantidades[]' value="<?= $prod->cantidad ?>" placeholder='cantidades' data-error='escriba una cantidad mayor a cero' required><div class='help-block with-errors'></div></div></td>
                                     <td><button type='button' data="<?= $prod->id_comb_prod ?>" class='btn btn-danger deletecomb-row-btn'><span class='fa fa-remove'></span></button></td>

                                       </tr>
                                   <?php endforeach ;  ?>
                                    <?php endif;  ?>
                                  
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

                <script type="text/javascript">
$(document).ready(function() {

$(".select_pro").select2();  
     $('#add_prod').submit(function(e) {

            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/insert_combo';
            var url_up = '<?php echo base_url() ?>panel_admin/update_combo';
            var data = $('#add_prod').serialize();

            var camino = $('#camino').val();

            if (camino == 'insertar')
               {
                console.log("insertar");

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
                          .done(function(data){
                            console.log(data);
                              $.toast({
                                  heading: 'Combo Agregado',
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


               }else{

                console.log("editar");

                        $.ajax({
                            type: 'ajax',
                            method: 'post',
                            url: '<?php echo base_url() ?>panel_admin/update_combo',
                            data: data,
                            dataType: 'json',
                            beforeSend: function() {
                                //sweetalert_proceso();
                                console.log("editando....");
                              }
                         })
                          .done(function(data){
                            console.log(data);
                          if (data) {
                            $('#modal-add-cap').modal('hide');

                            $.toast({
                                  heading: 'Combo Editado',
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

     $("#id_producto_edit").on("change",function(){
         $(this).find('select :first').attr("disabled",'true');
         $(this).attr("required", "true");
         data = $(this).val();
         var option        = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_prod   =  $('select[name="id_producto_edit"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='productos[]' value='"+data+"'>"+nombre_prod+"</td>";
             html += "<td><div class=form-group><input type='num' class='form-control cantidades col-xs-2' data-minlength='1' name='cantidades[]' placeholder='cantidades' data-error='escriba una cantidad mayor a cero' required><div class='help-block with-errors'></div></div></td>";
            html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tb-combo-edit tbody").append(html);
           
        }else{
            alert("seleccione un producto...");
        }
    });

   

      $('.btn-file').on("change", function(evt){
        var base_url= "<?php echo base_url();?>";
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


    //subir documento de evaluacion



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

 $(document).on("click",".limpiar", function(){
        $("#add_prod")[0].reset();
     });

  $(document).on("click",".deletecomb-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_comboProd',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  console.log(data);
                  $.toast({
                        heading: 'Producto eliminado',
                        text: 'El Producto eliminado del combo a sido eliminado.',
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