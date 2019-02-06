                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">INICIO</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li class="active">Inicio</li>
                            
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
                <!-- ============================================================== -->
                <!-- .row -->
                 <!-- .row -->
                <div class="row">
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title"> <a href="#" data-toggle="modal" data-target="#detallepatocinados">Q EMPRENDEDORES</a> </h3>

                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash2"></div>
                                </li>
                                <li class="text-right">
                                    <div class="stats-row">
                                    <div class="stat-item">
                                        <h6><strong>Total</strong></h6> <b><span class="counter text-info"><?= $cantidad_total ?></span></b></div>
                                    <div class="stat-item">
                                        <h6><strong>Mes Actual</strong> </h6> <b><span class="counter text-info"><?= $emp_mes ?></span></b></div>
                                    <!--div class="stat-item">
                                        <h6>Dia</h6> <b>0</b></div-->
                                </div>
                        </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title"><a href="#" data-toggle="modal" data-target="#modal_clientesFinales">Q CLIENTES FINALES </a></h3>

                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash"></div>
                                </li>
                                <li class="text-right">
                                    <div class="stats-row">
                                         <div class="stat-item">
                                            <h6><strong>Total</strong></h6> <b> <span class="counter text-info"><?= $total_cli ?></span></b></div>
                                        <div class="stat-item">
                                            <h6><strong>Mes Actual</strong> </h6> <b> <span class="counter text-info"><?= $total_comp ?></span></b></div>
                                        <!--div class="stat-item">
                                            <h6>Dia</h6> <b>0</b></div-->
                                    </div>
                        </li> 
                               
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-xs-12">
                        <div class="white-box analytics-info">
                            <h3 class="box-title"><a href="#" data-toggle="modal" data-target="#modal_ventames" >$ VENTAS MES</a></h3>
                            <ul class="list-inline two-part">
                                <li>
                                    <div id="sparklinedash3"></div>
                                </li>
                                    <li class="text-right">
                                      <div class="stats-row">
                                         <div class="stat-item">
                                            <h6><strong>Total</strong></h6> <b class="text-info"> $<span class="counter text-info"><?= $total_ventas ?></span></b></div>
                                        <div class="stat-item">
                                            <h6><strong>Mes Actual</strong> </h6> <b class="text-info"> $<span class="counter text-info"> <?= $total_ventasMes ?></span></b></div>
                                        <!--div class="stat-item">
                                            <h6>Dia</h6> <b>0</b></div -->
                                      </div>
                               </li>
                            </ul>
                        </div>
                    </div>
                </div>
               <!--/.row -->

              
                    

                 <div class="row">
                     <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">ADMINISTRAR EMPRENDEDORES</h3>
                            <p class="text-muted m-b-30"></p>
                            <div class="table-responsive">

                                <table id="example" class="table display manage-u-table" style="font-family:Arial; font-size:70%">
                                    <thead >
                                        <tr > 
                                            <th> ACTIVAR / DESACTIVAR</th>
                                            <th> EMPRENDEDOR</th>
											<th>PATROCINADO POR </th>
											<th>CONTRATO FIRMADO </th>
											<th>ULTIMA COMPRA </th>
											<th>ACUMULADO ANUAL</th>
											<th class="text-center">EP</th>
											<th class="text-center">EPAT</th>           
											<th class="text-center">EPAT / EP</th>
											<th class="text-center">Q CLIENTES EN CARTERA</th>
											<th  class="text-center">% CARTERA ATENDIDA</th>   

                                        </tr>
                                    </thead>
                                    <tbody id="contenido_admin"  >
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </div>

            </div>

