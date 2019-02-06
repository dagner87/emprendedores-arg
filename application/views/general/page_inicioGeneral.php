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
                <!--div class="row">
                    <div class="row">
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">COMPRAS TOTALES</h3>
                            <div class="text-right"> <span class="text-muted">Dinero</span>
                                <h1><sup><i class="ti-arrow-up text-success"></i></sup>12,000</h1> </div> <span class="text-success">20%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:20%;"> <span class="sr-only">20% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">TOTAL DE EMPRENDEDORES</h3>
                            <div class="text-right"> <span class="text-muted">Cantidad</span>
                                <h1><sup><i class="ti-arrow-down text-danger"></i></sup><?= $total_emp; ?></h1> </div> <span class="text-danger">30%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:30%;"> <span class="sr-only">230% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">NUEVOS EMPRENDEDORES</h3>
                            <div class="text-right"> <span class="text-muted">Semana</span>
                                <h1><sup><i class="ti-arrow-up text-info"></i></sup>10,000</h1> </div> <span class="text-info">60%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:60%;"> <span class="sr-only">20% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-xs-12">
                        <div class="white-box">
                            <h3 class="box-title">NUEVOS EMPRENDEDORES</h3>
                            <div class="text-right"> <span class="text-muted">Mes</span>
                                <h1><sup><i class="ti-arrow-up text-inverse"></i></sup>9,000</h1> </div> <span class="text-inverse">80%</span>
                            <div class="progress m-b-0">
                                <div class="progress-bar progress-bar-inverse" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width:80%;"> <span class="sr-only">230% Complete</span> </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div--->
                <div class="row">
                  <div class="col-md-6">
                        <div class="white-box"> 
                          <div class="box-body" >             
                          <canvas id="ventas_propias" style="height:230px"></canvas>
                          <br>
                         <!--button  id="btn-semanal" class="fcbtn btn btn-outline btn-primary btn-1c btn-sm">Semanal</button>
                        <button  id="btn-mensual" class="fcbtn btn btn-outline btn-primary btn-1c btn-sm">Mensual</button>
                        <button  id="btn-anual" class="fcbtn btn btn-outline btn-primary btn-1c btn-sm">Anual</button-->              
                      </div>
                    </div>
                  </div>
                  <div class="row">
                  <div class="col-md-6">
                        <div class="white-box"> 
                          <div class="box-body" >             
                          <canvas id="graf_emprendedores" style="height:230px"></canvas>
                          <br>
                      </div>
                    </div>
                  </div>
               

                 <!---div class="row">
                     <div class="col-sm-12">
                        <div class="white-box">
                            <h3 class="box-title m-b-0">ADMINISTRAR EMPRENDEDORES</h3>
                            <p class="text-muted m-b-30"></p>
                            <div class="table-responsive">
                                <table id="example" class="table display manage-u-table">
                                    <thead>
                                        <tr>
                                            <th>NOMBRE</th>
                                            <th>CONTRATO ADHESION </th>
                                            <th>ULTIMA COMPRA </th>
                                            <th>ACUMULADO</th>
                                            <th>PATROCINADOS ACTIVOS</th>
                                            <th>ESTADO</th>
                                            <th>CLIENTES FINALES</th>
                                            <th>ATENCION DE CLIENTE</th>
                                        </tr>
                                    </thead>
                                    <tbody id="contenido_admin">
                                    
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                  
                </div>

            </div-->

<!-- .modal for add task -->
<div class="modal fade" id="detallepatocinados" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content detalle">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Lista de Patrocinados </h4>
            </div>
            <div class="modal-body" id="">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel">
                            <div class="table-responsive">
                                <table class="table table-hover manage-u-table" id="lista-asoc">
                                    <thead>
                                        <tr>
                                            <th>No.Identidad</th>
                                            <th>Nombre</th>
                                            <th>Teléfono</th>
                                            <th width="250">Email</th>
                                        </tr>

                                    </thead>
                                    <tbody id="lista_patrocinados">

                                        
                                    </tbody>
                                </table>
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
            var base_url= "<?php echo base_url();?>";
            var year = (new Date).getFullYear(); 
            datagrafico_consumo(base_url,year);
            datagrafico_emprendedores(base_url,year);

          
        });
 
     $(document).on("change","select", function(){
         //var perfil = $(this).find(':selected')[0];
         var perfil = $(this).val();
        console.log(perfil);

      });

         function datagrafico_consumo(base_url,year){
            $.ajax({
              url: base_url + "general/getDataConsumo", 
              type:"POST",
              data:{year: year},
              dataType:"json",
              success:function(data){
                      
                var montos = [];          
                
                for (var k = 0 ; k < 12 ; k++) {  
                  montos[k] = 0;        
                }
                
                if(data.length > 0){
                  for (var key in data) { 
                    montos[data[key].mes - 1] = data[key].monto;
                  }
                  
                }     
                crear_grafica_ventas(montos);
                 
              }
            });
  }

  function crear_grafica_ventas(montos){
        $('#ventas_propias').replaceWith('<canvas id="ventas_propias" style="height:230px"></canvas>');   
    
    var ctx = document.getElementById("ventas_propias");
    var myChart = new Chart(ctx, {
      type: 'line',
           
      data: {
        labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
        datasets: [{
          label: 'VENTAS GENERALES',
          data: montos,
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)'
          ],
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

  //grafico emprendedores totales


         function datagrafico_emprendedores(base_url,year){
            $.ajax({
              url: base_url + "general/getDataConsumo", 
              type:"POST",
              data:{year: year},
              dataType:"json",
              success:function(data){
                      
                var montos = [];          
                
                for (var k = 0 ; k < 12 ; k++) {  
                  montos[k] = 0;        
                }
                
                if(data.length > 0){
                  for (var key in data) { 
                    montos[data[key].mes - 1] = data[key].monto;
                  }
                  
                }     
                crear_graf_emprendedores(montos);
                 
              }
            });
  }

  function crear_graf_emprendedores(montos){
        $('#graf_emprendedores').replaceWith('<canvas id="graf_emprendedores" style="height:230px"></canvas>');   
    
    var ctx = document.getElementById("graf_emprendedores");
    var myChart = new Chart(ctx, {
      type: 'bar',
           
      data: {
        labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
        datasets: [{
          label: 'EMPRENDEDORES',
          data: montos,
          backgroundColor: [
            'rgba(0, 168, 255, 0.2)'
          ],
          borderColor: [
            'rgba(20,168,255,1)'
          ],
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

   

        function load_data_emp()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/load_dataemp",
            method:"POST",
            success:function(data)
            {
             $('#contenido_admin').html(data);
               var table = $('#example').DataTable({
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

     $(document).on("click",".firmo", function(){
        var id = $(this).val();
       
         $.ajax({
            url:"<?php echo base_url(); ?>panel_admin/update_firma",
            method:"GET",
            data:{id_emp:id},
            success:function(data)
            {
             var obj = jQuery.parseJSON(data);
             
              console.log(obj.comprobador);

              if ($.fn.DataTable.isDataTable('#example')) {
                      table = $('#example').DataTable();
                      table.destroy();
                      console.log("limpio tabla");
                       load_data_emp();
                      }
                      else {
                           console.log("tabla cargada");
                          load_data_emp();
                          }
             //$('#span'+id).text(obj.comprobador);              
             
             
              
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
            url:"<?php echo base_url(); ?>general/load_listaPatrocinados",
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

