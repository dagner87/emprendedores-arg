<style type="text/css">
  textarea {
  resize: none;
}
</style>

<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTACION DE PRODUCTOS</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Tienda</a></li>
                            <li class="active">Adm.Productos</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                  
                </div>

<!-- .modal for add task -->
<div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Lista de Preguntas y Respuestas </h4>
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
<div class="modal fade" id="ordenvideosModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit"><strong>Ordenar Videos</strong> </h4>
            </div>
            <div class="modal-body" id="ordenvideoslista">
               <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">ORDEN DE VIDEOS <i class="fa  fa-arrows-v"></i></h3>
                            <input type="hidden" name="tar" id="tar" value="">
                            <div class="myadmin-dd-empty dd" id="nestable">
                               
                            </div>
                        </div>
                    </div>
                </div>
               
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
                <h4 class="modal-title" id="titulo_invit"><strong id="tit"> </strong></h4>
            </div>
            <div class="modal-body" id="form_cap">
               
            </div>
        <!-- /.modal-content -->
        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<!-- .modal for add task -->
<div class="modal fade" id="asociar-pregunta" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Agregar Preguntas </h4>
                </div>
                <div class="modal-body">
                    <form id="add_pregunta" action="<?php echo base_url() ?>panel_admin/insert_preguntas" method="post">
                        <input type="hidden" name="id_cap_preg" id="id_cap_preg" value="">
                       
                        <div class="row">
                               <div class="col-md-12">
                                 <table id="tb-preguntas" class="table table-bordered table-striped table-hover  color-table info-table">
                                  <thead>
                                      <tr>
                                          <th colspan="3" class="text-center">Escriba la Pregunta de Evaluación</th>

                                      </tr>
                                  </thead>
                                  <tbody id="list_preguntas">
                               <tr>
                                   <td><div class="form-group">
                                           <textarea    name="pregunta" class="form-control"  placeholder="Escriba Pregunta" rows="4" cols="50" required  data-error="Escriba Pregunta"></textarea>
                                            <div class="help-block with-errors"></div>
                                             <div class="cap-respuesta"></div>
                                         </div></td>
                            <td><button type='button' class='btn btn-primary add_repuesta' title="Crear una respuesta"><span class='fa fa-file-text-o'></span></button></td>
                              <td><button type='button' class='btn btn-danger btn-remove-pregunta'><span class='fa fa-remove'></span></button></td>
                              </tr>
                                  
                                  </tbody>
                              </table>
                             </div>  
                           </div>  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-success">Agregar</button>
                </div>
                 </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->                 

           


