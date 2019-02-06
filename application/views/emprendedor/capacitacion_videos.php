<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">CAPACITACION</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>">Inicio</a></li>
                            <li><a href="<?php echo base_url();?>">Capacitación</a></li>
                            <li class="active">Videos</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- .row -->
 



          <!-- .Row -->
           <?php  

                if (!empty($list_cap)):
                    foreach ($list_cap as $key): 
                    
                 ?> 
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    
                    <div class="row">
                        <div class="col-sm-3">
                             <a class="popup-youtube btn btn-default" title="Ver Video" href="<?= $key->url_video ?>"><img src="<?php echo base_url();?>assets/videos/<?= $key->imag_portada ?>" class="img-responsive" /></a>
                        </div>
                        <div class="col-sm-9" id="slimtest1">
                            <h3 class="box-title"><?= $key->titulo_video ?></h3>
                            <p align="justify"><?= $key->descripcion ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- /.Row -->
 <?php endforeach; ?> 
            <?php endif ?>  


<!-- form itself -->
            <div id="test-form" class="mfp-hide white-popup-block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info lg">
                                <div class="panel-wrapper collapse in" aria-expanded="true">
                                <div class="panel-body" id="form_eval">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               
            </div>

<script type="text/javascript">
   
     var base_url= "<?php echo base_url();?>";

     $(document).on("click",".btn-view-formEval",function(){
        //valor_id = $(this).val();
        var valor_id = $(this).attr('data');
        //alert(valor_id);
        $.ajax({
            url: base_url + "capacitacion/view_formEval",
            type:"POST",
            dataType:"html",
            data:{id:valor_id},
            success:function(data){
                $("#form_eval").html(data);
            }
        });
    }); 



      $(document).on("click",".descargar_doc",function(e){
        //  e.preventDefault();
        var valor_id = $(this).attr('data');
        //alert(valor_id);
        $.ajax({
            url: base_url + "capacitacion/downloads_doc",
            type:"POST",
            dataType:"html",
            data:{doc:valor_id},
            success:function(data){
                //$("#form_eval").html(data);
                console.log("descargando..."+data);
            }
        });
    });

     

      
</script>            

           






