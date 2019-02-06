<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">Carpeta Presentación</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>">Inicio</a></li>
                            <li class="active">Carpeta Presentación</li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- .row -->
 
 <div class="row">
                    <div class="col-md-12">
                        <div class="white-box">
                            <h3 class="box-title">Carpeta Modelo de Negocio</h3>
                          <iframe src="https://drive.google.com/embeddedfolderview?id=15IG6298ClVdAcwMl9Bl8h9hQBEA74JQW#list" width="100%" height="800" frameborder="0"></iframe>
                          </div>

                    </div>
                </div> 


<!-- form itself -->
            <div id="test-form" class="mfp-hide white-popup-block">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-info">
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

      
</script>            

           






