<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
use Automattic\WooCommerce\Client;

class Panel_admin extends CI_Controller
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
       
    }
    public function index()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
     $id_emp = $this->session->userdata('id_emp');
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp); 
     $data['total_emp']  = $this->modelogeneral->Total_emp("emprendedor");
     $result             = $this->modelogeneral->listar_clientes_finales_Mes($id_emp);
     $data['total_comp'] = $result['cantclientes'];
     $data['total_cli']  = $result['total_cli'];
     
     $resul_emp          = $this->modelogeneral->emprendedores_mensuales($id_emp);
     $data['emp_mes']           = $resul_emp['emp_mes'];
     $data['cantidad_total']    = $resul_emp['total_general'];

     $result_ventas = $this->modelogeneral->listar_dataVentasMes($id_emp);
     $data['total_ventasMes'] = $result_ventas['ventas_mes'];
     $data['total_ventas']    = $result_ventas['total_ventas'];

     $data['emp_ins_semana'] = $this->modelogeneral->emp_inc_semana();
     $data['emp_inc_mes']    = $this->modelogeneral->emp_inc_mes();
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");
     $result                 = $this->modelogeneral->mostrar_MisEmp($id_emp);
     $data['cantitad_emp']   = count($result);       
     
     $this->load->view("layout/header",$data);
     $this->load->view("admin_general/side_menuAdmin",$data);
     $this->load->view("admin_general/page_inicioAdmin",$data);
     $this->load->view("layout/footer");  
    }

     public function getDataConsumo(){
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }   
        $id_emp   = $this->session->userdata('id_emp'); 
        $year     = date('Y');
        $result = $this->modelogeneral->emprendedores_mensuales($id_emp);
       // var_dump($result);
       echo json_encode($result['cantidad_mes']);
    }

     public function getVentames(){
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }   
        $id_emp   = $this->session->userdata('id_emp'); 
        $result = $this->modelogeneral->listar_dataVentasMes($id_emp);
       echo json_encode($result['compras']);
    }


    public function listar_clientes_finales_Mes(){
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }   
        $id_emp   = $this->session->userdata('id_emp'); 
        $result = $this->modelogeneral->listar_clientes_finales_Mes($id_emp);
       echo json_encode($result['clientes']);
	   //var_dump($result);
    }


      function load_data_Pepuestos()
    {
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
        $id_producto  = $this->input->post('id_producto');
        $result  = $this->modelogeneral->prod_repuestos($id_producto);
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
            $datos_prod  = $this->modelogeneral->datos_productos($row->id_respuesto_hijo);  
            $output .= '<tr>';
            $output .= '<td>'.$datos_prod->nombre_prod.'</td>';
            $output .= '<td><button type="button" data="'.$row->id_resp_prod.'" class="btn btn-danger delete-resp"><span class="fa fa-remove"></span></button></td>';
            $output .= '</tr>';
            }
        }
    
        echo $output;
    }
	
	public function ipn_order_emprendedor(){ 
      $json   = file_get_contents('php://input');
      $data   = json_decode($json); 
      $param  = array('id_order' => $data->id);
      $result = $this->modelogeneral->insert_ipn($param);

    }
	
	public function comprobar_woo(){ 
        require '/home/admindvg/public_html/metric-online/api-wc/vendor/autoload.php';

		$woocommerce = new Client(
			'https://www.dvigi.com.ar', 
			'ck_15049661c7b0a408b9aaad3086def84155a81e5b', 
			'cs_d9e4118a9e6046251d7e2a12e7187af146827109',
			[
				'wp_api' => true,
				'version' => 'wc/v2',
			]
		);

        //$pedido = 8335;
		$emp_recomendado = 0;
		$total_compra = 0;
		$comision = 0;
		$comision_acumulada = 0;
		
		$result = $this->modelogeneral->listar_ipn_orders();
        foreach ($result as $key ) {
           $pedido = $key->id_order;
		   
		   $results = $woocommerce->get("orders/$pedido", $parameters = ['consumer_key'=>'ck_15049661c7b0a408b9aaad3086def84155a81e5b', 'consumer_secret' => 'cs_d9e4118a9e6046251d7e2a12e7187af146827109']);
		
			if ($results->status == "processing"){				
				foreach ($results->meta_data as $posicion => $mdata):
					if($mdata->key == "_emp"){
						$emp_recomendado =  $mdata->value; 
						$total_compra = $results->total;
						$comision = ($total_compra * 30)/100;
					  
                        $data = array(
						   'id_order'      => $pedido,
						   'status'        => 'processing',
						   'total_compra'  => $total_compra,
						   'comision'      => $comision,
						   'dni_emprend'   => $emp_recomendado
						);				
					    $this->modelogeneral->update_ipn($data);
              
                      	$emprendedor = $this->modelogeneral->buscar_dni_emp($emp_recomendado);
                        if($emprendedor != NULL){
							$comision_acumulada = $emprendedor->comision_acumulada + $comision;
							$param = array(
							    'dni_emp'             => $emp_recomendado,
						        'comision_acumulada'  => $comision_acumulada
							);							
							$this->modelogeneral->update_datos_emp($param);							
						}							
					}                               
			    endforeach;
				
				if($emp_recomendado == 0){
				    $data = array(
						   'id_order'      => $pedido,
						   'status'        => 'processing'
						);				
					$this->modelogeneral->update_ipn($data);
				}
			}
		}		
    }
    
     public function MyperfilAdmin()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        } 
                
     $id_emp = $this->session->userdata('id_emp');
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");  
    
      $this->load->view("layout/header",$data);
      $this->load->view("admin_general/side_menuAdmin",$data);
      $this->load->view("layout/perfil",$data);
      $this->load->view("layout/footer");  
    }

    

    function load_dataemp()
    {
        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->mostrar_MisEmp($id_emp);
        $year = date('Y');
        $mes  =  date('m');

        $cantitad = count($result);

        $count = 0;
        $output = '';
       // var_dump($result);
        if(!empty($result))
        {
            foreach($result as $row)
            {
                $data = array('mes' =>$mes,'year' =>$year, 'id_emp' =>$row->id_emp);
                $row_monto     = $this->modelogeneral->montos_mes($data); 
                $m_acumulado   = $this->modelogeneral->compras_acumuladas($data); 
                $cant_clientes = $this->modelogeneral->Count_Cli($row->id_emp); 
                $cant_cli_venc = $this->modelogeneral->cant_cli_venc($row->id_emp); 

                $cartera_atendida = $cant_clientes - $cant_cli_venc;
				
				if($cant_clientes > 0){
					$porc_venc = round(($cartera_atendida * 100) / $cant_clientes);
				}else{
					$porc_venc = 0;
				}
				
                $epats_activos = $this->modelogeneral->epatsActivos($row->id_emp); 
                $epats_total   = $this->modelogeneral->rowCountAsoc($row->id_emp);
                $padre_emp     = $this->modelogeneral->mostrar_patrocinador_padre($row->id_emp);
                $fecha_compra  = $this->modelogeneral->ultima_compra($row->id_emp);	
				if($fecha_compra != NULL){
				 $fecha_c = $fecha_compra->fecha_comp;
				}else{
					$fecha_c = "-";
				}
                if($epats_total != 0){
					$porciento_activos = round((($epats_activos * 100)/$epats_total));
					}else{
						$porciento_activos = 0;
						}				
                
                if ($row_monto->monto != null) {
                     $monto =  $row_monto->monto;
                 } else {
                     $monto = 0;
                 }

                if ($m_acumulado->monto != null) {
                     $m_acumulado =  $m_acumulado->monto;
                 } else {
                     $m_acumulado = 0;
                 } 

                 if ($row->firmo_contrato == 1) {
                     $firmo = "checked";
                     $desabled = "disabled";

                 } else {
                     $firmo = " ";
                     $desabled = "";
                 }
                 $anular = '';

                 switch ($row->estado) {
                            case '0':
                                $estado = '<span class="label label-warning">Invitación enviada</span>';
                                $anular = ' <button class="btn btn-danger delet-inv  btn-circle btn-sm m-r-5" data="'.$row->id_emp.'" id="" name="" title="Anular Invitación"><i class="fa fa-times"></i></button>';
                                break;
                            case '1':
                                 $estado = '<span class="label label-success">Aceptado</span>';
                                break;
                            case '2':
                                 $estado = '<span class="label label-info">Capacitación</span>';
                                break;
                            case '3':
                                 $estado = '<span class="label label-primary">Capacitado</span>';
                                break;
       
                        }

                        switch ($row->status_cli) {
                            case '1':
                                $checked ="checked";
                                break;
                            case '0':
                                $checked ="";
                               break;
                            } 
                 
                  
                $output .= '<tr>
                              <td >
                                  <label class="switch" title="activar/desactivar">
                                      <input type="checkbox"  '.$checked.' class="status_cli"  value="'.$row->id_emp."*".$row->status_cli.'">
                                      <span class="slider round"></span>
                                    </label>
                                  </td>

                               <td>
                                 <span class="font-medium">'.$row->nombre_emp." ".$row->apellido.'</span>
                                  <br/><span class="text-muted">'.$row->email.'</span>
                                  <br/><span class="text-muted">'.$row->telefono_emp.'</span>
								  <br/>'.$estado.' &nbsp; '.$anular.'
                                </td>

                                <td>
                                 <span class="font-medium">'.$padre_emp->nombre_emp.'</span>
                                </td>
                               
                               <td>
                                    <div class="checkbox checkbox-success">
                                                <input id="checkbox'.$row->id_emp.'"  '.$desabled.'  type="checkbox" '.$firmo.' value="'.$row->id_emp.'" class="firmo">
                                                <label for="checkbox'.$row->id_emp.'" ><span id="span'.$row->id_emp.'"></span></label>
                                     </div>
                                </td>
                              <td>'.$fecha_c.'</td>
                              <td align="">$'.$m_acumulado.'</td>
							 
                              <td align="center">'.$epats_total.'</td>
                             
                              <td align="center">'.$epats_activos.'</td>';  

                             
                             if($porciento_activos > 70){
                                $output .= ' <td style="background:  green;" align="center" ><strong style="color: #fff;">'.$porciento_activos.' %</strong></td>'; 
                                }else{
                                 $output .= ' <td style="background:  red;" align="center"><strong style="color: #fff;">'.$porciento_activos.' %</strong></td>';

                                }
                              
                              $output .= '<td align="center">'.$cant_clientes.'</td>';

                              if($porc_venc >= 80){
                                $output .= ' <td style="background:  green;"align="center" ><strong style="color: #fff;">'.$porc_venc.' %</strong></td>'; 
                                }else{
                                 $output .= ' <td style="background:  red;" align="center"><strong style="color: #fff;">'.$porc_venc.' %</strong></td>';
                                } 

                            
                            $output .= '</tr>';
            }
        }
    
        echo $output;
    }

    function load_listaPatrocinados()
    {
        $id_emp = $this->input->post('id_emp');
        $result = $this->modelogeneral->mostrar_asoc($id_emp);
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
              $output .= ' <tr>
                         <td>'.$row->dni_emp.'</td>
                         <td>'.$row->nombre_emp.'</td>
                         <td>'.$row->telefono_emp.'</td>
                         <td>'.$row->email.'</td>
                         </tr>';                                        
            }
        }
    
        echo $output;
    }

       public function update_firma()
    {
        $id_emp     = $this->input->get('id_emp');
        $param = array('id_emp' => $id_emp,'firmo_contrato' =>1);
        $result  = $this->modelogeneral->update_perfil($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = "FIRMO";
               $datos_emp  = $this->modelogeneral->getdatos_emp($id_emp);
               $this->sendMailGmailFirmoContrato($datos_emp);
             }
        echo json_encode($msg);
    }


