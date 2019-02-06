<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class General extends CI_Controller
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
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }
     $id_emp = $this->session->userdata('id_emp');
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp); 
     $data['total_emp']  = $this->modelogeneral->Total_emp("emprendedor");
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");       
     
     $this->load->view("layout/header",$data);
     $this->load->view("general/side_menu",$data);
     $this->load->view("general/page_inicioGeneral",$data);
     $this->load->view("layout/footer");  
    }

    public function getDataConsumo(){
        if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }   
        $year     = $this->input->post("year");
        $resultados = $this->modelogeneral->montos_consumoGeneral($year);
        echo json_encode($resultados);
    }


     public function administradores()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }
     $id_emp = $this->session->userdata('id_emp');
     $data['datos_emp']      = $this->modelogeneral->datos_emp($id_emp); 
     $data['total_emp']      = $this->modelogeneral->Total_emp("emprendedor");
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion"); 
     $data['paices']         = $this->modelogeneral->mostrar_paices(); 
           
     
     $this->load->view("layout/header",$data);
     $this->load->view("general/side_menu",$data);
     $this->load->view("general/administradores",$data);
     $this->load->view("layout/footer");  
    }

   
    
     public function perfil()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }   
     $id_emp = $this->session->userdata('id_emp');
     $data['cant_asoc']  = $this->modelogeneral->rowCountAsoc($id_emp);
     $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
     $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");  
    
      $this->load->view("layout/header",$data);
      $this->load->view("general/side_menu",$data);
      $this->load->view("layout/perfil",$data);
      $this->load->view("layout/footer");  
    }


        function load_data_admin_gls()
    {
        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->mostrar_empAdmin($id_emp);
        $year = date('Y');
        $mes  =  date('m');
        $count = 0;
        $output = '';
        if(!empty($result))
        {
            foreach($result as $row)
              
            {
             $output .= '<tr>
                               <td>
                                 <span class="font-medium">'.$row->nombre_emp.'</span>
                                </td>
                                <td>
                                <span class="text-muted">'.$row->email.'</span>
                                </td>
                                <td>'.$row->telefono_emp.'</td>
                                 <td>'.$row->nombre.'</td>
                                <td>
                                <button type="button" data="'.$row->id_emp.'" class=" btn btn-info btn-outline btn-circle btn-lg m-r-5 edit-row-btn"  data-toggle="tooltip" data-original-title="Editar" title ="Editar"><i class="ti-pencil-alt"></i></button>
                                <button type="button" data="'.$row->id_emp.'" class="btn btn-danger btn-outline btn-circle btn-lg m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button></td> 
                         </tr>';
            }        
        }
    
        echo $output;
    }


    

    function load_dataemp()
    {
        $id_emp = $this->session->userdata('id_emp');
        $result = $this->modelogeneral->mostrar_emp($id_emp);
         $year = date('Y');
         $mes  =  date('m');

        $count = 0;
        $output = '';
        if(!empty($result))
        {
            foreach($result as $row)
              
            {
                
                $data = array('mes' =>$mes,'year' =>$year, 'id_emp' =>$row->id_emp);
                $row_monto     = $this->modelogeneral->montos_mes($data); 
                $m_acumulado   = $this->modelogeneral->compras_acumuladas($data); 
                $cant_clientes = $this->modelogeneral->Count_Cli($row->id_emp); 
                $cant_cli_venc = $this->modelogeneral->cant_cli_venc($row->id_emp); 
                
                
                
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

                

                 switch ($row->estado) {
                            case '0':
                                $estado = '<span class="label label-warning">Invitación enviada</span>';
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
                 
                  
                $output .= '<tr>
                               <td>
                                 <span class="font-medium">'.$row->nombre_emp.'</span>
                                  <br/><span class="text-muted">'.$row->email.'</span>
                                  <br/><span class="text-muted">'.$row->telefono_emp.'</span>
                                </td>
                               <td>
                                    <div class="checkbox checkbox-success">
                                                <input id="checkbox'.$row->id_emp.'"  '.$desabled.'  type="checkbox" '.$firmo.' value="'.$row->id_emp.'" class="firmo">
                                                <label for="checkbox'.$row->id_emp.'" ><span id="span'.$row->id_emp.'"></span></label>
                                     </div>
                                </td>
                              <td>$'.$monto.'</td>
                              <td>$'.$m_acumulado.'</td>

                              <td><button type="button" data="'.$row->id_emp.'" class="btn btn-info btn-outline btn-circle btn-lg m-r-5 mostrar-asoc" data-toggle="modal" data-target="#detallepatocinados"  data-toggle="tooltip" data-original-title="Ver Patrocinados" title ="Ver Patrocinados"><i class="ti-eye"></i></button></td>
                             <td>
                                    '.$estado.'
                              </td>
                              
                              <td>'.$cant_clientes.'</td>
                             <td>'.$cant_cli_venc.'</td>
                            </tr>';
            }
        }
    
        echo $output;
    }

    function load_listaPatrocinados()
    {
        $id_emp = $this->input->post('id_emp');
        $result = $this->modelogeneral->mostrar_adminGenerales($id_emp);
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
        $id_emp = $this->input->get('id_emp');
        $param = array('id_emp' => $id_emp,'firmo_contrato' =>1);
        $result  = $this->modelogeneral->update_perfil($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = "FIRMO";
             }
        echo json_encode($msg);
    }
   
     
      public function eliminar_emp()
    {
        $id_emp = $this->input->get('id_emp');
        $result  = $this->modelogeneral->eliminar_emp($id_emp);
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
        $param['fecha_insc']   = date('Y-m-d');
        $data['id_hijo']       = $this->modelogeneral->insert_emp($param);
        $data['id_padre']      = $this->session->userdata('id_emp');
        $nombre                = $this->session->userdata('nombre');
        
        $asunto = $nombre." te invita";
        $cuerpo_mensaje = "Hola te invito a que formes parte de nuestro negocio como emprendedor";
        $url = base_url()."registro_asociado?id=".$data['id_hijo'];
        $cuerpo_mensaje .= "<a href='".$url."' target='_blank'>Completar Registro</a>";
        //$this->sendMailMandril($param['email'],$asunto, $cuerpo_mensaje);
        $this->sendMailGmail($param['email'],$asunto, $cuerpo_mensaje,$id_emp);
       
        $result = $this->modelogeneral->insert_emp_asoc($data);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
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
                         <td><span class="text-muted">'.$row->url_video.'</span></td>
                        <td><span class="text-muted">'.$row->evaluacion.'</span></td>';
                        $output .= '<td>

                        <button type="button" data="'.$row->id_cap.'" class=" btn btn-info btn-outline btn-circle btn-lg m-r-5 edit-row-btn collapseble"  data-toggle="tooltip" data-original-title="Editar" title ="Editar"><i class="ti-pencil-alt"></i></button>
                        <button type="button" data="'.$row->id_cap.'" class="btn btn-danger btn-outline btn-circle btn-lg m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button></td>
                        </tr>';

                        
                        
            }
        }
    
        echo $output;
    }
    /* Insertar videos*/
    public function insert_cap()
    {
       
        $param['titulo_video']   = $this->input->post('titulo_video');
        $param['descripcion']    = $this->input->post('descripcion');
        $param['imag_portada']   = $this->input->post('nombre_archivo');
        $param['url_video']      = $this->input->post('url_video');
       // $param['doc']            = $this->input->post('nombre_doc_eva');
        $param['evaluacion']     = $this->input->post('evaluacion');
        
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

       public function eliminar_admin()
    {
        $id_emp = $this->input->get('id');
        $result  = $this->modelogeneral->eliminar_admin($id_emp);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
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
      public function getdatos_cap()
    {
        $id_cap = $this->input->get('id');
        $result  = $this->modelogeneral->getdatos_cap($id_cap);
        echo json_encode($result);
    }

      public function getdatos_prod()
    {
        $id_producto = $this->input->get('id');
        $result  = $this->modelogeneral->getdatos_prod($id_producto);
        echo json_encode($result);
    }



    

    

     public function update_cap()
    {
        $param['id_cap']         = $this->input->post('id_cap');
        $param['titulo_video']   = $this->input->post('titulo_video');
        $param['descripcion']    = $this->input->post('descripcion');
        $param['imag_portada']   = $this->input->post('nombre_archivo');
        $param['url_video']      = $this->input->post('url_video');
       // $param['doc']            = $this->input->post('nombre_doc_eva');
        $param['evaluacion']     = $this->input->post('evaluacion');
        
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
                         <td><span class="text-muted">'.$row->precio.'</span></td>
                         <td><span class="text-muted">'.$row->costo.'</span></td>
                         <td><span class="text-muted">'.$margen.'</span></td>
                         <td>';
                $output .= '<button type="button" data="'.$row->id_producto.'" class=" btn btn-info btn-outline btn-circle btn-lg m-r-5 edit-row-btn collapseble"  data-toggle="tooltip" data-original-title="Editar" title ="Editar"><i class="ti-pencil-alt"></i></button>';
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
        echo json_encode($param);
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


   public function getdatos_emp()
    {
        $id      = $this->input->get('id');
        $result  = $this->modelogeneral->getdatos_emp($id);
        echo json_encode($result);
    }

        public function update_emp()
    {
        $param['id_emp']       = $this->input->post('id_emp');
        $param['nombre_emp']   = $this->input->post('nombre_emp');
        $param['email']        = $this->input->post('email');
        $param['dni_emp']      = $this->input->post('dni_emp');
        $param['id_pais']      = $this->input->post('id_pais');
        $param['telefono_emp'] = $this->input->post('telefono_emp');
        $result = $this->modelogeneral->update_perfil($param);
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
    public function insert_administrador()
    {
      
        $param['nombre_emp']     = $this->input->post('nombre_emp');
        $param['email']          = $this->input->post('email');
        $param['password']       = md5($this->input->post('confirm_password'));
        $param['dni_emp']        = $this->input->post('dni_emp');
        $param['telefono_emp']   = $this->input->post('telefono_emp');
        $param['perfil']         = "administrador";
        $param['foto_emp']       = "no_img.jpg";
        $param['firmo_contrato'] = 1;
        $param['id_pais']        = $this->input->post('id_pais');
        $result                  = $this->modelogeneral->insert_emp_admin($param);
        $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
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
         $msg['email']    = $this->input->post('email_rest');
         $msg['password'] = '1234';
          

         /*$result = $this->modelogeneral->comprobar_email($email,$password);
        
         $msg['comprobador'] = false;
        if($result)
             {
               $msg['comprobador'] = TRUE;
               $asunto = "Olvidó su contraseña";
               $cuerpo_mensaje = "Nueva Contraseña es :".$pass;
               $url = base_url()."login";
               $cuerpo_mensaje .= "<a href='".$url."' target='_blank'> Ingresar</a>";
              $this->sendMailMandril($email,$asunto, $cuerpo_mensaje);
             }*/
       
        echo json_encode($msg);
    }
    public function sendMailMandril($email_destino,$asunto, $cuerpo_mensaje)
    {       
        //cargamos la libreria email de ci
        $this->load->library("email");
 
        //configuracion para gmail
        $configGmail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.mandrillapp.com',
            'smtp_port' => 587,
            'smtp_user' => 'administracion@dvigi.com.ar',
            'smtp_pass' => 'nt6mBSRsBN-LM9m0y5Lkcw',
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );    
 
        //cargamos la configuración para enviar con gmail
        $this->email->initialize($configGmail);
 
        $this->email->from('emprendedores@dvigi.com.ar', 'DVIGI tu agua pura');
        $this->email->to("$email_destino");
        $this->email->subject("$asunto");
        $this->email->message('<h2>Email enviado desde el Sistema DVIGI</h2><hr></br>'.  $cuerpo_mensaje);
        $this->email->send();
        //con esto podemos ver el resultado
        //var_dump($this->email->print_debugger());
        //print_r('entro');die();
    }

    public function sendMailGmail($email_destino,$asunto, $cuerpo_mensaje)
    {   
      //cargamos la libreria email de ci
      $this->load->library("email");

      //$cuerpo_mensaje ="PRUEBA";
     // $email_destino ="dalenag87@gmail.com";
   
      //configuracion para gmail
      $configGmail = array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.gmail.com',
        'smtp_port' => 465,
        'smtp_user' => 'emprendedores@dvigi.com.ar',
        'smtp_pass' => 'veronica',
        'mailtype' => 'html',
        'charset' => 'utf-8',
        'newline' => "\r\n"
      );    
   
      //cargamos la configuración para enviar con gmail
      $this->email->initialize($configGmail);
   
      $this->email->from('emprendedores@dvigi.com.ar <emprendedores@dvigi.com.ar>', 'Notificaciones Dvigi');
      $this->email->to("$email_destino");
      $this->email->subject('Emprendedores Dvigi');
      $this->email->message('<h2>Email enviado desde el Sistema Dvigi ,</h2><hr></br>'.  $cuerpo_mensaje);
      $this->email->send();
      //con esto podemos ver el resultado
      //var_dump($this->email->print_debugger());
    }

    public function admin_prod()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
    $data['categorias']  = $this->modelogeneral->listar_categorias_prod(); 
    $data['respuestos']  = $this->modelogeneral->selec_respuestos_prod(); 
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");   

    $this->load->view("layout/header",$data);
    $this->load->view("general/side_menu",$data);
    $this->load->view("admin_general/admin_productos",$data);
    $this->load->view("layout/footer");  
    }

    public function admin_promo()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
   // $data['categorias']  = $this->modelogeneral->selec_categorias_prod();
    $data['productos']      = $this->modelogeneral->seleccion_productos();
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");  

    $this->load->view("layout/header",$data);
    $this->load->view("general/side_menu",$data);
    $this->load->view("admin_general/admin_promos",$data);
    $this->load->view("layout/footer");  
    }

       public function ventas()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
   // $data['categorias']  = $this->modelogeneral->selec_categorias_prod();
    $data['productos']      = $this->modelogeneral->seleccion_productos();
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");  

    $this->load->view("layout/header",$data);
    $this->load->view("general/side_menu",$data);
    $this->load->view("admin_general/admin_ventas",$data);
    $this->load->view("layout/footer");  
    }

     public function insert_promo()
    {
      if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        } 

        $param['nombre_promo']     = $this->input->post('nombre_promo');
        $param['fecha_inicio']     = $this->input->post('fecha_inicio');
        $param['fecha_fin']        = $this->input->post('fecha_fin');
        $param['descuento']        = $this->input->post('descuento');
        $msg['comprobador'] = false;
        
        if($this->modelogeneral->save_Promo($param)){
              $data['id_promo'] =  $this->modelogeneral->lastID();
              $data['productos']  = $this->input->post('productos');
              $this->save_detallePromo($data);
           $msg['comprobador'] = TRUE;
           } 
       echo json_encode($param);
    }
   protected function save_detallePromo($data){ 
    for ($i=0; $i < count($data['productos']); $i++) { 
      
          $dato_promo = array(
              'id_producto' => $data['productos'][$i], 
              'id_promo'    => $data['id_promo']
          );
       $this->modelogeneral->save_detallePromo($dato_promo);
    
    }
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
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp);
    $data['productos']  = $this->modelogeneral->seleccion_productos();
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");    


    $this->load->view("layout/header",$data);
    $this->load->view("general/side_menu",$data);
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
                $output .= '<tr>
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
                         $output .= '<td><button type="button" data="'.$row->id_combo.'" class="btn btn-danger btn-outline btn-circle btn-lg m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button></td>
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
            $productos = $this->modelogeneral->prod_promo($row->id_promo);
             $output .= '<tr>
                         <td><span class="font-medium">'.$row->nombre_promo.'</span></td>';
                         $output .= '<td>';
                         foreach($productos as $prod):
                          $output .= '<span class="text-muted">'.$prod->nombre_prod.'</br></span>';
                          endforeach ; 
                         $output .= '</td>';
                         $output .= '<td><span class="text-muted">'.$row->fecha_inicio.'</span></td>';
                         $output .= '<td><span class="text-muted">'.$row->fecha_fin.'</span></td>';
                         $output .= '<td><span class="text-muted">'.$row->descuento.'</span></td>';
                         $output .= '<td><button type="button" data="'.$row->id_promo.'" class="btn btn-danger btn-outline btn-circle btn-lg m-r-5 deletecap-row-btn"  data-toggle="tooltip" data-original-title="Eliminar" title ="Eliminar"><i class="icon-trash"></i></button></td>
                        </tr>';
            endforeach;
        }
    
        echo $output;
    }

    /*-------ventas-------*/

     /* cargar promociones*/
         function load_dataVentas()
    {
        $result = $this->modelogeneral->listar_dataVentas();
        $count = 0;
        $output = '';
        if(!empty($result))
        {
           
          foreach($result as $row):
             $estado = '';
            
             $productos = $this->modelogeneral->listar_productoxcompra($row->id_compra);
             $datos_emp = $this->modelogeneral->datos_emp($row->id_emp);
             $output .= '<tr>
                         <td>'.$row->fecha.'</td>';
                         $output .= '<td>'.$datos_emp->nombre_emp.'</td>';
                         $output .= '<td>';
                         foreach($productos as $prod):
                          $output .= $prod->nombre_prod.'</br>';
                          endforeach ; 
                         $output .= '</td>';
                       
                         $output .= '<td>'.$row->total_comp.'</td>';
                         
                        
                         /*success
                            pending
                            failure
                            */

                         switch ($row->collection_status) {

                            case 'pending':
                                    $estado = '<span class="label label-warning">Invitación enviada</span>';
                                    break;
                            
                            case 'approved':
                                    $estado = '<span class="label label-success">exito</span>';
                                    break;
                            
                            case 'in_mediation':
                                    $estado = '<span class="label label-warning">en proceso</span>';
                                    break;
                            
                            case 'rejected':
                                    $estado = '<span class="label label-danger">rechazado</span>';
                                    break;
                            
                            case 'cancelled':
                                    $estado = '<span class="label label-danger">cancelado</span>';
                                    break;
                            
                            case 'refunded':
                                    $estado = '<span class="label label-warning">reintegrado</span>';
                                    break;
                            
                            case 'charged_back':
                                    $estado = '<span class="label label-warning">cargado de vuelta</span>';
                                    break;
                        } 
                        $output .= '<td>'.$estado.'</td>';
                        $despachado = ''; 

                      switch ($row->despachado) {
                        
                        case 'pendiente':
                                $despachado = '<span class="label label-warning">pendiente</span>';
                                break;
                        
                        case 'despachado':
                                $despachado = '<span class="label label-success">exito</span>';
                                break;
                        
                        } 
                      $output .= '<td>'.$despachado.'</td></tr>';
                         

                         
                        
            endforeach;
        }
    
        echo $output;
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

              $this->save_combo_prod($data);
              $msg['comprobador'] = TRUE;
             }
        echo json_encode($data);
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



    protected function save_combo_prod($data){ 
    for ($i=0; $i < count($data['productos']); $i++) { 
      
          $dato_combo = array(
              'id_producto' => $data['productos'][$i], 
              'id_combo'    => $data['id_combo'],
              'cantidad'    => $data['cantidad'][$i] 
          );
        
        $this->modelogeneral->save_combos($dato_combo);
    
    }
}




     public function admin_capacitacion()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp); 
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");           
    $this->load->view("layout/header",$data);
    $this->load->view("general/side_menu",$data);
    $this->load->view("admin_general/admin_capacitacion");
    $this->load->view("layout/footer");  
    }

     public function rango_comisiones()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp); 
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");           
    $this->load->view("layout/header",$data);
    $this->load->view("general/side_menu",$data);
    $this->load->view("admin_general/rango_comisiones");
    $this->load->view("layout/footer");  
    } 

     public function configuracion_parametros()
    {
    if ($this->session->userdata('perfil') == false || $this->session->userdata('perfil') != 'super_admin') {
            redirect(base_url() . 'login');
        }
    $id_emp = $this->session->userdata('id_emp');
    $data['datos_emp']  = $this->modelogeneral->datos_emp($id_emp); 
    $data['cantidadVideos'] = $this->modelogeneral->rowCount("capacitacion");           
    $this->load->view("layout/header",$data);
    $this->load->view("general/side_menu",$data);
    $this->load->view("admin_general/configuraciones");
    $this->load->view("layout/footer");  
    } 


/*-----------------------------------------------------------*/



}