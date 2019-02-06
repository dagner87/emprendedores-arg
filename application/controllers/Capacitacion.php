<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Capacitacion extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->helper('download');
        $this->load->model('modelogeneral');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->library('excel');
    
    }

    public function progress($total=4)
	{
		
		
		for ($i=0; $i <= $total ; $i++) { 
	       $progreso[] = round(($i * 100)/ $total);
		}
		echo json_encode($progreso); 
    }

    function import()
    {

     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     
        if(isset($_FILES["file"]["name"]))
        {
            $path = $_FILES["file"]["tmp_name"];
            $verificador = false;
            $object = PHPExcel_IOFactory::load($path);
            $contador = 0;
            foreach($object->getWorksheetIterator() as $worksheet)
            {
                $highestRow    = $worksheet->getHighestRow();
                $highestColumn = $worksheet->getHighestColumn();
                for($row=3; $row <= $highestRow; $row++)
                {
                	$contador++;
                    $id_emp   = $this->session->userdata('id_emp'); 
                    $param['id_emp']           = $id_emp;
                  if($worksheet->getCellByColumnAndRow(0, $row)->getValue() != NULL){                    
                    $param['nombre_cliente']   = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $param['apellidos']        = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $param['dni']              = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $param['telefono']         = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $param['celular']          = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $param['email']            = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $param['direccion']        = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $param['fecha_nacimiento'] = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $codigo_postal             = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $datos_mun                 = $this->modelogeneral->buscar_MunicXcodigo($codigo_postal);  

                    $param['id_municipio']     = $datos_mun->id_municipio;
                    $param['id_provincia']     = $datos_mun->id_provincia;
                    $param['fecha_incio']      = $worksheet->getCellByColumnAndRow(9, $row)->getValue();

                    //verificar si existe en la bd
                    $client = $this->modelogeneral->buscar_exitenciaCLi($param['dni'], $param['email']);
                    if($client != NULL){
                      $data['id_cliente'] = $client->id_cliente;
                      $msg = "no encontre al cliente";
                     
                    }else{
                       $result = $this->modelogeneral->insert_cliente($param);
                       $data['id_cliente']    = $this->modelogeneral->lastID();                        
                       $msg = "encontre al cliente";
                    }

                    /*----registro el Pedido---- */                    
                    $data['id_emp']          = $id_emp;
                    $year = date('Y');
                    $no_pedido               = $this->modelogeneral->N_orden_compra($year);  
                    $data['no_pedido']       = 'ext-'.$no_pedido;
                    $this->modelogeneral->update_orden_compra($year);
                    $data['fecha_solicitud'] = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $this->modelogeneral->save_Pedido($data);
                    
                    /*  detalle de pedido */

	                $data_det['id_pedidos']    = $this->modelogeneral->lastID();
                    $producto                  = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $datos_prod                = $this->modelogeneral->buscar_ProdXnombre($producto);
                    $data_det['id_producto']   = $datos_prod->id_producto;
                    $data_det['cantidad']      = $worksheet->getCellByColumnAndRow(11, $row)->getValue();

                    $arrayDetalle = array(
                                          'productos'       => array($data_det['id_producto']),
                                          'id_pedidos'      => $data_det['id_pedidos'],
                                          'cantidad'        => array($data_det['cantidad']),
                                          'id_cliente'      => $data['id_cliente'],
                                          'fecha_solicitud' => $data['fecha_solicitud']

                                         );

                    $this->save_detallePedido($arrayDetalle);
                    $arrayDetalle = [];
                    //$this->modelogeneral->save_detallePedido($data_det); 
                   }                
                }
            }
            if ($verificador) {
                        $msg = "Datos importados con éxito";
                        
                    }else{
                        
                        $msg = "Error no se pudo importar";
                    }

            echo json_encode($arrayDetalle);
             //$msg;
        
            
        }   
    }


       public function eliminar_pedidoCli()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_pedidoCli($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

    protected function save_detallePedido($data){ 
    for ($i=0; $i < count($data['productos']); $i++) { 
      
          $dato_combo = array(
              'id_producto' => $data['productos'][$i], 
              'id_pedidos'  => $data['id_pedidos'],
              'cantidad'    => $data['cantidad'][$i] 
          );

          $infoProducto =  $this->modelogeneral->datos_productos($data['productos'][$i]);

            if ($infoProducto->es_repuesto == 1) {                 
                 
                 // buscamos los respuestos dado el producto
                 $result =  $this->modelogeneral->datos_respuestoPadre($data['productos'][$i]);

                 //$arrayVencimientos = [];

                 //inserto en la tabla producto_vencimiento el vencimiento de cada respuesto
                 $rep_cantidades  = $data['cantidad'][$i];
                 $infoRespuesto   =  $this->modelogeneral->datos_productos($result->id_respuesto_hijo);                     
                 $meses           =  $infoRespuesto->vencimiento * $rep_cantidades;
                 $fecha_actual    =  $data['fecha_solicitud'];
                 $fecha_final     = date("Y-m-d", strtotime("$fecha_actual + $meses month"));                     
                 $venc_resp       = array('fecha_vencimiento' => $fecha_final,
                                          'id_cliente' => $data['id_cliente'] ,
                                          'id_respuesto' => $result->id_respuesto_hijo);
                 $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                 $id_prod_vencimiento  =  $this->modelogeneral->lastID();
                 
                 //$arrayVencimientos[] = $id_prod_vencimiento;
                
                 /*foreach ($result as $key):
                    //inserto en la tabla producto_vencimiento el vencimiento de cada respuesto
                         $rep_cantidades  = $data['cantidad'][$i];
                         $infoRespuesto =  $this->modelogeneral->datos_productos($key->id_respuesto_hijo);                     
                         $meses =  $infoRespuesto->vencimiento * $rep_cantidades;
                         $fecha_actual =  date('Y-m-d');
                         $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));                     
                         $venc_resp = array('fecha_vencimiento' => $fecha_final,
                                           'id_cliente' => $data['id_cliente'] ,
                                           'id_respuesto' => $key->id_respuesto_hijo);
                         $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                         $id_prod_vencimiento  =  $this->modelogeneral->lastID();
                         $arrayVencimientos[] = $id_prod_vencimiento;
                  endforeach;*/

                     //inserto el respuesto del producto comprado
                     $prod_cliente = array('fecha_compra' => date('Y-m-d'),
                                           'id_producto'   => $data['productos'][$i],
                                           'id_cliente'    =>  $data['id_cliente']);
                     $this->modelogeneral->insert_prod_cliente($prod_cliente);
                     $id_prod_cli  =  $this->modelogeneral->lastID();
                     
                     //Guardo el registro de producto con repuesto del cliente
                     $prod_cli_venc = array('id_prod_vencimiento' => $id_prod_vencimiento,
                                            'id_prod_cli'         => $id_prod_cli);
                     $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);

                     /*for ($i=0; $i < count($arrayVencimientos) ; $i++) { 
                        $prod_cli_venc = array('id_prod_vencimiento' => $arrayVencimientos[$i],
                                               'id_prod_cli'         => $id_prod_cli);
                        $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);                      
                     }*/
                            
             } else {
                       //caso 1
                        $verif_resp =  $this->modelogeneral->verificador_vencimiento($data['id_cliente'],$data['productos'][$i]);
                        if ($verif_resp != NULL) {
                            $rep_cantidades  = $data['cantidad'][$i]; 
                            $dato_venc = $this->modelogeneral->buscar_prod($data['productos'][$i]);
                            $meses = $dato_venc->vencimiento * $rep_cantidades;
                            $fecha_actual =  $verif_resp->fecha_vencimiento;
                            $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month")); 

                            $datos_actvenc =  array('id_cliente' => $data['id_cliente'] ,
                                                   'id_producto' => $data['productos'][$i],
                                                    'fecha_vencimiento' =>$fecha_final);
                            $this->modelogeneral->updateverfi_vencimiento($datos_actvenc);                
                        } else {
                            $prod_padre =  $this->modelogeneral->datos_respuestoHijo($data['productos'][$i]);

                            $id_producto = $prod_padre->id_producto;

                            $prod_cliente = array('fecha_compra'   => $data['fecha_solicitud'],
                                                   'id_producto'   => $id_producto,
                                                   'id_cliente'    =>  $data['id_cliente']);

                            $this->modelogeneral->insert_prod_cliente($prod_cliente);
                            $id_prod_cli  =  $this->modelogeneral->lastID();


                            $dato_venc       = $this->modelogeneral->buscar_prod($data['productos'][$i]);
                            $rep_cantidades  = $data['cantidad'][$i];
                            $meses           = $dato_venc->vencimiento * $rep_cantidades;
                            $fecha_actual    =  $data['fecha_solicitud'];
                            $fecha_final     = date("Y-m-d", strtotime("$fecha_actual + $meses month"));
                            $venc_resp       = array( 'fecha_vencimiento' => $fecha_final,
                                                      'id_cliente' => $data['id_cliente'] ,
                                                      'id_respuesto' => $data['productos'][$i]);
                            $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                            $id_prod_vencimiento  =  $this->modelogeneral->lastID();

                            $prod_cli_venc = array('id_prod_vencimiento' => $id_prod_vencimiento,
                                                    'id_prod_cli'         => $id_prod_cli);
                            $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);
                           
                        }                
                    }
        
        $this->modelogeneral->save_detallePedido($dato_combo);
    
    }
}

   public function download_planilla(){
      	$file = './assets/uploads/cartera_clientes.xlsx';
           
            //download file from directory
            force_download($file, NULL);
     }


    public function getDataConsumo(){
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $id_emp   = $this->session->userdata('id_emp'); 
        $year     = $this->input->post("year");
        $resultados = $this->modelogeneral->montos_consumoAnual_pedidos($year,$id_emp);
        echo json_encode($resultados);
    }
	
	public function getDataConsumo_semanal(){
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $id_emp   = $this->session->userdata('id_emp'); 
        $year     = $this->input->post("year");
        $resultados = $this->modelogeneral->montos_consumo_semanal($year,$id_emp);
        echo json_encode($resultados);
    }

    public function getDataAtencionesCli(){
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $id_emp            =  $this->session->userdata('id_emp'); 
        $con_vencimiento   =  $this->modelogeneral->Count_vencimiento($id_emp);
        $total_cli         =  $this->modelogeneral->CountTotalCli($id_emp);
        $sin_venciento     =   $total_cli - $con_vencimiento;
        $atendidos_porc    =  round(($sin_venciento / $total_cli)*100);
        $no_atendidos_porc =  round(($con_vencimiento / $total_cli)*100);
     
        $resultados = array('total_cli'         => $total_cli ,
                            'con_vencimiento'   => $con_vencimiento,
                            'atendidos_porc'    => $atendidos_porc ,
                            'no_atendidos_porc' => $no_atendidos_porc
                             );


        
        echo json_encode($resultados);
    }

    public function getDataConsumoMes(){
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $id_emp   = $this->session->userdata('id_emp'); 
        $year     = $this->input->post("year");
        $resultados = $this->modelogeneral->montos_consumoMensual_pedidos($year,$id_emp);
        echo json_encode($resultados);
    }
	
	public function cron_comision()
    {
		$emp_result = $this->modelogeneral->emp_result();
		foreach ($emp_result as $key) {		
		  $dato['year'] = date('Y');
	      $dato['mes']= date('m'); 
	      echo "<br>".$dato['id_emp'] = $key->id_emp."<br>";
	      $valores_comisiones = $this->modelogeneral->cantidadVentas($dato);	
		  var_dump($valores_comisiones);
		  
		  $comision_actual = $this->modelogeneral->comision_actual($key->id_emp);
		  
		  $comision_final = $comision_actual->comision_acumulada + $valores_comisiones['comision'];
		  
		  $param = array(
		  'id_emp' => $key->id_emp,
		  'comision_acumulada' => $comision_final,
		  'categoria' => $valores_comisiones['categoria']);
		  
		  $update_comision = $this->modelogeneral->update_cartera_comision($param);
		 }
	}


     public function index()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp'); 
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['sumatoriaComp']  = $this->modelogeneral->sumatoriaCompraEmp($id_emp);
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);



     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);

     $temp = true;
     //if ($data['datos_emp']->id_cap != $data['ultimo_reg']->id_cap + 1)
     if ($temp == false)
      {
        $data['list_cap']   = $this->modelogeneral->listar_data_cap(); 
        $this->load->view("emprendedor/capacitacion_videos",$data);
      }else {            
			   $data['foot']="";
			   $data['foot_comisiones'] ="";
			   $i=1;
			   $total_comision = 0;
				while ($i <= 12):
					 $dato['year'] = date('Y');
					 $dato['mes']= $i;  
					 $dato['id_emp'] = $id_emp;
					 $valores_comisiones = $this->modelogeneral->cantidadVentas($dato); 
					 $data['foot'] .=  '<th class="text-center">'.$valores_comisiones['porciento'].'%</th>';
					 $data['foot_comisiones'] .=  '<th class="text-center">$ '.$valores_comisiones['comision'].'</th>';                
					$i++;
					$total_comision += $valores_comisiones['comision'];
				endwhile;

				 $data['total_comision']= $total_comision; 
				 
				 $dato['year'] = date('Y');
				 $dato['mes']= date('m'); 
				 $dato['id_emp'] = $id_emp;
				 $valores_comisiones = $this->modelogeneral->cantidadVentas($dato);
				 $data['categoria_siguiente'] = $valores_comisiones['categoria_siguiente'];
				 
				 $this->load->view("layout/page_content",$data);
            }
       $this->load->view("layout/footer");  
    }

    public function downloads_doc($doc){
      //$doc   = $this->input->post('doc');  
       $data = file_get_contents('assets/videos/'.$doc); 
       force_download($doc,$data); 
     
    }


     public function modulos()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp = $this->session->userdata('id_emp');
     $result = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['asociados']      = $result;
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
     $data['list_cap']   = $this->modelogeneral->listar_data_cap(); 
     $data['foot']="";
     $data['foot_comisiones'] ="";
     $i=1;
     $total_comision = 0;
        while ($i <= 12):
             $dato['year'] = date('Y');
             $dato['mes']= $i;  
             $dato['id_emp'] = $id_emp;
             $valores_comisiones = $this->modelogeneral->cantidadVentas($dato); 
             $data['foot'] .=  '<th class="text-center">'.$valores_comisiones['porciento'].'%</th>';
             $data['foot_comisiones'] .=  '<th class="text-center">$ '.$valores_comisiones['comision'].'</th>';                
            $i++;
            $total_comision += $valores_comisiones['comision'];
        endwhile;
     $data['total_comision']= $total_comision; 
     $dato['year'] = date('Y');
     $dato['mes']= date('m'); 
     $dato['id_emp'] = $id_emp;
     $valores_comisiones = $this->modelogeneral->cantidadVentas($dato);
     $data['categoria_siguiente'] = $valores_comisiones['categoria_siguiente'];
    
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/capacitacion_videos",$data);
     $this->load->view("layout/footer");  
    }




      public function carpeta_presentacion()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp = $this->session->userdata('id_emp');
     $result = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['asociados']      = $result;
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
     $data['list_cap']   = $this->modelogeneral->listar_data_cap(); 
    
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/carp_presentacion",$data);
     $this->load->view("layout/footer");  
    }


      public function cartera_clientes()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp                 = $this->session->userdata('id_emp');
     $data['productos']      = $this->modelogeneral->seleccion_productos();
     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/cartera_clientes",$data);
     $this->load->view("layout/footer");  
    }
  /*-------------------------*/
    public function almacen()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp                 = $this->session->userdata('id_emp');
     $data['productos']      = $this->modelogeneral->listar_productos();
     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/almacen",$data);
     $this->load->view("layout/footer");  
    }

    

    function load_dataAlmacen()
    {
       if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 
        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->listar_datosAlmacen($id_emp);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                         <td>'.$row->nombre_prod.'</td>
                         <td>'.$row->sku.'</td>
                         <td><input type="text" name="exitencia[]" id="exitencia_'.$row->id_almacen.'" value="'.$row->existencia.'" required>
                         <i id="capa_stock'.$row->id_almacen.'"></i></td>
                         <td>
                              <button type="button" data="'.$row->id_almacen.'" class="btn btn-danger btn-outline btn-circle  m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button>
                              </td>
                            
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

       public function eliminar_prodAlm()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_prodAlm($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }


      public function updateTable()
    {

        $id_emp      = $this->session->userdata('id_emp');
        $id_producto = $_GET['id_producto'];
        $valor       = $_GET['valor'];

        $param = array('id_almacen' => $id_producto,'existencia' => $valor, 'id_emp'=> $id_emp);
        $result =  $this->modelogeneral->update_tablaAlmacen($param);

      $msg['success'] = false;
       if($result){
        $msg['success'] = true;
      }
      echo json_encode($msg);

      
  }
    /*-------------------------------*/
    public function ventas()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp                 = $this->session->userdata('id_emp');
     $data['categorias']     = $this->modelogeneral->selec_categorias_prod();
     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/ventas",$data);
     $this->load->view("layout/footer");  
    }

    public function vencimientos()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

     $id_emp              = $this->session->userdata('id_emp');
     $data['categorias']  = $this->modelogeneral->selec_categorias_prod();

     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/vencimientos",$data);
     $this->load->view("layout/footer");  
    }

    

    
    public function productos_almacen()
    {
       if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
           redirect(base_url() . 'login');
       }
       
        $data['id_categoria']  = $this->input->post('id');
        $data['id_emp']      = $this->session->userdata('id_emp');
        $resultado = $this->modelogeneral->productos_almacen($data);
        $mostarprod ="";
        if(!empty($resultado))
        {
            $mostarprod .='<option value="">Seleccione</option>';
            foreach($resultado as $row):
              $mostarprod .='<option value="'.$row->id_producto.'*'.$row->existencia.'">'.$row->nombre_prod.'</option>';
            endforeach ; 
        }else{
           $mostarprod .='<option value=""> No hay stock para esta categor&iacute;a </option>'; 
        } 
        echo $mostarprod;
    }

    /*-------------------------------*/
 
    public function datos_cliente()
    {
       if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
           redirect(base_url() . 'login');
       }
        $id_cliente = $this->input->get('id');
        $resultado = $this->modelogeneral->datos_cliente($id_cliente);
        echo json_encode($resultado);
    }


    public function historial_cliente($id_cliente)
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['provincias']     = $this->modelogeneral->select_provincias();  
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
     $data['datos_cliente']  = $this->modelogeneral->datos_cliente($id_cliente);  
     
 
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/ficha_cliente",$data);
     $this->load->view("layout/footer");  
    }

    function load_dataClientes()
    {
       $id_emp                 = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->listar_clientes($id_emp);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                         <td>'.$row->dni.'</td>
                         <td>'.$row->nombre_cliente.' '.$row->apellidos.' </td>
                         <td>'.$row->telefono.'</td>
                         <td>'.$row->celular.'</td>
                         <td>'.$row->email.'</td>
                         <td>
                         <button type="button" data="'.$row->id_cliente.'" class="btn btn-info btn-outline btn-circle btn-sm hist-cliente" title="Historial de compra"><i class="fa fa-history"></i></button>
                          </td>
                         <td> 
                           <button type="button" data="'.$row->id_cliente.'" class="btn btn-danger btn-outline btn-circle btn-sm  deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button></td>
                          </td>
                         </tr>'; 
            }
        }
    
        echo $output;
    }

    function load_dataClientesVentas()
    {
        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->listar_clientes($id_emp);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                             <td>
                             <button type="button" data="'.$row->id_cliente.'" class="btn btn-success btn-outline btn-circle btn-sm btn-check"><i class="fa  fa-check"></i></button>
                              </td>   
                             <td>'.$row->dni.'</td>
                             <td>'.$row->nombre_cliente.' '.$row->apellidos.' </td>
                             <td>'.$row->telefono.'</td>
                             <td>'.$row->celular.'</td>
                             <td>'.$row->email.'</td>
                          </tr>';                                        
            }
        }
    
        echo $output;
    }

      function load_data_vencimientos()
    {
        $fecha_vencimiento = date('Y-m-d');
        $id_respuesto_hijo  = 2; 
        $respuestos_v = array('id_respuesto_hijo' =>$id_respuesto_hijo ,'fecha_vencimiento' => $fecha_vencimiento  );

        $result = $this->modelogeneral->buscarProdVencidos($respuestos_v);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                          <td>'.$row->nombre_prod.'</td>
                          <td>'.$row->fecha_vencimiento.' </td>
                          <td> </td>
                          <td><input type="text" name="" value="" id=""> </td>
                          <td><input type="text" name="" value="" id=""> </td>
                          <td></td>
                          <td><button type="button" data="" class="btn btn-success btn-outline btn-circle btn-sm btn-check"><i class="fa  fa-check"></i></button> </td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

    function vencimientosRepuestosCli()
    {
        $id_cliente = $this->input->post('id');
        $result = $this->modelogeneral->repustosVencidos_cliente($id_cliente);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
             {
               

              $output .= '<tr>
                          <td>'.$row->nombre_prod.'</td>
                          <td>'.$row->fecha_solicitud.'</td>
                          <td>'.$row->vencimiento.'</td>
                          <td>'.$row->fecha_vencimiento.'</td>
                          <td><span class="label label-warning">Vencido</span></td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }



     function lista_vencimientos()
    {
        $fecha_vencimiento = date('Y-m-d');
        $id_respuesto_hijo  = 2; 
        $respuestos_v = array('id_respuesto_hijo' =>$id_respuesto_hijo ,'fecha_vencimiento' => $fecha_vencimiento  );

        $result = $this->modelogeneral->buscarProdVencidos($respuestos_v);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                          <td>Marianela </td>
                          <td>'.$row->nombre_prod.'</td>
                          <td>'.$row->fecha_vencimiento.' </td>
                          <td><input type="text" name="" value="" id=""> </td>
                          <td><button type="button" data="" class="btn btn-success btn-outline btn-circle btn-sm btn-check"><i class="fa  fa-check"></i></button> </td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }


     function clientes_vencimiento()
    {
        
         $id_emp  = $this->session->userdata('id_emp');
        
        $result = $this->modelogeneral->clientes_vencimiento($id_emp);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $array = array('id_emp' =>$id_emp,'id_producto' => $row->id_producto);
               $existencia = $this->modelogeneral->dame_existencia($array);

               if ($existencia->existencia == 0  || $existencia == false) {
                    $stock  = '<small class="label label-danger m-r-5">no hay exitencia</small>';
                    $disabled ='disabled';
                  
               }else{
                     $stock  = '<small class="label label-success m-r-5">'.$existencia->existencia.'</small>';
                     $disabled ='';
                    }


               
                 
              $output .= ' <tr>
                          <td>'.$row->nombre_cliente.'</td>
                          <td>'.$row->nombre_prod.' </td>
                          <td>'.$stock .' </td>
                          <td style="color:red;">'.$row->fecha_vencimiento.' </td>
                          <td><button type="button" data="'.$row->id_cliente.'*'.$existencia->existencia.'*'.$row->id_producto.'" class="btn btn-success btn-outline btn-circle btn-sm btn-select-cli"  '.$disabled.' title=" Seleccione un cliente"><i class="fa fa-check"></i></button> </td>
                         </tr>';                                        
            }
            //
        }
    
        echo $output;
    }

      function Seccion_clientes_venc()
    {
        
        $id_emp      = $this->session->userdata('id_emp');
        $id_cliente  = $this->input->post('id'); 
        $id_producto = $this->input->post('id_producto');  
          
        $data = array('id_producto' => $id_producto,'id_cliente' => $id_cliente);
        $result = $this->modelogeneral->Seccion_clientes_venc($data);

        $output = '';
        if(!empty($result))
        {

          foreach($result as $row)
            {

               $array = array('id_emp' =>$id_emp,'id_producto' => $row->id_producto);
               $existencia = $this->modelogeneral->dame_existencia($array);
               if ($existencia == false)  {
                              $existencia = 0;    
                              }else{
                                $existencia =  $existencia->existencia;
                              }               
               
               $output .= '<input type="hidden" id="existencia_prod" value="'.$existencia.'">';
               $output .= '<tr class="resingao'.$row->id_prod_vencimiento.'">
                          <td>'.$row->nombre_cliente.' </td> 
                          <td>'.$row->nombre_prod.' </td>
                          <td>'.$row->fecha_vencimiento.' </td>
                          <td><input type="number" name="resp_cantidades[]" value="" class="resp_cantidades" required data-parsley-minlength="1"> </td>
                          <td><input type="number" name="resp_precios[]" value=""  class="resp_precios" required data-parsley-minlength="1"> </td>
                          <td><input type="hidden" name="resp_importes[]" value=" "><p></p></td>

                          <td><input type="hidden" name="reposicion" value="1" id=""><button type="button" data="'.$row->id_prod_vencimiento.'*'.$row->id_producto.'*'.$row->nombre_prod.'*'.$existencia.'*'.$row->id_cliente.'" title="Agregar a la venta"  class="btn btn-info btn-outline btn-circle btn-sm btn-add-car"><i class="fa  fa-plus"></i></button> </td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

    

     function lista_vencimientoSugeridos()
    {
        $fecha_vencimiento = date('Y-m-d');
        $respuestos_v = array('fecha_vencimiento' => $fecha_vencimiento );

        $result = $this->modelogeneral->buscarRespuestosVencidos($respuestos_v);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                          <td>Marianela </td>
                          <td>'.$row->nombre_prod.'</td>
                          <td>'.$row->fecha_vencimiento.' </td>
                          <td><input type="text" name="" value="" id=""> </td>
                          <td><button type="button" data="" class="btn btn-success btn-outline btn-circle btn-sm btn-check"><i class="fa  fa-check"></i></button> </td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

     //venta de reposiciones 

     public function add_reposicion()
    {
         if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

        $param['id_emp']            = $this->session->userdata('id_emp');

        // productos en resposicion
         $param['rep_productos']   = $this->input->post('rep_productos');
        
         $param['rep_idproductos'] = $this->input->post('rep_idproductos');
         $param['rep_cantidades']  = $this->input->post('rep_cantidades');
         $param['rep_precios']     = $this->input->post('rep_precios');
         $param['rep_importes']    = $this->input->post('rep_importes');

         //nuevos pedidos
         $data['productos']       = $this->input->post('productos');
         $data['cantidad']        = $this->input->post('cantidades');
         $data['precios']         = $this->input->post('precios');
         $data['importe']         = $this->input->post('importes');
         $data['id_cliente']      = $this->input->post('id_cliente');

         //logica productos en resposicion
         $this->save_detalleReposicion($param);
         //guardo el pedido
         $data_pedidos['id_emp']          = $this->session->userdata('id_emp');
         $data_pedidos['id_cliente']      = $this->input->post('id_cliente');
         $data_pedidos['no_pedido']       =  $this->modelogeneral->getComprobante($this->session->userdata('id_emp'));
         $data_pedidos['fecha_solicitud'] =  date('Y-m-d');
         $data_pedidos['total']           = $this->input->post('total');

         if($this->modelogeneral->save_Pedido($data_pedidos)){

                 $data['id_pedidos']   =  $this->modelogeneral->lastID();                  

                 $repo_detalle = array('productos' => $param['rep_idproductos'],
                                       'cantidad'  => $param['rep_cantidades'],
                                       'precios'   => $param['rep_precios'],
                                       'importe'   => $param['rep_importes'],
                                       'id_emp'    => $param['id_emp']);
                 
                 $repo_detalle['id_pedidos']  =  $data['id_pedidos'];
                 $repo_detalle['id_cliente']  =  $this->input->post('id_cliente');

                 //guardar_detalle_pedido
                 $this->save_detallePedidoConfirmado($data);
                 $this->save_detallePedidoConfirmado($repo_detalle);               
                 $msg['comprobador'] = TRUE;
               } 
         

        echo json_encode($msg);        
        
    }

    protected function save_detalleReposicion($param){ 
    for ($i=0; $i < count($param['rep_productos']); $i++){ 
          
          $dato_repo = array(
              'id_prod_vencimiento'   => $param['rep_productos'][$i]

          );

          $data = $this->modelogeneral->actualizar_vencimientos($dato_repo);
          
          $rep_cantidades  = $param['rep_cantidades'][$i];
          $meses = $data->vencimiento * $rep_cantidades;
          $fecha_inicial = $data->fecha_vencimiento;
          $fecha_final = date("Y-m-d", strtotime("$fecha_inicial + $meses month"));

          $dato_repo['fecha_vencimiento'] = $fecha_final;
          $this->modelogeneral->update_venc($dato_repo);
        }
    }


    public function add_pedido()
    {
         if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

        $param['id_emp']            = $this->session->userdata('id_emp');
        $param['nombre_cliente']    = $this->input->post('nombre_cliente');
        $param['apellidos']         = $this->input->post('apellidos');
        $param['dni']               = $this->input->post('dni');
        $param['telefono']          = $this->input->post('telefono');
        $param['email']             = $this->input->post('email');
        $param['celular']           = $this->input->post('celular');
        $param['direccion']         = $this->input->post('direccion');
        $param['fecha_nacimiento']  = $this->input->post('fecha_nacimiento');
       //$param['fecha_incio']       =  date('Y-m-d'); 
        $param['id_municipio']      = $this->input->post('id_municipio');
        $param['id_provincia']      = $this->input->post('id_provincia');
        $datos_emp                  = $this->modelogeneral->datos_emp($param['id_emp']);
        $param['id_pais']           = $datos_emp->id_pais;
       
        
        $exite_dni   = $this->modelogeneral->check_cliente('dni',$param['dni']);
        $exite_email = $this->modelogeneral->check_cliente('email',$param['email']);
        $msg['comprobador'] = false;    
       
        if ($exite_dni == true || $exite_email==true){
            if ($exite_dni) {
                $id_cliente = $this->modelogeneral->buscar_dnicli($param['dni']);
                $data['id_cliente'] = $id_cliente->id_cliente;  
            } else {
                $id_cliente = $this->modelogeneral->buscar_emailcli($param['email']); 
                $data['id_cliente'] = $id_cliente->id_cliente;
            }
        } else {

               $this->modelogeneral->insert_cliente($param);
               $data['id_cliente']     =  $this->modelogeneral->lastID();
               
              }

               $data['id_emp']          = $this->session->userdata('id_emp');
               $data['no_pedido']       =  $this->modelogeneral->getComprobante($this->session->userdata('id_emp'));
               $data['fecha_solicitud'] =  date('Y-m-d');
               $data['total']           = $this->input->post('total');
              
               if($this->modelogeneral->save_Pedido($data)){


                 $data['id_pedidos']      =  $this->modelogeneral->lastID();
                 $data['productos']       = $this->input->post('productos');
                 $data['cantidad']        = $this->input->post('cantidades');
                 $data['precios']         = $this->input->post('precios');
                 $data['importe']         = $this->input->post('importes');

                 $test = array();
                 $test = $this->save_detallePedidoConfirmado($data);
                 
               
                 $msg['comprobador'] = TRUE;
               }      
            

        echo json_encode($data['id_pedidos']);
    }



     public function edit_pedido()
    {
     
        $param['id_emp']            = $this->session->userdata('id_emp');
        $param['id_cliente']        = $this->input->post('id_cliente');
        $param['nombre_cliente']    = $this->input->post('nombre_cliente');
        $param['apellidos']         = $this->input->post('apellidos');
        $param['dni']               = $this->input->post('dni');
        $param['telefono']          = $this->input->post('telefono');
        $param['email']             = $this->input->post('email');
        $param['celular']           = $this->input->post('celular');
        $param['direccion']         = $this->input->post('direccion');
        $param['fecha_nacimiento']  = $this->input->post('fecha_nacimiento');
        $param['id_municipio']      = $this->input->post('id_municipio');
        $param['id_provincia']      = $this->input->post('id_provincia');

        // actualizo los datos del cliente
        $this->modelogeneral->update_datosCliente($param);
        

        $param['id_pedido_edit']    = $this->input->post('id_pedido_edit');
        $param['fecha_inicio']     = $this->input->post('fecha_inicio');
        $param['productos']        = $this->input->post('productos');
        $param['cantidad']         = $this->input->post('cantidad');
        $param['precios']          = $this->input->post('precios');
        $param['importes']         = $this->input->post('importes');
        $param['total']            = $this->input->post('total');        
        
        //actualizo el pedido.
        $updatePed = array('id_pedidos'       => $param['id_pedido_edit'],
                           'id_cliente'       => $param['id_cliente'],
                           'id_emp'           => $param['id_emp'],
                            'fecha_solicitud' => $param['fecha_inicio'],
                            'total'           => $param['total'] 
                        );
        $result_ped =  $this->modelogeneral->udpate_pedidoCli($updatePed);
         $msg['comprobador'] = false;
        if ($result_ped){
            //actualizo el detalle de pedido.
            for ($i=0; $i < count($param['productos']); $i++) { 
                $dato_pedido = array(
                                      'id_pedidos'    => $param['id_pedido_edit'],
                                      'id_producto'   => $param['productos'][$i], 
                                      'precio_pedido' => $param['precios'][$i], 
                                      'cantidad'      => $param['cantidad'][$i],
                                      'importe'       => $param['importes'][$i] 
                                    ); 
             $msg['comprobador'] =  $this->modelogeneral->udpate_detallepedidoCli($dato_pedido);
            } 
        } 
         

        echo json_encode($msg);
    }



    protected function save_detallePedidoConfirmado($data){ 
    for ($i=0; $i < count($data['productos']); $i++) { 
      
          $dato_pedido = array(
              'id_producto'   => $data['productos'][$i], 
              'id_pedidos'    => $data['id_pedidos'],
              'precio_pedido' => $data['precios'][$i], 
              'cantidad'      => $data['cantidad'][$i],
              'importe'       => $data['importe'][$i] 
          );  

         $test = array();
         // $test['total'] =  count($data['productos']); 
             
            
            //$dato['id_emp'] = $this->session->userdata('id_emp');
            //$this->modelogeneral->resto_almacen($dato);
            
            //pregunto si el producto es repuesto no
            $infoProducto =  $this->modelogeneral->datos_productos($data['productos'][$i]);

            if ($infoProducto->es_repuesto == 1) {
                 
                 $test[$i] =  "es producto"; 
                 // buscamos los respuestos dado el producto
                 $result =  $this->modelogeneral->datos_respuestoPadre($data['productos'][$i]);

                 $arrayVencimientos = [];

                 //inserto en la tabla producto_vencimiento el vencimiento de cada respuesto
                 $rep_cantidades  = $data['cantidad'][$i];
                 $infoRespuesto =  $this->modelogeneral->datos_productos($result->id_respuesto_hijo);                     
                 $meses =  $infoRespuesto->vencimiento * $rep_cantidades;
                 $fecha_actual =  date('Y-m-d');
                 $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));                     
                 $venc_resp = array('fecha_vencimiento' => $fecha_final,
                                   'id_cliente' => $data['id_cliente'] ,
                                   'id_respuesto' => $result->id_respuesto_hijo);
                 $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                 $id_prod_vencimiento  =  $this->modelogeneral->lastID();
                 
                 //$arrayVencimientos[] = $id_prod_vencimiento;
                
                 /*foreach ($result as $key):
                    //inserto en la tabla producto_vencimiento el vencimiento de cada respuesto
                         $rep_cantidades  = $data['cantidad'][$i];
                         $infoRespuesto =  $this->modelogeneral->datos_productos($key->id_respuesto_hijo);                     
                         $meses =  $infoRespuesto->vencimiento * $rep_cantidades;
                         $fecha_actual =  date('Y-m-d');
                         $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));                     
                         $venc_resp = array('fecha_vencimiento' => $fecha_final,
                                           'id_cliente' => $data['id_cliente'] ,
                                           'id_respuesto' => $key->id_respuesto_hijo);
                         $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                         $id_prod_vencimiento  =  $this->modelogeneral->lastID();
                         $arrayVencimientos[] = $id_prod_vencimiento;
                  endforeach;*/

                     //inserto el respuesto del producto comprado
                     $prod_cliente = array('fecha_compra' => date('Y-m-d'),
                                           'id_producto'   => $data['productos'][$i],
                                           'id_cliente'    =>  $data['id_cliente']);
                     $this->modelogeneral->insert_prod_cliente($prod_cliente);
                     $id_prod_cli  =  $this->modelogeneral->lastID();
                     
                     //Guardo el registro de producto con repuesto del cliente
                     $prod_cli_venc = array('id_prod_vencimiento' => $id_prod_vencimiento,
                                            'id_prod_cli'         => $id_prod_cli);
                     $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);

                     /*for ($i=0; $i < count($arrayVencimientos) ; $i++) { 
                        $prod_cli_venc = array('id_prod_vencimiento' => $arrayVencimientos[$i],
                                               'id_prod_cli'         => $id_prod_cli);
                        $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);                      
                     }*/
                            
             } else {
                       //caso 1
                        $verif_resp =  $this->modelogeneral->verificador_vencimiento($data['id_cliente'],$data['productos'][$i]);
                        if ($verif_resp != NULL) {
                            $rep_cantidades  = $data['cantidad'][$i]; 
                            $dato_venc = $this->modelogeneral->buscar_prod($data['productos'][$i]);
                            $meses = $dato_venc->vencimiento * $rep_cantidades;
                            $fecha_actual =  $verif_resp->fecha_vencimiento;
                            $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month")); 

                            $datos_actvenc =  array('id_cliente' => $data['id_cliente'] ,
                                                   'id_producto' => $data['productos'][$i],
                                                    'fecha_vencimiento' =>$fecha_final);
                            $this->modelogeneral->updateverfi_vencimiento($datos_actvenc);                
                        } else {
                            $prod_padre =  $this->modelogeneral->datos_respuestoHijo($data['productos'][$i]);

                            $id_producto = $prod_padre->id_producto;

                            $prod_cliente = array('fecha_compra'   => date('Y-m-d'),
                                                   'id_producto'   => $id_producto,
                                                   'id_cliente'    =>  $data['id_cliente']);

                            $this->modelogeneral->insert_prod_cliente($prod_cliente);
                            $id_prod_cli  =  $this->modelogeneral->lastID();


                            $dato_venc = $this->modelogeneral->buscar_prod($data['productos'][$i]);
                            $rep_cantidades  = $data['cantidad'][$i];
                            $meses = $dato_venc->vencimiento * $rep_cantidades;
                            $fecha_actual =  date('Y-m-d');
                            $fecha_final = date("Y-m-d", strtotime("$fecha_actual + $meses month"));
                            $venc_resp = array('fecha_vencimiento' => $fecha_final,
                                                'id_cliente' => $data['id_cliente'] ,
                                                'id_respuesto' => $data['productos'][$i]);
                            $this->modelogeneral->insertverfi_vencimiento($venc_resp);
                            $id_prod_vencimiento  =  $this->modelogeneral->lastID();

                            $prod_cli_venc = array('id_prod_vencimiento' => $id_prod_vencimiento,
                                                    'id_prod_cli'         => $id_prod_cli);
                            $this->modelogeneral->insert_prod_cli_venc($prod_cli_venc);
                           
                        }                
                    }

        $this->modelogeneral->save_detallePedido($dato_pedido);            
    }
   return $test;
}

      function load_historialCompra()
    {
         $id_cliente         = $this->input->post('id');
        $result = $this->modelogeneral->listado_pedidos($id_cliente);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $productos = $this->modelogeneral->listado_pedidosProd($row->id_pedidos);  
              $output .= ' <tr>
                         <td>'.$row->no_pedido.'</td>';
                         $output .= '<td>';
                         foreach($productos as $prod):
                          $output .= '<span class="text-muted">'.$prod->nombre_prod.'</br></span>';
                          endforeach ; 
                         $output .= '</td>
                         <td>'.$row->total.'</td>
                         <td>'.$row->fecha_solicitud.'</td>
                         <td>'.$row->fecha_solicitud.'</td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

      function listado_DetallepedidosCli()
    {
        $id_cliente         = $this->input->post('id');
        $result = $this->modelogeneral->listado_DetallepedidosCli($id_cliente);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {

             $meses =  $row->vencimiento * $row->cantidad;
             $fecha_actual =  $row->fecha_solicitud;
             $fecha_final  = date("d/m/Y", strtotime("$fecha_actual + $meses month")); 
             $fecha_sol    = date("d/m/Y", strtotime("$row->fecha_solicitud"));
                
              $output .= '<tr>
                          <td>'.$row->no_pedido.'</td>
                          <td>'.$row->nombre_prod.'</td>
                          <td>'.$row->cantidad.'</td>
                          <td>'.$row->total.'</td>
                          <td>'.$fecha_sol.'</td>
                          <td>'.$fecha_final.'</td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

   function select_municipio()
    {
        $id_provincia = $this->input->get("id");
        $result = $this->modelogeneral->select_municipio($id_provincia);
        $output = '';
        if(!empty($result))
        {  
          foreach($result as $row)
            {
             $output .= '<option value="'.$row->id_municipio.'">'.$row->nombre.'</option>';
            }
        }
    
        echo $output;
    }

    function select_municipiolistado()
    {
        $id_provincia = $this->input->get("id");
        $result = $this->modelogeneral->select_municipionombre($id_provincia);
      echo  json_encode($result);
    }

    function armar_municipio()
    {
        $id = $this->input->get("id");
        $row = $this->modelogeneral->get_nombreMuni($id);
      echo  json_encode($row);
    }

    function armar_prov()
    {
        $id = $this->input->get("id");
        $row = $this->modelogeneral->get_nombreProv($id);
      echo  json_encode($row);
    }

    public function insert_cliente()
    {
         if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        } 

        $param['id_emp']            = $this->session->userdata('id_emp');
        $param['nombre_cliente']    = $this->input->post('nombre_cliente');
        $param['apellidos']         = $this->input->post('apellidos');
        $param['dni']               = $this->input->post('dni');
        $param['telefono']          = $this->input->post('telefono');
        $param['email']             = $this->input->post('email');
        $param['celular']           = $this->input->post('celular');
        $param['direccion']         = $this->input->post('direccion');
        $param['fecha_nacimiento']  = $this->input->post('fecha_nacimiento');
        //$param['fecha_incio']       = $this->input->post('fecha_incio');
        $param['id_municipio']      = $this->input->post('id_municipio');
        $param['id_provincia']      = $this->input->post('id_provincia');
        $datos_emp                  = $this->modelogeneral->datos_emp($param['id_emp']);
        $param['id_pais']           = $datos_emp->id_pais;
      
        $result = $this->modelogeneral->insert_cliente($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $data['id_cliente']      =  $this->modelogeneral->lastID();
               $data['id_emp']          = $this->session->userdata('id_emp');
			   $year                   = date('Y');
               $no_compra              = $this->modelogeneral->N_orden_compra($year);	
               $data['no_pedido']       = 'ext-'.$no_compra;
               $data['fecha_solicitud'] = $this->input->post('fecha_incio');
              
               if($this->modelogeneral->save_Pedido($data)){

                 $data['id_pedidos'] =  $this->modelogeneral->lastID();
                 $data['productos']  = $this->input->post('productos');
                 $data['cantidad']   = $this->input->post('cantidades');
                 $this->save_detallePedido($data);
               } 
              $msg['comprobador'] = TRUE;
             }
        echo json_encode($data);
    }





public function update_datosCliente()
    {
        $param['id_cliente']        = $this->input->post('id_cliente');
        $param['nombre_cliente']    = $this->input->post('nombre_cliente');
        $param['apellidos']         = $this->input->post('apellidos');
        $param['dni']               = $this->input->post('dni');
        $param['telefono']          = $this->input->post('telefono');
        $param['email']             = $this->input->post('email');
        $param['celular']           = $this->input->post('celular');
        $param['direccion']         = $this->input->post('direccion');
        $param['fecha_nacimiento']  = $this->input->post('fecha_nacimiento');
        //$param['fecha_incio']       = $this->input->post('fecha_incio');
        $param['id_municipio']      = $this->input->post('id_municipio');
        $param['id_provincia']      = $this->input->post('id_provincia');

        
        $result   = $this->modelogeneral->update_datosCliente($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador']  = TRUE;
               
             }
        echo json_encode($param);
    }

   
     public function cron_fin_Mes()
    {
        
     $id_emp                 = $this->session->userdata('id_emp'); 
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['sumatoriaComp']  = $this->modelogeneral->sumatoriaCompraEmp($id_emp);
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);

     if ($data['datos_emp']->id_cap != $data['ultimo_reg']->id_cap)
      {
        $data['list_cap']   = $this->modelogeneral->listar_data_cap(); 
        $this->load->view("emprendedor/capacitacion_videos",$data);
      }else {
             $this->load->view("layout/page_content");
            }
       $this->load->view("layout/footer");  
    }

    public function view_formEval(){

        $id_cap = $this->input->post("id");
        $data = array(
            "id_cap"  =>$id_cap,
            "preguntas" => $this->modelogeneral->pregunta_cap($id_cap)
            
        );
        $this->load->view("emprendedor/formulario_evaluacion",$data);
    }


   /* Insertar Evaluacion*/
    public function update_evalcap()
    {
        $param['id_emp']           = $this->session->userdata('id_emp');
        $param['id_cap']           = $this->input->post('id_cap');// video en el que estoy evaluando
        $param['evaluacion_video'] = $this->input->post('evaluacion');
        
        $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
      
        $result   = $this->modelogeneral->udpate_evalcap($param);
        $msg['comprobador'] = false;
        $id_cap = $param['id_cap']+ 1;
        if($result)
             {
               $msg['comprobador']  = TRUE;
               $datos_upd['id_emp'] = $this->session->userdata('id_emp');
               $datos_upd['id_cap'] = $id_cap;
               $msg['updatemp'] = $this->modelogeneral->udpate_emp($datos_upd);
             }
        echo json_encode($param);
    }  

     

    public function checkout()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp'); 
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']     = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);          
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/checkout");
     $this->load->view("layout/footer");  

    }


    function reporte_asoc()
    {
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->mostrar_asoc($id_emp);
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
                $output .= '<tr>
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
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

                             $output .= '<td> <div class="col-md-12">
                                                <div class="form-group has-'.$msg.'">
                                                    <input  type="text" id="" readonly class="form-control" value=" $'.$S_ConsumoMensual->total_comp.'"></div>
                                                </div></td></tr>';

                      
                
            }
        }
    
        echo $output;
    }

    public function mi_red()
    {
     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['asociados']      = $this->modelogeneral->mostrar_asoc($id_emp);
     $data['asociados_inv']      = $this->modelogeneral->mostrar_asocInvitados($id_emp);
     

     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
    
    $this->load->view("layout/header",$data);
    $this->load->view("layout/side_menu",$data);
    $this->load->view("emprendedor/red",$data);
    $this->load->view("layout/footer");  

    }


    

    public function load_lista_inv(){

           if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
           } 
           $output = "";  
           $id_emp        = $this->session->userdata('id_emp');
           $asociados_inv = $this->modelogeneral->mostrar_asocInvitados($id_emp);
            if (!empty($asociados_inv)):
                foreach ($asociados_inv as $key):  

                   $output.= '<tr>
                                 <td>
                                   <a href="javascript:void(0)"><span> '.$key->email.'</a>
                                 </td>

                                 <td>
                                   <span class="text-warning">Invitacion enviada</span>
                                 </td>

                                 <td>
                                 <button class="btn btn-danger delet-inv  btn-circle btn-sm" type="button" data="'.$key->id_emp.'" ><i class="fa fa-times"></i></button>
                                 </td>
                            </tr>';
                endforeach;
           endif; 
       echo  $output ;          

    }

   

    public function carrito()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);

     $data['result_prod']   = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['result_combo']  = $this->modelogeneral->mostrar_carrito_combo($id_emp);
     

     $data['result'] = array($data['result_prod'],$data['result_combo'] );
     
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion"); 
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);         
    
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/carrito",$data);
     $this->load->view("layout/footer");  

    }


   /* public function load_carrito()
    {
     $id_emp                = $this->session->userdata('id_emp');
     $data['result_prod']   = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['result_combo']  = $this->modelogeneral->mostrar_carrito_combo($id_emp);
     $result = array($data['result_prod'],$data['result_combo'] );
     $output ='';
     $output .='<form  id="finalizar_compra1" action="<?php echo base_url() ?>capacitacion/validar_carrito"  method="post">';  
               if($result[0] == false && $result[1] == false){
                                       
                  $output .=' <tr>
                                <div class="alert alert-warning"> NO HAY PRODUCTOS EN EL CARRITO</div>
                             </tr>'; 
                                       
                 }else{
                        if(!empty($result)){
                        foreach ($result as $key => $value):
                          if($value){                                     
                            for ($i=0; $i <count($value) ; $i++):                                    
                                    $output .='<tr>
                                                 <td class="text-center"> <input type="hidden" name="idproductos[]" value="<?= $value[$i]->id_producto ?>"></td>
                                                <td class="text-center">
                                                 <a class= "btn-remove-producto" data-toggle="tooltip" data="<?= $value[$i]->id_car ?>" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a></td>
                                                <td>
                                                <img src="'.base_url().'assets/uploads/img_productos/'.$value[$i]->url_imagen.'" alt="user" class="img-circle" />'.$value[$i]->nombre_prod.'</td>
                                                <td class="text-center">'.$value[$i]->precio_car.'<input type="hidden" name="precios[]" value="'.$value[$i]->precio_car.'">
                                                        <input type="hidden" name="es_combo[]" value="'.$value[$i]->es_combo.'">
                                                </td>
                                                <td class="text-right">
                                                    <div class="row">
                                                    <div class="form-group">
                                                            <div class="col-sm-6 col-md-offset-3">
                                                              <input type="number" name="cantidades[]" class="form-control input-sm" 
                                                                value="'.$value[$i]->cantidad.'">
                                                            </div>
                                                        </div>
                                                    </div>    
                                                </td>
                                                <td class="text-right"> <input type="hidden" name="importes[]" value="'.$value[$i]->importe.'"><p>'.$value[$i]->importe.'</p></td>
                                            </tr>';
                            endfor;
                                              }
                        endforeach;                               
                                            }else{ 
                                             $output .='<tr>
                                                <div class="alert alert-warning"> NO HAY PRODUCTOS EN EL CARRITO</div>';
                                                 } 
                        }
                            $output .='</tr>';



     echo  $output;

    }*/

    public function comprar($id_compra)
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion"); 


     $data['detalle']        = $this->modelogeneral->getDetalleCompra($id_compra);
     $data['compra']         = $this->modelogeneral->getdatosCompra($id_compra);
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);    

     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/compra_completada",$data);
     $this->load->view("layout/footer");  

    }

     public function invitacion_asoc()
    {
        $id_emp                = $this->session->userdata('id_emp');
        $param['foto_emp']     = 'no_img.jpg';
        $param['email']        = $this->input->post('email');
        $param['fecha_insc']   = date('Y-m-d');
        $datos_emp             =  $this->modelogeneral->getdatos_emp($id_emp);
        $param['admin_cabeza'] = $datos_emp->admin_cabeza;

        $resultado = $this->modelogeneral->insert_emp($param);

        if ($resultado == "existe"){
            $msg['comprobador'] = "existe";  
        }else{
             
                 $data['id_hijo']  = $resultado;
                 $data['id_padre'] = $this->session->userdata('id_emp');
                 $result           = $this->modelogeneral->insert_emp_asoc($data);
                 $nombre           = $this->session->userdata('nombre');
                 $dato  = array('emp_padre' => $nombre,'id_hijo' => $data['id_hijo']);
                 $this->sendMailGmail($param['email'],$dato);
                 $msg['comprobador'] = false;
                if($result)
                 {
                   $msg['comprobador'] = true;
                 }
            }

            echo json_encode($msg);
    }

    public function sendMailGmail($email_destino,$dato)
    {   
      //cargamos la libreria email de ci
      $this->load->library("email");
   
      //configuracion para gmail
      $configGmail = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'consultas@dvigi.com.ar',
        'smtp_pass' => 'Amorpleno2018',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
      );   

      $cuerpo_mensaje = $this->load->view("layout/invitacion_nuevoPatrocinado",$dato,true); 
   
      //cargamos la configuración para enviar con gmail
      $this->email->initialize($configGmail);
   
      $this->email->from('consultas@dvigi.com.ar <consultas@dvigi.com.ar>', 'Emprendedores Dvigi');
      $this->email->to("$email_destino");
      $this->email->subject('Emprendedores Dvigi');
      $this->email->message($cuerpo_mensaje);
      $this->email->send();
      //con esto podemos ver el resultado
      //var_dump($this->email->print_debugger());
    }


     public function sendMailGmailCompraPendiente($id_compra)
    {  
      $data['id_compra']    = $id_compra;
	  $id_emp               = $this->session->userdata('id_emp'); 
      $data['datos_hijo']   = $this->modelogeneral->datos_emp($id_emp);
      $data['datos_padre']  = $this->modelogeneral->datos_emp($data['datos_hijo']->admin_cabeza);
     
      $data['detalle']    = $this->modelogeneral->getDetalleCompra_mail($id_compra);
      $data['compra']     = $this->modelogeneral->getdatosCompra($id_compra);
      //$email_destino      = "dalenag87@gmail.com"; 

      $email_destino      = $data['datos_padre']->email; 
      $cuerpo_mensaje = $this->load->view("emprendedor/solicitud_compra",$data,true);
      //cargamos la libreria email de ci
      $this->load->library("email");
      //configuracion para gmail
      $configGmail = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'consultas@dvigi.com.ar',
        'smtp_pass' => 'Amorpleno2018',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n",
		'wordwrap'=> TRUE,
      );    
   
      //cargamos la configuración para enviar con gmail
      $this->email->initialize($configGmail);
   
      $this->email->from('consultas@dvigi.com.ar <consultas@dvigi.com.ar>', 'Emprendedores Dvigi');
      $this->email->to("$email_destino");
      $this->email->subject('Nueva Solicitud de Compra');
      $this->email->message($cuerpo_mensaje);
      $this->email->send();
      //con esto podemos ver el resultado
      //var_dump($this->email->print_debugger());

      $this->load->view("emprendedor/solicitud_compra",$data);
    }


    public function validar_carrito_ajax()
    {

      if ($this->input->is_ajax_request()) 
         {
          
          $this->form_validation->set_rules('cantidades','...', 'callback_verficar_cantidad');
          $this->form_validation->set_rules('sub_total', '...', 'callback_verficar_monto');
         
          if ($this->form_validation->run() === TRUE) 
            {
                 $medio_pago = $this->input->post("medio_pago");
                 $id_emp     = $this->session->userdata('id_emp');
                 $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
    
                 $idproductos            = $this->input->post("idproductos");
                 $cantidades             = $this->input->post("cantidades");
                 $precio_comp            = $this->input->post("precios");
                 $importes               = $this->input->post("importes");
                 $micartera              = $this->input->post("micartera");
                 $es_combo               = $this->input->post("es_combo");

                 $datos_upd['comision_acumulada'] = $micartera - $data['datos_emp']->comision_acumulada;
                 $datos_upd['id_emp']   = $id_emp;

                 $this->modelogeneral->udpate_emp($datos_upd);
                
                 $param['total_comp']         = $this->input->post("total");
                 $param['fecha_comp']         = date('Y-m-d H:i:s');
                 $param['id_emp']             = $this->session->userdata('id_emp');
                 $year                        = date('Y');
                 $param['no_compra']          = $this->modelogeneral->N_orden_compra($year);    
                 $param['medio_pago']         = "solicitud_compra";
                 $param['collection_status']  = "pending";              
                 $result = false;  
               
                if ($this->modelogeneral->save_compra($param)) {
                        $id_compra = $this->modelogeneral->lastID();
                        $this->save_detalleCompra($idproductos,$id_compra,$precio_comp,$cantidades,$importes,$es_combo);
                        $this->modelogeneral->limpiar_carrito($id_emp);
                        $this->modelogeneral->update_orden_compra($year);
                        $this->sendMailGmailCompraPendiente($id_compra);
                        //redirect(base_url() . "mis_compras"); 
                        $result = TRUE;  
                    }
                if($result){
                             $msg['comprobador'] = TRUE;
                            }
                         echo json_encode($msg);

             }else{
                   $msg['validacion'] =  validation_errors('<li>','</li>');
                   echo json_encode($msg);
                  }
       }
           
    } // carrito ajax




   public function validar_carrito(){
    
	if ($this->input->post()) 
        {
	     require_once "/home/admindvg/public_html/emprendedores/sistema/mercado-pago/lib/mercadopago.php";
	     $mp = new MP ("7648711035353831", "bOJIZgeynb1zUBjRHEs87b4oeGZz9fBe");	
        
         $this->form_validation->set_rules('cantidades','...', 'callback_verficar_cantidad');
         $this->form_validation->set_rules('sub_total', '...', 'callback_verficar_monto');
         
          if($this->form_validation->run() === TRUE) 
            {

            	$medio_pago = $this->input->post("medio_pago");
            	$id_emp     = $this->session->userdata('id_emp');
            	$data['datos_emp']         = $this->modelogeneral->datos_emp($id_emp);
                $data['descuento_cartera'] = $this->input->post("descuento_cartera");
            	if ($medio_pago == "pago_empresa")
            		{
                         $idproductos            = $this->input->post("idproductos");
		                 $cantidades             = $this->input->post("cantidades");
		                 $precio_comp            = $this->input->post("precios");
		                 $importes               = $this->input->post("importes");
		                 $micartera              = $this->input->post("micartera");
						 $es_combo               = $this->input->post("es_combo");

		                 $datos_upd['comision_acumulada'] = $micartera;
		                 $datos_upd['id_emp']             = $id_emp;

		                 $this->modelogeneral->udpate_emp($datos_upd);
		                
		                 $param['total_comp']         = $this->input->post("total");
		                 $param['fecha_comp']         = date('Y-m-d H:i:s');
		                 $param['id_emp']             = $this->session->userdata('id_emp');
		                 $year                        = date('Y');
		                 $param['no_compra']          = $this->modelogeneral->N_orden_compra($year);	
		                 $param['medio_pago']         = "pago_empresa";
		                 $param['collection_status']  = "pending";				
						
						if ($this->modelogeneral->save_compra($param)) {
								$id_compra = $this->modelogeneral->lastID();
								//$this->sendMailGmailCompraPendiente($id_compra);
                                $this->save_detalleCompra($idproductos,$id_compra,$precio_comp,$cantidades,$importes,$es_combo);
								$this->modelogeneral->limpiar_carrito($id_emp);
								$this->modelogeneral->update_orden_compra($year);
								$data['id_compra']    = $id_compra;
								$id_emp               = $this->session->userdata('id_emp'); 
								$data['datos_hijo']   = $this->modelogeneral->datos_emp($id_emp);
								$data['datos_padre']  = $this->modelogeneral->datos_emp($data['datos_hijo']->admin_cabeza);
								 
								$data['detalle']    = $this->modelogeneral->getDetalleCompra_mail($id_compra);
								$data['compra']     = $this->modelogeneral->getdatosCompra($id_compra);
								  //$email_destino      = "dalenag87@gmail.com"; 

								$email_destino      = $data['datos_padre']->email; 
								$cuerpo_mensaje = $this->load->view("emprendedor/solicitud_compra",$data,true);
								  //cargamos la libreria email de ci
								$this->load->library("email");
								  //configuracion para gmail
								$configGmail = array(
									'protocol' => 'smtp',
									'smtp_host' => 'ssl://smtp.gmail.com',
									'smtp_port' => 465,
									'smtp_user' => 'consultas@dvigi.com.ar',
									'smtp_pass' => 'Amorpleno2018',
									'mailtype' => 'html',
									'charset' => 'utf-8',
									'newline' => "\r\n",
									'wordwrap'=> TRUE,
								);    
							   
								  //cargamos la configuración para enviar con gmail
								$this->email->initialize($configGmail);
							   
								$this->email->from('consultas@dvigi.com.ar <consultas@dvigi.com.ar>', 'Emprendedores Dvigi');
								$this->email->to("$email_destino");
								$this->email->subject('Nueva Solicitud de Compra');
								$this->email->message($cuerpo_mensaje);
								$this->email->send();
                                redirect(base_url() . "mis_compras");	
							}

            	//Transferencia Bancaria	
            	} else if($medio_pago == "pago_transf")
            	        {
                         $idproductos            = $this->input->post("idproductos");
		                 $cantidades             = $this->input->post("cantidades");
		                 $precio_comp            = $this->input->post("precios");
		                 $importes               = $this->input->post("importes");
		                 $micartera              = $this->input->post("micartera");
						 $es_combo               = $this->input->post("es_combo");

		                 $datos_upd['comision_acumulada'] = $micartera;
		                 $datos_upd['id_emp']   = $id_emp;

		                 $this->modelogeneral->udpate_emp($datos_upd);
		                
		                 $param['total_comp']         = $this->input->post("total");
		                 $param['fecha_comp']         = date('Y-m-d H:i:s');
		                 $param['id_emp']             = $this->session->userdata('id_emp');
		                 $year                        = date('Y');
		                 $param['no_compra']          = $this->modelogeneral->N_orden_compra($year);	
		                 $param['medio_pago']         = "pago_transf";
		                 $param['collection_status']  = "pending";

						
						if ($this->modelogeneral->save_compra($param)) {
								$id_compra = $this->modelogeneral->lastID();
                                //$this->sendMailGmailCompraPendiente($id_compra);
								$this->save_detalleCompra($idproductos,$id_compra,$precio_comp,$cantidades,$importes,$es_combo);
								$this->modelogeneral->limpiar_carrito($id_emp);
								$this->modelogeneral->update_orden_compra($year);
								$data['id_compra']    = $id_compra;
								$id_emp               = $this->session->userdata('id_emp'); 
								$data['datos_hijo']   = $this->modelogeneral->datos_emp($id_emp);
								$data['datos_padre']  = $this->modelogeneral->datos_emp($data['datos_hijo']->admin_cabeza);
								 
								$data['detalle']    = $this->modelogeneral->getDetalleCompra_mail($id_compra);
								$data['compra']     = $this->modelogeneral->getdatosCompra($id_compra);
								  //$email_destino      = "dalenag87@gmail.com"; 

								$email_destino      = $data['datos_padre']->email; 
								$cuerpo_mensaje = $this->load->view("emprendedor/solicitud_compra",$data,true);
								  //cargamos la libreria email de ci
								$this->load->library("email");
								  //configuracion para gmail
								$configGmail = array(
									'protocol' => 'smtp',
									'smtp_host' => 'ssl://smtp.gmail.com',
									'smtp_port' => 465,
									'smtp_user' => 'consultas@dvigi.com.ar',
									'smtp_pass' => 'Amorpleno2018',
									'mailtype' => 'html',
									'charset' => 'utf-8',
									'newline' => "\r\n",
									'wordwrap'=> TRUE,
								);    
							   
								  //cargamos la configuración para enviar con gmail
								$this->email->initialize($configGmail);
							   
								$this->email->from('consultas@dvigi.com.ar <consultas@dvigi.com.ar>', 'Emprendedores Dvigi');
								$this->email->to("$email_destino");
								$this->email->subject('Nueva Solicitud de Compra');
								$this->email->message($cuerpo_mensaje);
								$this->email->send();
							    redirect(base_url() . "tienda");	
							}	

				//Mercado Pago				
            	} else {
		               
		                 $idproductos            = $this->input->post("idproductos");
		                 $cantidades             = $this->input->post("cantidades");
		                 $precio_comp            = $this->input->post("precios");
		                 $importes               = $this->input->post("importes");
		                 $micartera              = $this->input->post("micartera");
						 $es_combo               = $this->input->post("es_combo");

		                 $datos_upd['comision_acumulada'] = $micartera;
		                 $datos_upd['id_emp']   = $id_emp;

		                 $this->modelogeneral->udpate_emp($datos_upd);
		                
		                 $param['total_comp']    = $this->input->post("total");
		                 $param['fecha_comp']    = date('Y-m-d H:i:s');
		                 $param['id_emp']        = $this->session->userdata('id_emp');
		                 $year                   = date('Y');
		                 $param['no_compra']     = $this->modelogeneral->N_orden_compra($year);	
                         $param['medio_pago']    = "mercado_pago";				
						
						if ($this->modelogeneral->save_compra($param)) {
								$id_compra = $this->modelogeneral->lastID();
                                //$this->sendMailGmailCompraPendiente($id_compra);
								$items = array();
								$back_urls = array (
									"success" => base_url()."success/".$id_compra,
									"pending" => base_url()."pending/".$id_compra,
									"failure" => base_url()."failure/".$id_compra
									);
								
								for ($i=0; $i < count($idproductos); $i++) { 
								
									 $producto = $this->modelogeneral->getdatos_prod_combo($idproductos[$i], $es_combo[$i]);
								   
										$data  = array(
											'title'         => $producto->nombre_prod, 
											'quantity'      => intval($cantidades[$i]),
											'currency_id'   => "ARS",
											'unit_price'    => floatval($precio_comp[$i])
										); 
										
										$items[$i] = $data; 
								
								}				
								
								$preference_data = array (
									"items" => $items,
									"notification_url" => base_url()."recibe_pago",
									"back_urls" => $back_urls
									);			
								
								$preference = $mp->create_preference($preference_data);
								
								//$param['id_pago'] = $preference["response"]["id"];
								
								$this->save_detalleCompra($idproductos,$id_compra,$precio_comp,$cantidades,$importes, $es_combo);
								$this->modelogeneral->limpiar_carrito($id_emp);
								$this->modelogeneral->update_orden_compra($year);
		                    }
							$data['descuento_cartera'] = $this->input->post("descuento_cartera");
						     //var_dump($preference);
                            $data['id_compra']    = $id_compra;
							$id_emp               = $this->session->userdata('id_emp'); 
							$data['datos_hijo']   = $this->modelogeneral->datos_emp($id_emp);
							$data['datos_padre']  = $this->modelogeneral->datos_emp($data['datos_hijo']->admin_cabeza);
							 
							$data['detalle']    = $this->modelogeneral->getDetalleCompra_mail($id_compra);
							$data['compra']     = $this->modelogeneral->getdatosCompra($id_compra);
							  //$email_destino      = "dalenag87@gmail.com"; 

							$email_destino      = $data['datos_padre']->email; 
							$cuerpo_mensaje = $this->load->view("emprendedor/solicitud_compra",$data,true);
							  //cargamos la libreria email de ci
							$this->load->library("email");
							  //configuracion para gmail
							$configGmail = array(
								'protocol' => 'smtp',
								'smtp_host' => 'ssl://smtp.gmail.com',
								'smtp_port' => 465,
								'smtp_user' => 'consultas@dvigi.com.ar',
								'smtp_pass' => 'Amorpleno2018',
								'mailtype' => 'html',
								'charset' => 'utf-8',
								'newline' => "\r\n",
								'wordwrap'=> TRUE,
							);    
						   
							  //cargamos la configuración para enviar con gmail
							$this->email->initialize($configGmail);
						   
							$this->email->from('consultas@dvigi.com.ar <consultas@dvigi.com.ar>', 'Emprendedores Dvigi');
							$this->email->to("$email_destino");
							$this->email->subject('Nueva Solicitud de Compra');
							$this->email->message($cuerpo_mensaje);
							$this->email->send();							 
						   redirect($preference['response']['init_point']);
		                
            	       }
         
            }else{
                    $this->carrito();
                 }

        }else{
		redirect(base_url() . "tienda");
		}			
  
  } 

    public function success($id_compra)
    {
      //Cuando llega a este punto es porque el pago fue aprobado, entonces esta venta está lista para armar y despachar, se manda para el sistema original, para el sistema original hay que mandar el id de la compra del emprendedor, para poder actualizar el almancen luego.
	  //se le envia un mail a el administrador de emprendedores, informando de la nueva compra.
	  //guardar ya el producto en el almacen del emprendedor, pero con un campo que sea activo o no, este activo lo pondrá en true, el sistema original por api, al hacer el despacho.
	  /*pending
		El usuario aún no completó el proceso de pago.
		approved
		El pago fue aprobado y acreditado.
		in_process
		El pago está siendo revisado.
		in_mediation
		Los usuarios tienen iniciada una disputa.
		rejected
		El pago fue rechazado. El usuario puede intentar pagar nuevamente.
		cancelled
		El pago fue cancelado por una de las partes, o porque el tiempo expiró.
		refunded
		El pago fue devuelto al usuario.
		charged_back
		Fue hecho un contracargo en la tarjeta del pagador.*/

      $param['id_compra']          = $id_compra;  
	  $param['collection_id']      = $_GET['collection_id'];
	  $param['collection_status']  = $_GET['collection_status'];
	  $param['preference_id']      = $_GET['preference_id'];
	  $param['external_reference'] = $_GET['external_reference'];
	  $param['payment_type']       = $_GET['payment_type'];
	  $param['merchant_order_id']  = $_GET['merchant_order_id'];
     
       $this->modelogeneral->update_compra($param);
       $this->load->view("respuesta_mercado_pago/exito");
    }

    public function pending($id_compra)
    {
      //El cron cada 5 minutos va a comprobar si ya esta venta fue aprobada, en el caso true se manda al sistema original, de lo contrario no pasa nada.
	  //se le manda un mail al administrador de emprendesdores con un resumen de todas las compras pendientes.
	  $param['id_compra']          = $id_compra;  
      $param['collection_id']      = $_GET['collection_id'];
      $param['collection_status']  = $_GET['collection_status'];
      $param['preference_id']      = $_GET['preference_id'];
      $param['external_reference'] = $_GET['external_reference'];
      $param['payment_type']       = $_GET['payment_type'];
      $param['merchant_order_id']  = $_GET['merchant_order_id'];

      $this->modelogeneral->update_compra($param);

	  $this->load->view("respuesta_mercado_pago/pending");
    }
    public function failure($id_compra)
    {
      //se le manda un mail al administrador de emprendedores y al emprendedor qie ha realizado la compra de que este pago ha sido cancelado o rechazado, en el mail para el admin, deben ir todos los datos del emprendedor.
      //Solo si es null  collection_status elimino la compra
	  $param['id_compra']          = $id_compra;  
      $param['collection_id']      = $_GET['collection_id'];
      $param['collection_status']  = $_GET['collection_status'];
      $param['preference_id']      = $_GET['preference_id'];
      $param['external_reference'] = $_GET['external_reference'];
      $param['payment_type']       = $_GET['payment_type'];
      $param['merchant_order_id']  = $_GET['merchant_order_id'];

      if ($param['collection_status'] == 'null'){
           $this->modelogeneral->eliminar_compra($id_compra);

      } else {
               $this->modelogeneral->update_compra($param);
            }
 
	  $this->load->view("respuesta_mercado_pago/error");
    }
  
  


   function verficar_monto() {
    $min = $this->modelogeneral->getValorMont_min();
    if ($_POST['sub_total'] >= $min->valor){
        return true;
       }else{
        $this->form_validation->set_message('verficar_monto', 'Por Favor debe comprar un monto mayor a $ '.$min->valor.'.00');
        return false;
        }
    }

 public function verficar_cantidad($str)
        {
                if ($_POST['cantidades'] == 0)
                {
                        $this->form_validation->set_message('verficar_cantidad', 'Por Favor debe colocar una cantidad  mayor a 0');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }     
     

protected function save_detalleCompra($productos,$id_compra,$precio_comp,$cantidades,$importes,$es_combo){ 
        for ($i=0; $i < count($productos); $i++) { 
           
                $data  = array(
                    'id_producto'   => $productos[$i], 
                    'id_compra'     => $id_compra,
                    'precio_comp'   => $precio_comp[$i],
                    'cantidad_comp' => $cantidades[$i], 
                    'importe'       => $importes[$i],
					'es_combo'      => $es_combo[$i]
                );  
            //$this->updateAlmacen_clientesResta($dato_alcli);        
            $this->modelogeneral->save_detalleCompra($data);
        
        }
}  

public function mis_compras()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion"); 
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
        
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/mis_compras",$data);
     $this->load->view("layout/footer"); 
    }

