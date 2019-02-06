
    <div class="row bg-title">
                    <!-- .page title -->
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">productos en carrito</h4> </div>
                </div>

   <div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                           
                                            <h4 class="modal-title">Información</h4> </div>
                                        <div class="modal-body">
                                            
                                        </div>
                                        <div class="modal-footer">
                                            
                                            <button type="button" class="btn btn-info waves-effect waves-light">OK</button>
                                        </div>
                                    </div>
                                </div>
                            </div>             

    <div class="white-box" id="capa_general">
        <div class="row">
            <div class="col-md-10 col-md-offset-2">
                  <h3><b>CARRITO</b> <span class="pull-right">
                    <button type="button" class="btn btn-block btn-outline btn-primary"
                   id="btn-micartera" data="<?= $datos_emp->comision_acumulada?>" <?php if($datos_emp->comision_acumulada == 0) echo "disabled" ?> ><i class="mdi mdi-wallet fa-fw"></i> Mi Cartera: $
                   <?= $datos_emp->comision_acumulada  ?></button></span></h3>

                <div class="table-responsive" style="clear: both;">
                    <br>
                    <div class="alert alert-danger" id="msg-error" style="display: none;">
                         <strong>¡Importante!</strong>  
                          <div  id="list_errorsA"></div>
                        </div>
                    <?php if (validation_errors()): ?>
                   <div class="alert alert-danger">
                      <?php echo validation_errors(); ?>
                   </div>
                <?php endif; ?>
                    <table class="table color-table info-table m-t-30 table-hover contact-list"
                     id="carrito" data-page-size="10">
                        <thead>
                            <tr>
                                <th class="text-center">&nbsp;</th>
                                <th class="text-center">&nbsp;</th>
                                <th>Producto</th>
                                <th class="text-right">Precio</th>
                                <th class="text-center">Cantidad</th>
                                <th  colspan=2 class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody >
                     <form  id="finalizar_compra1" action="<?php echo base_url() ?>capacitacion/validar_carrito"  method="post">  
                            <?php 
                            //var_dump($result);
              							if($result[0] == false && $result[1] == false){
              							?>
                             <tr>
                                <div class="alert alert-warning"> NO HAY PRODUCTOS EN EL CARRITO</div>
                             </tr>
              							<?php  
              							}else{
              								if(!empty($result)){
              								foreach ($result as $key => $value):
              								  if($value){									  
              									for ($i=0; $i <count($value) ; $i++) : 									  
              									 ?>
              								  <tr>
              									 <td class="text-center"> <input type="hidden" name="idproductos[]" value="<?= $value[$i]->id_producto ?>"></td>
              									<td class="text-center">
              									 <a class= "btn-remove-producto" data-toggle="tooltip" data="<?= $value[$i]->id_car ?>" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a></td>
              									<td>
              									<img src=" <?php echo base_url();?>assets/uploads/img_productos/<?= $value[$i]->url_imagen ?>" alt="user" class="img-circle" /><?= $value[$i]->nombre_prod ?></td>
              									<td class="text-center"> <?= $value[$i]->precio_car ?><input type='hidden' name='precios[]' value='<?= $value[$i]->precio_car ?>'>
												        <input type='hidden' name='es_combo[]' value='<?= $value[$i]->es_combo ?>'>
												</td>
              									<td class="text-right">
              										<div class="row">
              										<div class="form-group">
              												<div class="col-sm-6 col-md-offset-3">
              												  <input type="number" name="cantidades[]" class="form-control input-sm" 
              													value="<?= $value[$i]->cantidad ?>">
              												</div>
              											</div>
              										</div>    
              									</td>
              									<td class="text-right"> <input type='hidden' name='importes[]' value='<?= $value[$i]->importe ?>'><p><?= $value[$i]->importe ?></p></td>
              								</tr>
              							   <?php  endfor;
              								  }
              								endforeach; 							  
              								?>
              								<?php }else{ ?>
              								 <tr>
              									<div class="alert alert-warning"> NO HAY PRODUCTOS EN EL CARRITO</div>
              								<?php } 
              							}?> 
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-8 col-md-offset-4">
                <div class="pull-right m-t-30 text-right">
                    <h3><p> Subtotal: $<span id="subtotal"></span></p></h3>
                   <h3><p id="mis_comisiones" style="display: none;"> Mi Cartera: - $
                     <span id="descuento"></span></p></h3>
                 
                     <!--div class="col-md-2 col-md-offset-10">

                    <input type="hidden"  name="micartera" id="micartera" value="0.00" class=" form-control" data-bts-button-down-class="btn btn-default btn-outline" data-bts-button-up-class="btn btn-default btn-outline"></div-->
                    <h3><b>Total a Pagar :</b> $ <span id="total_pagar"></span> </h3> </div>
                   <input type="hidden" name="total" id="total" value=""> 
                   <input type="hidden" name="sub_total" id="sub_total" value="">
                   <input type="hidden" name="micartera" id="micartera" value="<?= $datos_emp->comision_acumulada  ?>">
                   <input type="hidden" name="descuento_cartera" id="descuento_cartera" value="0"> 
                   <input type="hidden" name="medio_pago" id="pago_empresa" value="pago_empresa">
                <div class="clearfix"></div>
                <hr>
               
              <div class="col-sm-12 col-md-8 col-md-offset-4 text-center">
                  <div class="form-group">
                      <label class="control-label">Seleccione Método de Pago</label>
                      <div class="radio-list">
                          <label class="radio-inline p-0">
                              <div class="radio radio-info">
                                  <input type="radio" name="medio_pago" id="pago_empresa" value="pago_empresa">
                                  <label for="radio1">Acordar con la empresa</label>
                              </div>
                          </label>
                          <label class="radio-inline">
                              <div class="radio radio-info">
                                  <input type="radio" name="medio_pago" id="pago_transf" value="pago_transf">
                                  <label for="radio2">Transferencia Bancaria </label>
                              </div>
                          </label>
                          <label class="radio-inline">
                              <div class="radio radio-info">
                                  <input type="radio" name="medio_pago" id="mercado_pago" checked="true" value="mercado_pago">
                                  <label for="radio2">Mercado Pago </label>
                              </div>
                          </label>
                      </div>
                  </div>
              </div>
              
            </div> 
                <div class="text-right">

                    <a href="<?php echo base_url();?>tienda" class="btn btn-default waves-effect waves-light m-r-10" type="button"> <span><i class="ti-shopping-cart-full"></i> Seguir Comprando</span> </a>
                    <button class="btn btn-info waves-effect waves-light" id="fin_compra" type="submit"> Solicitar Compra </button>
                </div>
            
           </form>
        </div>
    </div>

    <script type="text/javascript">

        $(document).ready(function(){
            //carrito();
            sumar_pro();
            var comision = $(this).attr('data');
            var total = $("input[name='subtotal']").val();
            if (total == 0){
              $("#fin_compra").attr('disabled',true);
            }

        $('#finalizar_compra').submit(function(e) {
            e.preventDefault();
            var url = '<?php echo base_url() ?>capacitacion/validar_carrito_ajax';
            var data = $('#finalizar_compra').serialize();
            $.ajax({
                    type: 'ajax',
                    method: 'post',
                    url: url,
                    data: data,
                    dataType: 'json',
                    beforeSend: function() {
                        //console.log("enviando....");
                        sweetalertprocesando();
                      }
                 })
                  .done(function(data){
                    console.log(data);
                    if (data.comprobador){
                       sweetalertinfo();
                       $("#msg-error").hide();
                     }
                    else{ 
                          $("#msg-error").show();
                          $("#list_errorsA").html(data.validacion);
                          $("#fin_compra").attr('disabled',true);
                        }
                     
                     
                  })
                  .fail(function(){
                     sweetalerterror();
                  }) 
                  .always(function(){
                   // window.location.href = "<?php echo base_url();?>carrito";
                  });
        });     
         
            
        });//fin onready

         function sweetalertinfo() {
         swal({   
            title: "Compra solicitada!",   
            text: "Un ejecutivo de DVIGI se comunicará con usted durante las proximas 24 hs. Para coordinar su envio y costo. De lo contrario pongase en contacto con nosotros, escribiendo a emprendedores@dvigi.com.ar",    
            type: "info",   
            showCancelButton: false,   
            confirmButtonText: "OK",   
            closeOnConfirm: false 
        }, function(){   
             window.location.href = "<?php echo base_url();?>mis_compras";
        });
     }

      function sweetalertprocesando() {
       var img = '<?php echo base_url();?>assets/ajax-cargando.gif';
        swal({
          title: "Procesando",
          text: "Por favor espere...",
          imageUrl: img,
          timer: 2000,   
          showConfirmButton: false
        });
     }

        


    $(document).on("click","#btn-micartera", function(){
              var comision  = parseFloat($(this).attr('data'));
              var sub_total = parseFloat( $('#sub_total').val());
              
              if (comision > sub_total){
              	  console.log(comision+" > "+sub_total);
                  resto = comision - sub_total;
				  total_pagar = 0;
				  $('#micartera').val(resto);
				  $('#total').val(0);
                  $('#descuento_cartera').val(sub_total.toFixed(2));
                  $('#btn-micartera').html('<i class="mdi mdi-wallet fa-fw"></i> Mi Cartera:  $ '+resto);
                  $('#mis_comisiones').show();
				  $("#descuento").text(" "+ sub_total.toFixed(2));
	              $("#total_pagar").text(" "+total_pagar.toFixed(2));
                 // sumar_pro();
                
              }else{
              	   console.log(comision+" < "+sub_total);
	              	resto = sub_total - comision;
					cartera_vacia = 0;
	                $('#micartera').val(cartera_vacia.toFixed(2));
                    $('#descuento_cartera').val(comision.toFixed(2));
	                $('#btn-micartera').html('<i class="mdi mdi-wallet fa-fw"></i> Mi Cartera:  $ '+cartera_vacia);
	                $('#mis_comisiones').show();
					$('#total').val(resto.toFixed(2));
					$("#descuento").text(" "+ comision.toFixed(2));
	                $("#total_pagar").text(" "+resto.toFixed(2));
	                //sumar_pro();
                   }
     });

 
    function sumar_pro(){
       
	   total = 0;
       descuento = $('#micartera').val();
	   
        $("#carrito tbody tr").each(function(){
            total = total + Number($(this).find("td:eq(5)").text());
           
            total_pagar = total;
        });
		 $("#subtotal").text(" "+total.toFixed(2));
		 $("#descuento").text(" "+ descuento);
		 $("#total_pagar").text(" "+total_pagar.toFixed(2));

		 $("#total").val(total_pagar.toFixed(2));
		 var sub_total =  $("#sub_total").val(total.toFixed(2));

           var total = $("input[name='sub_total']").val();
            if (total == 0){
              $("#fin_compra").attr('disabled',true);
            }else{
               $("#fin_compra").attr('disabled',false);
            }
      

    } 
 
    $(document).on("keyup","#carrito input", function(){

        cantidad = $(this).val();
        precio = $(this).closest("tr").find("td:eq(3)").text();
        id = $(this).closest("tr").find("td:eq(1)").children("a").attr('data');
        console.log(id);
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(5)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(5)").children("input").val(importe.toFixed(2));
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>capacitacion/update_prodCar',
                data: {id_car: id,cantidad: cantidad,importe: importe},
                async: false,
                dataType: 'json',
                success: function(data){
                  
                },
                error: function(){
                  alert('No se pudo actualizar');
                }
        });
        location.reload(true);
        sumar_pro();


    }); 

      $(document).on("change","#carrito input", function(){

        cantidad = $(this).val();
        precio = $(this).closest("tr").find("td:eq(3)").text();
        id = $(this).closest("tr").find("td:eq(1)").children("a").attr('data');
        console.log(id);
        importe = cantidad * precio;
        $(this).closest("tr").find("td:eq(5)").children("p").text(importe.toFixed(2));
        $(this).closest("tr").find("td:eq(5)").children("input").val(importe.toFixed(2));
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>capacitacion/update_prodCar',
                data: {id_car: id,cantidad: cantidad,importe: importe},
                async: false,
                dataType: 'json',
                success: function(data){
                  
                },
                error: function(){
                  alert('No se pudo actualizar');
                }
        });
        location.reload(true);
        sumar_pro();

    });   

    $(document).on("click",".btn-remove-producto", function(){
        $(this).closest("tr").remove();
        var id = $(this).attr('data');
        $.ajax({
                type: 'ajax',
                method: 'get',
                url: '<?php echo base_url() ?>capacitacion/eliminar_prodCar',
                data: {id_car: id},
                async: false,
                dataType: 'json',
                success: function(data){
                  $.toast({
                        heading: 'Producto eliminado ',
                        text: 'El producto a sido eliminado del carrito.',
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 3500

                    });
                },
                error: function(){
                  alert('No se pudo eliminar');
                }
        });
        location.reload(true);
        sumar_pro();
    });
   

    function carrito()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/carrito_compra",
            method:"POST",
            success:function(data)
            {
             $('#prod_car').html(data);
            }
        })
    }

    //
   
   

    </script>

