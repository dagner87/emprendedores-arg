         
                <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Tienda</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="<?php echo base_url();?>carrito" class="btn btn-info pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="ti-shopping-cart"></i> Carrito de Compra</a>
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>">Inicio</a></li>
                            <li><a href="<?php echo base_url();?>tienda">Tienda</a></li>
                            <li class="active">Productos</li>
                        </ol>
                    </div>
                </div>


                <!-- .modal for add task -->
<div class="modal fade" id="insetcapModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="titulo_invit">Cantidad a Comprar </h4>
            </div>
            <div class="modal-body">
              <div class="alert alert-danger" id="mensaje" style="display: none;"></div>
                <form id="add_cap" action="" method="post">
                  <input class="" type="hidden" name="id_prod" value="" id="id_prod">
                  <input class="" type="hidden" name="existencia" value="" id="existencia">
                  <input class="" type="hidden" name="precio" value="" id="precio">
                  <input class="" type="hidden" name="es_combo" value="" id="es_combo">
                  
                  

                  <div class="form-group">
                      <label for="cantidad" class="control-label">Cantidad</label>
                      <input type="text" class="form-control"  name="cantidad" id="cantidad" placeholder="Cantidad" 
                      data-error="Escriba numero mayor a cero" required>
                      <div class="help-block with-errors"></div>
                  </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-reset" data-dismiss="modal">Cerrar</button>
                <button type="submit" id="guardar" class="btn btn-success">Agregar</button>
            </div>
             </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

 <!-- ============================================================== -->