public function mis_ventas()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion"); 
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
     $data['provincias']     = $this->modelogeneral->select_provincias();
     $data['productos']     = $this->modelogeneral->seleccion_productos();
        
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/lista_ventas",$data);
     $this->load->view("layout/footer"); 
    } 

    public function eliminar_prod_pedido()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_prod_pedido($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

/*LISTA DE VENTAS */
 function load_mis_Ventas()
    {
       $id_emp  = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->lista_mis_ventas($id_emp);

        
        $output = '';
        if(!empty($result))
        {

          foreach($result as $row)
            {
               
                $output .= '<tr>
                                <td><span class="">'.$row->fecha.'</span></td>
                                 <td><span class="">'.$row->no_pedido.'</span></td>
                                 <td><span class="">'.$row->total.'</span></td>
                                 <td>'.$row->nombre_cliente.'</td>';
                $output .= '<td>
                             
                            <button type="button" data="'.$row->id_pedidos.'" class=" btn btn-success btn-outline btn-circle btn-lg m-r-5 view-detalle-compra" data-toggle="modal" data-target="#detalleModal"  data-toggle="tooltip" data-original-title="Ver Detalle" title ="Ver Detalle"><i class="ti-eye"></i></button> 

                            <!--button type="button" data="'.$row->id_pedidos.'" class=" btn btn-info btn-outline btn-circle btn-lg m-r-5 edit-row-btn" data-toggle="modal" data-target="#modal-add-cap"  data-toggle="tooltip" data-original-title="Editar" title ="Editar"><i class="ti-pencil-alt"></i></button---> 

                            <button type="button" data="'.$row->id_pedidos.'" class=" btn btn-danger btn-outline btn-circle btn-lg m-r-5 elim-row-btn"  data-toggle="tooltip" data-original-title="Eliminar Venta" title ="Eliminar Venta"><i class="icon-trash"></i></button> 
                            </td>                                
                            </tr>';

            }
        }
    
        echo $output;
    }

      public function getdatos_pedido_emp()
    {
        $id_pedidos = $this->input->post('id');
        $data['result']  = $this->modelogeneral->getdatos_pedido_emp($id_pedidos);
        echo json_encode($data);
    }


      function load_dataPedido()
    {
        
        $id_pedidos = $this->input->post('id');
        $result     = $this->modelogeneral->getDetalleVenta($id_pedidos);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
            $output .= '<tr>';
            $output .= '<td><input type="hidden" name="productos[]" value="'.$row->id_producto.'">'.$row->nombre_prod.'</td>
                       <td><input type="text" name="cantidad[]" value="'.$row->cantidad.'" class="cantidad" required data-parsley-minlength="1"></td>
                       <td><input type="text" name="precios[]" value="'.$row->precio_pedido.'" class="precios" required data-parsley-minlength="1"></td>
                       <td><input type="hidden" name="importes[]" value="'.$row->importe.'"><p>'.$row->importe.'</p></td>
                       <td><button type="button" data="'.$row->id_det_ped.'" class="btn btn-danger deletecomb-row-btn"><span class="fa fa-remove"></span></button></td>';
            $output .= '</tr>';
            }
        }
    
        echo $output;
    }


 function load_misCompras()
    {
       $id_emp  = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->lista_compra($id_emp);
        
        $output = '';
        if(!empty($result))
        {

          foreach($result as $row)
            {
                $estado     = "" ;
                $medio_pago = "" ;

             switch ($row->collection_status) {
                        case 'pending':
                                $estado = '<span class="label label-warning">Pendiente</span>';
                                break;

                        
                        case 'accepted':
                                $estado = '<span class="label label-success">Exito</span>';
                                break;
                                
                        case 'approved':
                                $estado = '<span class="label label-success">Exito</span>';
                                break;
                        
                        case 'in_mediation':
                                $estado = '<span class="label label-warning">En proceso</span>';
                                break;
                        
                        case 'rejected':
                                $estado = '<span class="label label-danger">Rechazado</span>';
                                break;
                        
                        case 'cancelled':
                                $estado = '<span class="label label-danger">Cancelado</span>';
                                break;
                        
                        case 'refunded':
                                $estado = '<span class="label label-warning">Reintegrado</span>';
                                break;
                        
                        case 'charged_back':
                                $estado = '<span class="label label-warning">Cargado de vuelta</span>';
                                break;
                        }  

                switch ($row->medio_pago) {
                        case 'pago_empresa':
                                $medio_pago = '<span class="text-info"> Acordar con la empresa</span>';
                                break;
                        case 'solicitud_compra':
                                $medio_pago = '<span class="text-info"> Solicitud Compra</span>';
                                break;        
                        
                        case 'pago_transf':
                                $medio_pago = '<span class="text-primary"> Transferencia Bancaria</span>';
                                break;
                        
                        case 'mercado_pago':
                                $medio_pago = '<span class="text-success"> Mercado Pago</span>';
                                break;
                        }         

                $output .= '<tr>
                                <td><span class="">'.$row->fecha.'</span></td>
                                 <td><span class="">'.$row->no_compra.'</span></td>
                                 <td><span class="">$ '.$row->total_comp.'</span></td>
                                 <td>'.$estado.'</td>
                                 <td>'.$medio_pago.'</td>
                                 <td><button type="button" class="btn btn-info view-detalle-compra" data-toggle="modal" data-target="#detalleModal" data="'.$row->id_compra.'" class="btn-outline btn-circle btn-lg m-r-5"><i class="ti-eye"></i></button></td>
                                 
                            </tr>';
            }
        }
    
        echo $output;
    }



