<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('Login_model');
		$this->load->model('modelogeneral');
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->database();
    }
	
	public function index()
	{	
		$this->output->set_header('Expires: Sat, 26 Jul 2000 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');
      	switch ($this->session->userdata('perfil')) {
			case '':
				$data['token'] = $this->token();
				$this->load->view('layout/login',$data);
				break;
			case 'super_admin':
			    redirect(base_url().'general');
				break;	
			case 'administrador':
			    redirect(base_url().'panel_admin');
				break;
			case 'emprendedor':
			    redirect(base_url().'capacitacion');
				break;
					
		    default:		
				$data['token'] = $this->token();
				$this->load->view('layout/login',$data);
				break;		
		}
	}
	
	public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token',$token);
		return $token;
	}


	public function emp_bloqueado()
	{
 	$data['token'] = $this->token();
 	 $this->load->view('layout/emp_bloqueado',$data);
		
	}
	
	public function new_user()
	{
		$this->output->set_header('Expires: Sat, 26 Jul 2000 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');

		if($this->input->post('token') == $this->session->userdata('token'))
		{
			    $email      = $this->input->post('email');
				$password   = md5($this->input->post('password'));
				$check_user = $this->Login_model->login_user($email,$password);

				if ($check_user->firmo_contrato == 1) {
					 $data = array(
						'is_logued_in' 	      =>  TRUE,
	                    'perfil'		      =>  $check_user->perfil,
		                'email' 		      =>  $check_user->email,
		                'id_emp' 	          =>  $check_user->id_emp,
		                'nombre' 	          =>  $check_user->nombre_emp,
		                );
				
				$this->session->set_userdata($data);
				$this->index();
				}else{
                      redirect(base_url().'login/emp_bloqueado');
       				 }

				

            $this->form_validation->set_rules('email', 'Correo', 'required|trim|min_length[2]|max_length[150]');
            $this->form_validation->set_rules('password', 'Contraseña', 'required|trim|min_length[6]|max_length[150]');
 
            //lanzamos mensajes de error si es que los hay
            $this->form_validation->set_message('required', 'El %s es requerido');
            $this->form_validation->set_message('min_length', 'El %s debe tener al menos %s carácteres');
            $this->form_validation->set_message('max_length', 'El %s debe tener al menos %s carácteres');
			if($this->form_validation->run() == FALSE)
			{
			    $this->index();
			}

		}else{
			redirect(base_url().'login');
		}
	}

	public function salir()
	{
		$this->output->set_header('Expires: Sat, 26 Jul 2000 05:00:00 GMT');
        $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
        $this->output->set_header('Pragma: no-cache');

		$this->session->sess_destroy();
		redirect(base_url());
	}
	
	public function reg_asociado(){

		$result = $this->modelogeneral->exitencia_emp($_GET['id']);
		if ($result) {
			$data['token']     = $this->token();
		    $data['id_emp']    = $_GET['id'];
		    $this->load->view('layout/registro_asoc',$data);
		}else{

			$this->load->view("layout/invitacion_anulada");
		}
		
		
	}

	public function reset_pass(){

		$data['token']     = $this->token();
        $data['id_emp']    = $_GET['id'];
		//$this->formulariocambiar_pass($data);
		 $this->load->view('layout/cambiar_pass',$data);
	}

	public function cambio_pass(){
	  $data['token']     = $this->token();
      $this->load->view('layout/pantalla_cambiopass.php',$data);
	}


	public function change_pass(){

		$param['password'] = md5($this->input->post('confir_password'));
		$param['id_emp'] = $this->input->post('id_emp');
		$result = $this->modelogeneral->udpate_emp($param);
		$datos['result'] = $this->modelogeneral->datos_emp($param['id_emp']);
        $datos['confir_password'] = $this->input->post('confir_password');
        $this->sendMailGmailCambioPass($datos);
		redirect(base_url()."login");
	}

	

	public function update_registro(){

		if($this->input->post('token') == $this->session->userdata('token'))

		{
			 $param['id_emp']       = $this->input->post('id_emp');
			 $param['nombre_emp']   = $this->input->post('nombre_emp');
			 $param['apellido']     = $this->input->post('apellido');
			 $param['foto_emp']     = $this->input->post('nombre_archivo');//= 'no_img.jpg';
			 $param['dni_emp']      = $this->input->post('dni_emp');
			 $param['telefono_emp'] = $this->input->post('telefono_emp');
             $param['fecha_insc']   = date('Y-m-d');
             $param['password']     = md5($this->input->post('confir_password'));
		     $param['estado']       = 1;
		     $result = $this->modelogeneral->udpate_empInv($param);
             $msg['comprobador'] = false;
             if($result)
             { 
               $datos['result'] = $this->modelogeneral->datos_emp($param['id_emp']);
              // $this->ingreso($param);
               $msg['comprobador'] = TRUE;
               $datos['confir_password'] = $this->input->post('confir_password');
               $this->sendMailGmail($datos);
                redirect(base_url() . 'login');
               
             }else{

             	$this->load->view("layout/invitacion_anulada"); 

             }
           
         }
	}

	

	public function sendMailGmailCambioPass($datos)
    {   
      //cargamos la libreria email de ci
      $this->load->library("email");
   
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

     $cuerpo_mensaje = $this->load->view("layout/notif_CambioPasscompletado",$datos,true); 
   
      //cargamos la configuración para enviar con gmail
      $this->email->initialize($configGmail);
      $email_destino =  $datos['result']->email;
      $this->email->from('emprendedores@dvigi.com.ar <emprendedores@dvigi.com.ar>', 'Emprendedores Dvigi');
      $this->email->to("$email_destino");
      $this->email->subject('Cambio de contraseña');
      $this->email->message($cuerpo_mensaje);
      $this->email->send();

    }

	public function sendMailGmail($datos)
    {   
      //cargamos la libreria email de ci
      $this->load->library("email");
   
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

     $cuerpo_mensaje = $this->load->view("layout/notificacion_regCompletado",$datos,true); 
   
      //cargamos la configuración para enviar con gmail
      $this->email->initialize($configGmail);
      $email_destino =  $datos['result']->email;
      $this->email->from('emprendedores@dvigi.com.ar <emprendedores@dvigi.com.ar>', 'Emprendedores Dvigi');
      $this->email->to("$email_destino");
      $this->email->subject('Registro Completado');
      $this->email->message($cuerpo_mensaje);
      $this->email->send();
      //con esto podemos ver el resultado
      //var_dump($this->email->print_debugger());*/
    }




	public function ingreso($param)
    {

     $check_user = $this->Login_model->login_user($param['email']->email ,$param['password']);
	  if($check_user == TRUE)
	   {
	    $data = array(
						'is_logued_in' 	      =>  TRUE,
	                    'perfil'		      =>  $check_user->perfil,
		                'email' 		      =>  $check_user->email,
		                'id_emp' 	          =>  $check_user->id_emp,
		                'nombre' 	          =>  $check_user->nombre_emp,
		                );
				
		 $this->session->set_userdata($data);	
         $id_emp = $this->session->userdata('id_emp'); 

	     $this->index();
	  }   

    }


	public function n_registro(){

		if($this->input->post('token') == $this->session->userdata('token'))
		{
			 $param['nombre_emp']   = $this->input->post('nombre_emp');
			 $param['foto_emp']     = 'no_img.jpg';
			 $param['email']        = $this->input->post('email');	
			 $param['dni_emp']      = $this->input->post('dni_emp');
			 $param['telefono_emp'] = $this->input->post('telefono_emp');
             $param['fecha_insc']   = date('Y-m-d');
             $param['password']     = md5($this->input->post('confir_password'));
		     $param['estado']      = 1;
		     $data['id_hijo']      = $this->modelogeneral->insert_emp($param);	
		     $data['id_padre']     = 1;
             $result               = $this->modelogeneral->insert_emp_asoc($data);
             $msg['comprobador'] = false;
             if($result)
             { 
              
              $this->ingreso($param);
               $msg['comprobador'] = TRUE;
             }
        echo json_encode($msg);
         }
	}

	
	
	

}