<div class="row">
  <div class="col-xs-12">
                        <div class="panel panel-info">
                            <div class="panel-heading">Datos de Capacitación</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    
                                  <div class="m-t-15 collapseblebox dn">
                                        <div class="well">

                                          <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form  id="add_cap" action="" method="post" data-toggle="validator" >
                        <input type="hidden" name="id_cap" id="id_cap1" value="">
                        <input type="hidden" name="camino" id="camino1" value="">
                        <div class="form-body">
                            
                                <div class="form-group">
                                    <label for="titulo_video" class="control-label">Titulo:</label>
                                    <input type="text" class="form-control" name="titulo_video" id="titulo_video" placeholder="Escriba Titulo Video"  data-error="Escriba un titulo" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group" >
                                    <div class="btn-file1"id="foto1" >
                                        <label for="url_imagen">Subir imagen:</label>
                                        <input type="file" id="url_imagen" name="url_imagen" class="dropify" required data-error="Agrege una imagen"
                                        data-default-file=""/>
                                        <input type="hidden" id="nombre_archivo" name="nombre_archivo"  value="" class="form-control" >
                                    </div>
                                     <div class="help-block with-errors"></div>
                                </div>    
                                <div class="form-group">
                                    <label for="url_video"  class="control-label">URL:</label>
                                    <input type="url" class="form-control" id="url_video" name="url_video"  placeholder="Escriba URL" 
                                    data-error="Escriba una url correcta" required>
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                    <label for="descripcion" class="control-label">Descripción:</label>
                                    <textarea id="descripcion"  name="descripcion" class="form-control" required></textarea> 
                                    <span class="help-block with-errors"></span> 
                                </div>
                                
                      
                        <div class="form-actions">
                            <button type="submit" class="btn btn-success collapseble"> <i class="fa fa-check"></i> Guardar</button>
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
                      <button type="button" id="btn-add-cap" data-toggle="modal" data-target="#modal-add-cap" class="btn btn-info btn-rounded"> <i class="fa fa-plus"></i> Agregar Capacitación</button>
                      <button type="button" id="btn-add-cap" data-toggle="modal" data-target="#ordenvideosModal" class="btn btn-primary btn-rounded"> <i class="fa fa-arrows"></i> Ordenar Videos</button></h3>


                        <div class="panel">
                            <div class="table-responsive">
                                <table class="table table-hover manage-u-table contact-list" id="editable-datatable">
                                    <thead>
                                         <tr>
                                            <th>TITULO VIDEO</th>
                                            <th>VISTA PREVIA</th>
                                            <th>PREGUNTAS/RESPUESTAS </th>
                                            <th>ACCION</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenido_cap">
                                        
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
    <script src="<?php echo base_url();?>assets/plugins/bower_components/jquery-datatables-editable/jquery.dataTables.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/datatables/dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/mindmup-editabletable.js"></script>
    <script src="<?php echo base_url();?>assets/plugins/bower_components/tiny-editable/numeric-input-example.js"></script>

    <script src="<?php echo base_url();?>assets/plugins/bower_components/nestable/jquery.nestable.js"></script>
    <script>


    
    $(document).ready(function() {
        load_data_cap();
        load_ordenVideos();
        
        $('#nestable').nestable().on('change',function(){          
          var array =[];  
          var dato = $(this).nestable('serialize');

          $.ajax({
            url: "<?php echo base_url();?>panel_admin/update_ordenVideos",
            type:"POST",
            dataType: 'json',
            data:{id:dato},
            success:function(data){
                console.log(data);
                if (data){
                  $.toast({
                            heading: 'Video Ordenado',
                            text: 'Se ordeno correctamente el video.',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });
                }
                if ($.fn.DataTable.isDataTable( '#editable-datatable' ) ) {
                              table = $('#editable-datatable').DataTable();
                              table.destroy();
                              load_data_cap();
                              }
                              else {
                                    load_data_cap();
                                   }
            }
        });
          //console.log(data[0].id);
          $.each(dato, function( key, value ) {
          array.push(dato[key].id);
        });
         $('#tar').val(array+",");

        });
       
       
    $('#evaluacion').keypress(function(tecla) {
        if(tecla.charCode < 48 || tecla.charCode > 57) return false;
    });

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


    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        sumar();
    });


    $(document).on("click","#btn-agregar", function(){
        $("#add_cap")[0].reset();
        $('#camino').val("insertar");
    });

    $(document).on("click",".btn-asociar-pregunta", function(){
        $(this).closest("tr").css('background-color', '#8cf2ee');
        var id = $(this).attr('data');
        $('#id_cap_preg').val(id);
         
    });
    var ite = 0;
    $(document).on("click",".add_pregunta", function(){
         ite = ite + 1;
            html = "<tr>";
            html += '<td><div class="form-group">'+
                         '<input type="num" class="form-control" id="pregunta" name="pregunta['+ite+'][]"  placeholder="Escriba Pregunta'+ite+'"    data-error="Escriba Pregunta " required>'+
                         '<div class="help-block with-errors"></div>'+
                         '<div class="cap-respuesta"></div>'+
                        '</div></td>';
            html += "<td><button type='button' class='btn btn-primary add_repuesta'><span class='fa fa-file-text-o'></span></button></td>";
            html += "<td><button type='button' class='btn btn-danger btn-remove-pregunta'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $("#list_preguntas").append(html);
           
       
    });
    

    var teste = 0;
    $(document).on("click",".add_repuesta", function(){
            teste = teste + 1;
            html = "<tr>";
            html += '<td>'+
                     '<div class="col-md-12">'+
                        '<div class="form-group">'+
                         '<textarea    name="respuesta[]" class="form-control"  placeholder="Escriba repuesta" rows="4" cols="50" required  data-error="Escriba Respuesta"></textarea>'+


                         '<div class="help-block with-errors"></div>'+
                        '</div>'+
                      '</div></td>'+

                      '<td>'+
                          '<div class="col-md-12">'+
                            '<div class="form-group">'+
                              '<label class="control-label">Es Correcta:</label>'+
                              '<select class="form-control"  name="es_correcta[]">'+
                                  '<option value="0" selected >NO</option>'+
                                  '<option value="1">SI</option>'+
                              '</select>'+ 
                              '<div class="help-block with-errors"></div>'+
                           '</div>'+
                      '</td>';
            html += "<td><button type='button' class='btn btn-danger btn-remove-pregunta'><span class='fa fa-remove'></span></button></td>";
            html += "</tr>";
            $(".cap-respuesta").append(html);
           
       
    });



     $(document).on("click",".btn-remove-pregunta", function(){
        $(this).closest("tr").remove();
        ite --;
        teste --;
     });

      $(document).on("click","input[type=radio]", function(e){
        alert($(this).val());
          if($(this).is(':checked')){
           // es_correcta = $('input[name=radio_respuesta]').val(1);
          es_correcta = 1;
         }
              console.log(es_correcta)
          $("input[name='es_correcta']").val(es_correcta);
         
     });

  $(document).on("click","#btn-add-cap",function(){
      $("#add_cap")[0].reset();
      var camino = "insertar";
      $('#tit').text('Nueva Capacitación');
      
        $.ajax({
            url: "<?php echo base_url();?>panel_admin/form_add_cap",
            type:"POST",
            dataType:"html",
             data:{camino:camino},
            success:function(data){
                $("#form_cap").html(data);
            }
        });
    }); 

    $(document).on("click",".edit-row-btn",function(){
      var id = $(this).attr('data');
      console.log(id);
      var camino = "editar";
      $('#tit').text('Editar Capacitación');
        $.ajax({
            url: "<?php echo base_url();?>panel_admin/getdatos_cap",
            type:"POST",
            dataType:"html",
             data:{id:id,camino:camino},
            success:function(data){
                $("#form_cap").html(data);
            }
        });
    });     



        
   $(document).on("click",".view-preg-resp",function(){
        var valor_id = $(this).attr('data');
        console.log(valor_id);
        $.ajax({
            url: "<?php echo base_url();?>panel_admin/view_preg_resp",
            type:"POST",
            dataType:"html",
            data:{id:valor_id},
            success:function(data){
                $("#detalle_compra").html(data);
            }
        });
    }); 
    

     




    $(document).on("click",".edit-row-btn1", function(){
        var id = $(this).attr('data');
        $('#camino').val("editar");
        var camino = "editar";
       // $(".collapseblebox").css({'display': "block" });
      
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/getdatos_cap',
                data: {id: id,camino:camino},
                async: false,
                dataType: 'json',
                success: function(data){

                    $('#id_cap').val(data.id_cap); 
                    $('#titulo_video').val(data.titulo_video);
                    $('#descripcion').val(data.descripcion);
                    $('#nombre_archivo').val(data.imag_portada);
                    $('#url_video').val(data.url_video);
                    $('#nombre_doc_eva').val(data.doc);
                    $('#evaluacion').val(data.evaluacion); 
                   var ruta = '<?php echo base_url();?>assets/videos/';
                   
                    $('#url_imagen').attr("data-default-file",ruta+data.imag_portada); 
                    // $("#foto").load(" #foto");

                },
                error: function(){
                  alert('No se pudo mostrar');
                }
        });        
    });


    
      $(document).on("click",".vista_previa", function(e){
            e.preventDefault();
            console.log("aq");
            $(this).ekkoLightbox();

     });



    $(document).on("click",".deletecap-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_cap',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  $.toast({
                        heading: 'Video eliminado ',
                        text: 'El video a sido eliminado.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 2500
                    });
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
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        
    });

         function load_ordenVideos()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_ordenVideos",
            method:"POST",
            success:function(data)
            {
             $('#nestable').html(data);
            }
        })
    }





       function load_data_cap()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_datAdmCap",
            method:"POST",
            success:function(data)
            {
             $('#contenido_cap').html(data);
               var table = $('#editable-datatable').DataTable({
                 responsive: true,
                 ordering: false,
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