function load_detalleCarrito()
    {
        $id_emp               = $this->session->userdata('id_emp');
        $data['result_prod']  = $this->modelogeneral->mostrar_carrito($id_emp);
        $data['result_combo']  = $this->modelogeneral->mostrar_carrito_combo($id_emp);
        
        $result    = array($data['result_prod'],$data['result_combo'] );

        $cantidad_prod = $this->modelogeneral->count_cantProdCar($id_emp);

        $output = '';
        if(!empty($result))
        {
          $output = '<div class="drop-title">'.$cantidad_prod.' Productos</div>';
          foreach ($result as $key => $value):
              if($value){                                     
                for ($i=0; $i <count($value) ; $i++) :  
                 $output .= '<li>
                                <div class="message-center">
                                    <a>
                                        <div class="user-img"> <img src="'.base_url().'assets/uploads/img_productos/'.$value[$i]->url_imagen.'" alt="producto" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                            <h5>'.$value[$i]->nombre_prod.'</h5> <span class="mail-desc">'.$value[$i]->cantidad.' X $'. $value[$i]->precio_car.' </span> </div>
                                    </a>
                                </div>
                            </li>';
                                
                endfor;
               }   
        endforeach;

            $output .= '<li>
                          <a class="text-center" href="'.base_url().'carrito"> <strong>Ver Carrito </strong> <i class="fa fa-angle-right"></i> </a>
                            </li>';
        }
    
        echo $output;
    } 


