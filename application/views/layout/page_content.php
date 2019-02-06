<style type="text/css">
.progress-bar-bronze{
   background-color: #a75b10;
}
.progress-bar-plata{
    background-color: #7d7474;
}
.progress-bar-oro{
    background-color:#ffcf40;
}



</style>
               <div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title">INICIO</h4> </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                        <a href="<?php echo base_url();?>carrito" class="btn btn-info pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="ti-shopping-cart"></i> Carrito de Compra</a>
                        <ol class="breadcrumb">
                            <li class="active">Inicio</li>
                            
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- ============================================================== -->
                <!-- Different data widgets -->
            
				<div class="row">
				  <div class="col-md-12">
				    <div class="white-box">
						<h3 class="box-title">Comisiones por Patrocinados Activos</h3>							
						<div class="progress progress-lg" style="background: linear-gradient(top, black, white);">

              <?php 
              $output = "";

              switch ($datos_emp->categoria) {
                case 'JUNIOR':

                
                 $porcentaje = $this->modelogeneral->poc_comisiones('JUNIOR');
                ?>
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 20%;" 
                   class="progress-bar progress-bar-danger progress-bar-striped active">JUNIOR <?=$porcentaje->valor_comision  ?>%</div>
                 
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BRONCE'); ?>  
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-bronze progress-bar" 
                  style="background-color:#a75b1047; width: 20%;">BRONCE <?=$porcentaje->valor_comision  ?>%</div> 
                 
                  <?php  $porcentaje = $this->modelogeneral->poc_comisiones('PLATA'); ?>                 
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-plata progress-bar"
                   style="background-color:#4c566738; width: 20%;">PLATA <?=$porcentaje->valor_comision  ?> %</div>
                  
                    <?php  $porcentaje = $this->modelogeneral->poc_comisiones('ORO'); ?> 
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#ffcf4040; width: 20%;" class="progress-bar progress-bar-oro progress-bar" >ORO <?=$porcentaje->valor_comision  ?> %</div>
                  
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BLACK'); ?> 
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#4c566761; width: 20%;" class="progress-bar progress-bar-inverse progress-bar">BLACK <?=$porcentaje->valor_comision  ?> %</div>
                 
                   <!--?php  $porcentaje = $this->modelogeneral->poc_comisiones('DIAMANTE'); ?> 
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style=" background-color:#7ace4c40; width: 17%;" class="progress-bar progress-bar-success progress-bar"> DIAMANTE <?=$porcentaje->valor_comision  ?> %</div-->
                
                <?php 
                  break;
                case 'BRONCE':
                  ?>
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('JUNIOR'); ?>  
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style=" background-color:#f331554a;width: 20%;" class="progress-bar progress-bar-danger progress-bar">JUNIOR <?=$porcentaje->valor_comision  ?> %</div>
                  
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BRONCE'); ?>  
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 20%;" class="progress-bar progress-bar-bronze progress-bar-striped active">BRONCE <?=$porcentaje->valor_comision  ?>%</div>
                  
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('PLATA'); ?>  
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-plata progress-bar"
                   style="background-color:#4c566738; width: 20%;">PLATA <?=$porcentaje->valor_comision  ?> %</div>
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('ORO'); ?>  
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#ffcf4040; width: 20%;" class="progress-bar progress-bar-oro progress-bar" >ORO <?=$porcentaje->valor_comision  ?> %</div>
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BLACK'); ?>  
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#4c566761; width: 20%;" class="progress-bar progress-bar-inverse progress-bar">BLACK <?=$porcentaje->valor_comision  ?> %</div>
                   <!--?php  $porcentaje = $this->modelogeneral->poc_comisiones('DIAMANTE'); ?>  
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style=" background-color:#7ace4c40; width: 17%;" class="progress-bar progress-bar-success progress-bar">DIAMANTE <?=$porcentaje->valor_comision  ?> %</div-->
                <?php
                  break;
                case 'PLATA':
                  ?>
                    <?php  $porcentaje = $this->modelogeneral->poc_comisiones('JUNIOR'); ?>  
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#f331554a;width: 20%;" class="progress-bar progress-bar-danger progress-bar">JUNIOR <?=$porcentaje->valor_comision  ?> %</div>
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BRONCE'); ?>  
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-bronze progress-bar" 
                  style="background-color:#a75b1047; width: 20%;">BRONCE <?=$porcentaje->valor_comision  ?>%</div> 
                  <?php  $porcentaje = $this->modelogeneral->poc_comisiones('PLATA'); ?>  
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 20%;" class="progress-bar progress-bar-plata progress-bar-striped active">PLATA <?=$porcentaje->valor_comision  ?> %</div>
                 
                  <?php  $porcentaje = $this->modelogeneral->poc_comisiones('ORO'); ?>  
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#ffcf4040; width: 20%;" class="progress-bar progress-bar-oro progress-bar" >ORO <?=$porcentaje->valor_comision  ?> %</div>
                  
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BLACK'); ?>  
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#4c566761; width: 20%;" class="progress-bar progress-bar-inverse progress-bar">BLACK <?=$porcentaje->valor_comision  ?> %</div>
                  
                   <!--?php  $porcentaje = $this->modelogeneral->poc_comisiones('DIAMANTE'); ?>  
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style=" background-color:#7ace4c40; width: 17%;" class="progress-bar progress-bar-success progress-bar">DIAMANTE <?=$porcentaje->valor_comision  ?> %</div-->
                <?php
                  break;
                case 'ORO':
                  ?>
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('JUNIOR'); ?>  
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style=" background-color:#f331554a;width: 20%;" class="progress-bar progress-bar-danger progress-bar">JUNIOR <?=$porcentaje->valor_comision  ?> %</div>
                  
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BRONCE'); ?>  
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-bronze progress-bar" 
                  style="background-color:#a75b1047; width: 20%;">BRONCE <?=$porcentaje->valor_comision  ?>%</div> 
                   
                  <?php  $porcentaje = $this->modelogeneral->poc_comisiones('PLATA'); ?>  
                    <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-plata progress-bar"
                   style="background-color:#4c566738; width: 20%;">PLATA <?=$porcentaje->valor_comision  ?> %</div>
                  
                  <?php  $porcentaje = $this->modelogeneral->poc_comisiones('ORO'); ?>  
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 20%;" class="progress-bar progress-bar-oro progress-bar-striped active">ORO <?=$porcentaje->valor_comision  ?> %</div>
                 
                 <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BLACK'); ?>   
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#4c566761; width: 20%;" class="progress-bar progress-bar-inverse progress-bar">BLACK <?=$porcentaje->valor_comision  ?> %</div>
                
                  <!--?php  $porcentaje = $this->modelogeneral->poc_comisiones('DIAMANTE'); ?>   
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style=" background-color:#7ace4c40; width: 17%;" class="progress-bar progress-bar-success progress-bar">DIAMANTE <?=$porcentaje->valor_comision  ?> %</div-->
                <?php
                  break;
                case 'BLACK':
                  ?>
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('JUNIOR'); ?>
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style=" background-color:#f331554a;width: 20%;" class="progress-bar progress-bar-danger progress-bar">JUNIOR <?=$porcentaje->valor_comision  ?> %</div>
                 
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BRONCE'); ?>
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-bronze progress-bar" 
                  style="background-color:#a75b1047; width: 20%;">BRONCE <?=$porcentaje->valor_comision  ?>%</div> 
                  
                    <?php  $porcentaje = $this->modelogeneral->poc_comisiones('PLATA'); ?>
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-plata progress-bar"
                   style="background-color:#4c566738; width: 20%;">PLATA <?=$porcentaje->valor_comision  ?> %</div>
                  
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('ORO'); ?>
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#ffcf4040; width: 20%;" class="progress-bar progress-bar-oro progress-bar" >ORO <?=$porcentaje->valor_comision  ?> %</div>
                  
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BLACK'); ?>
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 20%;" class="progress-bar progress-bar-inverse progress-bar-striped active">BLACK <?=$porcentaje->valor_comision  ?> %</div>
                 
                   <!--?php  $porcentaje = $this->modelogeneral->poc_comisiones('DIAMANTE'); ?>
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style=" background-color:#7ace4c40; width: 17%;" class="progress-bar progress-bar-success progress-bar">DIAMANTE <?=$porcentaje->valor_comision  ?> %</div-->
                <?php
                  break;
                case 'DIAMANTE':
                  ?>
                    <?php  $porcentaje = $this->modelogeneral->poc_comisiones('JUNIOR'); ?>
                   <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style=" background-color:#f331554a;width: 20%;" class="progress-bar progress-bar-danger progress-bar">JUNIOR <?=$porcentaje->valor_comision  ?> %</div>
                  
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BRONCE'); ?>
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-bronze progress-bar" 
                  style="background-color:#a75b1047; width: 20%;">BRONCE <?=$porcentaje->valor_comision  ?>%</div>                  
                  
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('PLATA'); ?>
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" class="progress-bar progress-bar-plata progress-bar"
                   style="background-color:#4c566738; width: 20%;">PLATA <?=$porcentaje->valor_comision  ?> %</div>
                  
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('ORO'); ?>
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#ffcf4040; width: 20%;" class="progress-bar progress-bar-oro progress-bar" >ORO <?=$porcentaje->valor_comision  ?> %</div>
                   
                   <?php  $porcentaje = $this->modelogeneral->poc_comisiones('BLACK'); ?>
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="background-color:#4c566761; width: 20%;" class="progress-bar progress-bar-inverse progress-bar">BLACK <?=$porcentaje->valor_comision  ?> %</div>
                  
                   <!--?php  $porcentaje = $this->modelogeneral->poc_comisiones('DIAMANTE'); ?>
                  <div role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 17%;" class="progress-bar progress-bar-success progress-bar-striped active"><i class="fa fa-trophy"> </i> DIAMANTE <?=$porcentaje->valor_comision  ?> %</div-->
                <?php
                  break;
                
              }  
               ?>	
						</div>	
                 <p>Te falta <?= $categoria_siguiente  ?> emprendedores activos para pasar a siguiente categoría</p>						
					</div>                    					
				  </div>
				</div>  
                <div class="row">
                  <div class="col-md-6">
				    <div class="white-box"> 
					    <div class="box-body" >							
							<canvas id="ventas_propias" style="height:230px"></canvas>
							<br>
              <button  id="btn-semanal" class="fcbtn btn btn-outline btn-primary btn-1c btn-sm">Semanal</button>
							<button  id="btn-mensual" class="fcbtn btn btn-outline btn-primary btn-1c btn-sm">Mensual</button>
							<button  id="btn-anual" class="fcbtn btn btn-outline btn-primary btn-1c btn-sm">Anual</button>							
						</div>
					</div>							
				  </div>
				  <div class="col-md-6">
				    <div class="col-md-6">
					  <div class="white-box">
						   <h3 class="box-title">% Cartera de clientes Atendida</h3>						
						   <canvas id="clientes_atendidos" style="height:230px"></canvas>	
               <div class="row p-t-30">
                                <div class="col-xs-8 p-t-28">
                                    <h5 class="text-muted m-t-0" ><span id="porc_atendidos"></span> </h5>
                                    <h5 class="text-muted m-t-0"><span id="porc_no_atendidos"></span> </h5>
                                </div>
                </div>  					
					</div>
				    </div>
					<div class="col-md-6">
					  <div class="white-box">
						    <h3 class="box-title">Productos Vencidos</h3>						
						    <canvas id="clientes_productos_vencidos" style="height:230px"></canvas>		
                <div class="row p-t-30">
                                <div class="col-xs-8 p-t-28">
                                    <h5 class="text-muted m-t-0" ><span id="atendidos"></span> </h5>
                                    <h5 class="text-muted m-t-0"><span id="no_atendidos"></span> </h5>
                                </div>
                </div>				
					   </div>
				    </div>                    					
				  </div>                 				  
                </div>
                  <div class="row">
                    <div class="col-sm-12">
                        <div class="white-box">
                           <!--div class="col-md-3 col-sm-4 col-xs-6 pull-right">
                                <select class="form-control pull-right row b-none">
                                    <option> 2017</option>
                                    <option> 2018</option>
                                </select>
                            </div-->
                            <h3 class="box-title">Reporte de asociados</h3>
                            <div class="row sales-report">
                                <div class="col-md-6 col-sm-6 col-xs-6">
                                    <h2></h2>
                                    <p></p>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 ">
                                   <h1 class="text-right text-info m-t-15" style="font-size: 28px;">Total de Comisión: <strong> $<?= $total_comision ?></strong></h1>
                                </div>
                            </div> <div class="table-responsive">
                                <table id="example23" class="table color-table info-table m-t-30 table-hover contact-list" data-page-size="10"" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Asociado</th>
                                            <th>Compras</th>
                                            <th class="text-center">Enero</th>
                                            <th class="text-center">Febrero</th>
                                            <th class="text-center">Marzo</th>
                                            <th class="text-center">Abril</th>
                                            <th class="text-center">Mayo</th>
                                            <th class="text-center">Junio</th>
                                            <th class="text-center">Julio</th>
                                            <th class="text-center">Agosto</th>
                                            <th class="text-center">Septiembre</th>
                                            <th class="text-center">Octubre</th>
                                            <th class="text-center">Noviembre</th>
                                            <th class="text-center">Diciembre</th>
                                        </tr>
                                    </thead>
                              
                                  
                                    <tbody>
                        <?php 
                            $count = 0;
                            $output = '';
                            
                            if(!empty($result))
                            {

                            $mes= 0;
                            foreach($result as $row)
                            {

                            $sumatoriaComp  = $this->modelogeneral->sumatoriaCompraEmp($row->id_emp);
                            $data['mes']    = 0;
                            $data['year']   = date('Y');
                            $data['id_emp'] = $row->id_emp;
                            $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                            $output .= '<tr >
                                    <td>
                                    <strong><img src="'.base_url().'assets/plugins/images/users/'.$row->foto_emp.'" alt="user" class="img-circle" /> '.$row->nombre_emp.'</strong>
                                    </td>
                                    <td> $ '.$sumatoriaComp->total_comp.'</td>';
                                     $data['mes'] ++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";

                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                    //*ENERO*/

                                     $data['mes']++;
                                     $S_ConsumoMensual          = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     $cantidad_venta['enero']    = $this->modelogeneral->cantidadVentas($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                    
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes'] ++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                    /*febrero*/                    
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                    
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                    
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12"style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td>';
                                     $data['mes']++;
                                     $S_ConsumoMensual  = $this->modelogeneral->sumatoriaCompraEmpMensual($data);
                                     if ($S_ConsumoMensual->total_comp == 0) {
                                        $msg ="error";
                                     }else{
                                        $msg ="success";
                                     }

                                     $output .= '<td> <div class="col-md-12" style ="padding-right: 0;
    padding-left: 0;">
                                                        <div class="form-group has-'.$msg.'">
                                                            <input  type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                        </div></td></tr>';
   
                                                   
                            }
                            

                            }
                            echo $output;
                            ?>    

                                        
    </tbody>
           <tfoot >
        <tr>
            <th>Comisión</th>
            <th>-</th>
          
            <?= $foot  ?>
            
        <tr>
            <th>Total</th>
            <th>$ <?= $total_comision ?></th>
             <?= $foot_comisiones  ?>
            
        </tr>
       
    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
               

 <div class="modal fade" id="modal_bienvenido" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                     <h4 class="modal-title" id="titulo_invit">BIENVENIDO  AL SISTEMA DE EMPRENDEDORES </h4>
                </div>
                <div class="modal-body">
                 
                  <!-- START carousel-->
                  <div id="carousel-example-captions-1" data-ride="carousel" class="carousel slide">
                      <ol class="carousel-indicators">
                          <li data-target="#carousel-example-captions-1" data-slide-to="0" class="active"></li>
                          <li data-target="#carousel-example-captions-1" data-slide-to="1"></li>
                          <li data-target="#carousel-example-captions-1" data-slide-to="2"></li>
  <li data-target="#carousel-example-captions-1" data-slide-to="3"></li>
  <li data-target="#carousel-example-captions-1" data-slide-to="4"></li>
                      </ol>
                      <div role="listbox" class="carousel-inner">
                          <div class="item active"> <img src="<?php echo base_url();?>assets/bienvenido/combo.jpg" alt="First slide image"> </div>
                          <div class="item"> <img src="<?php echo base_url();?>assets/bienvenido/jarraazul.jpg" alt="Second slide image"> </div>
                          <div class="item"> <img src="<?php echo base_url();?>assets/bienvenido/jarraroja.jpg" alt="Third slide image"> </div>
  <div class="item"> <img src="<?php echo base_url();?>assets/bienvenido/purificadores.jpg" alt="Third slide image"> </div>
  <div class="item"> <img src="<?php echo base_url();?>assets/bienvenido/purificadorgris.jpg" alt="Third slide image"> </div>
                      </div>
                  </div>
                  <!-- END carousel-->
                          
                  
                </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
   </div>  

                                                            
                
<script type="text/javascript">

    $(document).ready(function(){ 
    var base_url= "<?php echo base_url();?>";
    var year = (new Date).getFullYear(); 
    datagrafico_consumo(base_url,year);
    //productos vencidos
    datagrafico_prod_venc(base_url); 
	
	});//fin onready  

    $(document).on("click","#btn-mensual", function(){
        
        $('#ventas_propias').empty();
        var base_url= "<?php echo base_url();?>";
       var year = (new Date).getFullYear(); 
       getDataConsumoMes(base_url,year);
    });

    $(document).on("click","#btn-semanal", function(){
        $('#ventas_propias').empty();
        var base_url= "<?php echo base_url();?>";
       var year = (new Date).getFullYear(); 
       datagrafico_consumo_semanal(base_url,year); 
    });  
	
	$(document).on("click","#btn-anual", function(){
        $('#ventas_propias').empty();
        var base_url= "<?php echo base_url();?>";
       var year = (new Date).getFullYear(); 
       datagrafico_consumo(base_url,year); 
    }); 





function datagrafico_prod_venc(base_url){
    
        $.ajax({
            url: base_url + "capacitacion/getDataAtencionesCli", 
            dataType:"json",
            success:function(data){
                console.log(data);
                grafico_prod_venc(data);
                grafico_porc_atencion(data);
                    
            }
        });
    }

/*
clientes_atendidos
clientes_productos_vencidos
*/


     //--------------------------------------
     function grafico_porc_atencion(data){
    
    //% de antendidos y no atendidos
    var atendidos     = data.atendidos_porc;
    var no_atendidos  = data.no_atendidos_porc;
    $('#porc_atendidos').text("Atendidos: "+atendidos+"%");
    $('#porc_no_atendidos').text("No atendidos: "+no_atendidos+"%");
        
      var PieData = [atendidos, no_atendidos];
      
      var ctx = document.getElementById("clientes_atendidos");
      
      data = {
        datasets: [{
          data: PieData,
          backgroundColor: ['#36a2eb','#ff6384']
        }],

        // se puede asignar un arreglo dinamico con las localidades existentes
        labels: [
          '% Atendidos',
          '% No Atendidos'
        ]
      };
      
      var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: data
        
      });
      
    
  }

   function grafico_prod_venc(data){
    
    //% de antendidos y no atendidos
    var total          = data.total_cli - data.con_vencimiento;
    var con_vencimiento  = data.con_vencimiento;

    $('#atendidos').text("Con vencimiento: "+con_vencimiento);
    $('#no_atendidos').text("Atendidos: "+total);
        
      var PieData = [total, con_vencimiento];
      
      var ctx = document.getElementById("clientes_productos_vencidos");
      
      data = {
        datasets: [{
          data: PieData,
          backgroundColor: ['#36a2eb','#ff6384']
        }],

        // se puede asignar un arreglo dinamico con las localidades existentes
        labels: [
          'Cant. Atendidos',
          'Cant. No Atendidos'
        ]
      };
      
      var myDoughnutChart = new Chart(ctx, {
        type: 'doughnut',
        data: data
        
      });
      
    
  }


     



	
	function datagrafico_consumo_semanal(base_url,year){
    
		$.ajax({
			url: base_url + "capacitacion/getDataConsumo_semanal", 
			type:"POST",
			data:{year: year},
			dataType:"json",
			success:function(data){
				console.log(data);
			    var dias = new Array();
          var montos = new Array();
			
				$.each(data,function(key, value){
					dias.push(value.dia);
					valor = Number(value.monto);
					montos.push(valor);
				});
				
				console.log(montos);               					
						
				crear_grafica_ventas_diarias(montos, dias);
			    	
			}
		});
	}


    



    function datagrafico_consumo(base_url,year){
    
		$.ajax({
			url: base_url + "capacitacion/getDataConsumo", 
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

    function getDataConsumoMes(base_url,year){
		
		$.ajax({
			url: base_url + "capacitacion/getDataConsumoMes", 
			type:"POST",
			data:{year: year},
			dataType:"json",
			success:function(data){				
				
				var montos = [];          
				
				for (var k = 0 ; k < 31 ; k++) {	
					montos[k] = 0;				
				}
				
				if(data.length > 0){
					for (var key in data) {	
						montos[data[key].dia] = data[key].monto;
					}
					
				}			
				crear_grafica_ventasMes(montos);
                
			   
			}
		});
	}

     //--------------------------------------
    function crear_grafica_ventas_diarias(montos_semanal, dias){
        $('#ventas_propias').replaceWith('<canvas id="ventas_propias" style="height:230px"></canvas>');		
		
		var ctx = document.getElementById("ventas_propias");
		var myChart = new Chart(ctx, {
			type: 'line',
           
			data: {
				labels: dias,
				datasets: [{
					label: 'MIS VENTAS',
					data: montos_semanal,
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
                    text: 'MIS VENTAS'
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
	
	function crear_grafica_ventas(montos){
        $('#ventas_propias').replaceWith('<canvas id="ventas_propias" style="height:230px"></canvas>');		
		
		var ctx = document.getElementById("ventas_propias");
		var myChart = new Chart(ctx, {
			type: 'line',
           
			data: {
				labels: ["Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic"],
				datasets: [{
					label: 'MIS VENTAS',
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

     function crear_grafica_ventasMes(montos){
		
        $('#ventas_propias').replaceWith('<canvas id="ventas_propias" style="height:230px"></canvas>');		
                
        var ctx = document.getElementById("ventas_propias");
        var myChart = new Chart(ctx, {
            type: 'line',
           
            data: {
                labels: ["1", "2", "3", "4", "5", "6", "7","8", "9", "10", "11", "12","13", "14", "15", "16", "17", "18", "19","20", "21", "22", "23", "24","25", "26", "27", "28", "29", "30", "31"],
                datasets: [{
                    label: 'MIS VENTAS',
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


	 
   

     function reporte_asoc()
    {
        $.ajax({
            url:"<?php echo base_url(); ?>capacitacion/reporte_asoc",
            method:"POST",
            success:function(data)
            {
             //$('#reporte_asoc').html(data);
              $('#example23 tbody').html(data);
              $('#reporte tbody').html(data);
              var table = $('#example23').DataTable({
                
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
              var reporte = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function(settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function(group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });
             
             
            }
        })
    }

</script>  
