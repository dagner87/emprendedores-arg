 <div class="panel-body">
                    <form  id="add_cap" action="" method="post" data-toggle="validator" >
                        <input type="hidden" name="id_cap" id="id_cap" value="<?= $id_cap ?>">
                        <input type="hidden" name="camino" id="camino" value="<?= $camino ?>">
                        <div class="form-body">
                            
                                <div class="form-group">
                                    <label for="titulo_video" class="control-label">Titulo:</label>
                                    <input type="text" class="form-control" name="titulo_video" id="titulo_video" placeholder="Escriba Titulo Video"  value=" <?php if (!empty($datos->titulo_video))echo $datos->titulo_video; ?>" data-error="Escriba un titulo" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group" >
                                    <div class="btn-file"id="foto" >
                                        <label for="url_imagen">Subir imagen:</label>
                                        <input type="file" id="url_imagen" name="url_imagen" class="dropify"  data-error="Agrege una imagen"
                                        data-default-file="<?php if (!empty($datos->imag_portada))echo base_url()."assets/videos/".$datos->imag_portada; ?>"/>
                                        <input type="hidden" id="nombre_archivo" name="nombre_archivo"  value="<?php if (!empty($datos->imag_portada))echo $datos->imag_portada; ?>" class="form-control" >
                                    </div>
                                     <div class="help-block with-errors"></div>
                                </div>    
                                <div class="form-group">
                                    <label for="url_video"  class="control-label">URL:</label>
                                    <input type="url" class="form-control" id="url_video" name="url_video"  placeholder="Escriba URL" value="<?php if (!empty($datos->url_video))echo $datos->url_video; ?>" 
                                    data-error="Escriba una url correcta" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción:</label>
                                    <textarea id="descripcion"  name="descripcion" class="form-control" required><?php if (!empty($datos->descripcion))echo $datos->descripcion; ?></textarea> 
                                    <span class="help-block with-errors"></span> 
                                </div>
                       
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success collapseble"> <i class="fa fa-check"></i> Guardar</button>
                            <button type="button" class="btn btn-default limpiar">Limpiar</button>
                        </div>
                    </form>
                </div>

                <script type="text/javascript">
$(document).ready(function() {
  
     $('#add_cap').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/insert_cap';
            var url_up = '<?php echo base_url() ?>panel_admin/update_cap';
            var data = $('#add_cap').serialize();

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
                                  heading: 'Video Agregado',
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
                                  heading: 'Video Editado',
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

   $('#add_pregunta').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>panel_admin/insert_preguntas';
            var data = $('#add_pregunta').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        
                     // $('#asociar-respuesto').modal("hide");
                        console.log("enviando....");
                      }
                 })
                  .done(function(){
                    console.log(data);
                      $.toast({
                          heading: 'Pregunta Agregada',
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
     

    $('.btn-file').on("change", function(evt){
        var base_url= "<?php echo base_url();?>";
          $('#url_imagen').attr('required', true);  
        // declaro la variable formData e instancio el objeto nativo de javascript new FormData
        var formData = new FormData(document.getElementById("add_cap"));
       // iniciar el ajax
        $.ajax({
            url: base_url + "panel_admin/subir_imgVideo",
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
               $('#nombre_archivo').val(objJson.imagen); //agrego el nombre del archivo subido
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
        $("#add_cap")[0].reset();
     });
</script>