function load_detalleVencimientos()
    {
        $id_emp        = $this->session->userdata('id_emp');
        $result        = $this->modelogeneral->show_vencimiento($id_emp);
        $cantidad_venc = $this->modelogeneral->Count_vencimiento($id_emp);
        $output = '';
        if(!empty($result))
        {


        if ($cantidad_venc == 1) {
            $output = '<div class="drop-title">'.$cantidad_venc.' Producto con vencimiento</div>';
        } else {
           $output = '<div class="drop-title">'.$cantidad_venc.' Productos con vencimiento</div>';
        }

        foreach ($result as $value):
              if($value){                                     
               
                 $output .= '<li>
                                <div class="message-center">
                                    <a>
                                        <div class="user-img"> 
                                        <img src="'.base_url().'assets/uploads/img_productos/'.$value->url_imagen.'" alt="producto" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                        <h5>'.$value->nombre_cliente.'</h5>
                                         <span class="mail-desc">'.$value->nombre_prod.'</span> <span class="time">'. $value->fecha.'</span>
                                        </div>
                                    </a>
                                </div>
                            </li>';
               
               }   
        endforeach;

            $output .= '<li>
                          <a class="text-center" href="'.base_url().'vencimientos"><strong>Recambio </strong> <i class="fa fa-angle-right"></i> </a>
                            </li>';
        }
    
        echo $output;
    }  





    

 public function mi_cartera()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp                 = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['result']         = $this->modelogeneral->mostrar_carrito($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp); 
        
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/mi_cartera",$data);
     $this->load->view("layout/footer"); 
    }


    function cantidad_prodCesta(){

        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $id_emp                 = $this->session->userdata('id_emp');
        $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp); 

      echo json_encode($data);    
    }

    function Count_vencimiento(){

        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $id_emp             = $this->session->userdata('id_emp');
        $data['cont_venc']  = $this->modelogeneral->Count_vencimiento($id_emp); 

      echo json_encode($data);    
    }


    

 function load_miCartera()
    {
       $id_emp  = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->lista_miCartera($id_emp);
        
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
             $output .= '<tr>
                         
                         <td><span class="">'.$row->fecha.'</span></td>
                         <td><span class="">'.$row->no_compra.'</span></td>
                         <td><span class="">'.$row->gasto_cartera.'</span></td>
                         <td><span class="">'.$row->saldo.'</span></td>
                        </tr>';
            }
        }
    
        echo $output;
    }  
   


     public function view_detalleCompra()
     {
        $id = $this->input->post("id");
        $data = array(
            "result" => $this->modelogeneral->getDetalleCompra($id),
            "total" => $this->modelogeneral->get_sumatoriaCompra($id)
        );
        $this->load->view("emprendedor/detalle_compra",$data);
    }

     public function view_detalleVenta(){
        $id = $this->input->post("id");
        $data = array(
            "result" => $this->modelogeneral->getDetalleVenta($id),
            "total" => $this->modelogeneral->get_sumatoriadetalleVenta($id)
            
        );
        $this->load->view("emprendedor/detalle_venta",$data);
    }

     public function comprobanteVenta(){
        $id = $this->input->post("id");
        $data = array(
            "detalles_prod" => $this->modelogeneral->getDetalleVenta($id),
            "row_venta"     => $this->modelogeneral->get_detalleVenta($id),
        );
        $this->load->view("emprendedor/comprobante_venta",$data);
    }





  

     public function Myperfil()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp');
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);

    
    $this->load->view("layout/header",$data);
    $this->load->view("layout/side_menu",$data);
    $this->load->view("layout/perfil",$data);
    $this->load->view("layout/footer");  
    }

      public function calendario()
    {

     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp');
     $result = $this->modelogeneral->mostrar_asoc($id_emp);
     $data = array('asociados' => $result);
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);          
     
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/calendar",$data);
     $this->load->view("layout/footer");  

    }

       public function tienda()
    {
     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   

     $id_emp = $this->session->userdata('id_emp');
     $result = $this->modelogeneral->mostrar_producto();
     $combos = $this->modelogeneral->listar_data_combosActivos();
     
     $data   = array('productos' => $result,'combos' => $combos );
     
     $data['cant_asoc']      = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
     $data['iva']      = $this->modelogeneral->getIva();
     
     $data['ultimo_reg']     = $this->modelogeneral->las_insetCap(); 
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $data['cantidad_prod']  = $this->modelogeneral->count_cantProdCar($id_emp);
              
     $this->load->view("layout/header",$data);
     $this->load->view("layout/side_menu",$data);
     $this->load->view("emprendedor/tienda",$data);
     $this->load->view("layout/footer");  

    }
   

    public function add_toCar()
    {
     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $param['id_emp']          = $this->session->userdata('id_emp');
        $param['fecha_car']       = date('Y-m-d');
        $param['id_producto']     = $this->input->post('id_prod');
        $param['cantidad']        = $this->input->post('cantidad');
        $param['precio_car']      = $this->input->post('precio'); //costo final
        $param['importe']         = $param['precio_car'] * $param['cantidad'];
        $param['es_combo']        = 0;
        $result                   = $this->modelogeneral->insert_toCar($param);
        
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
       // redirect(base_url() . "ventas/add_salida_prodcliente");
    }

      public function add_toCar_combo()
    {
     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $param['id_emp']          = $this->session->userdata('id_emp');
        $param['fecha_car']       = date('Y-m-d');
        $param['id_producto']     = $this->input->post('id_prod');
        $param['cantidad']        = $this->input->post('cantidad');
        $param['precio_car']      = $this->input->post('precio'); //costo final
        $param['importe']         = $param['precio_car'] * $param['cantidad'];
        $param['es_combo']        = 1;
        $result                   = $this->modelogeneral->insert_toCar($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
       
    }

    


    public function insert_prodAlmacen()
    {
     if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   
        $param['id_emp']          = $this->session->userdata('id_emp');
        $param['id_producto']     = $this->input->post('id_producto');
        $param['existencia']      = $this->input->post('existencia');
        
        $result = $this->modelogeneral->insert_prodAlmacen($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

     public function update_prodCar()
    {
       
        $param['id_car']    = $this->input->get('id_car');
        $param['cantidad']  = $this->input->get('cantidad');
        $param['importe']   = $this->input->get('importe');
        $result             = $this->modelogeneral->update_prodCar($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

     public function prueba()
    {
       
       echo  $param['id_car']    = $this->input->post('id_car');
       
    }



     function carrito_compra()
    {
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
            redirect(base_url() . 'login');
        }   

        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->mostrar_carrito($id_emp);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
            foreach($result as $row)
            {
                $count++;
                $output .= '<tr>
                                 <td class="text-center">&nbsp;</td>
                                <td class="text-center">
                                 <a class= "btn-remove-producto" data-toggle="tooltip" data="'.$row->id_car.'" data-original-title="Close"> <i class="fa fa-close text-danger"></i> </a></td>
                                <td>
                                <img src="'.base_url().'assets/uploads/img_productos/'.$row->url_imagen.'" alt="user" class="img-circle" /> '.$row->nombre_prod.'</td>
                                <td class="text-right"> '.$row->precio_car.' </td>
                                <td class="text-center">
                                   <div class="row">
                                    <div class="form-group">
                                     <input id="tch3_22" size="5" type="text" value="'.$row->cantidad.'" name="tch3_22" data-bts-button-down-class="btn btn-default btn-outline" data-bts-button-up-class="btn btn-default btn-outline"> </div> 
                                   </div>
                                </td>
                                <td class="text-right">'.$row->importe.'</td>

                            </tr>';
                
            }
        }
    
        echo $output;
    }
    public function eliminar_prodCar()
    {
        $param['id_car'] = $this->input->get('id_car');
        $param['id_emp'] = $this->session->userdata('id_emp');
        $result  = $this->modelogeneral->eliminar_prodCar($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }


         public function eliminar_cli()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_cli($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

    





    /*-----------------------*/

       public function udpdateDatosProd()
    {
       $param['id_producto']  = $this->input->post('id_producto');
       $param['id_categoria'] = $this->input->post('id_categoria');
       $param['descripton']   = $this->input->post('descripton');
       $result                = $this->modelogeneral->udpdateDatosProd($param);
       $msg['success']        = false;
       if($result){
        $msg['success'] = true;
      }
      echo json_encode($msg);

    }

  /*---------------get datos del producto---------------*/

     public function editar_producto(){
        $id_producto = $this->input->get('id_producto');
        $resultado = $this->modelogeneral->editar_producto($id_producto);
        echo json_encode($resultado);
    }


    

    public function show_categorias()
    {
       $result = $this->modelogeneral->administrar_categorias();
       echo json_encode($result);
    }


    

    
	public function GetProducto()
    {
        $id_producto = $_GET['idprod'];
        $result = $this->modelogeneral->update_producto_tienda($id_producto);
        $msg['success'] = false;
       if($result){
         $msg['success'] = true;
        }
       echo json_encode($msg);
	}


	

	public function RetornarProducto()
    {
        $id_producto = $_GET['idprod'];
        $result = $this->modelogeneral->retorna_producto_tienda($id_producto);
        $msg['success'] = false;
       if($result){
         $msg['success'] = true;
        }
       echo json_encode($msg);
	}

    /*---------solicitud de nuevo plan--------------*/
    public function Solicitud_plan()
    {
        $id_plan = $_GET['plan'];
        $usuario = $this->session->userdata('id_usuario');
        $result = $this->modelogeneral->update_plan($id_plan,$usuario);
        $msg['success'] = false;
       if($result){
         $msg['success'] = true;
        }
       echo json_encode($msg);
    }


    
      public function contactar_soporte()
    {
        
      if($this->input->is_ajax_request()) 
        {
                   
                  $data = array(
                               
                                'asunto'   => $this->input->post('asunto'),
                                'email'    => $this->input->post('email'),
                                'telefono' => $this->input->post('telefono'),
                                'mensaje'  => $this->input->post('mensaje'),
                                'fecha'    =>  date('Y-m-d H:i:s'),
                                'usuario'  => $this->input->post('usuario')
                                 );
                    
                   $result = $this->modelogeneral->insertar_consulta($data);
                   $msg['comprobador'] = false;
                   if($result)
                     {
                       $msg['comprobador'] = TRUE;
                     }
                    echo json_encode($msg);

          
        }       
       

           
    } // fin insertar consulta a soporte

      public function udpate_perfil()
    {
        $data = array(
                   
                    'nombre_usuario' => $this->input->post('nombre_usuario'),
                    'usuario'        => $this->input->post('usuario'),
                    'mail'           => $this->input->post('mail'),
                    'pass'           => md5($this->input->post('pass')),
                    'id_tienda'      => $this->input->post('id_tienda')
                     );
        $id_usuario     = $this->input->post('id_usuario'); 

       $result = $this->modelogeneral->update_perfil($data,$id_usuario);
       $msg['comprobador'] = false;
       if($result)
         {
           $msg['comprobador'] = TRUE;
         }
            echo json_encode($msg);
       
           
    } // fin update perfil




}
