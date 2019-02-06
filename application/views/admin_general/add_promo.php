 <div class="panel-body">
                    <form  id="add_promo" action="" method="post"><!--data-toggle="validator"-->
                       <input type="hidden" name="camino" id="camino" value="<?= $camino ?>">
                       <input type="hidden" name="id_promo" id="id_promo" value="<?php if (!empty($datos->id_promo))echo $datos->id_promo; ?>">

                        <div class="form-body">
                           <div class="row">
                               <div class="col-lg-12">
                            <div class="alert alert-danger" id="mensaje_seleccProd" style="display: none;">Debe seleccionar algun producto o combo </div>
                             </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Nombre de Promoción</label>
                                         <input type="text" id="nombre_promo" name="nombre_promo" class="form-control" placeholder="Escriba nombre " required data-error="Agrege Nombre de Promoción"  value="<?php if (!empty($datos->nombre_promo))echo $datos->nombre_promo; ?>"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Descuento</label>
                                         <input type="text" id="descuento" name="descuento" class="form-control" placeholder="Escriba descuento " required data-error="Agrege Descuento" value="<?php if (!empty($datos->descuento))echo $datos->descuento; ?>"> <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fecha inicio</label>
                                         <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" placeholder="Escriba fecha inicio" required data-error="Agrege Fecha inicio" value="<?php if (!empty($datos->fecha_inicio))echo $datos->fecha_inicio; ?>"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Fecha fin</label>
                                         <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" placeholder="Escriba fecha_fin" required data-error="Agrege Fecha fin" value="<?php if (!empty($datos->fecha_fin))echo $datos->fecha_fin; ?>"> 
                                         <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                                
                                
                            </div>


                           
                            <!--/row-->
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                        <label class="control-label">Productos:</label>
                                        <select class="form-control select_pro"  name="id_producto" id="id_producto" data-placeholder="Seleccione">
                                          <?=  $productos ?>
                                        </select>
                                    </div>
                                   
                                </div>
                                
                            </div>
                            <!--/row-->
                             <!--/row-->
                            <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                        <label class="control-label">Combos:</label>
                                        <select class="form-control select_pro"  name="id_combo" id="id_combo" data-placeholder="Seleccione">
                                          <?=  $combos ?>
                                        </select>
                                    </div>
                                   
                                </div>
                                
                            </div>
                            <!--/row-->
                           

                            <div class="row">
                               <div class="col-lg-12">
                                 <table id="tb-promo" class="table table-bordered table-striped table-hover">
                                  <thead>
                                      <tr>
                                          <th>Producto</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>

                                     <?php if (!empty($productos_selec)):?>
                                    <tr>
                                    <?php 
                                    foreach($productos_selec as $prod):

                                       $valor =  $this->modelogeneral->getdatos_prod_combo($prod->id_producto,$prod->es_combo);
                                      // var_dump($valor);
                                     ?>
                                      <tr>
                                      <td>
                                        <div class=form-group>
                                         <input type='hidden' name='es_combo[]' value='<?= $prod->es_combo ?>'>
                                         <input type='hidden' name='productos[]' value='<?= $prod->id_producto ?>'><?= $valor->nombre_prod ?>
                                        </div>
                                      </td>
                                     <td><button type='button' data="<?= $prod->id_promo_prod ?>" class='btn btn-danger deletecomb-row-btn'><span class='fa fa-remove'></span></button></td>
                                       </tr>
                                   <?php endforeach ;  ?>
                                    <?php endif;  ?>
                                  </tbody>
                              </table>
                            </div>   
                            </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-success" id="guardar_promo" > <i class="fa fa-check"></i> Guardar</button>
                            <button type="button" class="btn btn-default limpiar">Limpiar</button>
                        </div>
                    </form>
                </div>

                <script type="text/javascript">
$(document).ready(function() {


   $(".select_pro").select2();
   $(".select_combo").select2();    

     $('#add_promo').submit(function(e) {
       e.preventDefault();

       var nFilas = $("#tb-promo tbody tr").length;
       if (nFilas == 0){
        $("#mensaje_seleccProd").show().fadeOut(7500); 
        
       }else {
            var url = '<?php echo base_url() ?>panel_admin/insert_promo';
            var url_up = '<?php echo base_url() ?>panel_admin/update_promo';
            var data = $('#add_promo').serialize();
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
                                  heading: 'Promoción Agregada',
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
                            if ($.fn.DataTable.isDataTable('#promo-table') ) {
                              table = $('#promo-table').DataTable();
                              table.destroy();
                              load_data_cap();
                              }
                              else {
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
                                console.log(url_up);
                              }
                         })
                          .done(function(data){
                            console.log(data);
                          if (data) {
                            $('#modal-add-cap').modal('hide');

                            $.toast({
                                  heading: 'Productos editados',
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
                            if ($.fn.DataTable.isDataTable('#promo-table') ) {
                              table = $('#promo-table').DataTable();
                              table.destroy();
                              load_data_cap();
                              }
                              else {
                                  load_data_cap();
                                  }
                          });
                

                    }
           


             }  
                
        });

        $("#id_producto").on("change",function(){
         $(this).find('select :first').attr("disabled",'true');
         data = $(this).val();

         var option        = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_prod   =  $('select[name="id_producto"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
         console.log(nombre_prod);
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='es_combo[]' value='0'><input type='hidden' name='productos[]' value='"+data+"'>"+nombre_prod+"</td>";
            html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tb-promo tbody").append(html);
           
        }else{
            alert("Seleccione un producto...");
        }
    });

    


     $("#id_combo").on("change",function(){
         $(this).find('select :first').attr("disabled",'true');
         data = $(this).val();
         var option         = $(this).find(':selected')[0];//obtiene el producto seleccionado
         var nombre_combo   =  $('select[name="id_combo"] option:selected').text();
         $(option).attr('disabled', 'disabled'); // y lo desabilita para no volverlo a seleccionar
        
        if (data !='') {
            html = "<tr>";
            html += "<td><input type='hidden' name='es_combo[]' value='1'><input type='hidden' name='productos[]' value='"+data+"'>"+nombre_combo+"</td>";

            html += "<td><button type='button' class='btn btn-danger btn-remove-producto'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#tb-promo tbody").append(html);
           
        }else{
            alert("Seleccione un Combo");
        }
    });

    });//onready

 $(document).on("click",".limpiar", function(){
        $("#add_promo")[0].reset();
       $("#tb-promo tbody").empty();
       $('#id_combo option:first').prop('selected', true);
       $('#id_producto option:first').prop('selected', true);

     });

   $(document).on("click",".deletecomb-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_Prod_Promo',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  console.log(data);
                  if (data.comprobador) {

                    $.toast({
                        heading: 'Producto eliminado',
                        text: 'El Producto eliminado de la promoción.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 2500
                    });
                    if ($.fn.DataTable.isDataTable( '#promo-table' ) ) {
                      table = $('#promo-table').DataTable();
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


  $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        
    });  


</script>