public function sendMailGmailFirmoContrato($datos_emp)
    { 
       $datos_admin = $this->modelogeneral->getdatos_emp($datos_emp->admin_cabeza); 
      //cargamos la libreria email de ci
      $this->load->library("email");
      //configuracion para gmail
      $configGmail = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'consultas@dvigi.com.ar',
        'smtp_pass' => 'Agosto30',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
      );   
      $cuerpo_mensaje = $this->load->view("layout/notif_contrato_firmado",$datos_admin,true); 
      $email_destino = $datos_emp->email;
     //cargamos la configuración para enviar con gmail
      $this->email->initialize($configGmail);
      $this->email->from('consultas@dvigi.com.ar <consultas@dvigi.com.ar>', 'Emprendedores Dvigi');
      $this->email->to("$email_destino");
      $this->email->subject('Emprendedores Dvigi');
      $this->email->message($cuerpo_mensaje);
      $this->email->send();
    }
   
     
      public function eliminar_emp()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_emp($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }
   
    public function insert_emp()
    {
        $id_emp                = $this->session->userdata('id_emp');
        $param['foto_emp']     = 'no_img.jpg';
        $param['email']        = $this->input->post('email');
        $email_destino         = $this->input->post('email');
        $param['fecha_insc']   = date('Y-m-d');
        $param['admin_cabeza'] = $id_emp; 


        $resultado = $this->modelogeneral->insert_emp($param);

        if ($resultado == "existe"){
            $msg['comprobador'] = "existe";  
        }else{
             
                 $data['id_hijo']  = $resultado;
                 $data['id_padre'] = $this->session->userdata('id_emp');
                 $result           = $this->modelogeneral->insert_emp_asoc($data);
                 $nombre           = $this->session->userdata('nombre');
                 $dato  = array('emp_padre' => $nombre,'id_hijo' => $data['id_hijo']);
                 $msg['comprobador'] =  $this->sendMailGmail($email_destino,$dato);
            }

            echo json_encode($msg);
    }
    

     function load_ordenVideos()
    {
        $result = $this->modelogeneral->listar_data_cap();
        $count = 0;
        $output = '';
        if(!empty($result))
        {
         $output .= '<ol class="dd-list">';
          foreach($result as $row)
            {
             $output .= '<li class="dd-item dd3-item" data-id="'.$row->id_cap.'">
                            <div class="dd-handle dd3-handle"></div>
                            <div class="dd3-content dd-handle">'.$row->titulo_video.'</div>
                         </li>';
            }
            $output .= '</ol>';
        }
    
        echo $output;
    }



     function load_datAdmCap()
    {
        $result = $this->modelogeneral->listar_data_cap();
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
             $output .= '<tr>
                         <td><span class="font-medium">'.$row->titulo_video.'</span></td>
                         <td>
                                    <div class="row">
                                        <div class="col-sm-3">
                                             <a class="popup-youtube vista_previa btn btn-default" data-title="Vista Previa" title="Vista Previa" href="'.$row->url_video.'">
                                             <i class="fa fa-play"></i></a>
                                        </div>

                                   </div>
                         
                         <!--span class="text-muted">'.$row->url_video.'</span></td-->
                        <td><button type="button" class="btn btn-info view-preg-resp" data-toggle="modal" data-target="#detalleModal" data="'.$row->id_cap.'" class="btn-outline btn-circle btn-lg m-r-5"><i class="ti-eye"></i></button></td>';
                        $output .= '<td>
                        <button type="button" data="'.$row->id_cap.'" class=" btn btn-info btn-outline btn-circle btn-lg m-r-5 edit-row-btn" data-toggle="modal" data-target="#modal-add-cap"  data-toggle="tooltip" data-original-title="Editar" title ="Editar"><i class="ti-pencil-alt"></i></button>

                        <button type="button" data="'.$row->id_cap.'" class=" btn btn-primary btn-outline btn-circle btn-lg m-r-5 btn-asociar-pregunta" data-toggle="modal" data-target="#asociar-pregunta"   data-toggle="tooltip" data-original-title="Agregar Preguntas" title ="Agregar Preguntas"><i class="fa fa-question-circle"></i></button>

                        <button type="button" data="'.$row->id_cap.'" class="btn btn-danger btn-outline btn-circle btn-lg m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button></td>
                        </tr>';

                        
                        
            }
        }
    
        echo $output;
    }

    public function prueba1(){
    	$valor   = $this->modelogeneral->selec_maxorden_visual();
    	var_dump($valor->orden_visual);
    	//echo $valor;
    }


    /* Insertar videos*/
    public function insert_cap()
    {
       
        $param['titulo_video']   = $this->input->post('titulo_video');
        $param['descripcion']    = $this->input->post('descripcion');
        $param['imag_portada']   = $this->input->post('nombre_archivo');
        $param['url_video']      = $this->input->post('url_video');
        $param['fecha_public']   = date('Y-m-d');
        $valor                   = $this->modelogeneral->selec_maxorden_visual();
        $param['orden_visual']   = $valor->orden_visual+1;
        
        $result                  = $this->modelogeneral->insert_cap($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }


     public function downloads($doc){
         
       $data = file_get_contents('assets/videos/'.$doc); 
       force_download($name,$data); 
     
    }
     /* eliminar videos de capacitacion */
      public function eliminar_cap()
    {
        $id_cap = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_cap($id_cap);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

       /* eliminar eliminar_preguntas */
      public function eliminar_resp()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_resp($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }


        public function updateResp()
    {

        $id_respuesta = $this->input->get('id_respuesta');
        $es_correcta  = $this->input->get('es_correcta');
        $param = array('id_respuesta' => $id_respuesta,'es_correcta' => $es_correcta);
        $result =  $this->modelogeneral->update_resp($param);
        $msg['success'] = false;
       if($result){
            $msg['success'] = true;
        }
      echo json_encode($msg);

    }

    public function update_ordenVideos()
    {
        $data = $this->input->post('id');
        for ($i=0; $i < count($data); $i++) { 
        
          $param = array(
              'id_cap'       => $data[$i]['id'], 
              'orden_visual' => $i,
          );
          $result =  $this->modelogeneral->update_ordenVideos($param);
    }
      echo json_encode($result);

    }

        public function updateRespuesta()
    {
              
        $id_respuesta = $this->input->post('pk');
        $respuesta    = $this->input->post('value');

        $param = array('id_respuesta' => $id_respuesta,'respuesta' => $respuesta);
        
        $result =  $this->modelogeneral->update_resp($param);
        $msg['success'] = false;
       if($result){
            $msg['success'] = true;
        }
      echo json_encode($msg);

    }

    public function form_add_cap(){
        $camino = $this->input->post("camino");
         $data = array(
            "camino" => $camino,
            'id_cap' => 0,
            
        );
        $this->load->view("admin_general/add_cap",$data);
    }



    
    
      public function getdatos_cap()
    {
        $id_cap = $this->input->post('id');
        $result  = $this->modelogeneral->getdatos_cap($id_cap);
        $camino = $this->input->post("camino");
        $data = array(
            'camino' => $camino,
            'id_cap' => $id_cap,
             'datos'  => $result

        );
        $this->load->view("admin_general/add_cap",$data);
       
    }

      public function form_add_promo(){
        $data['productos']  = $this->modelogeneral->seleccion_productos();
        $data['combos']    = $this->modelogeneral->seleccion_combos();
        $data['camino']    =  $this->input->post("camino");
        $this->load->view("admin_general/add_promo",$data);
    }



      public function form_add_combo(){
        $camino = $this->input->post("camino");
        $productos       = $this->modelogeneral->seleccion_productos();
         $data = array(
            "camino" => $camino,
            'id_combo' => 0,
            'productos' =>$productos,
            
            
        );
        $this->load->view("admin_general/add_combo",$data);
    }

       public function getdatos_combo()
    {
        $id_combo        = $this->input->post('id');
        $result          = $this->modelogeneral->getdatos_combo($id_combo);
        $productos_selec = $this->modelogeneral->prod_delcombo($id_combo); 
        $productos       = $this->modelogeneral->seleccion_productos();
        $camino = $this->input->post("camino");
       
        $data = array(
            'camino'           => $camino,
            'id_combo'         => $id_combo,
             'datos'           => $result,
             'productos'       => $productos,
             'productos_selec' => $productos_selec,

        );
        $this->load->view("admin_general/add_combo",$data);
       // echo json_encode($result);
    }

       public function getdatos_promo()
    {
        $id_promo        = $this->input->post('id');
        $camino          = $this->input->post("camino");
        $result          = $this->modelogeneral->getdatos_promo($id_promo);
        $productos_selec = $this->modelogeneral->prod_dePromo($id_promo); 
        $productos       = $this->modelogeneral->seleccion_productos();
        $combos          = $this->modelogeneral->seleccion_combos();
        $data = array(
            'camino'           => $camino,
             'id_promo'        => $id_promo,
             'datos'           => $result,
             'productos'       => $productos,
             'productos_selec' => $productos_selec,
             'combos'          => $combos
        );

        $this->load->view("admin_general/add_promo",$data);
       
    }


     public function form_add_prod(){
        $camino = $this->input->post("camino");
        $categorias  = $this->modelogeneral->listar_categorias_prod(); 
        $data = array(
            "camino"           => $camino,
            'id_producto_edit' => 0,
            'categorias'       => $categorias
            
        );
        $this->load->view("admin_general/add_prod",$data);
    }

       public function getdatos_prod()
    {
        $id_producto = $this->input->post('id');
        $result      = $this->modelogeneral->getdatos_prod($id_producto);
        $categorias  = $this->modelogeneral->listar_categorias_prod(); 
        $camino      = $this->input->post("camino");
        $data = array(
            'camino'           => $camino,
            'id_producto_edit' => $id_producto,
             'datos'           => $result,
             'categorias'      => $categorias

        );
        $this->load->view("admin_general/add_prod",$data);
     
    }

     public function update_cap()
    {
        $param['id_cap']         = $this->input->post('id_cap');
        $param['titulo_video']   = $this->input->post('titulo_video');
        $param['descripcion']    = $this->input->post('descripcion');
        $param['imag_portada']   = $this->input->post('nombre_archivo');
        $param['url_video']      = $this->input->post('url_video');
        $param['fecha_public']   = date('Y-m-d');
        
        $result = $this->modelogeneral->update_cap($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

 /*----------- CRUD PRODUCTO-----------------------*/ 
     function load_dataProp()
    {
        $result = $this->modelogeneral->listar_data_prod();
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
                $margen = $row->precio - $row->costo;
             $output .= '<tr>
                         <td><img src="'.base_url().'assets/uploads/img_productos/'.$row->url_imagen.'" alt="'.$row->nombre_prod.'" class="img-circle" /></td>
                         <td><span class="font-medium">'.$row->nombre_prod.'</span></td>';
               
                $repuestos = $this->modelogeneral->repuestos($row->id_producto);          
                $output .= '<td>';
                foreach ($repuestos as $key):

                   $output .= '<small>'.$key->nombre_prod.'</small><br>';
                endforeach;

                $output .= '</td>';
                $output .= '<td><span class="text-muted">'.$row->existencia.'</span></td>
                         <td><span class="text-muted">$ '.$row->precio.'</span></td>
                         <td><span class="text-muted">$ '.$row->costo.'</span></td>
                         <td><span class="text-muted">$ '.$margen.'</span></td>
                         <td>';
                $output .= '<button type="button" data="'.$row->id_producto.'" class=" btn btn-info btn-outline btn-circle btn-lg m-r-5 edit-row-btn" data-toggle="modal" data-target="#modal-add-cap" data-toggle="tooltip" data-original-title="Editar" title ="Editar"><i class="ti-pencil-alt"></i></button>';
                $output .= '<button type="button" data="'.$row->id_producto.'" class="btn btn-danger btn-outline btn-circle btn-lg m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button>';
                         if ($row->es_repuesto == 1) {
                          $output .= '<button type="button"  data="'.$row->id_producto.'" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 btn-asociar-respuesto" data-toggle="modal" data-target="#asociar-respuesto" title ="Asociar Respuestos">
                           <i class="ti-server"></i></button></td></tr>';
                          }

                     
            }
        }
    
        echo $output;
    }
       /* Insertar producto*/
    public function insert_prod()
    {
        $param['nombre_prod']    = $this->input->post('nombre_prod');
        $param['url_imagen']     = $this->input->post('nombre_archivo');
        $param['costo']          = $this->input->post('costo');
        $param['precio']         = $this->input->post('precio');
        $param['es_repuesto']    = $this->input->post('es_repuesto');
        $param['existencia']     = $this->input->post('existencia');
        $param['vencimiento']    = $this->input->post('vencimiento');
        $param['alto']           = $this->input->post('alto');
        $param['ancho']          = $this->input->post('ancho');
        $param['largo']          = $this->input->post('largo');
        $param['peso']           = $this->input->post('peso');
        $param['sku']            = $this->input->post('sku');
        $param['id_categoria']   = $this->input->post('id_categoria');
        $param['valor_declarado']= $this->input->post('valor_declarado');       
        
        $result = $this->modelogeneral->insert_prod($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($param);
    }
     /* eliminar producto */
      public function eliminar_prod()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_prod($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

    /* eliminar respuesto asocidado */
      public function eliminar_respAsoc()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_respAsoc($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }


  /* update producto*/

   public function update_prod()
    {
        $param['id_producto']    = $this->input->post('id_producto_edit');
        $param['nombre_prod']    = $this->input->post('nombre_prod');
        $param['url_imagen']     = $this->input->post('nombre_archivo');
        $param['costo']          = $this->input->post('costo');
        $param['precio']         = $this->input->post('precio');
        $param['es_repuesto']    = $this->input->post('es_repuesto');
        $param['existencia']     = $this->input->post('existencia');
        $param['vencimiento']    = $this->input->post('vencimiento');
        $param['alto']           = $this->input->post('alto');
        $param['ancho']          = $this->input->post('ancho');
        $param['largo']          = $this->input->post('largo');
        $param['peso']           = $this->input->post('peso');
        $param['sku']            = $this->input->post('sku');
        $param['id_categoria']   = $this->input->post('id_categoria');
        $param['valor_declarado']= $this->input->post('valor_declarado');       
        
        $result = $this->modelogeneral->update_prod($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }


 /*-----------./ CRUD PRODUCTO-----------------------*/ 
 /* subir imagen*/
 public function subir_img()
    {
        $config['upload_path'] = 'assets/uploads/img_productos';
        $config['allowed_types'] = 'pdf|jpg|png|jpeg';
        $config['max_size'] = 4048;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('url_imagen')) { #Aquí me refiero a "foto", el nombre que pusimos en FormData
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
          $datos_img = array('upload_data' =>$this->upload->data());
          $msg['imagen'] = $datos_img['upload_data']['file_name'];
           echo json_encode($msg);
        }
    }
  public function subir_imgPerfil()
    {
        $config['upload_path'] = 'assets/plugins/images/users';
        $config['allowed_types'] = 'pdf|jpg|png|jpeg';
        $config['max_size'] = 4048;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('url_imagen')) { #Aquí me refiero a "foto", el nombre que pusimos en FormData
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
          $datos_img = array('upload_data' =>$this->upload->data());
          $msg['imagen'] = $datos_img['upload_data']['file_name'];
           echo json_encode($msg);
        }
    }

 public function subir_imgVideo()
    {
        $config['upload_path'] = 'assets/videos';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size'] = 4048;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('url_imagen')) { #Aquí me refiero a "foto", el nombre que pusimos en FormData
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
          $datos_img = array('upload_data' =>$this->upload->data());
          $msg['imagen'] = $datos_img['upload_data']['file_name'];
           echo json_encode($msg);
        }
    } 

 public function subir_doc()
    {
        $config['upload_path'] = 'assets/videos';
        $config['allowed_types'] = 'pdf|jpg|png|jpeg';
        $config['max_size'] = 4048;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('doc_eva')) { #Aquí me refiero a "foto", el nombre que pusimos en FormData
            $error = array('error' => $this->upload->display_errors());
            echo json_encode($error);
        } else {
          $datos_img = array('upload_data' =>$this->upload->data());
          $msg['doc'] = $datos_img['upload_data']['file_name'];
           echo json_encode($msg);
        }
    }      
    
 /*------update perfil--------*/
 public function update_perfil()
    {
        $param['id_emp']       = $this->session->userdata('id_emp');
        $param['nombre_emp']   = $this->input->post('nombre_emp');
        $param['foto_emp']     = $this->input->post('foto_emp');
        $param['email']        = $this->input->post('email');
        $param['dni_emp']      = $this->input->post('dni_emp');
        $param['telefono_emp'] = $this->input->post('telefono_emp');
        
        $result = $this->modelogeneral->update_perfil($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

/*-------------TABLA DE COMSIONES-------------*/

/*LISTAR RANGO DE COMISIONES*/
function load_dataRango()
    {
        $result = $this->modelogeneral->listar_rango();
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
             $output .= '<tr>
                         <td><span class="font-medium">'.$row->rango_inicial.'</span></td>
                         <td><span class="font-medium">'.$row->rango_final.'</span></td>
                        <td><span class="font-medium">'.$row->valor_comision.'</span></td>
                        <td><span class="font-medium">'.$row->categoria.'</span></td>
                        <td>
                        <button type="button" data="'.$row->id_tbl_comisiones.'" class=" btn btn-info btn-outline btn-circle btn-lg m-r-5 edit-row-btn" data-toggle="modal" data-target="#insetcapModal"  data-toggle="tooltip" data-original-title="Editar" title ="Editar"><i class="ti-pencil-alt"></i></button>
                        <button type="button" data="'.$row->id_tbl_comisiones.'" class="btn btn-danger btn-outline btn-circle btn-lg m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button></td>
                        </tr>';
            }
        }
    
        echo $output;
    }

  /* Insertar*/
    public function insert_comision()
    {
       
        $param['rango_inicial']  = $this->input->post('rango_inicial');
        $param['rango_final']    = $this->input->post('rango_final');
        $param['valor_comision'] = $this->input->post('valor_comision');
        $param['categoria']      = $this->input->post('categoria');
        $result                  = $this->modelogeneral->insert_comisiones($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

    /*listar*/

       public function getdatos_rango()
    {
        $id      = $this->input->get('id');
        $result  = $this->modelogeneral->getdatos_rango($id);
        echo json_encode($result);
    }

    public function update_rango()
    {
        $param['id_tbl_comisiones'] = $this->input->post('id_tbl_comisiones');
        $param['rango_inicial']     = $this->input->post('rango_inicial');
        $param['rango_final']       = $this->input->post('rango_final');
        $param['valor_comision']    = $this->input->post('valor_comision');
        $param['categoria']         = $this->input->post('categoria');
        
        $result = $this->modelogeneral->update_rango($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

      /* eliminar videos de capacitacion */
  public function eliminar_rango()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_rango($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }  

 /*-----------------------------*/
 /*-------------TABLA DE MONTO MINIMO-------------*/


function load_datamonto()
    {
        $result = $this->modelogeneral->configuracion();
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row)
            {
             $output .= '<tr>
                         <td><span class="font-medium">'.$row->parametro.'</span></td>
                         <td>
                             <input type="text" name="valor[]" class="" id="valor_'.$row->id_conf.'" value="'.$row->valor.'"  required>
                             <i id="capa_'.$row->id_conf.'"></i>
                             
                        </td>            
                         <td><span class="font-medium">'.$row->descripcion.'</span></td>
                        </tr>';
            }
        }
    
        echo $output;
    }

  /* Insertar*/
    public function insert_monto()
    {
       
        $param['monto_minimo']  = $this->input->post('monto_minimo');
        $param['fecha']         = date('Y-m-d');
        $result                 = $this->modelogeneral->insert_monto($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

    /*listar*/

       public function getdatos_monto()
    {
        $id      = $this->input->get('id');
        $result  = $this->modelogeneral->getdatos_monto($id);
        echo json_encode($result);
    }

    public function updateParametros()
    {
        $param['id_conf']  = $this->input->get('id_conf');
        $param['valor']    = $this->input->get('valor');
        
        $result = $this->modelogeneral->updateParametros($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

      /* eliminar monto */
  public function eliminar_monto()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_monto($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }   


 /*-----------------------------*/  
    public function forgot_pass()
    {
         $email  = $this->input->post('email_rest');
         $dato   = $this->modelogeneral->buscar_email_emp($email);
         $msg['comprobador'] = false;
        if($dato)
             {
              $this->sendMailGmailOptenerDatos($email,$dato);
              redirect(base_url()."login/cambio_pass");

             }
       
       // echo json_encode($msg);
    }

     public function sendMailGmailOptenerDatos($email_destino,$dato)
    {   
      //cargamos la libreria email de ci
      $this->load->library("email");
      //configuracion para gmail
      $configGmail = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'consultas@dvigi.com.ar',
        'smtp_pass' => 'Agosto30',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
      );   
      $cuerpo_mensaje = $this->load->view("layout/notificacion_cambio_pass",$dato,true); 
     //cargamos la configuración para enviar con gmail
      $this->email->initialize($configGmail);
      $this->email->from('consultas@dvigi.com.ar <consultas@dvigi.com.ar>', 'Emprendedores Dvigi');
      $this->email->to("$email_destino");
      $this->email->subject('Emprendedores Dvigi');
      $this->email->message($cuerpo_mensaje);
      $this->email->send();
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
        'smtp_pass' => 'Agosto30',
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
     return $this->email->send();
      //con esto podemos ver el resultado
      //var_dump($this->email->print_debugger());
    }

    public function prueba (){
     $data['id_hijo'] =214;
     $nombre ="Silvana";
     $dato  = array('emp_padre' => $nombre,'id_hijo' => $data['id_hijo']);
      $cuerpo_mensaje = $this->load->view("layout/invitacion_nuevoPatrocinado",$dato); 
      
    }

    public function admin_prod()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
    $data['categorias']  = $this->modelogeneral->listar_categorias_prod(); 
    $data['respuestos']  = $this->modelogeneral->selec_respuestos_prod(); 
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");   

    $this->load->view("layout/header",$data);
    $this->load->view("admin_general/side_menuAdmin",$data);
    $this->load->view("admin_general/admin_productos",$data);
    $this->load->view("layout/footer");  
    }

    public function admin_promo()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp);
    $data['productos']      = $this->modelogeneral->seleccion_productos();
    $data['combos']         = $this->modelogeneral->listar_data_combos();
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");  

    $this->load->view("layout/header",$data);
    $this->load->view("admin_general/side_menuAdmin",$data);
    $this->load->view("admin_general/admin_promos",$data);
    $this->load->view("layout/footer");  
    }

       public function ventas()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
   // $data['categorias']  = $this->modelogeneral->selec_categorias_prod();
    $data['productos']      = $this->modelogeneral->seleccion_productos();
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");  

    $this->load->view("layout/header",$data);
    $this->load->view("admin_general/side_menuAdmin",$data);
    $this->load->view("admin_general/admin_ventas",$data);
    $this->load->view("layout/footer");  
    }

     public function insert_promo()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        } 

        $param['nombre_promo']     = $this->input->post('nombre_promo');
        $param['fecha_inicio']     = $this->input->post('fecha_inicio');
        $param['fecha_fin']        = $this->input->post('fecha_fin');
        $param['descuento']        = $this->input->post('descuento');
        $es_combo                  = $this->input->post("es_combo");
        $msg['comprobador']        = false;
        
        if($this->modelogeneral->save_Promo($param)){
              $data['id_promo'] =  $this->modelogeneral->lastID();
              $data['productos']  = $this->input->post('productos');
              $this->save_detallePromo($data, $es_combo);
           $msg['comprobador'] = TRUE;
           } 
       echo json_encode($msg);
    }

    
   protected function save_detallePromo($data, $es_combo){ 
    for ($i=0; $i < count($data['productos']); $i++) {         
      
          $dato_promo = array(
              'id_producto' => $data['productos'][$i], 
              'id_promo'    => $data['id_promo'],
              'es_combo'    => $es_combo[$i]
          );
       $this->modelogeneral->save_detallePromo($dato_promo);
    
    }
}


  public function update_promo()
    {
        $param['id_promo']         = $this->input->post('id_promo'); 
        $param['nombre_promo']     = $this->input->post('nombre_promo');
        $param['fecha_inicio']     = $this->input->post('fecha_inicio');
        $param['fecha_fin']        = $this->input->post('fecha_fin');
        $param['descuento']        = $this->input->post('descuento');
        
        $this->modelogeneral->update_promo($param);
       
        $msg['comprobador'] = false;
        $result ="";
        $data['id_promo']   = $this->input->post('id_promo'); 
        $data['productos']  = $this->input->post('productos');
        $data['es_combo']   = $this->input->post('es_combo');
        
        for ($i=0; $i < count($data['productos']); $i++) { 
                  $param_cp = array(
                      'id_producto' => $data['productos'][$i], 
                      'id_promo'    => $data['id_promo'],
                      'es_combo'    => $data['es_combo'][$i] 
                  );
                  
                $result = $this->modelogeneral->update_promoProd($param_cp);
            }
           
              
            
        echo json_encode($result);
    }

         public function eliminar_Prod_Promo()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_Prod_promo($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }





    public function all_productos_cat()
    {
       if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'emprendedor') {
           redirect(base_url() . 'login');
       }
       
        $data['id_categoria']  = $this->input->post('id');
        $resultado = $this->modelogeneral->productos_cat($data);
        $mostarprod ="";
        if(!empty($resultado))
        {
            $mostarprod .='<option value="">Seleccione</option>';
            foreach($resultado as $row):
              $mostarprod .='<option value="'.$row->id_producto.'">'.$row->nombre_prod.'</option>';
            endforeach ; 
        } 
        echo $mostarprod;
    }



     public function insert_preguntas()
    {
        $param['id_cap']     = $this->input->post('id_cap_preg');
        $param['pregunta']   = $this->input->post('pregunta');

        $result = $this->modelogeneral->insert_cap_preguntas($param);
        $msg['comprobador'] = false;
        if($result)
             {
              $data['id_preg']      = $this->modelogeneral->lastID();
              $data['respuesta']    = $this->input->post('respuesta');
              $data['es_correcta']  = $this->input->post('es_correcta');
              $this->save_cap_respuestas($data);
              $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);

    }

      protected function save_cap_respuestas($data){ 
    for ($i=0; $i < count($data['respuesta']); $i++) { 
      
          $dato_preg = array(
              'id_preg'     => $data['id_preg'],
              'respuesta'   => $data['respuesta'][$i], 
              'es_correcta' => $data['es_correcta'][$i] 
          );
        
        $this->modelogeneral->insert_cap_repuestas($dato_preg);
    
    }
}


 public function view_preg_resp(){
        $id = $this->input->post("id");
        $data = array(
            "preguntas" => $this->modelogeneral->pregunta_cap($id)
        );
        $this->load->view("admin_general/list_preg_resp",$data);
    }






    

     public function insert_repuesto()
    {
        $param['id_producto']     = $this->input->post('id_producto');
        $param['respuestos']        = $this->input->post('respuestos');

        for ($i=0; $i < count($param['respuestos']); $i++) { 
      
          $dato = array(
              'id_producto'       => $param['id_producto'], 
              'id_respuesto_hijo' => $param['respuestos'][$i] 
          );
        
         $msg['comprobador'] = $this->modelogeneral->insert_repuesto($dato);
    
       }
     echo json_encode($msg);
    }

   
    

  /* administracion de combos*/

     public function admin_combos()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
    $data['productos']  = $this->modelogeneral->seleccion_productos();
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");    


    $this->load->view("layout/header",$data);
    $this->load->view("admin_general/side_menuAdmin",$data);
    $this->load->view("admin_general/admin_combos",$data);
    $this->load->view("layout/footer");  
    }

       function load_dataCombos()
    {
        $result = $this->modelogeneral->listar_data_combos();
        $count = 0;
        $output = '';
        if(!empty($result))
        {


            foreach($result as $row):
                $productos = $this->modelogeneral->prod_delcombo($row->id_combo);

                switch ($row->estado_combo) {
                case '1':
                    $checked ="checked";
                    break;
                case '0':
                    $checked ="";
                   break;
               
            }   
                $output .= '<tr>
                         <td >
                          <label class="switch" title="activar/desactivar">
                              <input type="checkbox"  '.$checked.' class="estado_combo" title="activar/desactivar" value="'.$row->id_combo."*".$row->estado_combo.'">
                              <span class="slider round"></span>
                            </label>
                          </td>
                         <td><span class="text-muted"><img src="'.base_url().'assets/uploads/img_productos/'.$row->url_imagen.'" alt="'.$row->nombre_combo.'" class="img-circle" /></td>
                         <td><span class="font-medium">'.$row->nombre_combo.'</span></td>';
                         $output .= '<td>';
                         foreach($productos as $prod):
                          $output .= '<span class="text-muted">'.$prod->nombre_prod.'</br></span>';
                          endforeach ; 
                         $output .= '</td>';
                         $output .= '<td><span class="text-muted">'.$row->precio_combo.'</span></td>';
                         $output .= '<td><span class="text-muted">'.$row->costo.'</span></td>
                         <td><span class="text-muted">'.$row->existencia.'</span></td>';

                        
                         $output .= '<td>
                         <button type="button" data="'.$row->id_combo.'" class=" btn btn-info btn-outline btn-circle btn-lg m-r-5 edit-row-btn" data-toggle="modal" data-target="#modal-add-cap"  data-toggle="tooltip" data-original-title="Editar" title ="Editar"><i class="ti-pencil-alt"></i></button>

                         <button type="button" data="'.$row->id_combo.'" class="btn btn-danger btn-outline btn-circle btn-lg m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button></td>
                        </tr>';
            endforeach ; 
        }
    
        echo $output;
    }

    /* cargar promociones*/
         function load_dataPromo()
    {
        $result = $this->modelogeneral->listar_data_promos();
        $count = 0;
        $output = '';
        if(!empty($result))
        {
          foreach($result as $row):
            $productos = $this->modelogeneral->listar_data_promo($row->id_promo);

            switch ($row->estado_promo) {
                case '1':
                    $estado_promo ='<span class="label label-success">activa</span>';
                    $checked ="checked";
                    break;
                case '0':
                    $estado_promo ='<span class="label label-danger">Inactiva</span>';
                    $checked ="";
                   break;
               
            }
             $output .= '<tr>
                         <td >
                          <label class="switch" title="activar/desactivar">
                              <input type="checkbox"  '.$checked.' name="estado_idpromo" class="estado_promo" value="'.$row->id_promo."*".$row->estado_promo.'">
                              <span class="slider round"></span>
                            </label>
                          </td>
                         <td><span class="font-medium">'.$row->nombre_promo.'</span></td>';
                         $output .= '<td>';
                         foreach($productos as $prod):

                            if ($prod->es_combo == 1){
                                $dato = $this->modelogeneral->datoscombo($prod->id_producto);
                                $output .= '<span class="text-muted">'.$dato->nombre_combo.'</br></span>';
                            } else {
                                $dato = $this->modelogeneral->datos_prod($prod->id_producto);
                                $output .= '<span class="text-muted">'.$dato->nombre_prod.'</br></span>';
                            }
                          endforeach ; 
                         $output .= '</td>';
                         $output .= '<td><span class="text-muted">'.$row->fecha_inicio.'</span></td>';
                         $output .= '<td><span class="text-muted">'.$row->fecha_fin.'</span></td>';
                         $output .= '<td><span class="text-muted">'.$row->descuento.'%</span></td>';
                         $output .= '<td>
                          <button type="button" data="'.$row->id_promo.'" class=" btn btn-info btn-outline btn-circle btn-lg m-r-5 edit-row-btn" data-toggle="modal" data-target="#modal-add-cap"  data-toggle="tooltip" data-original-title="Editar" title ="Editar"><i class="ti-pencil-alt"></i></button>
                         <button type="button" data="'.$row->id_promo.'" class="btn btn-danger btn-outline btn-circle btn-lg m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button></td>
                        </tr>';
            endforeach;
        }
    
        echo $output;
    }


    
   public function count_dataVentas(){

       $id_emp = $this->session->userdata('id_emp');
       $result = $this->modelogeneral->count_dataVentas($id_emp);
       $output = "";
       //var_dump($result);
        if (!empty($result['lista'])) {
             $output .= '<li>
                           <div class="drop-title">Agregar Costo de Envio '.$result['cantidad'].' </div>
                         </li>';
            foreach ($result['lista'] as $value):
              if($value){                                     
               
                 $output .= '<li>
                                <div class="message-center">
                                    <a>
                                        <div class="user-img"> 
                                        <img src="'.base_url().'assets/plugins/images/users/no_img.jpg" alt="Cliente" class="img-circle"> <span class="profile-status online pull-right"></span> </div>
                                        <div class="mail-contnet">
                                        <h5>No Compra:'.$value->no_compra.'</h5>
                                         <span class="mail-desc">$ '.$value->total_comp.'</span> <span class="time">'. $value->fecha.'</span>
                                        </div>
                                    </a>
                                </div>
                            </li>';
               
               }   
            endforeach;

            $output .= '<li>
                          <a class="text-center" href="'.base_url().'panel_admin/ventas"><strong>Solicitud de Compra </strong> <i class="fa fa-angle-right"></i> </a>
                            </li>';
    
        }
         
         $datos = array('output' => $output, 'cantidad' => $result['cantidad']);
        echo json_encode($datos); 
   }

    /*-------ventas-------*/
     
    function load_dataVentas()
    {
        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->listar_dataVentas($id_emp);
        $count = 0;
        $output = '';
        //var_dump($result);
        if(!empty($result))
        {
           
          foreach($result as $row):
             $estado     = "" ;
             $medio_pago = "" ;
             $confirmar_compra ="";
             $despachado = ''; 
             $disabled ="disabled";

             $productos = $this->modelogeneral->listar_productoxcompra($row->id_compra);

             
             $datos_emp = $this->modelogeneral->datos_emp($row->id_emp);
                switch ($row->collection_status) {

                        case '':
                                $estado = '<span class="label label-danger">Error</span>';
                                $disabled ="disabled";
                                break;

                        case 'pending':
                             $estado = '<span class="label label-warning">Pendiente</span>';
                             $disabled ="disabled";
                             break;
                     
                        case 'accepted':
                                $estado = '<span class="label label-info">Pago Aceptado</span>';
                                $disabled ="disabled";
                                break;       
                        
                        case 'approved':
                                $estado = '<span class="label label-success">Exito</span>';
                                $disabled =" ";
                                break;
								
						case 'rejected':
                                $estado = '<span class="label label-danger">Solicitud Rechazada</span>';
                              
                                break;		
                        
                        case 'in_mediation':
                                $estado = '<span class="label label-warning">En proceso</span>';
                                
                                break;
                        
                        case 'rejected':
                                $estado = '<span class="label label-danger">Rechazado</span>';
                               
                                break;
                        
                        case 'cancelled':
                                $estado = '<span class="label label-danger">Solicitud Cancelada</span>';
                               
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
                                $medio_pago = '<span class="text-info"> Pago a Empresa</span>';
                                break;

                       case 'solicitud_compra':
                                $medio_pago = '<span class="text-info"> Solicitud Compra</span>';
                                break;           
                        
                        case 'pago_transf':
                                $medio_pago = '<span class="text-primary"> Transferencia Bancaria</span>';

                                if ($row->fecha_pago == "0000-00-00") {
                                	$confirmar_compra = '<button type="button" data ="'.$row->id_compra.'" data-toggle="modal" data-target="" title="Confirmar Pago"
                            class="btn btn-success btn-outline btn-circle btn-lg estado" data-toggle="tooltip" data-original-title="Confirmar Pago"><i class="fa fa-check-circle-o"></i></button></td>';
                                }
                         break;
                        
                        case 'mercado_pago':
                                $medio_pago = '<span class="text-success"> Mercado Pago</span>';
                                break;

                        case 'pago_efectivo':
                                $medio_pago = '<span class="text-success"> Pago en Efectivo</span>';
                                break;          

                        } 
                switch ($row->despachado) {
                        
                        case 'pendiente':
                                $despachado = '<span class="label label-warning">Pendiente</span>';
                                
                                break;
                        
                        case 'despachado':
                                $despachado = '<span class="label label-success">Despachado</span>';
                                $disabled ="disabled";
                                break;
                        
                        }              

             $output .= '<tr>
             			 <td>
             			     <div class="checkbox checkbox-info" >
                                 <input type="checkbox" class="checkitem" '.$disabled.' name="" title="Marcar como despachado" id="" value="'.$row->id_compra.'">
                             <label for="checkbox7"></label>
                             </div>
                          
             			  </td>
                          <td>
                             <strong>'.$row->no_compra.'<strong>
                          </td>
                         <td>'.$row->fecha.'</td>';
                         $output .= '<td>'.$datos_emp->nombre_emp.' '.$datos_emp->apellido.'</td>';
                         $output .= '<td>';

                        
                         foreach($productos as $prod):

                            $nombre_prod = $this->modelogeneral->getdatos_prod_combo($prod->id_producto,$prod->es_combo);
                            $output .= $nombre_prod->nombre_prod.'</br>';
                          endforeach ; 

                         $output .= '</td>';
                         $output .= '<td>$ '.$row->total_comp.'</td>';
                         $output .= '<td>$ '.$row->precio_envio.'</td>';
                         $output .= '<td> <div class="row">'.$estado.'</div></td>';
                         $output .= '<td>'.$despachado.'</td>';
                         $output .= '<td>'.$medio_pago.'</td>';

                      if ($row->solic_enviada == 0) {
                         $confirmar_compra = '<button type="button" data ="'.$row->id_compra.'" data-toggle="modal" data-target="#confirmar_compra" title="Metodo Pago y Costo Envio"
                            class="btn btn-info btn-outline btn-circle btn-lg add_p_envio"  data-toggle="modal" data-target="#modal-add-cap"  data-toggle="tooltip" data-original-title="Confirmar Compra"><i class="ti-truck"></i></button></td>';
                        }
                      $output .= '<td>'. $confirmar_compra.'</td>';
                      $output .= '</tr>';
                         
            endforeach;
        }
    
        echo $output;
    }


     public function update_estadoPromo()
    {
        $param['id_promo']  = $this->input->get('id_promo');
        $estado_promo       = $this->input->get('estado_promo');

        if ($estado_promo == 1){

            $param['estado_promo'] = 0;
        }else{
             $param['estado_promo'] = 1;
        }

        $result =  $this->modelogeneral->update_promo($param);
        $msg['success'] = false;
       if($result){
            $msg['success'] = true;
        }
      echo json_encode($msg);

    }

       public function update_estadoCombo()
    {
        $param['id_combo']  = $this->input->get('id_combo');
        $estado_combo       = $this->input->get('estado_combo');

        if ($estado_combo == 1){

            $param['estado_combo'] = 0;
        }else{
             $param['estado_combo'] = 1;
        }
        $result =  $this->modelogeneral->update_combo($param);
        $msg['success'] = false;
       if($result){
            $msg['success'] = true;
        }
      echo json_encode($msg);

    }


       public function update_estadoEmp()
    {
        $param['id_emp']  = $this->input->get('id_emp');
        $status_cli       = $this->input->get('status_cli');

        if ($status_cli == 1){  // activo

            $param['status_cli'] = 0; //inactivo
        }else{
             $param['status_cli'] = 1;
        }
        $result =  $this->modelogeneral->update_perfil($param);
        $msg['success'] = false;
       if($result){
            $msg['success'] = true;
        }
      echo json_encode($msg);

    }



      public function update_estado()
    {
        $param['id_compra']         = $this->input->post('id_compra_pago');
        $param['fecha_pago']        = $this->input->post('fecha_pago');
        $param['collection_status'] = "approved";
        $result =  $this->modelogeneral->update_compra($param);
        $msg['success'] = false;
       if($result){
            $msg['success'] = true;
        }
      echo json_encode($msg);

    }

     public function update_estadoDespacho()
    {
    	$id_compra  = $this->input->get('id');
        for ($i=0; $i < count($id_compra); $i++) { 

        	$param['id_compra']    = $id_compra[$i];
            $param['despachado']   = "despachado";
            $result =  $this->modelogeneral->update_compra($param);
        }
        $msg['success'] = false;
       if($result){
            $msg['success'] = true;
        }
      echo json_encode($msg);

    }






