<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">ADMINISTRACION DE PROMOCIONES</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="#">Inicio</a></li>
                            <li><a href="#">Tienda</a></li>
                            <li class="active">Adm.Promociones</li>
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
                <h4 class="modal-title" id="titulo_invit"> <strong id="tit"> </strong></h4>
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
<div class="modal fade" id="insetcapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Nuevo Producto </h4>
            </div>
            <div class="modal-body">
            <form  action="<?php echo base_url() ?>panel_admin/insert_prod" method="post">
            <div class="form-group">
                <label for="exampleInputuname">Nombre producto</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-layers-alt"></i></div>
                    <input type="text" class="form-control" name="nombre_prod" id="nombre_prod" placeholder=" Escriba Nombre producto" 
                    required data-error="Nombre producto"> 
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Stock </label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-shopping-cart-full"></i></div>
                    <input type="text" class="form-control"  name="stock" id="stock" placeholder=" Escriba Stock" required> </div>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Precio Tienda </label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-shopping-cart-full"></i></div>
                    <input type="text" class="form-control"  name="precio_original" id="precio_original" placeholder=" Escriba Precio Tienda" required> </div>
            </div>
            <div class="form-group">
                <label for="exampleInputphone">Precio Mayorista</label>
                <div class="input-group">
                    <div class="input-group-addon"><i class="ti-money"></i></div>
                    <input type="text" class="form-control" name="precio_unitario" id="precio_unitario" placeholder="Escriba Precio Unitario" required > </div>
            </div>
            <div class="form-group">
                <label for="exampleInputphone">Imagen</label>
                <div class="input-group">
                    <div class="input-group-addon"><i id="cargando" class="ti-camera"> </i></div>
                    <input type="file" class="form-control btn-file1" name="url_imagen1" id="url_imagen1" placeholder="Subir Imagen" required> </div>
                     <input type="text" id="nombre_archivo" name="nombre_archivo"  value="" class="form-control">
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
                            <div class="panel-heading">Lista de Promociones</div>
                            <div class="panel-wrapper collapse in">
                                <div class="panel-body">
                                    
                                  <div class="m-t-15 collapseblebox dn">
                                        <div class="well">
                                          <div class="panel-wrapper collapse in" aria-expanded="true">
                <div class="panel-body">
                    <form ><!--data-toggle="validator"-->
                        <div class="form-body">
                        
                    </form>
                </div>
            </div>
          </div>
     </div>
   </div>
   <div class="row">
        <div class="col-md-12">
          <h3 class="box-title">
             <button type="button" id="btn-add-cap" data-toggle="modal" data-target="#modal-add-cap" class="btn btn-info btn-rounded"> <i class="fa fa-plus"></i> Agregar Promoción</button>
          </h3>
            <div class="panel">
                
                <div class="table-responsive">
                 <br>
                <table class="table table-hover manage-u-table" id="promo-table">
                        <thead>
                            <tr>
                              <th style="width:10%">Estado</th>
                                <th>Nombre Promocion</th>
                                <th>Productos</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Descuento</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody id="contenido_tabla">
                            
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

   
    <script>

    
 
    $(document).ready(function() {

        load_data_cap();
        
    });//onready

 $(document).on("click",".estado_promo", function(){
         data = $(this).val();
        infoproducto     = data.split("*");
         id_promo        = infoproducto[0];
         estado_promo    = infoproducto[1];
         //console.log("marcado> "+id_promo);
          $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/update_estadoPromo",
            method:"get",
           dataType: 'json',
            data:{id_promo:id_promo,estado_promo:estado_promo},
            success:function(data)
            {
             // console.log(data);
              if (data.success) {
                 $.toast({
                            heading: 'Estado Actualizado',
                            text: 'Se actualizo la informacion correctamente.',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'info',
                            hideAfter: 3500,
                            stack: 6
                        });

                  if ($.fn.DataTable.isDataTable('#promo-table')) {
                      table = $('#promo-table').DataTable();
                      table.destroy();
                       load_data_cap();
                      }
                      else {
                          load_data_cap();
                          }
                }

              }
          
        })
    });



$(document).on("click","#btn-add-cap",function(){
      var camino = "insertar";
      $('#tit').text('Nueva Promo');
        $.ajax({
            url: "<?php echo base_url();?>panel_admin/form_add_promo",
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
      var camino = "editar";
      $('#tit').text('Editar Promoción');
        $.ajax({
            url: "<?php echo base_url();?>panel_admin/getdatos_promo",
            type:"POST",
            dataType:"html",
             data:{id:id,camino:camino},
            success:function(data){
                $("#form_cap").html(data);
            }
        });
    }); 

   
    
    $(document).on("click",".deletecap-row-btn", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_promo',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  $.toast({
                        heading: 'Promoción eliminada ',
                        text: 'La Promoción a sido eliminada.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 2500
                    });
                  if ($.fn.DataTable.isDataTable( '#promo-table' ) ) {
                      table = $('#promo-table').DataTable();
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
       function load_data_cap()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_dataPromo",
            method:"POST",
            success:function(data)
            {
             $('#contenido_tabla').html(data);
               var table = $('#promo-table').DataTable({
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