<!-- Blog-component -->
<!-- ============================================================== -->


                <div class="row">
             <?php  if (!empty($productos)):?> 
                          <?php foreach ($productos as $key):
                          
                           $promo = $this->modelogeneral->buscar_promo($key->id_producto);
                          
                            ?> 
                            <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> 
                                  <?php if (!empty($promo)){  ?>
                                    <h4 class="price-lable text-white text-center bg-warning"> Promo</h4>
                                  <?php   }  ?> 
                             
                              <img class="img-responsive" alt="<?=  $key->nombre_prod;?>" src="<?php echo base_url();?>assets/uploads/img_productos/<?= $key->url_imagen;?>">
                                <div class="white-box" style="height: 300px;">
                                    <h3 class="m-t-20 m-b-20"><strong><span style=""><?=  $key->nombre_prod;?></span></strong></h3>
                                     <div class="text-muted">
                                      <a style="color:#3ec457" class="text-muted m-l-10" href="#"> <?=  $key->existencia;?> disponibles</a></div>
                                    <p>
                                      
                                    <?php
                                       if (!empty($promo)){
                                          $prociento = ($key->costo * $promo->descuento)/100 ;
                                          $promo  = $key->costo - $prociento;
                                          ?>
                                          <!--precio oficial de la tienda-->  
                                            <span style="color:#2ea3f2"> Precio + IVA <?= $iva->valor ?> %: <?= " $".$key->precio;?></span>
                                            <br>
                                          <!--costo para emprendedores -->
                                            <strong><span style="color:#2ea3f2" >Costo + IVA <?= $iva->valor ?> %: <?= " $ <s>".$key->costo ?></s> <?= " $ ".$promo ?> </span></strong>
                                            <br>
                                            <?php $costo_final =  $promo ;?>
                                          <!--margen-->
                                          <?php  $margen =  $key->precio - $promo ?>

                                          <span style="color:#2ea3f2">Margen:<?= " $".$margen;?></span>

                                          <?php 
                                        
                                       }else{  ?>
                                              <!--precio oficial de la tienda-->  
                                            <span style="color:#2ea3f2"> Precio + IVA <?= $iva->valor ?> %: <?= " $".$key->precio;?></span>
                                            <br>
                                          <!--costo para emprendedores -->
                                            <strong><span style="color:#2ea3f2" >Costo + IVA <?= $iva->valor ?> %: <?= " $ ".$key->costo ?></span></strong>
                                            <br>
                                            <?php $costo_final =  $key->costo ;?>
                                          <!--margen-->
                                          <?php  $margen =  $key->precio - $key->costo ?>

                                          <span style="color:#2ea3f2">Margen: <?= " $".$margen;?></span>

                                         <?php 
                                            }

                                          ?>

                                    </p>
                                    <div class="text-center">
                                      <button data-toggle="modal" data-target="#insetcapModal"  value="<?=  $key->id_producto."*".$key->existencia."*".$costo_final;?>" class="btn btn-outline btn-info btn-sm btn-car"><i class="ti-shopping-cart"></i> Añadir al Carrito</button>
                                      &nbsp;
                                     </div>
                                </div>
                            </div>
                    <?php endforeach; ?> 
                    <?php endif ?> 

                </div>

                   <!--combos-->

                <div class="row">
             <?php  if (!empty($combos)):?> 
                          <?php foreach ($combos as $key):

                            $promo = $this->modelogeneral->buscar_promoCombo($key->id_combo);

                          
                            ?> 
                            <div class="col-md-6 col-lg-3 col-xs-12 col-sm-6"> 

                              <?php if (!empty($promo)){  ?>
                                    <h4 class="price-lable text-white text-center bg-warning"> Promo</h4>
                                  <?php   }  ?> 
                             
                              <img class="img-responsive" alt="user" src="<?php echo base_url();?>assets/uploads/img_productos/<?= $key->url_imagen;?>">
                                <div class="white-box" style="height: 300px;">
                                    <h3 class="m-t-20 m-b-20"><strong><span style=""><?=  $key->nombre_combo;?></span></strong></h3>
                                     <div class="text-muted">
                                      <a style="color:#3ec457" class="text-muted m-l-10" href="#"> <?=  $key->existencia;?> disponibles</a></div>
                                    <p>

                                      <?php
                                       if (!empty($promo)){
                                          $prociento = ($key->costo * $promo->descuento)/100 ;
                                          $promo  = $key->costo - $prociento;
                                          ?>
                                          <!--precio oficial de la tienda-->  
                                            <span style="color:#2ea3f2"> Precio + IVA <?= $iva->valor ?> %: <?= " $".$key->precio_combo;?></span>
                                            <br>
                                          <!--costo para emprendedores -->
                                            <strong><span style="color:#2ea3f2" >Costo + IVA <?= $iva->valor ?> %: <?= " $ <s>".$key->costo ?></s> <?= " $ ".$promo ?> </span></strong>
                                            <br>
                                            <?php $costo_final =  $promo ;?>
                                          <!--margen-->
                                          <?php  $margen =  $key->precio_combo - $promo ?>

                                          <span style="color:#2ea3f2">Margen:<?= " $".$margen;?></span>

                                          <?php 
                                        
                                       }else{  ?>
                                              <!--precio oficial de la tienda-->  
                                              <span style="color:#2ea3f2"> Precio + IVA <?= $iva->valor ?> %: <?= " $".$key->precio_combo;?></span>
                                              <br>
                                            <!--costo para emprendedores -->
                                              <strong><span style="color:#2ea3f2" >Costo + IVA <?= $iva->valor ?> %: <?= " $ ".$key->costo ?></span></strong>
                                              <br>
                                              <?php $costo_final =  $key->costo ;?>
                                            <!--margen-->
                                            <?php  $margen =  $key->precio_combo - $key->costo ?>

                                            <span style="color:#2ea3f2">Margen: <?= " $".$margen;?></span>

                                         <?php 
                                            }

                                          ?>
                                      
                                    </p>
                                    <div class="text-center">
                                      <button data-toggle="modal" data-target="#insetcapModal"  value="<?=  $key->id_combo."*".$key->existencia."*".$costo_final;?>" class="btn btn-outline btn-info btn-sm btn-car-combo"><i class="ti-shopping-cart"></i> Añadir al Carrito</button>
                                      &nbsp;
                                     </div>
                                </div>
                            </div>
                    <?php endforeach; ?> 
                    <?php endif ?> 

                </div>
                <!-- ============================================================== -->
                <!-- chats, message & profile widgets -->
                <!-- ============================================================== -->
                <!-- /.row -->
                 