function load_detallecomprasxConfirmar()
    {
        $id_emp        = $this->session->userdata('id_emp');
        $result        = $this->modelogeneral->show_compraspendientes($id_emp);
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


     public function add_p_envio()
    {
        $id_compra              = $this->input->post('id_compra');
        $datos_compra           = $this->modelogeneral->getdatosCompra($id_compra);
        
        $param['id_compra']     = $this->input->post('id_compra');
        $param['precio_envio']  = $this->input->post('precio_envio');
        $medio_pago             = $this->input->post('medio_pago');
        $param['solic_enviada']  = 1;
        $msg['comprobador'] = false;
         switch ($medio_pago)
           {
                case 'pago_transf':
                    $param['medio_pago'] = "pago_transf";
                    $result = $this->modelogeneral->update_compra($param);
                    $this->sendMailDatosTransferencia($id_compra);
                    $msg['comprobador'] = TRUE; 
                    break;

                case 'mercado_pago':
                     $param['medio_pago'] = "mercado_pago";
                     $result = $this->modelogeneral->update_compra($param);
                     $this->link_pago($id_compra);
                     $msg['comprobador'] = TRUE;
                    break;

                case 'pago_efectivo':
                     $param['medio_pago'] = "pago_efectivo";
                     $param['fecha_pago'] = date('Y-m-d');
                     $param['collection_status'] = "approved";
                     $result = $this->modelogeneral->update_compra($param);
                     $msg['comprobador'] = 'pago_efectivo';
                    break;
            }

        echo json_encode($msg);
    }

    public function link_pago($id_compra)
    {
        
       $config_tocken      = $this->modelogeneral->getAccesTocken();
       $access_token       = $config_tocken->valor;
       $id_emp             = $this->session->userdata('id_emp'); 
       $data['detalle']    = $this->modelogeneral->getDetalleCompra($id_compra);
       $data['compra']     = $this->modelogeneral->getdatosCompra($id_compra);
       $data['datos_hijo'] = $this->modelogeneral->datos_emp($data['compra']->id_emp);
       $admin              = $this->modelogeneral->datos_emp($id_emp);
       $email_destino      = $data['datos_hijo']->email; 
       // $cc                 =  $admin->email;
        $total_comp = floatval($data['compra']->total_comp + $data['compra']->precio_envio);
        $detalle = "";
        $description  = "";
        $importe_sinenvio = 0;
       foreach ($data['detalle'] as $key) :
        $importe_sinenvio += $key->importe;
        $detalle .=  $key->cantidad_comp." ".$key->nombre_prod.", Precio: ".$key->precio_comp.", ";
       endforeach;
        $detalle .=  " Importe Total: ".$importe_sinenvio."\r\n";
        $detalle .=  " + Costo de Envio: ".$data['compra']->precio_envio."\r\n";
        $description .=  strval($detalle);

        $data = array(
            'currency_id'      => 'ARS',
            'payer_email'      => $email_destino,
            'amount'           => $total_comp ,
            'description'      => $description,
            'concept_type'     => 'off_platform'
        );
         
        $payload = json_encode($data);
         
        // Prepare new cURL resource
        $ch = curl_init('https://api.mercadopago.com/money_requests?access_token='.$access_token);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
         
        // Set HTTP Header for POST request 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payload))
        );
         
        // Submit the POST request
        $result = curl_exec($ch);
         
        // Close cURL session handle
        curl_close($ch);

        $test = json_decode($result, true);
        $param['id_compra']          = $id_compra;
        $param['id_link_pago']       = $test['id'];
        $param['collection_status']  = $test["status"];
		$param['external_reference'] = $test["external_reference"];
         
        $result = $this->modelogeneral->update_compra($param);
        var_dump($test);

     }

      public function cron_pago()
    {
       //elimino todas las solicitudes de compras que esten null  en el collection_status
        $this->modelogeneral->eliminar_compraNull();
        //Recorro la tabla compra donde collection_status sea igual a pendiente y le saco el id_link_pago para actualizar el estado
       $config_tocken      = $this->modelogeneral->getAccesTocken();
       $access_token       = $config_tocken->valor;

       $result = $this->modelogeneral->getCompraspendientes();
       if($result != NULL){
          foreach ($result as $key) {
	         $id  =	$key->id_link_pago;
             if($id != NULL){
				 // Prepare new cURL resource
		        $ch = curl_init('https://api.mercadopago.com/money_requests/'.$id.'?access_token='.$access_token);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		        curl_setopt($ch, CURLINFO_HEADER_OUT, true);        
		         
		        // Set HTTP Header for POST request 
		        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		         
		        // Submit the POST request
		        $result = curl_exec($ch);
		         
		        // Close cURL session handle
		        curl_close($ch);

		        $test = json_decode($result, true);
		        $param['id_link_pago']       = $test['id'];
                $param['collection_status']  = $test["status"];

                if ($param['collection_status'] == "approved") {
                    $param['solic_enviada']  = 1;
                }
                
				$param['external_reference'] = $test["external_reference"];
                $result = $this->modelogeneral->update_pago_mercadoPago($param);
		        var_dump($test);
		        echo "<br>";
			 }
	       }
       }
       
     }
	 
	public function recive_ipn()
    {
	 require_once "/home/admindvg/public_html/emprendedores/sistema/mercado-pago/lib/mercadopago.php";
	 $mp = new MP ("7648711035353831", "bOJIZgeynb1zUBjRHEs87b4oeGZz9fBe");	
	 $params = ["access_token" => $mp->get_access_token()];
     $access_token = $mp->get_access_token();
	 
	 $id     = $_POST['id'];
	 $topic  = $_POST['topic'];
	 //$id     = "4299324572"; 
     //$topic  = "payment";
	 
	 $payment_info = $mp->get("/collections/notifications/" . $id, $params, false);
	 var_dump($payment_info);
	 
	  //**************************** Si es un pago *****************************
		if ($payment_info["status"] == 200) {
			if($topic == 'payment'){
			 $id_orden_optenida = $payment_info["response"]["collection"]["external_reference"];
              //Buscar en la base si hay una compra con esta referencia, en el caso de encontrarla actualizar el estado a pagado
              $result = $this->modelogeneral->buscar_referencia($id_orden_optenida);
              if($result){
				$id_compra = $result->id_compra;  
				$param['id_compra']          = $id_compra;  
				$param['collection_status']  = "approved";  
				$this->modelogeneral->update_compra($param);  
			  }else{
			    echo "No es de emprendedores ese pago";
			  }				  
			}
		}
	}



     public function sendMailDatosTransferencia($id_compra)
    {  
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }   
      $id_emp             = $this->session->userdata('id_emp'); 
      $data['detalle']    = $this->modelogeneral->getDetalleCompra($id_compra);
      $data['compra']     = $this->modelogeneral->getdatosCompra($id_compra);
      $data['datos_hijo'] = $this->modelogeneral->datos_emp($data['compra']->id_emp);

      $admin              = $this->modelogeneral->datos_emp($id_emp);
      $email_destino      = $data['datos_hijo']->email; 
      $cc                 =  $admin->email;
      $data['admin_asoc'] =  $admin->email;
     // $email_destino ="dalenag87@gmail.com";
      $cuerpo_mensaje = $this->load->view("emprendedor/notificacion_pago",$data,true);
      //cargamos la libreria email de ci
      $this->load->library("email");
      //configuracion para gmail
      $configGmail = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'consultas@dvigi.com.ar',
        'smtp_pass' => 'Agosto30',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
      );    
   
     //cargamos la configuración para enviar con gmail
      $this->email->initialize($configGmail);
   
      $this->email->from('consultas@dvigi.com.ar <consultas@dvigi.com.ar>', 'Emprendedores Dvigi');
      $this->email->to("$email_destino");
      $this->email->cc("$cc");
      $this->email->subject('Confirmación de Compra');
      $this->email->message($cuerpo_mensaje);
      $this->email->send();
      //con esto podemos ver el resultado
      //var_dump($this->email->print_debugger());
     // $this->load->view("emprendedor/notificacion_pago",$data);
    }



   /* Insertar combo*/
  
    public function insert_combo()
    {
        $param['nombre_combo']     = $this->input->post('nombre_combo');
        $param['url_imagen']       = $this->input->post('nombre_archivo');
        $param['precio_combo']     = $this->input->post('precio_combo');
        $param['costo']            = $this->input->post('costo');
        $param['existencia']       = $this->input->post('existencia');

        $result = $this->modelogeneral->insert_combo($param);
        $msg['comprobador'] = false;
        if($result)
             {
              $data['id_combo']   =  $this->modelogeneral->lastID();
              $data['productos']  = $this->input->post('productos');
              $data['cantidad']   = $this->input->post('cantidades');
              for ($i=0; $i < count($data['productos']); $i++) { 
		          $param_cp = array(
		              'id_producto' => $data['productos'][$i], 
		              'id_combo'    => $data['id_combo'],
		              'cantidad'    => $data['cantidad'][$i] 
		          );
		        $result = $this->modelogeneral->buscar_existe_comboProd($param_cp);
		    }
              $msg['comprobador'] = $result;
             }
        echo json_encode($msg);
    }

    protected function save_combo_prod($data){ 
		    for ($i=0; $i < count($data['productos']); $i++) { 
		        
		          $param = array(
		              'id_producto' => $data['productos'][$i], 
		              'id_combo'    => $data['id_combo'],
		              'cantidad'    => $data['cantidad'][$i] 
		          );
		        $result = $this->modelogeneral->buscar_existe_comboProd($param);
		       //$this->modelogeneral->save_combos($dato_combo);
		    return  $result;
		    }
    }


      public function update_combo()
    {
        $param['id_combo']         = $this->input->post('id_combo_edit'); 
        $param['nombre_combo']     = $this->input->post('nombre_combo');
        $param['url_imagen']       = $this->input->post('nombre_archivo');
        $param['precio_combo']     = $this->input->post('precio_combo');
        $param['costo']            = $this->input->post('costo');
        $param['existencia']       = $this->input->post('existencia');

        $result = $this->modelogeneral->update_combo($param);
        $msg['comprobador'] = false;
       
	    $data['id_combo']   = $this->input->post('id_combo_edit'); 
	    $data['productos']  = $this->input->post('productos');
	    $data['cantidad']   = $this->input->post('cantidades');
        for ($i=0; $i < count($data['productos']); $i++) { 
		          $param_cp = array(
		              'id_producto' => $data['productos'][$i], 
		              'id_combo'    => $data['id_combo'],
		              'cantidad'    => $data['cantidad'][$i] 
		          );
		        $result = $this->modelogeneral->buscar_existe_comboProd($param_cp);
		    }
              
            
        echo json_encode($result);
    }






        public function eliminar_comboProd()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_comboProd($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

    

      public function eliminar_combo()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_combo($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }

    

       public function eliminar_promo()
    {
        $id = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_promo($id);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
    }





 




     public function admin_capacitacion()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp); 
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");           
    $this->load->view("layout/header",$data);
    $this->load->view("admin_general/side_menuAdmin",$data);
    $this->load->view("admin_general/admin_capacitacion");
    $this->load->view("layout/footer");  
    }

     public function rango_comisiones()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp); 
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");           
    $this->load->view("layout/header",$data);
    $this->load->view("admin_general/side_menuAdmin",$data);
    $this->load->view("admin_general/rango_comisiones");
    $this->load->view("layout/footer");  
    } 

     public function configuracion_parametros()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'administrador') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp); 
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");           
    $this->load->view("layout/header",$data);
    $this->load->view("admin_general/side_menuAdmin",$data);
    $this->load->view("admin_general/configuraciones");
    $this->load->view("layout/footer");  
    } 


/*-----------------------------------------------------------*/



}