<!-- .modal for add task -->
<div class="modal fade" id="detallepatocinados" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Q Emprendedores </h4>
            </div>
            <div class="modal-body" id="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="table-responsive">
                                <div class="">
                                    <div class="white-box">
                                        <h3 class="box-title"></h3>
                                        <div>
                                              <canvas id="total_emp" style="height:230px"></canvas>
                                        </div>
                                    </div>
                                </div>
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
<div class="modal fade" id="modal_clientesFinales" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Q CLIENTES FINALES </h4>
            </div>
            <div class="modal-body" id="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="table-responsive">
                                <div class="">
                                    <div class="white-box">
                                        <h3 class="box-title"></h3>
                                        <div>
                                              <canvas id="grafica_clientesfinales" style="height:230px"></canvas>
                                        </div>
                                    </div>
                                </div>
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
<div class="modal fade" id="modal_ventames" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">$ VENTAS MES </h4>
            </div>
            <div class="modal-body" id="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="table-responsive">
                                <div class="">
                                    <div class="white-box">
                                        <h3 class="box-title"></h3>
                                        <div>
                                              <canvas id="grafica_ventames" style="height:230px"></canvas>

                                        </div>
                                    </div>
                                </div>
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





            <!-- /.container-fluid -->
<script type="text/javascript">
        $(document).ready(function() {
            load_data_emp();
            datagrafico_emp();
            ventasmes();
            ClientesFinales();
            

          
        });
 
     $(document).on("change","select", function(){
         //var perfil = $(this).find(':selected')[0];
         var perfil = $(this).val();
        console.log(perfil);

      });

      $(document).on("click",".status_cli", function(){
         data = $(this).val();
        infoproducto   = data.split("*");
         id            = infoproducto[0];
         status        = infoproducto[1];
         console.log("marcado--> "+infoproducto);
          $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/update_estadoEmp",
            method:"get",
           dataType: 'json',
            data:{id_emp:id,status_cli:status},
            success:function(data)
            {
              console.log(data);
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

                  if ($.fn.DataTable.isDataTable('#editable-datatable')) {
                      table = $('#editable-datatable').DataTable();
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


 
    function load_data_emp()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_dataemp",
            method:"POST",
            success:function(data)
            {
             $('#contenido_admin').html(data);
               var table = $('#example').DataTable({
                order:[[ 0, "desc"]],
               //pageLength: 5,
                scrollY:"400px",
                scrollCollapse: true,
                //paging: false,
                responsive: true,
				columnDefs: [
                    { "width": "8%", "targets": 10 },
					{ "width": "8%", "targets": 9 },
					{ "width": "8%", "targets": 8 },
					{ "width": "8%", "targets": 7 },
					{ "width": "8%", "targets": 6 },
					{ "width": "8%", "targets": 5 },
					{ "width": "8%", "targets": 4 },
					{ "width": "5%", "targets": 3 },
					{ "width": "5%", "targets": 2 },
					{ "width": "20%", "targets": 1 },
					{ "width": "14%", "targets": 0 }
				  ],
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


    function datagrafico_emp(){
   
     var base_url= "<?php echo base_url();?>";
    $.ajax({
      url: base_url + "panel_admin/getDataConsumo", 
      type:"POST",
      dataType:"json",
      success:function(data){
        var montos = new Array();      
        $.each(data,function(key, value){          
          montos.push(value);
        });
        crear_grafica_emp(montos);
       }
    });
  }

  

   function crear_grafica_emp(montos){
    $('#total_emp').replaceWith('<canvas id="total_emp" style="height:230px"></canvas>');   
    
    console.log(montos);
    var ctx = document.getElementById("total_emp");
    var myChart = new Chart(ctx, {
      type: 'bar',
           
      data: {
        labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
        datasets: [{
          label: 'Q EMPRENDEDORES',
          data: montos,
          backgroundColor: ['#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2'],
          borderColor: ['#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2'],
          borderWidth: 1
        }]
      },

      options: {
                title: {
                    display: false,
                    text: 'FUENTES DE INGRESO'
                },
                

        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true
            }

          }]
        }
      }
    });
    
  }


   $(document).on("click",".delet-inv", function(){
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>panel_admin/eliminar_emp',
                data: {id: id},
                async: false,
                dataType: 'json',
                success: function(data){
                	console.log(data);
                	
                	 $.toast({
	                        heading: 'Emprendedor Eliminado ',
	                        text: ' El emprendedor a sido eliminado.',
	                        position: 'top-right',
	                        loaderBg: '#ff6849',
	                        icon: 'error',
	                        hideAfter: 2500
                    });
                  if ($.fn.DataTable.isDataTable('#example')){
                      table = $('#example').DataTable();
                      table.destroy();
                      load_data_emp();
                      }
                      else {
                            load_data_emp();
                          }

                	
                 
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        
    });


  function ventasmes(){
    var base_url= "<?php echo base_url();?>";
    $.ajax({ 
      url: base_url + "panel_admin/getVentames", 
      type:"POST",
      dataType:"json",
      success:function(data){
        var montos = new Array();      
        $.each(data,function(key, value){          
          montos.push(value);
        });
        crear_grafica_ventasmes(montos);
       }
    });
  }

     function crear_grafica_ventasmes(montos){
    $('#grafica_ventames').replaceWith('<canvas id="grafica_ventames" style="height:230px"></canvas>');   
    
    console.log(montos);
    var ctx = document.getElementById("grafica_ventames");
    var myChart = new Chart(ctx, {
      type: 'bar',
           
      data: {
        labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
        datasets: [{
          label: '$ VENTAS MES',
          data: montos,
          backgroundColor: ['#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2'],
          borderColor: ['#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2'],
          borderWidth: 1
        }]
      },

      options: {
                title: {
                    display: false,
                    text: 'FUENTES DE INGRESO'
                },
                

        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true
            }

          }]
        }
      }
    });
    
  }


   function ClientesFinales(){
    var base_url= "<?php echo base_url();?>";
    $.ajax({
      url: base_url + "panel_admin/listar_clientes_finales_Mes", 
      type:"POST",
      dataType:"json",
      success:function(data){
        var montos = new Array();  
        $.each(data,function(key, value){          
          montos.push(value);
        });
        crear_grafica_finales(montos);
       }
    });
  }

     function crear_grafica_finales(montos){
    $('#grafica_clientesfinales').replaceWith('<canvas id="grafica_clientesfinales" style="height:230px"></canvas>');   
    
    //console.log(montos);
    var ctx = document.getElementById("grafica_clientesfinales");
    var myChart = new Chart(ctx, {
      type: 'bar',
           
      data: {
        labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
        datasets: [{
          label: 'Q CLIENTES FINALES',
          data: montos,
          backgroundColor: ['#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2'],
          borderColor: ['#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2','#2EA3F2'],
          borderWidth: 1
        }]
      },

      options: {
                title: {
                    display: false,
                    text: 'FUENTES DE INGRESO'
                },
                

        scales: {
          yAxes: [{
            ticks: {
              beginAtZero:true
            }

          }]
        }
      }
    });
    
  }






     $(document).on("click",".firmo", function(){
        var id = $(this).val();
         $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/update_firma",
            method:"GET",
            data:{id_emp:id},
            success:function(data)
            {
             var obj = jQuery.parseJSON(data);
            //console.log(obj.comprobador);
              if (obj.comprobador =="FIRMO"){
                  $.toast({
                            heading: 'Email enviado',
                            text: 'Notificación de contrato firmado enviado.',
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 3500,
                            stack: 6
                        });

                  if ($.fn.DataTable.isDataTable('#example')) {
                      table = $('#example').DataTable();
                      table.destroy();
                       load_data_emp();
                      }
                      else {
                          load_data_emp();
                          }
              }
 
            }

        })
    });

    $(document).on("click",".mostrar-asoc", function(){
        var id = $(this).attr('data');

        if ($.fn.DataTable.isDataTable('#lista-asoc')) {
                      table = $('#lista-asoc').DataTable();
                      table.destroy();
                      console.log("limpio tabla");
                      
                      }
                      else {
                           console.log("tabla cargada");
                         
                          }
        
         $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_listaPatrocinados",
            method:"POST",
            data:{id_emp:id},
            success:function(data)
            {
             $('#lista_patrocinados').html(data);
               var table = $('#lista-asoc').DataTable({
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
    });
</script>            

