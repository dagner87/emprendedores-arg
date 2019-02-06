
<div class="row">
   <div class="col-md-12">
    <h4 class="box-title m-b-20"></h4>
    <div class="panel-group" role="tablist" aria-multiselectable="true">

      <?php  


          if(!empty($preguntas)):
                $cont= 0;
                     foreach ($preguntas as $key): 
                     $cont++  
             ?> 
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title"> <a role="button"  data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?= $key->id_preg ?>" aria-expanded="true" aria-controls="collapseOne" class="font-bold"> <?= $key->pregunta ?></a> </h4> </div>
            <div id="collapseOne<?= $key->id_preg ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <div class="row">
                            <div class="col-md-12">
                            <div class="panel panel-info">
                                <div class="table-responsive">
                                 <br>
                                    <table class="table table-hover manage-u-table" id="editable-datatable">
                                        <thead>
                                            <tr>
                                                <th>Respuesta</th>
                                                <th>Es Correcta</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody id="contenido_video">
                                            <tr>
                                            <?php 
                                            $respuestas = $this->modelogeneral->listar_respuestas_cap($key->id_preg); 
                                             if (!empty($respuestas)):
                                               foreach ($respuestas as $resp):  ?>
                                                 <tr>
                                                <td >
                                                    <a href="#" title="click para editar" class="inline-comments" data-name="respuesta" data-type="textarea" data-pk="<?= $resp->id_respuesta ?>" data-placeholder="Escriba una respuesta" data-title="Escriba una respuesta"><?= $resp->respuesta ?></a>

                                                <td>
                                                    <div class="row"> 
                                                      <?php if ($resp->es_correcta == 1){ ?>
                                                      <div class="col-md-12">
                                                          <div class="form-group">
                                                            <select class="form-control" required>
                                                                <option value="<?= $resp->id_respuesta ?>*0">NO</option>
                                                                <option value="<?= $resp->id_respuesta ?>*1" selected>SI</option>
                                                            </select>
                                                            <div class="help-block with-errors"></div> 
                                                        </div>
                                                     </div>
                                                    <?php }else{ ?>
                                                    <div class="col-md-12>
                                                          <div class="form-group">
                                                            <select class="form-control" required>
                                                                <option value="<?= $resp->id_respuesta ?>*0" selected>NO</option>
                                                                <option value="<?= $resp->id_respuesta ?>*1">SI</option>
                                                            </select>
                                                            <div class="help-block with-errors"></div> 
                                                        </div>
                                                     </div>
                                                   <?php } ?>

                                                   </div>
                                                    <i id="capa_stock'<?= $resp->id_respuesta ?>"></i>
                                                   
                                                 </td>
                                                <td>
                                                   <button type="button" data="<?= $resp->id_respuesta ?>" class="btn btn-danger btn-outline btn-circle btn-sm  delete-rep-row-btn"  data-toggle="tooltip" data-original-title="Eliminar respuesta" title ="Eliminar respuesta"><i class="icon-trash"></i></button></td>
                                                </tr> 
                                               <?php endforeach; ?> 
                                            <?php endif ?> 
                                                   
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            </div>
                     </div>
                </div>
            </div>
        </div>

        <?php endforeach; ?> 
        <?php endif ?>  

        <?php if ($preguntas == false) { ?> 
         <div class="alert alert-warning"><p><i class="mdi mdi-alert-outline fa-fw"></i><strong> No hay Preguntas Creadas</strong> </p></div>
         <?php } ?>

         




    </div>
    </div>
</div>  
 <!-- jQuery x-editable -->
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/plugins/bower_components/x-editable/dist/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<script type="text/javascript">
    $(function() {
        //editables 

      $('.inline-comments').editable({
    type: 'text',
    url: '<?php echo base_url() ?>panel_admin/updateRespuesta',    
    mode: 'inline',
    title: 'Enter username',
    validate: function(value) {
                if ($.trim(value) == '') return 'Este Campo es obligatorio';
            },
    ajaxOptions: {
        dataType: 'json'
    },
    success: function(response, newValue) {
      console.log(response)
        if(!response) {
            return "Unknown error!";
        }          
        
        if(response.success === false) {
             return response.msg;
        }
    }        
});
     
 
$('.inline-comments1').editable({
    mode: 'inline',
    type: 'POST',
    url: '<?php echo base_url() ?>panel_admin/updateRespuesta',    
    title: 'Escriba una respuesta',
    validate: function(value) {
                if ($.trim(value) == '') return 'Este Campo es obligatorio';
            },
    ajaxOptions: {
        dataType: 'json'
    },
    success: function(response, newValue) {
      console.log(response);
        if(!response) {
            return "Unknown error!";
        }          
        
        if(response.success === false) {
             return response.msg;
        }
    }        
});


       
    });




    $(document).on("change","select", function(){
                 var val = $(this).val();
                 //var name = $(this).attr("name");
                 var dato =  val.split("*");
                 var id_respuesta  =  dato[0];
                 var es_correcta   =  dato[1];
                 console.log(id_respuesta);
            
           $.get( "<?php echo base_url();?>panel_admin/updateResp",{ 
                   id_respuesta:id_respuesta,
                   es_correcta:es_correcta
                  })
                .done(function(data) {
                 var obj = $.parseJSON(data);
                  console.log(obj.success);
                 $('#capa_stock'+id_respuesta).html('<i class="fa fa-spinner fa-spin"></i>').fadeIn().delay(2000).fadeOut('slow');
                  
                  $.toast({
                        heading: 'Datos Actualizados',
                        text: ' La Infomacion a sido actualizada.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 2500
                    });
                              
                });

    }); 

      $(document).on("click",".delete-rep-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_resp',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                    console.log(data);
                  $.toast({
                        heading: 'Respuesta  eliminada',
                        text: 'La Respuesta a sido eliminada.',
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
