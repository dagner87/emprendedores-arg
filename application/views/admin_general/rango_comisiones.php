<div class="row bg-title">
    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
        <h4 class="page-title">ADMINISTACION DE COMISIONES</h4> </div>
    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <ol class="breadcrumb">
            <li><a href="#">Inicio</a></li>
            <li><a href="#">Configuración</a></li>
            <li class="active">Adm. Rango Comisiones</li>
        </ol>
    </div>
    <!-- /.col-lg-12 -->
 </div>
  <div class="row">
       <div class="col-md-12">
          <div class="white-box">
                <div class="row">
                  <div class="col-md-12">
                      <div class="panel">
                          <div class="panel-heading">Lista Rango de  comisiones</div>
                          <div class="table-responsive">
                           <h3 class="box-title"><button type="button"  id="btn-agregar" class="btn btn-info btn-rounded collapseble" data-toggle="modal" data-target="#insetcapModal" ><i class="fa fa-plus"></i> Agregar Rango</button></h3>

                          <table class="table table-striped" id="editable-datatable">
                                  <thead>
                                     <tr>
                                        <th>RANGO INICIAL</th>
                                        <th>RANGO FINAL</th>
                                        <th> % COMISION</th>
                                        <th>CATEGORIA</th>
                                        <th>ACCION</th>
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

    <!-- .modal for add task -->
<div class="modal fade" id="insetcapModal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit"><strong id="tit"> </strong></h4>
            </div>
            <div class="modal-body">
                <form id="add_cap" action="<?php echo base_url() ?>panel_admin/insert_comision" method="post">
                   <input type="hidden" name="id_tbl_comisiones" id="id_tbl_comisiones" value="">
                   <input type="hidden" name="camino" id="camino" value="">

            <div class="form-group">
                <label for="exampleInputuname">RANGO INICIAL</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-flag"></i></div>
                    <input type="text" class="form-control" name="rango_inicial" id="rango_inicial" placeholder=" Escriba rango Inicial" required> </div>
            </div>
            <div class="form-group">
                <label for="exampleInputphone">RANGO FINAL</label>
                <div class="input-group">
                    <div class="input-group-addon"><i id="cargando" class="ti-flag-alt"> </i></div>
                    <input type="text" class="form-control" name="rango_final" id="rango_final" placeholder="Escriba rango Final" required> </div>
            </div>
           
            
            <div class="form-group">
                <label for="exampleInputphone">% COMISION</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-percent"></i></div>
                    <input type="tel" class="form-control" name="valor_comision" id="valor_comision" placeholder="Escriba valor comisión" required> </div>
            </div>

            <div class="form-group">
                <label for="categoria">CATEGORIA</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-star"></i></div>
                    <input type="text" class="form-control" name="categoria" id="categoria" placeholder="Escriba la categoría" required> </div>
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


    <script>
    
    
    $(document).ready(function() {
        load_data_cap();


        $('#add_cap').submit(function(e) {
            e.preventDefault();
            var url    = '<?php echo base_url() ?>panel_admin/insert_comision';
            var url_up = '<?php echo base_url() ?>panel_admin/update_rango';
            var data   = $('#add_cap').serialize();
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
                              heading: 'Rango de comisión Agregado',
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
                                      heading: 'Rango de comisión Editado',
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

     
        
    });//onready
   
       function load_data_cap()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_dataRango",
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
      $(document).on("click","#btn-agregar", function(){
        $("#add_cap")[0].reset();
        $('#camino').val("insertar");
        $('#tit').text('Nuevo Rango');
    });

     $(document).on("click",".edit-row-btn", function(){
        var id = $(this).attr('data');
        $('#camino').val("editar");
        $('#tit').text('Editar Rango');
        $('#id_tbl_comisiones').val(id);
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/getdatos_rango',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                   $('#rango_inicial').val(data.rango_inicial);
                   $('#rango_final').val(data.rango_final);
                   $('#valor_comision').val(data.valor_comision);
                   $('#categoria').val(data.categoria);
                 },
                error: function(){
                  alert('No se pudo mostrar');
                }
        });
        
    }); 

    $(document).on("click",".deletecap-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_rango',
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
    </script>
    