<form action=""  id="evaluacion_form">
    <input type="hidden" name="id_cap" id="id_cap" value="<?= $id_cap  ?>">
    <div class="form-body">
        <h3 class="box-title">cuestionario</h3>
        <hr>
        <!--/row-->
        <?php   
        if (!empty($preguntas)):
            $cont= 0;
                 foreach ($preguntas as $key): 
                 $cont++  
         ?> 
          
        <div class="row">
            <!--/span-->
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label"><?= $key->pregunta ?></label>
                    <?php 
                    $respuestas = $this->modelogeneral->listar_respuestas_cap($key->id_preg); 

                     if (!empty($respuestas)):
                       foreach ($respuestas as $resp):  ?>

                    <div class="radio radio-info">
                        <input type="radio" class="item-radio" name="respuesta<?= $key->id_preg?>" id="respuesta<?= $resp->id_respuesta?>" value="<?= $key->id_preg."*".$resp->es_correcta?>" required>
                        <label for="radio5"> <?= $resp->respuesta  ?> </label>
                    </div>
                       <?php endforeach; ?> 
                   <?php endif ?>   
                </div>
            </div>
            <!--/span-->
        </div>
        <hr>
          <?php endforeach; ?> 
          <input type="hidden" id="cantidad_preg" value="<?= $cont ?>"> 
          <input type="hidden" id="respuesta_ok" value=""> 
          
          
        <?php endif ?>    
        
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> Evaluar</button>
        <button type="button" class="btn btn-default btn_reset">Limpiar</button>
    </div>
                                    </form>

 <script type="text/javascript">
     $(document).ready(function($) {

        $('#evaluacion_form').submit(function(e) {
        e.preventDefault();
        var data = $('#evaluacion_form').serialize();
       
        //alert(data);
        enviar_evaluacion(); 
      });

      $('.btn_reset').click(function(e){
            $('#evaluacion_form')[0].reset();
        });


      
      

   

        
    }); //fin onready
    
     var total = 0;
     $(document).on("click",".item-radio",function(){
      
       var valor_id = $(this).val();
       var dato = valor_id.split("*");
       var id_preg = dato[0]; // id de la pregunta
       var es_correcta = dato[1]; // id de la pregunta
       total += parseInt(es_correcta);
       
       var cant_preg = $('#cantidad_preg').val();
       $('#respuesta_ok').val(total);
       
       
       console.log(total);



        });




      


     function enviar_evaluacion(){
          var url = '<?php echo base_url() ?>capacitacion/update_evalcap';
          var respuesta_ok = $('#respuesta_ok').val();
          var id_cap = $('#id_cap').val();
          var cant_preg = $('#cantidad_preg').val();
              if (respuesta_ok == cant_preg ){

                $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: {id_cap:id_cap,evaluacion:respuesta_ok},
                    dataType: 'json',
                    beforeSend: function() {
                        //sweetalert_proceso();
                        console.log("enviando....");
                      }
                 })
                  .done(function(data){
                   // console.log(data);
                    sweetalertsuccessEval();
                     
                  })
                  .fail(function(){
                     //sweetalertclickerror();
                  }) 
                  .always(function(){
                    /* setTimeout(function(){
                      redireccionar();
                     },2000);*/

                  });


              }else{

                 swal("Vuelve a evaluarte!!", "Tienes respuestas incorrectas..." , "error");
                     setTimeout('document.location.reload()',2000);
              }


          
        } 

         function sweetalertsuccessEval() {
        swal({
          title: "Buen Trabajo!!",
          text: "Puedes continuar con el siguiente video",
          type: "success", 
          timer: 2000,   
          showConfirmButton: false
        });
        setTimeout('document.location.reload()',2001);
     }          
</script>                                 