<script type="text/javascript">

   $(document).ready(function() {

   $('#add_cap').submit(function(e) {
            e.preventDefault();
         var  verficador = $('#es_combo').val();
         if (verficador == 'es_combo'){
              $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '<?php echo base_url() ?>capacitacion/add_toCar_combo',
                        data: $('#add_cap').serialize(),
                        dataType: 'json',
                        beforeSend: function() {
                            //sweetalert_proceso();
                            console.log("editando....");

                          }
                     })
                      .done(function(data){
                        console.log(data);
                      if (data.comprobador) {

                        $.toast({
                              heading: 'Producto agregado ',
                              text: 'Se agregó al carrito.',
                              position: 'top-right',
                              loaderBg: '#ff6849',
                              icon: 'success',
                              hideAfter: 3500,
                              stack: 6
                          });
                        $('#insetcapModal').modal('hide');
                         $("#add_cap")[0].reset();

                      }
                          
                         
                      })
                      .fail(function(){
                         alert("No se pudo agregar el carrito");
                           $('#insetcapModal').modal('hide');
                           $("#add_cap")[0].reset();
                      }) 
                      .always(function(){
                        
                      });
                

         }else{

                $.ajax({
                        type: 'ajax',
                        method: 'post',
                        url: '<?php echo base_url() ?>capacitacion/add_toCar',
                        data: $('#add_cap').serialize(),
                        dataType: 'json',
                        beforeSend: function() {
                            //sweetalert_proceso();
                            console.log("editando....");

                          }
                     })
                      .done(function(data){
                        console.log(data);
                      if (data.comprobador) {

                        $.toast({
                              heading: 'Producto agregado ',
                              text: 'Se agregó al carrito.',
                              position: 'top-right',
                              loaderBg: '#ff6849',
                              icon: 'success',
                              hideAfter: 3500,
                              stack: 6
                          });
                        $('#insetcapModal').modal('hide');
                         $("#add_cap")[0].reset();

                      }
                          
                         
                      })
                      .fail(function(){
                         alert("No se pudo agregar el carrito");
                           $('#insetcapModal').modal('hide');
                           $("#add_cap")[0].reset();
                      }) 
                      .always(function(){
                        
                      });
              }

        }); //insertar
 


   });// fin onready

$(document).on("click",".btn-reset",function(){  $("#add_cap")[0].reset(); });

$(document).on("click",".btn-car",function(){
        datos = $(this).val();
        var infoproducto = datos.split("*");
        $('#id_prod').val(infoproducto[0]); // id del producto
        $('#existencia').val(infoproducto[1]); // existencia
        $('#precio').val(infoproducto[2]); // existencia
        
        var stock = parseInt($('#existencia').val());
        if (stock == 0){
           $("input[name='cantidad']").attr('disabled',true);
  
        }else{
          $("input[name='cantidad']").TouchSpin({
                min: 1,
                max:stock ,
                stepinterval: 50,
                maxboostedstep:stock,
               
            });

        }
 
});

$(document).on("click",".btn-car-combo",function(){
        datos = $(this).val();
        var infoproducto = datos.split("*");
        $('#id_prod').val(infoproducto[0]); // id del combo
        $('#existencia').val(infoproducto[1]); // existencia
        $('#precio').val(infoproducto[2]); // costo final
        $('#es_combo').val("es_combo"); // es combo
        
        var stock = parseInt($('#existencia').val());
        if (stock == 0){
           $("input[name='cantidad']").attr('disabled',true);
  
        }else{
          $("input[name='cantidad']").TouchSpin({
                min: 1,
                max:stock ,
                stepinterval: 50,
                maxboostedstep:stock,
               
            });

        }
 
});

$(document).on("keyup","#cantidad",function(){
    var stock = parseInt($('#existencia').val());
    var valor = $(this).val();
    if(valor == 0 || valor > stock){
      console.log(valor);
      $("#guardar").attr("disabled",true);
      $('#mensaje').html("El valor debe ser inferior o igual a "+stock).show();

     
    } else {
            $("#guardar").attr("disabled",false);
            $('#mensaje').hide();

          }


  });
$(document).on("keydown","#cantidad",function(){
    var stock = parseInt($('#existencia').val());
    var valor = $(this).val();
    if(valor == 0 || valor > stock){
      console.log(valor);
      $("#guardar").attr("disabled",true);
      $('#mensaje').html("El valor debe ser inferior o igual a "+stock).show();

     
    } else {
            $("#guardar").attr("disabled",false);
            $('#mensaje').hide();

          }


  });
$(document).on("change","#cantidad",function(){
    var stock = parseInt($('#existencia').val());
    var valor = $(this).val();
    if(valor == 0 || valor > stock){
      console.log(valor);
      $("#guardar").attr("disabled",true);
      $('#mensaje').html("El valor debe ser inferior o igual a "+stock).show();

     
    } else {
            $("#guardar").attr("disabled",false);
            $('#mensaje').hide();

          }


  });



</script>