<?php
class Modelogeneral extends CI_Model {
  
  private $hijos = array();
  private $hijos_mes = array();
  private $hijos_ventasmes = array();
  private $hijos_clientes_fmes = array();
  
  
  
  public function __construct() {
      parent::__construct();
      $this->load->database();         
   }
   
   public function insert_ipn($data)
  {
    $this->db->where('id_order',$data['id_order']);
    $query = $this->db->get('ipn_orders');
    if($query->num_rows() > 0){
       return;
    }else{
         $this->db->insert('ipn_orders',$data);
        return;  
     }
  }

   public function update_ipn($data)
  {
    $this->db->where('id_order',$data['id_order']);    
    $this->db->update('ipn_orders',$data);
   if($this->db->affected_rows() > 0){
      return true;
       }else{
             return true;
            }
  } 

  public function listar_ipn_orders(){
    $this->db->where("status","pending");
    $resultados = $this->db->get("ipn_orders");
    return $resultados->result();
  }  
   
   
   public function insert_emp($data)
  {
     $this->db->where('email', $data['email']);
     $query = $this->db->get('emprendedor');
      if($query->num_rows() > 0){
        $msg ="existe";
        return $msg;
      }else{
         $this->db->insert('emprendedor',$data);
         return $this->db->insert_id();
      }
     
  }

   public function selec_maxorden_visual()
  {
     $this->db->select_max('orden_visual');
     $query = $this->db->get('capacitacion');
     return  $query-> row();
     
  }

   public function insert_emp_admin($data)
  {
      $this->db->insert('emprendedor',$data);
      
  }


  public function insert_emp_asoc($data)
  {
      $this->db->insert('emp_asoc',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }

 public function montos_mes($data){
   
    $this->db->select("SUM(total_comp) as monto");
    $this->db->where("MONTH(fecha_comp)",$data['mes']);
    $this->db->where("YEAR(fecha_comp)",$data['year']);
    $this->db->from("compra");
    $this->db->where("id_emp",$data['id_emp']);
    $resultados = $this->db->get();
    return $resultados->row();
  }

// consumo mensual
 public function montos_consumo($year,$id_emp){
    $this->db->select("MONTH(fecha_comp) as mes, SUM(dc.importe) as monto");
    $this->db->from("detalle_compra dc");
    $this->db->join("compra c","dc.id_compra = c.id_compra");
    $this->db->where("fecha_comp >=",$year."-01-01");
    $this->db->where("fecha_comp <=",$year."-12-31");
    $this->db->where("c.id_emp",$id_emp);
    $this->db->group_by("mes");
    $this->db->order_by("mes");
    $resultados = $this->db->get();
    return $resultados->result();
  }

  public function montos_consumoGeneral($year){
    $this->db->select("MONTH(fecha_comp) as mes, SUM(dc.importe) as monto");
    $this->db->from("detalle_compra dc");
    $this->db->join("compra c","dc.id_compra = c.id_compra");
    $this->db->where("fecha_comp >=",$year."-01-01");
    $this->db->where("fecha_comp <=",$year."-12-31");
    $this->db->where("c.collection_status","approved");
    $this->db->group_by("mes");
    $this->db->order_by("mes");
    $resultados = $this->db->get();
    return $resultados->result();
  }

  // consumo anual general
 public function montos_consumoAnual_general($year){
    $this->db->select("MONTH(fecha_solicitud) as mes, SUM(dp.importe) as monto");
    $this->db->from("detalle_pedido dp");
    $this->db->join("pedidos p","dp.id_pedidos = p.id_pedidos");
    $this->db->where("fecha_solicitud >=",$year."-01-01");
    $this->db->where("fecha_solicitud <=",$year."-12-31");
    $this->db->group_by("mes");
    $this->db->order_by("mes");
    $resultados = $this->db->get();
    return $resultados->result();
  } 




// consumo anual
 public function montos_consumoAnual_pedidos($year,$id_emp){
    $this->db->select("MONTH(fecha_solicitud) as mes, SUM(dp.importe) as monto");
    $this->db->from("detalle_pedido dp");
    $this->db->join("pedidos p","dp.id_pedidos = p.id_pedidos");
    $this->db->where("fecha_solicitud >=",$year."-01-01");
    $this->db->where("fecha_solicitud <=",$year."-12-31");
    $this->db->where("p.id_emp",$id_emp);
    $this->db->group_by("mes");
    $this->db->order_by("mes");
    $resultados = $this->db->get();
    return $resultados->result();
  } 



// consumo semanal
 public function montos_consumo_semanal($year,$id_emp){
	$fecha_final =  date('Y-m-d');
	$fecha_inicio = date('Y-m-d', strtotime("$fecha_final - 7 day"));
	
    $this->db->select("DAY(fecha_solicitud) as dia, SUM(dp.importe) as monto");
    $this->db->from("detalle_pedido dp");
    $this->db->join("pedidos p","dp.id_pedidos = p.id_pedidos");
    $this->db->where("fecha_solicitud >",$fecha_inicio);
    $this->db->where("fecha_solicitud <=",$fecha_final);
    $this->db->where("p.id_emp",$id_emp);
    $this->db->group_by("dia");
    $this->db->order_by("dia");
    $resultados = $this->db->get();
    return $resultados->result();
  }    

// consumo mensual
 public function montos_consumoMensual_pedidos($year,$id_emp){
    $mes = date('m');
    $this->db->select("DAY(fecha_solicitud) as dia, SUM(dp.importe) as monto");
    $this->db->from("detalle_pedido dp");
    $this->db->join("pedidos p","dp.id_pedidos = p.id_pedidos");
    $this->db->where("fecha_solicitud >=",$year."-".$mes."-01");
    $this->db->where("fecha_solicitud <=",$year."-".$mes."-31");
    $this->db->where("p.id_emp",$id_emp);
    $this->db->group_by("dia");
    $this->db->order_by("dia");
    $resultados = $this->db->get();
    return $resultados->result();
  }  

//cantidad de emp inscritos en la semana
  public function emp_inc_semana(){
    $fecha_final =  date('Y-m-d');
    $fecha_inicio = date('Y-m-d', strtotime("$fecha_final - 7 day"));
    $this->db->where("estado",1);
    $this->db->where("perfil",'emprendedor');
    $this->db->where("fecha_insc >",$fecha_inicio);
    $this->db->where("fecha_insc <=",$fecha_final);
    $resultados = $this->db->get('emprendedor');
    return $resultados->num_rows();
  } 
//cantidad de emp inscritos en la mes
   public function emp_inc_mes(){
    $mes = date('m');
    $year = date('Y');
    $this->db->where("estado",1);
    $this->db->where("perfil",'emprendedor');
    $this->db->where("fecha_insc >=",$year."-".$mes."-01");
    $this->db->where("fecha_insc <=",$year."-".$mes."-31");
    $resultados = $this->db->get('emprendedor');
    return $resultados->num_rows();
  } 


  public function ultima_compra($id_emp){
   
    $this->db->select("DATE_FORMAT(fecha_comp,'%d/%m/%Y') as fecha_comp");
    $this->db->where('id_emp',$id_emp);
    $this->db->order_by('fecha_comp','DESC');
    $this->db->limit(1);   
    $query = $this->db->get('compra');
    return $query->row();
  }


 public function compras_acumuladas($data){
   
    $this->db->select("SUM(total_comp) as monto");
    $this->db->where("fecha_comp >=",$data['year']."-01-01");
    $this->db->where("fecha_comp <=",$data['year']."-12-31");
    $this->db->from("compra");
    $this->db->where("id_emp",$data['id_emp']);
    $resultados = $this->db->get();
    return $resultados->row();
  }  


  public function check_cliente($parametro, $valor)
  {
    $this->db->where($parametro,$valor);
    $query = $this->db->get('cliente');
    if($this->db->affected_rows() > 0){
          return true;        
      }else{
             return false;
           }
  }

   public function buscar_MunicXcodigo($codigopostal) {
   $this->db->where('codigopostal',$codigopostal);
   $query = $this->db->get('municipios');
   return $query->row();
       
   }
   public function buscar_ProdXnombre($nombre_prod) {
   $this->db->where('nombre_prod',$nombre_prod);
   $query = $this->db->get('productos');
   return $query->row();
  }



   public function buscar_exitenciaCLi($dni, $email) {
    $this->db->where('dni', $dni);
    $this->db->or_where('email', $email);
    $query = $this->db->get('cliente');
    return $query->row();             
   }
  
  public function buscar_dnicli($dni) {
   $this->db->where('dni',$dni);
   $query = $this->db->get('cliente');
   return $query->row();
       
   }
   public function buscar_emailcli($email) {
   $this->db->where('email',$email);
   $query = $this->db->get('cliente');
   return $query->row();
       
   }
   public function buscar_email_emp($email) {
   $this->db->where('email',$email);
   $query = $this->db->get('emprendedor');
   return $query->row();
       
   }
   
   public function buscar_dni_emp($dni_emp) {
	   $this->db->where('dni_emp',$dni_emp);
	   $query = $this->db->get('emprendedor');
	   return $query->row();       
   }
   
    public function update_datos_emp($param) 
	  {
		$this->db->where('dni_emp',$param['dni_emp']);
		$this->db->update('emprendedor',$param);
	   if($this->db->affected_rows() > 0){
		  return true;
		   }else{
				 return true;
				}
	  }

   public function buscar_referencia($id_orden_optenida) {
   $this->db->where('external_reference',$id_orden_optenida);
   $query = $this->db->get('compra');
   if($this->db->affected_rows() > 0){
      return $query->row();
       }else{
            
           return false;
        }
   
       
   }

    public function resto_almacen($data) {
   
     $datos_almacen = $this->datos_prodAlmacen($data);
     $saldo = $datos_almacen->existencia - $data['cantidad'];

     $param = array('existencia' => $saldo);
   
     $this->db->where('id_emp',$data['id_emp']);
     $this->db->where('id_producto',$data['id_producto']);
     $this->db->update('almacen_emp',$param);
   
     if($this->db->affected_rows() > 0){
      return true;
       }else{
            
           return false;
        }
       
   }

   

   public function datos_prodAlmacen($data) {
  
   $this->db->where('id_emp',$data['id_emp']);
   $this->db->where('id_producto',$data['id_producto']);
   $query = $this->db->get('almacen_emp');
   return $query->row();
       
   }

   

  
  

  /*-----------crud clientes----------------*/

    public function insert_cliente($data)
  {
      $this->db->insert('cliente',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
  }

   public function Count_Cli($id_emp){
    $this->db->where('id_emp',$id_emp);
    $resultados = $this->db->get('cliente');
    return $resultados->num_rows();
  }

  public function insert_promo($data)
  {
      $this->db->insert('promo',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
  }

     public function update_promo($param) 
  {
    $this->db->where('id_promo',$param['id_promo']);
    $this->db->update('promo',$param);
   if($this->db->affected_rows() > 0){
      return true;
       }else{
             return true;
            }
  }
  

  public function listar_clientes($id_emp)
  {
     $this->db->where('id_emp',$id_emp);
     $query = $this->db->get('cliente');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  

   public function update_datosCliente($param)
  {
    $this->db->where('id_cliente',$param['id_cliente']);
    $this->db->update('cliente',$param);
   if($this->db->affected_rows() > 0){
      return true;
       }else{
             return true;
            }
     
  }

   public function listado_pedidosProd($id_pedido){
        $this->db->select('prod.nombre_prod');
        $this->db->where('de_pe.id_pedidos', $id_pedido);
        $this->db->join('productos as prod', 'prod.id_producto = de_pe.id_producto');
        $query = $this->db->get('detalle_pedido as de_pe');
        return $query->result();
       
    }

  public function listado_DetallepedidosCli($id_cliente){
        $this->db->select('ped.no_pedido,prod.nombre_prod,de_pe.cantidad,ped.total,ped.fecha_solicitud,prod.vencimiento');
        $this->db->where('ped.id_cliente', $id_cliente);
        $this->db->join('productos as prod', 'prod.id_producto = de_pe.id_producto');
        $this->db->join('pedidos as ped', 'ped.id_pedidos =de_pe.id_pedidos');
        $query = $this->db->get('detalle_pedido as de_pe');
        return $query->result();
       
    }  

     public function listado_pedidos($id_cliente){
        $this->db->where('id_cliente', $id_cliente);
        $query = $this->db->get('pedidos');
        return $query->result();
       
    }

    public function listar_datosAlmacen($id_emp){
        $this->db->select('alm.id_almacen,prod.nombre_prod,prod.sku,alm.existencia');
        $this->db->join('productos as prod', 'prod.id_producto = alm.id_producto');
        $this->db->where('alm.id_emp', $id_emp);
        //$this->db->where('alm.existencia >',0);
        $query = $this->db->get('almacen_emp as alm');
        return $query->result();
       
    }

   public function datos_cliente($id_cliente) {
   $this->db->where('id_cliente',$id_cliente);
   $query = $this->db->get('cliente');
   return $query-> row();
  
   }


/*----------------------------------**/   

public function getComprobante($id_emp){
    $this->db->where("id_emp",$id_emp);
    $resultado = $this->db->get("emprendedor");
    $row = $resultado->row();
    $no_pedido = $row->cons_venta +1;
    $param = array('cons_venta' => $no_pedido);
    $this->db->where("id_emp",$id_emp);
    $this->db->update('emprendedor',$param);
   return $no_pedido;
   }   


public function save_Pedido($data){
    return $this->db->insert("pedidos",$data);
  }

public function save_Promo($data){
    return $this->db->insert("promo",$data);
  } 
public function save_detallePromo($data){
    return $this->db->insert("promo_producto",$data);
  } 

   public function buscar_promo($id_producto){
   $hoy = date('Y-m-d');
   $this->db->join('productos as prod', 'prod.id_producto = pro_p.id_producto');
   $this->db->join('promo as pro', 'pro_p.id_promo = pro.id_promo');
   $this->db->where('pro.estado_promo',1);//promociones activas
   $this->db->where('pro.fecha_fin >=',$hoy);
   $this->db->where('pro_p.es_combo',0);
   $this->db->where('pro_p.id_producto',$id_producto);
   $query = $this->db->get('promo_producto as pro_p');
   if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  
   } 

   public function buscar_promoCombo($id_combo){
   $hoy = date('Y-m-d');
   $this->db->join('combo as co', 'co.id_combo = pro_p.id_producto');
   $this->db->join('promo as pro', 'pro_p.id_promo = pro.id_promo');
   $this->db->where('pro.fecha_fin >=',$hoy);
   $this->db->where('pro_p.id_producto',$id_combo);
   $query = $this->db->get('promo_producto as pro_p');
   if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  
   }       
  

  public function save_detallePedido($data){
    return $this->db->insert("detalle_pedido",$data);
  } 

   public function select_provincias()
  {
     $query = $this->db->get('provincias');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
    public function select_municipio($id_provincia)
  {
     $this->db->where('id_provincia',$id_provincia);
     $query = $this->db->get('municipios');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

    public function get_nombreMuni($id_municipio)
  {
     $this->db->where('id_municipio',$id_municipio);
     $query = $this->db->get('municipios');
      if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  }

    public function get_nombreProv($id_provincia)
  {
     $this->db->where('id_provincia',$id_provincia);
     $query = $this->db->get('provincias');
      if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  }


    public function select_municipionombre($id_provincia)
  {
      $this->db->select('id_municipio,nombre');
     $this->db->where('id_provincia',$id_provincia);
     $query = $this->db->get('municipios');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }




  
   





  /* insertar videos */
   public function insert_cap($data)
  {
      $this->db->insert('capacitacion',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }

    public function getdatos_combo($id_combo)
  {
     $this->db->where('id_combo',$id_combo);
     $query = $this->db->get('combo');
     return $query->row();
     
  }

     public function getdatos_promo($id_promo)
  {
     $this->db->where('id_promo',$id_promo);
     $query = $this->db->get('promo');
     return $query->row();
     
  }


   public function getdatos_cap($id_cap)
  {
     $this->db->where('id_cap',$id_cap);
     $query = $this->db->get('capacitacion');
     return $query->row();
     
  }

  public function getdatos_prod($id_producto)
  {
     $this->db->where('id_producto',$id_producto);
     $query = $this->db->get('productos');
     return $query->row();
     
  }


  
  public function getdatos_prod_combo($id_producto, $es_combo)
  {
     if($es_combo == 0){
		    $this->db->select('nombre_prod'); 
	  	  $this->db->where('id_producto',$id_producto);
        $query = $this->db->get('productos');
        return $query->row();
	    }else{
		      $this->db->select('nombre_combo as nombre_prod'); 
	        $this->db->where('id_combo',$id_producto);
          $query = $this->db->get('combo');
           return $query->row();
	       }
  }






   public function update_cap($param) 
  {
    $this->db->where('id_cap',$param['id_cap']);
    $this->db->update('capacitacion',$param);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }
 

  

  /* insetar evaluacion **/
   public function udpate_evalcap($param)
  {
    $this->db->where('id_emp',$param['id_emp']);
    $this->db->where('id_cap',$param['id_cap']);
    $this->db->update('emp_cap',$param);
   if($this->db->affected_rows() > 0){
      return true;
       }else{
            $this->db->insert('emp_cap',$param);
             return true;
        }
     
  }

  

  /* update emprendedor **/
   public function udpate_emp($datos_upd)
  {
    $this->db->where('id_emp',$datos_upd['id_emp']);
    $this->db->update('emprendedor',$datos_upd);
    if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }


    public function udpate_empInv($param)
  {
    $this->db->where('id_emp',$param['id_emp']);
    $this->db->update('emprendedor',$param);
    if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }

  /*----------tabla de comsiones--------*/

  /*listar*/
   public function listar_rango()
  {
     $query = $this->db->get('tbl_comisiones');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
    /* insertar videos */
   public function insert_comisiones($data)
  {
      $this->db->insert('tbl_comisiones',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
          return false;
        }
     
  }

    public function getdatos_emp($id)
  {
     $this->db->where('id_emp',$id);
     $query = $this->db->get('emprendedor');
     return $query->row();
     
  }

     public function exitencia_emp($id)
  {
     $this->db->where('id_emp',$id);
     $this->db->get('emprendedor');
     if($this->db->affected_rows() > 0){
          return true;
        }else{
          return false;
        }
     
     
  }

  public function getdatos_rango($id)
  {
     $this->db->where('id_tbl_comisiones',$id);
     $query = $this->db->get('tbl_comisiones');
     return $query->row();
     
  }

   public function update_rango($param) 
  {
    $this->db->where('id_tbl_comisiones',$param['id_tbl_comisiones']);
    $this->db->update('tbl_comisiones',$param);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }

     public function udpate_pedidoCli($param)
  {
    $this->db->where('id_pedidos',$param['id_pedidos']);
    $this->db->update('pedidos',$param);
    if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }

  public function eliminar_pedidoCli($id)
    {
     $this->db->where('id_pedidos',$id);
     $this->db->delete('pedidos');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  } 


   public function eliminar_rango($id)
    {
     $this->db->where('id_tbl_comisiones',$id);
     $this->db->delete('tbl_comisiones');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  } 
  /*------------------------------------*/
   /*----------tabla de comsiones--------*/

  /*listar*/
   public function getValorMont_min()
  {
    $this->db->where('parametro','monto_min');
    $query = $this->db->get('configuracion');
    return $query->row();
 }

  public function getAccesTocken()
  {
    $this->db->where('parametro','access_token');
    $query = $this->db->get('configuracion');
    return $query->row();
 }

 public function getIva()
  {
    $this->db->where('parametro','iva');
    $query = $this->db->get('configuracion');
    return $query->row();
 }


  public function getValorNo_orden()
  {
    $this->db->where('parametro','no_orden');
    $query = $this->db->get('configuracion');
    return $query->row();
 }

 public function aumentar_No_orden()
  {
   $dato = $this->getValorNo_orden();
   $text = $dato->valor + 1;
   $data = array('valor' => $text);
   $this->db->where('parametro','no_orden');
   $this->db->update('configuracion',$data);
  }

  public function configuracion()
  {
     $query = $this->db->get('configuracion');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  

  public function updateParametros($param) 
  {
    $this->db->where('id_conf',$param['id_conf']);
    $this->db->update('configuracion',$param);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }






    /* insertar videos */
   public function insert_monto($data)
  {
      $this->db->insert('monto_comisiones',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
          return false;
        }
     
  }

  public function getdatos_monto($id)
  {
     $this->db->where('id_monto',$id);
     $query = $this->db->get('monto_comisiones');
     return $query->row();
     
  }



   public function update_monto($param) 
  {
    $this->db->where('id_monto',$param['id_monto']);
    $this->db->update('monto_comisiones',$param);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }

  public function eliminar_monto($id)
    {
     $this->db->where('id_monto',$id);
     $this->db->delete('monto_comisiones');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  } 


  /*------------------------------*/

   public function listar_categorias_prod()
  {
     $query = $this->db->get('p_categorias');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

    public function selec_categorias_prod()
  {
     $mostarcategorias ="";
      $result_c =$this->listar_categorias_prod(); 
       if(!empty($result_c))
        {
           
          foreach($result_c as $row):
              $mostarcategorias .='<option value="'.$row->id.'">'.$row->nombre.'</option>';
           endforeach ; 
        } 
     
   return $mostarcategorias;
  }

      public function selec_respuestos_prod()
  {
     $mostarrespuesto ="";
      $result_r =$this->listar_respuesto(); 
       if(!empty($result_r))
        {
          $mostarrespuesto .='<option value="">Seleccionar</option>';
          foreach($result_r as $row):
              $mostarrespuesto .='<option value="'.$row->id_producto.'">'.$row->nombre_prod.'</option>';
           endforeach ; 
        } 
     
   return $mostarrespuesto;
  }



   public function listar_respuesto()
  {
     $this->db->where('es_repuesto',2);//2 es respuesto
     $query = $this->db->get('productos');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  public function insert_repuesto($data)
  {
      $this->db->insert('respuestos',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
              return false;
             }
  }

   public function datos_respuestoPadre($id_producto)
  {
     $this->db->where('id_producto',$id_producto);
     $query = $this->db->get('respuestos');
      if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  }

   public function datos_respuestoHijo($id_producto)
  {
     $this->db->where('id_respuesto_hijo',$id_producto);
     $query = $this->db->get('respuestos');
      if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  }

   public function verificador_vencimiento($id_cliente,$id_respuesto)
  {
     $this->db->where('id_cliente',$id_cliente);
     $this->db->where('id_respuesto',$id_respuesto);
     $query = $this->db->get('prod_vencimiento');
     return $query->row();
      
  }

   public function buscar_prod($id_producto){
      
      $this->db->select('vencimiento');
      $this->db->where('id_producto',$id_producto);
      $query = $this->db->get('productos');
      if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  }

  
  public function updateverfi_vencimiento($data) {
    $param = array('fecha_vencimiento' => $data['fecha_vencimiento']);
   $this->db->where('id_cliente',$data['id_cliente']);
   $this->db->where('id_respuesto',$data['id_producto']);
   $this->db->update('prod_vencimiento',$param);
   if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
   }




 public function insertverfi_vencimiento($data)
  {
      $this->db->insert('prod_vencimiento',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
              return false;
             }
  }

  
  public function insert_prod_cliente($data)
  {
      $this->db->insert('producto_cliente',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
              return false;
             }
  }

  public function insert_prod_cli_venc($data)
  {
      $this->db->insert('prod_cli_venc',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
              return false;
             }
  }


  public function buscarProdVencidos($data){
      
      $this->db->select('pro.nombre_prod,pro_ven.fecha_vencimiento');
      $this->db->where('res.id_respuesto_hijo',$data['id_respuesto_hijo']);
      $this->db->where('pro_ven.fecha_vencimiento <=', $data['fecha_vencimiento']);
      $this->db->join('respuestos as res', 'res.id_producto = prod_cli.id_producto');
      $this->db->join('prod_cli_venc as  prod_cli_v','prod_cli_v.id_prod_cli = prod_cli.id_prod_cli');
      $this->db->join('prod_vencimiento as pro_ven', 'pro_ven.id_prod_vencimiento = prod_cli_v.id_prod_vencimiento');
      $this->db->join('productos as pro', 'pro.id_producto = prod_cli.id_producto');
      $query = $this->db->get('producto_cliente as prod_cli');

      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

    public function buscarRespuestosVencidos($data){
      
      $this->db->select('pro.nombre_prod,pro_ven.fecha_vencimiento');
      //$this->db->where('res.id_respuesto_hijo',$data['id_respuesto_hijo']);
      $this->db->where('pro_ven.fecha_vencimiento <=', $data['fecha_vencimiento']);
      $this->db->join('respuestos as res', 'res.id_respuesto_hijo = prod_cli.id_producto');
      $this->db->join('prod_cli_venc as  prod_cli_v','prod_cli_v.id_prod_cli = prod_cli.id_prod_cli');
      $this->db->join('prod_vencimiento as pro_ven', 'pro_ven.id_prod_vencimiento = prod_cli_v.id_prod_vencimiento');
      $this->db->join('productos as pro', 'pro.id_producto = prod_cli.id_producto');
      $query = $this->db->get('producto_cliente as prod_cli');

      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

   public function clientes_vencimiento($id_emp){
      
      $this->db->select("prov.id_prod_vencimiento,prov.id_cliente,cli.nombre_cliente,prod.id_producto,prod.nombre_prod,DATE_FORMAT(prov.fecha_vencimiento,'%d/%m/%Y') as fecha_vencimiento");
      $this->db->where('prov.fecha_vencimiento <', date('Y-m-d'));
      $this->db->where('cli.id_emp', $id_emp);
      $this->db->join('cliente as cli', 'cli.id_cliente = prov.id_cliente');
      $this->db->join('productos as prod','prod.id_producto = prov.id_respuesto');
      $query = $this->db->get('prod_vencimiento as prov');

      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

   public function show_vencimiento($id_emp){
      
      $this->db->select("cli.nombre_cliente,prod.nombre_prod,prod.url_imagen, DATE_FORMAT(prov.fecha_vencimiento,'%d/%m/%Y') as fecha");
      $this->db->where('prov.fecha_vencimiento <', date('Y-m-d'));
      $this->db->where('cli.id_emp', $id_emp);
      $this->db->join('cliente as cli', 'cli.id_cliente = prov.id_cliente');
      $this->db->join('productos as prod','prod.id_producto = prov.id_respuesto');
      $query = $this->db->get('prod_vencimiento as prov');

      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  public function Count_vencimiento($id_emp){
      
      $this->db->select('prov.id_prod_vencimiento,prov.id_cliente,cli.nombre_cliente,prod.nombre_prod,prov.fecha_vencimiento');
      $this->db->where('prov.fecha_vencimiento <', date('Y-m-d'));
      $this->db->where('cli.id_emp', $id_emp);
      $this->db->join('cliente as cli', 'cli.id_cliente = prov.id_cliente');
      $this->db->join('productos as prod','prod.id_producto = prov.id_respuesto');
      $query = $this->db->get('prod_vencimiento as prov');
      return $query->num_rows();
  }

  public function CountTotalCli($id_emp){
    $this->db->where('id_emp', $id_emp);
    $resultados = $this->db->get('cliente');
    return $resultados->num_rows();
  }



   public function cant_cli_venc($id_emp){
      
      $this->db->select('prov.id_prod_vencimiento,prov.id_cliente,cli.nombre_cliente,prod.nombre_prod,prov.fecha_vencimiento');
      $this->db->where('prov.fecha_vencimiento <', date('Y-m-d'));
      $this->db->where('cli.id_emp', $id_emp);
      $this->db->join('cliente as cli', 'cli.id_cliente = prov.id_cliente');
      $this->db->join('productos as prod','prod.id_producto = prov.id_respuesto');
      $query = $this->db->get('prod_vencimiento as prov');

      if($query->num_rows() > 0){
        return $query->num_rows();

      }else{
        return false;
      }
  }

  // lista de repuestos vencidos para el  historial de cliente
  public function repustosVencidos_cliente($id_cliente){
      
      $this->db->select("prod.nombre_prod,
                        DATE_FORMAT(prov.fecha_vencimiento,'%d/%m/%Y') as fecha_vencimiento,
                        prod.vencimiento,DATE_FORMAT(ped.fecha_solicitud,'%d/%m/%Y') as fecha_solicitud" );
      $this->db->where('prov.fecha_vencimiento <', date('Y-m-d'));
      $this->db->where('prov.id_cliente',$id_cliente);
      $this->db->join('pedidos as ped', 'ped.id_cliente = prov.id_cliente');
      $this->db->join('productos as prod','prod.id_producto = prov.id_respuesto');
      $this->db->group_by("prov.id_prod_vencimiento");
      $query = $this->db->get('prod_vencimiento as prov');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

//reposicion de unidades filtrantes

   public function Seccion_clientes_venc($data){
      
      $this->db->select("prov.id_prod_vencimiento,prov.id_cliente,cli.nombre_cliente,prod.nombre_prod,prod.id_producto,DATE_FORMAT(prov.fecha_vencimiento,'%d/%m/%Y') as fecha_vencimiento");
      $this->db->where('prov.fecha_vencimiento <', date('Y-m-d'));
       $this->db->where('prov.id_respuesto',$data['id_producto']);
      $this->db->where('prov.id_cliente',$data['id_cliente']);
      $this->db->join('cliente as cli', 'cli.id_cliente = prov.id_cliente');
      $this->db->join('productos as prod','prod.id_producto = prov.id_respuesto');
      $query = $this->db->get('prod_vencimiento as prov');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

   public function actualizar_vencimientos($data){
      
      $this->db->select('prod.vencimiento,prod_v.fecha_vencimiento');
      $this->db->where('prod_v.id_prod_vencimiento',$data['id_prod_vencimiento']);
      $this->db->join('productos as prod','prod.id_producto = prod_v.id_respuesto');
      $query = $this->db->get('prod_vencimiento` as prod_v');
      if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  }

  
   public function update_venc($param)
  {
   $campo = array('fecha_vencimiento' => $param['fecha_vencimiento']);
   $this->db->where('id_prod_vencimiento',$param['id_prod_vencimiento']);
   $this->db->update('prod_vencimiento',$campo);
      if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }




   public function update_tablaAlmacen($param)
  {
    $campo = array('existencia' => $param['existencia']);

   $this->db->where('id_emp',$param['id_emp']);
   $this->db->where('id_almacen',$param['id_almacen']);
   $this->db->update('almacen_emp',$campo);
      if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }
  

   public function insert_prodAlmacen($data)
  {
     $param = array('id_emp' =>$data['id_emp'] ,'id_producto' => $data['id_producto'] );
     $exitencia = $this->buscar_productoAlmacen($param);
      if ($exitencia) {
        return false;
      } else {
        $this->db->insert('almacen_emp',$data);
        return true;
      }
    

     
  }


   public function buscar_productoAlmacen($param)
  {
   $this->db->where('id_producto',$param['id_producto']);
   $this->db->where('id_emp',$param['id_emp']);
   $resultados =$this->db->get('almacen_emp');
   if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }

   public function dame_existencia($param)
  {
   $this->db->where('id_producto',$param['id_producto']);
   $this->db->where('id_emp',$param['id_emp']);
   $resultados =$this->db->get('almacen_emp');
   if($this->db->affected_rows() > 0){
        return $resultados->row();
      }else{
        return 0;
      }
  }



  /*------------------------------------*/


   public function las_insetCap()
  {
    $this->db->select('id_cap,evaluacion');
    $this->db->order_by("id_cap","desc"); 
    $resultados = $this->db->get('capacitacion');
    return $resultados->row();
  }

   public function insert_toCar($data)
  {
     $this->db->insert('carrito',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
              return false;
             }
  }

 /*  public function mostexit_combocarrito($param)
  {
      $this->db->select('id_car,car.id_producto,url_imagen, com.nombre_combo as nombre_prod,precio_car,cantidad,importe');
      $this->db->where('car.id_emp',$param['id_emp']);
      $this->db->where('car.es_combo',1);
      $this->db->join('combo as com','com.id_combo = car.id_producto');
      $query = $this->db->get('carrito as car');
      if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  }

     public function mostexit_prodcarrito($param)
  {
      $this->db->select('id_car,car.id_producto,url_imagen, com.nombre_combo as nombre_prod,precio_car,cantidad,importe');
      $this->db->where('car.id_emp',$param['id_emp']);
      $this->db->where('car.es_combo',0);
      $this->db->join('combo as com','com.id_combo = car.id_producto');
      $query = $this->db->get('carrito as car');
      if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  }*/





  public function update_prodCar($param) {
   $this->db->where('id_car',$param['id_car']);
   $this->db->update('carrito',$param);
   if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
   } 
  public function rowCountAsoc($id_emp){
      $this->db->where('emp.estado','1');
      $this->db->where('e_a.id_padre', $id_emp);
      $this->db->join('emprendedor as emp ', 'e_a.id_hijo = emp.id_emp');
      $query = $this->db->get('emp_asoc as e_a');
      if($query->num_rows() > 0){
        return $query->num_rows();
      }else{
        return 0;
      }
  }







  public function rowCount($tabla){
    $resultados = $this->db->get($tabla);
    return $resultados->num_rows();
  }
  public function comprobar_email($email,$password){
       $data = array('password' => md5($password));
      $this->db->where('email', $email);
      $this->db->update('password',$password);
      $query = $this->db->get('emprendedor');
      if($query->num_rows() > 0){
        return $query->row();
      }else{
        return false;
      }
  }
  
  public function mostrar_asoc($id_emp)
  {
      $this->db->where('emp.estado','1');
      $this->db->where('e_a.id_padre', $id_emp);
      $this->db->join('emprendedor as emp ', 'e_a.id_hijo = emp.id_emp');
      $query = $this->db->get('emp_asoc as e_a');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

   public function mostrar_asocInvitados($id_emp)
  {
      $this->db->where('emp.estado','0');
      $this->db->where('e_a.id_padre', $id_emp);
      $this->db->join('emprendedor as emp ', 'e_a.id_hijo = emp.id_emp');
      $query = $this->db->get('emp_asoc as e_a');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  /*Mostar padre de emprededor*/

 public function mostrar_Padre_asoc($id_emp)
  {
      $this->db->where('e_a.id_hijo', $id_emp);
      $query = $this->db->get('emp_asoc as e_a');
       return $query->row();
  }
  
  
   public function mostrar_patrocinador_padre($id_emp)
  {
      $this->db->where('e_a.id_hijo', $id_emp);
	  $this->db->join('emprendedor as emp ', 'e_a.id_padre= emp.id_emp');
      $query = $this->db->get('emp_asoc as e_a');

       return $query->row();
  }

  /*MOSTRAR ASOCIADOS ACTIVOS*/

 public function mostrar_asocAct($id_emp)
  {
      $this->db->where('emp.estado','1');
      $this->db->where('e_a.id_padre', $id_emp);
      $this->db->join('emprendedor as emp ', 'e_a.id_hijo = emp.id_emp');
      $query = $this->db->get('emp_asoc as e_a');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  /*-------------------------*/
  public function mostrar_carrito($id_emp)
  {
      $this->db->select('id_car,car.id_producto,url_imagen,nombre_prod,precio_car,cantidad,importe, car.es_combo');
      $this->db->where('car.id_emp',$id_emp);
      $this->db->where('car.es_combo',0);
      $this->db->join('productos as prod','prod.id_producto = car.id_producto');
      $query = $this->db->get('carrito as car');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  public function mostrar_carrito_combo($id_emp)
  {
      $this->db->select('id_car,car.id_producto,url_imagen, com.nombre_combo as nombre_prod,precio_car,cantidad,importe, car.es_combo');
      $this->db->where('car.id_emp',$id_emp);
      $this->db->where('car.es_combo',1);
      $this->db->join('combo as com','com.id_combo = car.id_producto');
      $query = $this->db->get('carrito as car');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  public function mostrar_detallecarrito($id_emp)
  {
      $this->db->select('url_imagen,nombre_prod,car.precio_car,car.cantidad');
      $this->db->where('car.id_emp',$id_emp);
      $this->db->join('productos as prod','prod.id_producto = car.id_producto');
      $query = $this->db->get('carrito as car');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

    public function count_cantProdCar($id_emp)
  {
    $this->db->from('carrito');
    $this->db->where('id_emp',$id_emp);
    return $this->db->count_all_results();
  }
 
 /*----------INSERTAR COMPRA ------------------*/
 public function save_compra($data){
    return $this->db->insert("compra",$data);
  }

  public function lastID(){
    return $this->db->insert_id();
  }

  public function save_detalleCompra($data){
    $this->db->insert("detalle_compra",$data);
  }


  public function update_compra($param) {
   $this->db->where('id_compra',$param['id_compra']);
   $this->db->update('compra',$param);
   if($this->db->affected_rows()>0){
        return true;
      }else{
        return false;
      }
  } 

//compra con estado pendiente 
   public function getCompraspendientes(){

    $this->db->where("collection_status","pending");
    $resultados = $this->db->get("compra");
    if ($resultados->num_rows() > 0) {
      return $resultados->result();
    }else 
    {
      return false;
    }
  }

    public function update_pago_mercadoPago($param) {
   $this->db->where('id_link_pago',$param['id_link_pago']);
   $this->db->update('compra',$param);
   if($this->db->affected_rows()>0){
        return true;
      }else{
        return false;
      }
  }

  public function getDetalleCompra($id_compra){

    $this->db->select("prod.nombre_prod,cantidad_comp,precio_comp,importe,es_combo,d_c.id_producto");
    $this->db->from("detalle_compra d_c");
    $this->db->where("d_c.id_compra",$id_compra);
    $this->db->join("productos as prod","prod.id_producto = d_c.id_producto");
    $resultados = $this->db->get();
    if ($resultados->num_rows() > 0) {
      return $resultados->result();
    }else 
    {
      return false;
    }
  }
  
    
  public function getDetalleCompra_mail($id_compra)
	  {
		$this->db->where('id_compra',$id_compra);
		$query = $this->db->get('detalle_compra');
		return  $query->result();
	  }

   public function getDetalleVenta($id_pedidos){

    $this->db->select("prod.nombre_prod,cantidad,precio_pedido,importe,id_det_ped,d_p.id_producto");
    $this->db->from("detalle_pedido d_p");
    $this->db->where("d_p.id_pedidos",$id_pedidos);
    $this->db->join("productos as prod","prod.id_producto = d_p.id_producto");
    $resultados = $this->db->get();
    if ($resultados->num_rows() > 0) {
      return $resultados->result();
    }else 
    {
      return false;
    }
  }

   public function getdatos_pedido_emp($id_pedidos)
  {
     
     $this->db->where('id_pedidos',$id_pedidos);
     $this->db->join('cliente as cli','ped.id_cliente = cli.id_cliente');
     $query = $this->db->get('pedidos as ped');
     return $query->row();
     
  }

   public function get_sumatoriadetalleVenta($id_pedidos)
  {
    $this->db->where('id_pedidos',$id_pedidos);
    $this->db->select_sum('importe');
    $query = $this->db->get('detalle_pedido');
  return  $query-> row();
  }

   public function get_detalleVenta($id_pedidos)
  {
    $this->db->select("DATE_FORMAT(ped.fecha_solicitud,'%d/%m/%Y') as fecha,
                       no_pedido,
                       emp.nombre_emp,
                       emp.apellido,
                       emp.dni_emp,
                       emp.telefono_emp,
                       cli.nombre_cliente,
                       cli.apellidos,
                       cli.email,
                       cli.celular,
                       cli.direccion,
                       cli.dni,
                       cli.telefono,
                       ped.total");
    $this->db->where('ped.id_pedidos',$id_pedidos);
    $this->db->join('cliente as cli','ped.id_cliente = cli.id_cliente');
    $this->db->join('emprendedor as emp','emp.id_emp = ped.id_emp');
    $query = $this->db->get('pedidos as ped');
  return  $query-> row();
  }

  public function datoscombo($id_combo)
    {
      $this->db->select("nombre_combo");
      $this->db->where('id_combo',$id_combo);
      $query = $this->db->get('combo');
      return  $query-> row();
    } 



    public function datosdecompradetallecombo($id_combo)
    {
      $this->db->select("prod.nombre_prod");
      $this->db->where('id_combo',$id_combo);
      $this->db->join("productos as prod","prod.id_producto = c_p.id_producto");
      $query = $this->db->get('combo_producto as c_p');
      return  $query-> result();
    } 




   public function datosdecompradetalle($id_compra)
    {
      $this->db->where('id_compra',$id_compra);
      $query = $this->db->get('detalle_compra');
      return  $query-> row();
    } 

     public function lista_compra($id_emp)
  {
     $this->db->select("DATE_FORMAT(fecha_comp,'%d/%m/%Y') as fecha,no_compra,total_comp,id_compra,collection_status,medio_pago");
     $this->db->where("id_emp",$id_emp);
     $this->db->order_by("id_compra", "desc"); 
     $query = $this->db->get('compra');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  } 

      public function lista_mis_ventas($id_emp)
  {
     $this->db->select("DATE_FORMAT(fecha_solicitud,'%d/%m/%Y') as fecha,no_pedido,total,nombre_cliente,id_pedidos,ped.id_cliente");
     $this->db->where('ped.id_emp',$id_emp);
     $this->db->join('cliente as cli','ped.id_cliente = cli.id_cliente');
     $this->db->order_by("fecha", "desc"); 
     $query = $this->db->get('pedidos as ped');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  } 

  /*----------mi cartera------------*/
  public function lista_miCartera($id_emp)
  {
     $this->db->select("DATE_FORMAT(fecha,'%d/%m/%Y'),no_compra,gasto_cartera,saldo");
     $this->db->where("id_emp",$id_emp);
     $query = $this->db->get('cartera_comisiones');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
     public function comision_actual($id_emp)
	  {
		$this->db->where('id_emp',$id_emp);
		$query = $this->db->get('emprendedor');
	    return  $query-> row();
	  } 
	  
	 public function update_cartera_comision($param) 
	  {
		$this->db->where('id_emp',$param['id_emp']);
		$this->db->update('emprendedor',$param);
		 if($this->db->affected_rows() > 0){
		  return true;
		   }else{
			 return false;
			}
	  }  
  
  
    public function getdatosCompra($id_compra)
	  {
		$this->db->where('id_compra',$id_compra);
		$query = $this->db->get('compra');
		return  $query-> row();
	  } 

  public function eliminar_compra($id)
    {
     $this->db->where('id_compra',$id);
     $this->db->delete('compra');
    }

  // eliminar compras nulas
  
   public function eliminar_compraNull()
    {
     $this->db->where('collection_status',"");
     $this->db->delete('compra');
    }  



   public function get_sumatoriaCompra($id_compra)
  {
    $this->db->where('id_compra',$id_compra);
    $this->db->select_sum('importe');
    $query = $this->db->get('detalle_compra');
  return  $query-> row();
  }

   public function sumatoriaCompraEmp($id_emp)
  {
    $this->db->where('id_emp',$id_emp);
   // $this->db->where("YEAR(fecha_comp)",$data['year']);
    $this->db->select_sum('total_comp');
    $query = $this->db->get('compra');
  return  $query-> row();
  }

   public function sumatoriaCompraEmpMensual($data)//$id_emp,$mes,$año
  {
    $this->db->where('id_emp',$data['id_emp']);
    $this->db->select_sum('total_comp');
    $this->db->where("MONTH(fecha_comp)",$data['mes']);
    $this->db->where("YEAR(fecha_comp)",$data['year']);
    $query = $this->db->get('compra');
    if($query->num_rows() > 0){
        return $query-> row();
      }else{
        return 0;
      }

  }

     public function Estado_emp_asoc($id_emp)
  {
    $mes = date('m');
    $year = date('Y');
    $this->db->where('id_emp',$id_emp);
    $this->db->select_sum('total_comp');
    $this->db->where("MONTH(fecha_comp)",$mes);
    $this->db->where("YEAR(fecha_comp)",$year);
    $query = $this->db->get('compra');
    if($query->num_rows() > 0){
        return 1;
      }else{
        return 0;
      }

  }



   public function epatsActivos($id_emp)
  {

    $total_plata = 0;
    $porcientos = [];
    $mes = date('m');
    $year = date('Y');

    $this->db->select("id_hijo, sum(comp.total_comp) as total");
    $this->db->where("e_a.id_padre",$id_emp);
    $this->db->where("MONTH(comp.fecha_comp)",$mes);
    $this->db->where("YEAR(comp.fecha_comp)",$year);
    $this->db->join("compra as comp","e_a.id_hijo = comp.id_emp");
    $this->db->group_by("e_a.id_hijo");
    $query = $this->db->get('emp_asoc as e_a');

    if($query->num_rows() > 0){
       $cantidad_ventas = $query->num_rows(); 
      }else{
        $cantidad_ventas = 0;
      }

    return $cantidad_ventas;
  }


    public function poc_comisiones($data)
  {
  	$this->db->where('categoria',$data);
    $query = $this->db->get('tbl_comisiones');
    if($query->num_rows() > 0){
        return $query-> row();
      }else{
        return 0;
      }

  }


 public function cantidadVentas($data){    
    $total_plata = 0;
    $porcientos = [];

    $this->db->select("id_hijo, sum(comp.total_comp) as total");
    $this->db->where("e_a.id_padre",$data['id_emp']);
    $this->db->where("MONTH(comp.fecha_comp)",$data['mes']);
    $this->db->where("YEAR(comp.fecha_comp)",$data['year']);
    $this->db->join("compra as comp","e_a.id_hijo = comp.id_emp");
    $this->db->group_by("e_a.id_hijo");
    $query = $this->db->get('emp_asoc as e_a');

    $cantidad_ventas = $query->num_rows();    
    foreach ($query->result() as $row)
      {
        $total_plata += $row->total;              
      }
    $porcientos = $this->obtener_porciento($cantidad_ventas);
    $comision = $this->calcular_porciento($porcientos['porciento'], $total_plata);

    $datos = array('cantidad_ventas' => $cantidad_ventas, 'total_plata' => $total_plata,'porciento' => $porcientos['porciento'], 'categoria' => $porcientos['categoria'], 'comision' => $comision, 'categoria_siguiente' => $porcientos['categoria_siguiente']);

    return $datos;
    

  }

   public function obtener_porciento($cantidad)
    {
      $porciento = 0;
      $categoria = '';
	    $categoria_siguiente = 6;
      $this->db->select("valor_comision,categoria,rango_final");
      $this->db->where('rango_inicial <=',$cantidad);
      $this->db->where('rango_final >=',$cantidad);
      $query = $this->db->get('tbl_comisiones');
      foreach ($query->result() as $row)
        {
          $porciento   = $row->valor_comision;
          $categoria   = $row->categoria;
		      $rango_final = $row->rango_final;
		      $categoria_siguiente = ($rango_final + 1) - $cantidad;	  
        }
      $datos = array('porciento' => $porciento, 'categoria' => $categoria, 'categoria_siguiente' => $categoria_siguiente);  
      return  $datos;
    }

    public function calcular_porciento($porc, $plata)
    {
      $total = ($porc * $plata)/100;  
      return  $total;
    }





  

  /*limpiar carrito*/

 public function limpiar_carrito($id_emp)
    {
     $this->db->where('id_emp',$id_emp);
     $this->db->delete('carrito');
     
  }

/*--------------compra----------------*/  

  public function mostrar_paices()
  {
     $query = $this->db->get('paises');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
  

   public function mostrar_producto()
  {
     $query = $this->db->get('productos');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  } 
  
    public function emp_result()
  {
  	$this->db->where('perfil !=','administrador');
	$query = $this->db->get('emprendedor');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
  
  
  
  /*mostrar lista de  emprendedores */
    public function mostrar_emp($id_emp)
  {
     $this->db->where('id_emp !=',$id_emp);
     $this->db->where('perfil','emprendedor');
     $query = $this->db->get('emprendedor');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

      public function mostrar_empAdmin($id_emp)
  {
     $this->db->where('id_emp !=',$id_emp);
     $this->db->where('perfil','administrador');
     $this->db->join('paises as pa','emp.id_pais = pa.id');
     $query = $this->db->get('emprendedor as emp');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
  /*mostrar datos de emprender especifico*/
  /*-----Devuelve el consecutivo de la orden -----------*/
   public function datos_emp($id_emp) {
   $this->db->where('id_emp',$id_emp);
   $query = $this->db->get('emprendedor');
   return $query-> row();
   } 
   
   
   
   
   
   
   
   public function listar_data_cap()
  {
     $this->db->order_by("orden_visual", "ASC");
     $query = $this->db->get('capacitacion');

      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
  /*lista de preguntas por id_cap */

   public function pregunta_cap($id_cap)
  {
      $this->db->where('id_cap',$id_cap); 
     $query = $this->db->get('cap_preguntas');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

   public function listar_respuestas_cap($id_preg)
  {
     $this->db->where('id_preg',$id_preg);
     $query = $this->db->get('cap_respuesta');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

 




  public function Total_emp($tabla){
     $this->db->where('estado',1);
     $this->db->where('perfil','emprendedor');
    $resultados = $this->db->get($tabla);
    return $resultados->num_rows();
  }
  /*CRUD PRODUCTOS*/
    public function listar_data_prod()
  {
     $query = $this->db->get('productos');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

// lista de respuesto asignados a productos
  public function repuestos($id_producto){
      
      $this->db->select('prod.nombre_prod');
      $this->db->where('resp.id_producto',$id_producto);
      $this->db->join('productos as prod','prod.id_producto = resp.id_respuesto_hijo');
      $query = $this->db->get('respuestos as resp');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

     public function seleccion_productos()
  {
     $result =$this->listar_categorias_prod(); 
     $mostarcategorias = "";
     $mostarcategorias .='<option value="" selected>Seleccione</option>';
     foreach($result as  $value):
      $mostarcategorias .='<optgroup label="'.$value->nombre.'">';
      $result_prod =$this->listar_productosxcateg($value->id); 
       if(!empty($result_prod))
        {
          
            foreach($result_prod as $row):
              $mostarcategorias .='<option value="'.$row->id_producto.'">'.$row->nombre_prod.'</option>';
            endforeach ; 
        } 
      $mostarcategorias .= '</optgroup>';
      endforeach ; 
   return $mostarcategorias;
  }

   public function seleccion_combos()
  {
     $result =$this->listar_data_combos(); 
     $mostarcombos = "";
     $mostarcombos .='<option value="" selected>Seleccione</option>';
     foreach($result as  $row):
           $mostarcombos .='<option value="'.$row->id_combo.'">'.$row->nombre_combo.'</option>';
      endforeach ; 
   return $mostarcombos;
  }

 


  public function productos_almacen($data)
  {
    
    $this->db->select('prod.id_producto,prod.nombre_prod,alm.existencia');
    $this->db->join('productos as prod', 'prod.id_producto = alm.id_producto');
    $this->db->where('alm.id_emp', $data['id_emp']);
    $this->db->where('prod.id_categoria', $data['id_categoria']);
   // $this->db->where('alm.existencia >',0);
    $query = $this->db->get('almacen_emp as alm');
    return $query->result();

  }

   public function productos_cat($data)
  {
    $this->db->where('id_categoria', $data['id_categoria']);
    $query = $this->db->get('productos');
    return $query->result();

  }

 
  /*Insertar combo*/

     public function insert_combo($data)
  {
      $this->db->insert('combo',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }

      public function insert_cap_preguntas($data)
  {
     $this->db->insert('cap_preguntas',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
          return false;
        }
     
  }

 public function insert_cap_repuestas($data)
  {
    $this->db->insert('cap_respuesta',$data);
     if($this->db->affected_rows() > 0){
          return true;
        }else{
          return false;
        }
  }

  


  public function save_combos($data){
    return $this->db->insert("combo_producto",$data);
  }

  public function eliminar_comboProd($id)
    {
     $this->db->where('id_comb_prod',$id);
     $this->db->delete('combo_producto');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }


  public function eliminar_combo($id)
    {
     $this->db->where('id_combo',$id);
     $this->db->delete('combo');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }

    public function eliminar_prodAlm($id)
    {
     $this->db->where('id_almacen',$id);
     $this->db->delete('almacen_emp');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }


      public function eliminar_cli($id)
    {
     $this->db->where('id_cliente',$id);
     $this->db->delete('cliente');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }


  

   public function eliminar_promo($id)
    {
     $this->db->where('id_promo',$id);
     $this->db->delete('promo');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }

   public function prod_dePromo($id_promo){
      /*$this->db->select('prod.nombre_prod,pro_p.*'); 
      $this->db->join('productos as prod', 'prod.id_producto = pro_p.id_producto');*/
      $this->db->where('pro_p.id_promo', $id_promo);
      $query = $this->db->get('promo_producto as pro_p');
     return $query->result();

    // $productos_selec[]= [];
     /* foreach ($query->result() as $key):

       if($key->es_combo == 0){
          $this->db->select('nombre_prod,id_producto'); 
          $this->db->where('id_producto',$key->id_producto);
              $query = $this->db->get('productos');
              return  $productos_selec = $query->row();
         }else{
            $this->db->select('com.nombre_combo as nombre_prod,promo_p.*'); 
            $this->db->where('id_producto',$key->id_producto);
            $this->db->join('combo as com', 'com.id_combo = promo_p.id_producto');
            $query = $this->db->get('promo_producto as promo_p');
           return $productos_selec = $query->row();
         }

      endforeach;*/
       
    }


   

  public function prod_delcombo($id_combo){

        $this->db->select('prod.nombre_prod,com_p.cantidad,com_p.id_comb_prod,com_p.id_producto');
        $this->db->where('com_p.id_combo', $id_combo);
        $this->db->join('productos as prod', 'prod.id_producto = com_p.id_producto');
        $query = $this->db->get('combo_producto as com_p');
        return $query->result();
       
    }


       public function listar_productosxcateg($id)
  {
    $this->db->where('id_categoria', $id);
    $this->db->select("id_categoria,id_producto,nombre_prod");
     $query = $this->db->get('productos');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }



  /*---------productos----------*/
     public function listar_productos()
  {
    $this->db->select("id_categoria,id_producto,nombre_prod");
     $query = $this->db->get('productos');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }
  /*Insertar*/
  
     public function insert_prod($data)
  {
      $this->db->insert('productos',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }
 /*actualizar */
   public function update_prod($param) 
  {
    $this->db->where('id_producto',$param['id_producto']);
    $this->db->update('productos',$param);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }

     public function update_combo($param) 
  {
    $this->db->where('id_combo',$param['id_combo']);
    $this->db->update('combo',$param);
    if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
     
  }

  

     public function buscar_existe_comboProd($param) 
  {
    $this->db->where('id_combo',$param['id_combo']);
    $this->db->where('id_producto',$param['id_producto']);
    $query = $this->db->get('combo_producto');
    if($query->num_rows() > 0){
       $campo = array('cantidad' => $param['cantidad']);
       $this->db->where('id_combo',$param['id_combo']);
       $this->db->where('id_producto',$param['id_producto']);
       $this->db->update('combo_producto',$campo);
       $valor = "actualizado";
       
       return $valor;
      }else{
        $this->save_combos($param);
        $valor = "insertado";
        return $valor;
      }
  }
 
  
  /*Eliminar*/
     public function eliminar_prod($id)
    {
     $this->db->where('id_producto',$id);
     $this->db->delete('productos');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }
  /*----------------*/

    /*CRUD COMBOS*/
    public function listar_data_combos()
  {
     
     $query = $this->db->get('combo');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

    public function listar_data_combosActivos()
  {
      $this->db->where('estado_combo',1);// mostrar solo los combos activos
     $query = $this->db->get('combo');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  //-------- cantidad por mes --------------------------------------------
  public function emprendedores_mensuales($id_emp)
  {
    $year = date('Y');    
    $cantidad_mes = array();
    $emp_mes = 0;
    $total_emp = 0;
    $total_general = 0;
    $mes_actual = (int)date('m');
    for ($a=1; $a <= 12; $a++) { 
      $cantidad_mes[$a] = 0;
    }
    
    $this->arbol_hijo_mensual($id_emp);
    foreach ($this->hijos_mes[$id_emp] as $key):
          for ($i=1; $i <= 12; $i++) { 
            $this->db->where('id_emp', $key);
            $this->db->where("MONTH(fecha_insc)",$i);
            $this->db->where("YEAR(fecha_insc)",$year);
            $this->db->order_by("id_emp", "desc");
             $query = $this->db->get('emprendedor');
              if($query->num_rows() > 0){
                $cant_temp = $query->num_rows();
                $total_emp += $cant_temp;
                $cantidad_mes[$i] = $cantidad_mes[$i] + $cant_temp;
                if($i == $mes_actual){
                  $emp_mes = $cant_temp;          
                } 

              }             
          }          
    endforeach;

    foreach ($this->hijos_mes[$id_emp] as $key):
    $this->db->where('id_emp', $key);    
    $query1 = $this->db->get('emprendedor');
      if($query1->num_rows() > 0){
        $total_general += $query1->num_rows();
      }
    endforeach;  

    $datos = array('emp_mes' => $cantidad_mes[$mes_actual] ,'cantidad_mes' => $cantidad_mes, 'cantidad_total' => $total_emp, 'total_general' => $total_general);
    return $datos;     
  }

  public function arbol_hijo_mensual($id_emp)
  {
     $id_user = $this->session->userdata('id_emp');     
     $this->db->where('e_a.id_padre', $id_emp);
     $query = $this->db->get('emp_asoc as e_a');
     $asoc =  $query->result();
     
     if($asoc != NULL){
       foreach ($asoc as $key):
         $this->hijos_mes[$id_user][] = $key->id_hijo;
         $this->arbol_hijo_mensual($key->id_hijo);
       endforeach;       
     }else{
          $this->hijos_mes[$id_user][] = 0;
          }     
  } 

  //-------------------------MOSTRAR REPUESTOS ASOCIADOS-------
   public function prod_repuestos($id_producto){
        $this->db->select('id_resp_prod,id_respuesto_hijo');
        $this->db->where('id_producto', $id_producto);
        $query = $this->db->get('respuestos');
        return $query->result();
       
    }
  //------------------------- VENTA MES-----------------------------------------------
  public function listar_dataVentasMes($id_emp) 
  {
     $year = date('Y');
     $ventas_mes = 0;
     $mes_actual = (int)date('m');
     $compras = array();
     $total_ventas = 0 ;
     for ($a=1; $a <= 12; $a++) { 
        $compras[$a] = 0;
      }

    $this->arbol_hijoMes($id_emp);
    foreach ($this->hijos_ventasmes[$id_emp] as $key):
        for ($i=1; $i <= 12; $i++) {
          $this->db->select("total_comp");
          $this->db->where('id_emp', $key);
          $this->db->where("MONTH(fecha_comp)",$i);
          $this->db->where("YEAR(fecha_comp)",$year);
          $this->db->where("collection_status",'approved');            
          $query = $this->db->get('compra');
            if($query->num_rows() > 0){
              $compras_temp = $query->result();
               $cant_temp   = $query->num_rows();
              
              foreach ($compras_temp as $comp_key):
                 $compras[$i] = $compras[$i] + $comp_key->total_comp;
                 
                 if($i == $mes_actual){
                  $ventas_mes = $cant_temp;          
                }
              endforeach;        
            }
        }

    endforeach;

    foreach ($this->hijos_ventasmes[$id_emp] as $key):
    $this->db->where('id_emp', $key);
    $this->db->where("collection_status",'approved'); 
    $query1 = $this->db->get('compra');
      if($query1->num_rows() > 0){
        $compras_temp = $query1->result();
        foreach ($compras_temp as $comp_key):
                 $total_ventas += $comp_key->total_comp;
        endforeach; 
      }
    endforeach;
     $datos = array('ventas_mes' => $compras[$mes_actual] ,'compras' => $compras,'total_ventas' => $total_ventas);
    return $datos;    
  }


  public function arbol_hijoMes($id_emp)
  {
     $id_user = $this->session->userdata('id_emp');     
     $this->db->where('e_a.id_padre', $id_emp);
     $query = $this->db->get('emp_asoc as e_a');
     $asoc =  $query->result();
     
     if($asoc != NULL){
       foreach ($asoc as $key):
         $this->hijos_ventasmes[$id_user][] = $key->id_hijo;
         $this->arbol_hijoMes($key->id_hijo);
       endforeach;       
     }else{
          $this->hijos_ventasmes[$id_user][] = 0;

     }    
  }  

  //---------------------------------- Clientes finales ---------------------------------
  public function listar_clientes_finales_Mes($id_emp)
  {
     $year = date('Y');
     $mes_actual = (int)date('m');
     $datos = array();
     $clientes = array();
     $clinetes_mes = 0;
     $total_general = 0;
     $total_cli = 0;
     for ($a=1; $a <= 12; $a++) { 
        $clientes[$a] = 0;
      }
      
    $this->arbol_hijo_clientes_finales_Mes($id_emp);

    foreach ($this->hijos_clientes_fmes[$id_emp] as $key):
        for ($i=1; $i <= 12; $i++) {
            $this->db->where('id_emp', $key);
            $this->db->where("MONTH(fecha_incio)",$i);
            $this->db->where("YEAR(fecha_incio)",$year);            
            $query = $this->db->get('cliente');
              if($query->num_rows() > 0){
                $clientes_temp = $query->num_rows();
                $clientes[$i] = $clientes[$i] + $clientes_temp; 
                $total_cli += $clientes_temp;

                if($i == $mes_actual){
                  $clinetes_mes = $clientes_temp;          
                }      
              }
        }
    endforeach;

    foreach ($this->hijos_clientes_fmes[$id_emp] as $key):
    $this->db->where('id_emp', $key);    
    $query1 = $this->db->get('cliente');
      if($query1->num_rows() > 0){
        $total_general += $query1->num_rows();
      }
    endforeach;
    $datos = array('cantclientes' => $clientes[$mes_actual] ,'clientes' => $clientes,'total_cli' => $total_general);

    return $datos;    
  }


  public function arbol_hijo_clientes_finales_Mes($id_emp)
  {
     $id_user = $this->session->userdata('id_emp');     
     $this->db->where('e_a.id_padre', $id_emp);
     $query = $this->db->get('emp_asoc as e_a');
     $asoc =  $query->result();
     
     if($asoc != NULL){
       foreach ($asoc as $key):
         $this->hijos_clientes_fmes[$id_user][] = $key->id_hijo;
         $this->arbol_hijo_clientes_finales_Mes($key->id_hijo);
       endforeach;       
     }else{
     	$this->hijos_clientes_fmes[$id_user][] = 0;
     }  
  }  
  
 



  //-------------------------------------------------------------------------


    public function mostrar_MisEmp($id_emp)
  {
    $compras = array();
    $this->arbol_hijo($id_emp);
    if (!empty($this->hijos[$id_emp])) {

    	 foreach ($this->hijos[$id_emp] as $key):
          $this->db->where('id_emp', $key);
          $this->db->order_by("id_emp", "desc");
           $query = $this->db->get('emprendedor');
            if($query->num_rows() > 0){
              $compras_temp = $query->result();
              foreach ($compras_temp as $comp_key):
                 $compras[] = $comp_key;
              endforeach;
            }
    endforeach;
    }else{
    	$compras = 0; 
    }
   
    return $compras;     
  }


    public function count_dataVentas($id_emp)
  {
    $compras = array();
    $compras['lista']    = "";
    $compras['cantidad'] = 0;
    $this->arbol_hijo($id_emp);
    foreach ($this->hijos[$id_emp] as $key):
          $this->db->select("DATE_FORMAT(fecha_comp,'%d/%m/%Y') as fecha,id_compra, id_emp,no_compra,total_comp");
          $this->db->where('id_emp', $key);
          $this->db->where('collection_status', 'pending');
          $this->db->order_by("id_compra", "desc");
           $query = $this->db->get('compra');
            if($query->num_rows() > 0){
              $compras['cantidad'] = $query->num_rows();
              $compras['lista']    =  $query->result();
            }

    endforeach;
    return $compras;    
  }




    /*Listar Ventas admin*/
  public function listar_dataVentas($id_emp)
  {
    $compras = array();
    $this->arbol_hijo($id_emp);
    foreach ($this->hijos[$id_emp] as $key):
          $this->db->select("DATE_FORMAT(fecha_comp,'%d/%m/%Y') as fecha,id_compra, id_emp,no_compra,total_comp,collection_status,despachado,medio_pago,precio_envio,solic_enviada,fecha_pago");
          $this->db->where('id_emp', $key);
          $this->db->order_by("id_compra", "desc");
           $query = $this->db->get('compra');
            if($query->num_rows() > 0){
              $compras_temp = $query->result();
              foreach ($compras_temp as $comp_key):
                 $compras[] = $comp_key;
              endforeach;
            }
    endforeach;
    return $compras;    
  }

  public function arbol_hijo($id_emp)
  {
     $id_user = $this->session->userdata('id_emp');     
     $this->db->where('e_a.id_padre', $id_emp);
     $query = $this->db->get('emp_asoc as e_a');
     $asoc =  $query->result();
     
     if($asoc != NULL){
       foreach ($asoc as $key):
         $this->hijos[$id_user][] = $key->id_hijo;
         $this->arbol_hijo($key->id_hijo);
       endforeach;       
     }else{
     	 $this->hijos[$id_user][] = 0;
     }    
  } 

    public function listar_productoxcompra($id_compra)
  {
    $this->db->where('d_c.id_compra', $id_compra);
    $query = $this->db->get('detalle_compra as d_c');
    return $query->result();
  } 


  public function update_promoProd($param)
  {
   $this->db->where('id_producto',$param['id_producto']);
   $this->db->where('id_promo',$param['id_promo']);
   $this->db->where('es_combo',$param['es_combo']);
   $query = $this->db->get('promo_producto',$param);
   $existe = $query->num_rows();
    if($existe > 0){
        //$this->db->update('promo_producto',$param);
        return "existe";
      }else{
       $this->db->insert('promo_producto',$param);
        return "insertado";
      }
  }

 
  

  /*Listar promociones*/
     public function listar_data_promos()
  {
     $this->db->select("id_promo,nombre_promo,DATE_FORMAT(fecha_inicio,'%d/%m/%Y') as fecha_inicio,DATE_FORMAT(fecha_fin,'%d/%m/%Y') as fecha_fin,descuento,estado_promo");
     $query = $this->db->get('promo');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

      public function listar_data_promo($id_promo)
  {
     $this->db->where('id_promo', $id_promo);
     $query = $this->db->get('promo_producto');
      if($query->num_rows() > 0){
        return $query->result();
      }else{
        return false;
      }
  }

  public function prod_promo($id_promo)
  {
    $this->db->select('prod.nombre_prod');
    $this->db->where('promo_p.id_promo', $id_promo);
    $this->db->where('promo_p.es_combo', 0);
    $this->db->join('productos as prod', 'prod.id_producto = promo_p.id_producto');
    $query = $this->db->get('promo_producto as promo_p');
    return $query->result();
  }


    public function udpate_detallepedidoCli($param) 
  {
     $this->db->where('id_pedidos',$param['id_pedidos']);
     $this->db->where('id_producto',$param['id_producto']);
     $query = $this->db->get('detalle_pedido');
    if($query->num_rows() > 0){
       $campo = array('precio_pedido' => $param['precio_pedido'],'cantidad' => $param['cantidad'],'importe' => $param['importe']);
       $this->db->where('id_pedidos',$param['id_pedidos']);
       $this->db->where('id_producto',$param['id_producto']);
       $this->db->update('detalle_pedido',$campo);
       $valor = "actualizado";
       
       return $valor;
      }else{
        $this->save_detallePedido($param);
        $valor = "insertado";
        return $valor;
      }
  }




  public function eliminar_prod_pedido($id)
    {
     $this->db->where('id_det_ped',$id);
     $this->db->delete('detalle_pedido');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }



    public function eliminar_Prod_promo($id)
    {
     $this->db->where('id_promo_prod',$id);
     $this->db->delete('promo_producto');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }

     public function eliminar_respAsoc($id)
    {
     $this->db->where('id_resp_prod',$id);
     $this->db->delete('respuestos');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }

   
   /*-----Devuelve el consecutivo de la orden -----------*/
   public function N_orden_compra($year) {
    
   $this->db->where('year',$year);
   $query = $this->db->get('orden_compra');
   $row = $query-> row();
   return $row->no_orden;
  
   } 
      /*-----actualiza consecutivo de la orden -----------*/
   public function update_orden_compra($year) {
   $orden = $this->N_orden_compra($year);
   $i=3;
   $n_orden = str_pad($orden, $i, 0, STR_PAD_LEFT);
   $data = array('no_orden' => $n_orden+1);
   $this->db->where('year',$year);
   $this->db->update('orden_compra',$data);
  
   }
   /*-----actualiza consecutivo de la orden -----------*/
   public function update_datosEmp($data_ins) {
   $data = array('password' => $data_ins['password'],'estado'=> 1);
   $this->db->where('email',$data_ins['email']);
   $this->db->update('emprendedor',$data);
  
   } 

    public function datos_productos($id_producto) {
    
   $this->db->where('id_producto',$id_producto);
   $query = $this->db->get('productos');
   return $query-> row();
  
   } 
    
    /*-----Devuelve dato del producto -----------*/
   public function datos_prod($id_producto) {
    
   $this->db->where('id_producto',$id_producto);
   $query = $this->db->get('productos');
   return $query-> row();
  
   }
    public function eliminar_prodCar($param)
    {
     $this->db->where('id_car',$param['id_car']);
     $this->db->where('id_emp',$param['id_emp']);
     $this->db->delete('carrito');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }
    public function eliminar_cap($id_cap)
    {
     $this->db->where('id_cap',$id_cap);
     $this->db->delete('capacitacion');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }

    public function eliminar_admin($id_emp)
    {
     $this->db->where('id_emp',$id_emp);
     $this->db->delete('emprendedor');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }


   public function update_ordenVideos($param)
  {
   $this->db->where('id_cap',$param['id_cap']);
   $this->db->update('capacitacion',$param);
      if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }

  


    public function eliminar_resp($id)
    {
     $this->db->where('id_respuesta',$id);
     $this->db->delete('cap_respuesta');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }


   public function update_resp($param)
  {
   $this->db->where('id_respuesta',$param['id_respuesta']);
   $this->db->update('cap_respuesta',$param);
      if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }


  public function eliminar_emp($id_emp)
    {
     $this->db->where('id_emp',$id_emp);
     $this->db->delete('emprendedor');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }
   /*-----------------------editar Perfil-----------------------*/ 
   
  public function update_perfil($param) 
  {
    $this->db->where('id_emp',$param['id_emp']);
    $this->db->update('emprendedor',$param);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }




 


























  /*-----Devuelve los datos de una tienda especifica-----------*/
   public function datos_tienda($id_tienda) {
    
   $this->db->where('id_tienda',$id_tienda);
   $query = $this->db->get('tiendas');
   
   return $query-> row();
  
   }
/*-------devuelve los datos del plan------------*/
  public function datos_plan($id_plan) 
  {
     $this->db->where('id_plan',$id_plan);
     $query = $this->db->get('plan_pago');
    return $query-> row();
  }
  /*-------devuelve los datos del usuario------------*/
  public function datos_usuario($id_usuario) 
  {
     $this->db->where('id_usuario',$id_usuario);
     $query = $this->db->get('usuario');
    return $query-> row();
  }
  /*------------devuelve los datos del usuario------------------*/
   public function datos_usuarioT($id_usuario){
      
        $this->db->where('id_usuario', $id_usuario);
        $this->db->join('plan_pago as plan ', 'plan.id_plan = usuario.id_plan');
        $query = $this->db->get('usuario');
        if($query->num_rows() > 0){
          return $query->row();
        }else{
          return false;
        }
    }
  /*-------devuelve los datos del plan------------*/
  public function update_plan($id_plan,$id_usuario) 
  {
      $fecha_solicPlan = date("Y-m-d H:i:s");
      $fecha_vencimiento = date("Y-m-d", strtotime("$fecha_solicPlan +1 month"));
      $data = array('plan_solicitado'   => $id_plan ,
                    'fecha_solicPlan'   => $fecha_solicPlan,
                    'fecha_vencimiento' => $fecha_vencimiento
                  );
      $this->db->where('id_usuario',$id_usuario);
      $this->db->update('usuario',$data);
      
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }
    /*-------actualiza el plan solicitado------------*/
  public function update_planSol($plan_sol,$id_usuario) 
  {
      $data = array('id_plan' => $plan_sol ,'plan_solicitado' => 0 );// el plan solicitado se pone en cero y se actualiza el id_plan
      $this->db->where('id_usuario',$id_usuario);
      $this->db->update('usuario',$data);
      
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
  }
    //----------------------------
  public function eliminar_usuarioTienda($id_usuario)
    {
     $this->db->where('id_usuario',$id_usuario);
     $this->db->delete('usuario');
     if($this->db->affected_rows() > 0){
        return true;
      }else{
        return false;
      }
  }
  
/*-------update los datos de los productos de una tienda------------*/
   public function update_producto_tienda($id_producto)
  {
     $data = array('seleccionado' => 1 ); // seleccionado 1 significa q esta seleccionado ese producto
     $this->db->where('id_producto',$id_producto);
     $this->db->update('productos_tienda',$data);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
   }
/*-------retorna los  productos a productos generales de la  tienda------------*/
   public function retorna_producto_tienda($id_producto)
  {
     $data = array('seleccionado' => 0,'cargado'=> 0,'aprobado'=> 0,'listo' => 0 ); // seleccionado 0 significa que  retorna a la tienda  ese producto
     $this->db->where('id_producto',$id_producto);
     $this->db->update('productos_tienda',$data);
     $this->insertar_eliminacion_prio($id_producto);
    
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
   }
 public function insertar_eliminacion_prio($id_producto)
  {
   $this->db->select('store_id'); 
   $this->db->where('id_producto',$id_producto);
   $query = $this->db->get('productos_tienda');
   $tienda = $query-> row();
   $dato_prod = array('id_producto' => $id_producto,'store_id' => $tienda->store_id);
   $this->db->insert('eliminacion_prio',$dato_prod); 
  }
  
/*-------insertar consulta de soporte tecnico------------*/
     public function insertar_consulta($data)
  {
      $this->db->insert('consultas_soporte',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }
      public function insertar_wizard($data)
  {
      $this->db->insert('usuario',$data);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }
  /*------------get datos de producto-------------------*/
  public function editar_producto($id_producto)
  {
    $this->db->where('id_producto',$id_producto);
    $query = $this->db->get('productos_tienda');
    if($query->num_rows() > 0){
      return $query->row();
    }else{
      return false;
    }
  }
  /*------------insertar usuarios registrados--------*/
     public function InsertDatosUsuario($param)
  {
      $this->db->insert('registro_usuario',$param);
     if($this->db->affected_rows() > 0){
          return true;
        
        }else{
          return false;
        }
     
  }
  /*-----------------------update datos de productos---------------------*/
    public function udpdateDatosProd($param)
  {
    
    $campos = array(
                   'descripton'  => $param['descripton'],
                   'id_categoria'=> $param['id_categoria'],
                   'listo'       =>1
                  );
     $this->db->where('id_producto',$param['id_producto']);
     $this->db->update('productos_tienda',$campos);
     if($this->db->affected_rows() > 0){
      return true;
       }else{
         return false;
        }
   } 
   
  
    //-----------------codigo viejo -----------

  //--------------actualizar valor_inicial del curso------------------------
  public function aumentar_valor_curso()
  {
   $datos['valor_inicial_curso'] = $this->getValorincialCurso();
   $text = $datos['valor_inicial_curso']->valor + 1;
   $data = array('valor' => $text);
   $this->db->where('parametro','valor_inicialcurso');
   $this->db->update('configuracion',$data);
  }
//----------------------------------------   
 public function count_all()
  {
    $this->db->from('chofer');
    $this->db->where('stado','1');
    return $this->db->count_all_results();
  }
  //--------------contar Productos--------
   public function count_Productos($store_id)
  {
    $this->db->from('productos_tienda');
    $this->db->where('store_id',$store_id); 
    return $this->db->count_all_results();
  }
   public function count_Productos_generales($store_id)
  {
    $this->db->from('productos_tienda');
    $this->db->where('store_id',$store_id);
  $this->db->where('seleccionado',0);
    return $this->db->count_all_results();
  }
  public function count_Productos_seleccionados($store_id)
  {
    $this->db->from('productos_tienda');
    $this->db->where('store_id',$store_id);
  $this->db->where('seleccionado',1);
    return $this->db->count_all_results();
  }
    //--------------contar Productos SELECCIONADO DADO UNA TIENDA--------
   public function count_Productos_Selec($store_id)
  {
    $this->db->from('productos_tienda');
    $this->db->where('store_id',$store_id);
    $this->db->where('seleccionado',1);
    return $this->db->count_all_results();
  }
     //--------------contar Nuevas Solitudes--------
   public function count_NuevasSolitudPlan()
  {
    $this->db->from('usuario');
    $this->db->where('plan_solicitado !=',0);
    return $this->db->count_all_results();
  }
   public function getNewNoticaciones()
  {
   $this->db->select('*');    
   $this->db->from('usuario as us'); 
   $this->db->join('tiendas as tie', 'us.id_tienda = tie.id_tienda');
   $this->db->join('plan_pago as plan', 'us.id_plan = plan.id_plan');
   $this->db->where('plan_solicitado !=',0);
   $query = $this->db->get();
   return $query->result();    
  }
    public function getPlanes()
  {
   $this->db->from('plan_pago');
   $query = $this->db->get();
   return $query->result();    
  }


  //------------------ contar alumnos inscritos curso----

   public function count_alumnoInscritosC($idEvento)
  {
    $this->db->where('idEvento',$idEvento);
    $this->db->from('alumno');
    return $this->db->count_all_results();
  }


    public function count_recibosTotal()
  {
    $this->db->from('recibo_boleta');
    return $this->db->count_all_results();
  }

   public function count_Nincripciones()
  {
    $this->db->where('stado','0');
    $this->db->from('chofer');
    return $this->db->count_all_results();
  }




	public function get_sumatoriaventa()
	{
    $this->db->where('stado','1');
	  $this->db->select_sum('precio');
   // $this->db->as('total');
    $this->db->from('chofer');
    //$this->db->join('chofer', 'curso.id_curso = chofer.id_curso', 'inner');
    $query = $this->db->get();
         
    return  $query-> row();
	}
  public function get_sumatoriaCentro($id_centro)
  {
    $this->db->where('id_centro',$id_centro);
    $this->db->select_sum('importe_curso');
   // $this->db->as('total');
    $this->db->from('recibo_boleta');
    $query = $this->db->get();
  return  $query-> row();
  }

    public function get_sumatoriaTotal()
  {
    
    $this->db->select_sum('total_comp');
    $this->db->from('compra');
    $query = $this->db->get()->row();
  return  $query->total_comp;
  }

   public function get_sumatoriaTotalMes()
  {
    $mes  = date('m');
    $year = date('Y');
    $this->db->select_sum('total_comp');
    $this->db->from('compra');
    $this->db->where("MONTH(fecha_comp)",$mes);
    $this->db->where("YEAR(fecha_comp)",$year);
    $query = $this->db->get()->row();
  return  $query->total_comp;
  }

  
	
	public function getdatosregion($id_region)
  {
    $this->db->where('id_region',$id_region);
    $query = $this->db->get('region');
    return $query->row();
 }

public function getdatosChofer($dni)
  {
    $this->db->where('dni',$dni);
    $query = $this->db->get('chofer');
    return $query->row();
 }

 public function getdatosChofer_codigo($codigo_barra)
  {
    $this->db->where('codigo_barra',$codigo_barra);
    $query = $this->db->get('chofer');
    return $query->row();
 }



public function datosChofer(){
        $codigo_barra = $this->input->get('codigo_barra');
        $this->db->where('codigo_barra', $codigo_barra);
        $query = $this->db->get('chofer');
        if($query->num_rows() > 0){
          return $query->row();
        }else{
          return false;
        }
    } 


 

public function getdatosChofer_recibo($codigo_barra)
  {
    $this->db->where('codigo_barra',$codigo_barra);
    $query = $this->db->get('recibo_boleta');
    return $query->row();
 }

 

 public function insertar_recibo_bol($campos)
  {
    $this->db->insert('recibo_boleta',$campos);
   
 }
  //-------------devuelve la fila bol_inicial--------
  public function getValorInicial()
  {
    $this->db->where('parametro','bol_inicial');
    $query = $this->db->get('configuracion');
    return $query->row();
 }

   public function getValorInicialInscrip($id_centro)
  {
    $this->db->where('id_centro',$id_centro);
    $query = $this->db->get('recibo_unidad');
    return $query->row();
 }


   public function getValorInicialInscrip_centro($id_centro)
  {
    $this->db->where('id_centro',$id_centro);
    $query = $this->db->get('inscripcion_centro');
    return $query->row();
 }

  public function mod_ValorInicialInscrip_centro($id_centro,$valor_inscripcion)
    {
      $datos  = array('valor' => $valor_inscripcion);

      $this->db->where('id_centro',$id_centro);
      $this->db->update('inscripcion_centro',$datos);

    }

  public function insert_ValorInicialInscrip_centro($id_centro)
    {

      $datos  = array('id_centro' => $id_centro,'valor' => 1);
      $this->db->insert('inscripcion_centro',$datos);

    }
  


 

 public function mod_ValorInicialInscrip($id_centro,$valor_inscripcion)
    {
      $datos  = array('valor' => $valor_inscripcion);

      $this->db->where('id_centro',$id_centro);
      $this->db->update('recibo_unidad',$datos);

    }

    public function insert_ValorInicialInscrip($id_centro)
    {

      $datos  = array('id_centro' => $id_centro,'valor' => 1);
      $this->db->insert('recibo_unidad',$datos);

    }

    

 public function aumentar_valor_no_recibo($aumento)
    {

     $this->db->where('parametro','no_recibo');
     $this->db->update('recibo_unidad',$aumento);

    }

 //-------------aumentar el valor_pedido------------
  public function aumentar_valor_no_inscripcion($aumento)
    {
     $data = array('valor' => $aumento);
     $this->db->where('parametro','n_inscripcion');
     $this->db->update('configuracion',$data);

    }

 public function getdatosrecibo_bol($id_recibo)
  {
    $this->db->where('id_recibo',$id_recibo);
    $query = $this->db->get('recibo_boleta');
    return $query->row();
 }
 
 
  public function getdatosCentro($id_centro)
  {
    $this->db->where('id_centro',$id_centro);
    $query = $this->db->get('centro_inscripcion');
    return $query->row();
 }

  public function getdatosAlumnoInscrito($id_inscripcion)
  {
    $this->db->where('id_inscripcion',$id_inscripcion);
    $query = $this->db->get('inscripcion');
    return $query->row();
 }
  public function getdatosAlumno($id_alumno)
  {
    $this->db->where('id_alumno',$id_alumno);
    $query = $this->db->get('alumno');
    return $query->row();
 }
 
  public function getdatosAula($id_unidad)
  {
    $this->db->where('id_unidad',$id_unidad);
    $query = $this->db->get('aula');
    return $query->row();
 }

   public function aula($id_aula)
  {
    $this->db->where('id_aula',$id_aula);
    $query = $this->db->get('aula');
    return $query->row();
 }

  public function getdatosprofesor($idEvento)
  {
    $this->db->where('idEvento',$idEvento);
    $query = $this->db->get('profesor');
    if($query->num_rows() > 0){
          return $query->row();
        }else{
          return false;
        }
   
 }

 public function ver_siexitprofesor($idEvento)
  {
    $this->db->from('profesor');
    $this->db->where('idEvento',$idEvento);
    return $this->db->count_all_results();
 }

 

 public function getdatosprofesorCBO($idEvento,$dia)
  {
    $this->db->where('idEvento',$idEvento);
    $this->db->where('dia',$dia);
    $query = $this->db->get('profesor');
    if($query->num_rows() > 0){
          return $query->row();
        }else{
          return false;
        }
   
 }
 

   public function getValorconvenio()
  {
    $this->db->where('parametro','convenio_bancario');
    $query = $this->db->get('configuracion');
    return $query->row();
 }
   public function getValorincialCurso()
  {
    $this->db->where('parametro','valor_inicialcurso');
    $query = $this->db->get('configuracion');
    return $query->row();
 }

 public function getallUsuariosTienda()
  {
   $this->db->select('*');    
   $this->db->from('usuario as us'); 

   $this->db->join('tiendas as tie', 'us.id_tienda = tie.id_tienda');
   $this->db->join('plan_pago as plan', 'us.id_plan = plan.id_plan');
   $query = $this->db->get();
   return $query->result();    
  }
 public function getPagoexitoso()
  {
   $this->db->select('*');
   $this->db->from('notificaciones_pagoexitoso as noti_pago'); 
   $this->db->join('usuario as us','us.id_usuario = noti_pago.id_usuario');
   $this->db->join('plan_pago as plan', 'us.id_plan = plan.id_plan');
   $query = $this->db->get();
   return $query->result();    
  }
  /*--------------devolver historico de usuario de planes------------*/  

  public function getHistoricoUsuariosTienda($id_usuario)
  {
   $this->db->select('*');    
   $this->db->from('historico_pago as hist_pago'); 
   $this->db->where('hist_pago.id_usuario',$id_usuario);
   $this->db->join('usuario as us','us.id_usuario = hist_pago.id_usuario');
   $this->db->join('plan_pago as plan', 'hist_pago.id_plan = plan.id_plan');
   $query = $this->db->get();
   return $query->result();    
  }

    /*--------------devolver historico de usuario Admin------------*/  

  public function HistoricoUsuariosTienda()
  {
   $this->db->select('*');    
   $this->db->from('historico_pago as hist_pago'); 
   $this->db->join('usuario as us','us.id_usuario = hist_pago.id_usuario');
   $this->db->join('plan_pago as plan', 'hist_pago.id_plan = plan.id_plan');
   $query = $this->db->get();
   return $query->result();    
  }  

   public function getPagoxConfirmar()
  {
   $this->db->select('*');
   $this->db->from('notificaciones_error_pago as noti_error'); 
   $query = $this->db->get();
   return $query->result();    
  }  
  /*-------administrar categorias---*/

   public function administrar_categorias()
  {
   $this->db->select('*');
   $this->db->from('categorias'); 
   $query = $this->db->get();
   return $query->result();    
  } 

  public function getPlanSolicitado($id_usuario)
  {
   $this->db->where('id_usuario',$id_usuario);
    $query = $this->db->get('usuario');
    return $query->row();    
  }

   public function getProd_Tienda($store_id,$number_per_page)
  {
   $this->db->select('*');    
   $this->db->from('productos_tienda'); 
   $this->db->where('store_id',$store_id);
   $this->db->where('seleccionado',0);
  $this->db->limit($number_per_page,$this->uri->segment(3));
   $query = $this->db->get();
   return $query->result();    
  }

/*MUESTRA LOS PRODUCTOS SELECCIONADOS DADO UNA TIENDA*/
   public function getProd_Tienda_Selec($store_id,$number_per_page)
  {
   $this->db->select('*');    
   $this->db->from('productos_tienda'); 
   $this->db->where('store_id',$store_id);
   $this->db->where('seleccionado',1);
   $this->db->limit($number_per_page,$this->uri->segment(3));
   $query = $this->db->get();
   return $query->result();    
  }



  //----------getProvincia-----

  public function getProvincia()
  {
   
   $this->db->select('*');    
   $this->db->from('provincia'); 
   return $query = $this->db->get();
       
  }

  //--------------obtener el precio unitario de los productos--------------
    public function datosunidad(){
        $id_provincia = $this->input->get('id_provincia');
        $this->db->where('id_provincia',$id_provincia);
        $query = $this->db->get('unidad_academica');
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return false;
        }
    }
  //----------------obtener datos de recibo_boleta
    public function datosrecibo_boleta(){
        
        $id_unidad = $this->input->get('id_unidad');
        $this->session->set_flashdata("id_unidad_flash", $id_unidad);
        $this->db->where('id_unidad',$id_unidad);
        $query = $this->db->get('recibo_boleta');
        if($query->num_rows() > 0){
          return $query->result();
        }else{
          return false;
        }
    }  

     public function mostrar_rep($id_unidad){
       
       $this->db->where('id_unidad',$id_unidad);
       $query = $this->db->get('recibo_boleta');
       return $query->result();
       
    } 
 


   public function listardatosunidad()
   {
    $query = $this->db->get('unidad_academica');
    return $query->result();
   }


   public function listardatos_correos_ins($mes,$id_unidad,$id_curso)
   {
    $this->db->select('mail,nombre_alumno,apellido_alunmo,numero_doc,sku,nombre_curso');
    $this->db->from('alumno as al');
    $this->db->join('eventos as ev', 'al.idEvento = ev.idEvento'); 
    $this->db->join('unidad_academica  as ua', 'ua.id_unidad = ev.id_unidad');
    $this->db->join('curso  as cur', 'ev.id_curso = cur.id_curso');    
    
    $this->db->where('ua.id_unidad',$id_unidad);
    $this->db->where('cur.id_curso',$id_curso);
    $this->db->where('MONTH(ev.fecInicio)',$mes);
   // $this->db->where('YEAR(CURDATE())'); //NOTA TENGO Q BUSCAR EL PARMETRO PARA SACARLE EL AÑO
    $this->db->where('al.estado',3);
    $query = $this->db->get();
    return $query->result();
   }

   public function listarcapacitadorC($id_centro,$id_curso)
   {
     $this->db->where('id_centro',$id_centro);
     $this->db->where('id_curso',$id_curso);
     $query = $this->db->get('capacitador');
     return $query->result();
   }

   public function listarcapacitador()
   {
     
     $query = $this->db->get('capacitador');
     return $query->result();
   }


     public function update_pagoRecibo()
  {
    $id = $this->input->post('id_recibo');
    $field = array(
                  'fecha_entrega'=>$this->input->post('fecha_entrega'), 
                  'estado_entregado'  =>'PAGADO'
                  
                  );
    $this->db->where('id_recibo', $id);
    $this->db->update('recibo_boleta', $field);
    if($this->db->affected_rows() > 0){
      return true;
    }else{
      return false;
    }
  }

    public function buscar_chofer($dni){
       
       $this->db->where('dni',$dni);
       $query = $this->db->get('chofer');
       return $query->result();
       
    }

     public function eliminar_recib()
  {
    $id            = $this->input->post('id_recibo');
    $usuario       = $this->input->post('usuario');
    $motivo        = $this->input->post('motivo');
    $row['recibo'] = $this ->getdatosrecibo_bol($id);
    $fecha_log     = date('Y-m-d H:i:s');
     
    $data = array(
                   'no_recibo_boleta'   => $row['recibo']->no_recibo_boleta,
                   'id_centro'          => $row['recibo']->id_centro,
                   'id_unidad'          => $row['recibo']->id_unidad,
                   'codigo_barra'       => $row['recibo']->codigo_barra,
                   'n_boleta'           => $row['recibo']->n_boleta,
                   'nombre'             => $row['recibo']->nombre,
                   'apellidos'          => $row['recibo']->apellidos,
                   'dni'                => $row['recibo']->dni,
                   'id_curso'           => $row['recibo']->id_curso,
                   'importe_curso'      => $row['recibo']->importe_curso,
                   'fecha_recibo'       => $row['recibo']->fecha_recibo,
                   'estado_entregado'   => $row['recibo']->estado_entregado,
                   'fecha_entrega'      => $row['recibo']->fecha_entrega,
                   'id_unidad_registro' => $row['recibo']->id_unidad_registro,
                   'motivo'             => $motivo,
                   'usuario'            => $usuario,
                   'fecha_log'          => $fecha_log
                   
                   );
        $this->db->insert('backup_registros',$data);
        
         if($this->db->affected_rows() > 0){
            $dni = $row['recibo']->dni;
            $resultado = $this->buscar_chofer($dni);
            
            foreach ($resultado as  $value):
              $this->db->where('dni',$dni);
              $this->db->delete('chofer');
            endforeach ;
           
          $this->db->where('id_recibo', $id);
          $this->db->delete('recibo_boleta');
        return true;
        }else{
          return false;
        }

  }

  ///--------------------recibo_por centro academico-------------------------------------

   public function showRecibo_centro($id_centro,$fecha_inicial,$fecha_final)
   {

      $this->db->where('id_centro',$id_centro);
      $this->db->where('fecha_recibo >= "'.$fecha_inicial.'"');
      $this->db->where('fecha_recibo <="'.$fecha_final.'"' );
      $query = $this->db->get('recibo_boleta');
      if($this->db->affected_rows() > 0){
       
       return $query->result();
      
      }else{
        return false;
      }
    
  }


   public function showallRecibo($fecha_inicial,$fecha_final)
   {

      $this->db->where('fecha_recibo >=',$fecha_inicial);
      $this->db->where('fecha_recibo <=',$fecha_final);
      $query = $this->db->get('recibo_boleta');
      if($this->db->affected_rows() > 0){
       
       return $query->result();
      
      }else{
        return false;
      }
    
  }

  
   public function showdatoschofer($dni)
  {
   $this->db->where('dni',$dni);
   $query = $this->db->get('chofer'); 
  return $query-> row();
  }

  public function datosChoferDNI(){
        $dni = $this->input->get('dni');
        $this->db->where('dni', $dni);
        $query = $this->db->get('chofer');
        if($query->num_rows() > 0){
          return $query->row();
        }else{
          return false;
        }
    }


   public function showdatosunidadA($id_unidad)
  {
   $this->db->where('id_unidad',$id_unidad);
   $query = $this->db->get('unidad_academica'); 
  return $query-> row();
  }

    public function showdatosProvincia($id_provincia)
  {
   $this->db->where('id_provincia',$id_provincia);
   $query = $this->db->get('provincia'); 
  return $query-> row();
  }
  public function showdatosDistrito($id_distrito)
  {
   $this->db->where('id_distrito',$id_distrito);
   $query = $this->db->get('distrito_academico'); 
  return $query-> row();
  }




//----------------devuelve todos los cursos----------------------
   public function getCursos()
  {
   $this->db->select('*');    
   $this->db->from('curso'); 
     return $query = $this->db->get();
   }

//----------devuelve los datos del curso especifico---------------
  public function getCurso($id)
  {
   $this->db->select('*'); 
   $this->db->where('id_curso',$id);
   $this->db->from('curso'); 
   $query = $this->db->get(); 

     return $query-> row();
  }
  //-----------tabla  inscripcion curso-------------
   public function getinscripcion_curso($id)
  {
   $this->db->where('id_inscripcion',$id);
   $query = $this->db->get('inscripcion_curso'); 
  return $query-> row();
  }
 
  
  public function getunidad($id)
  {
   $this->db->where('id_unidad',$id);
   $query = $this->db->get('unidad_academica'); 
   return $query-> row();
  }


  public function get_existencia($id_producto)
    {
      
       $this->db->where('id_producto',$id_producto);
       $query = $this->db->get('existencia');
       
       return $query-> row();
       
    }
    


  public function get_CategoriaxAlmacen($id_almacen)
  {
    
     $this->db->where('id_almacen',$id_almacen);
     $query = $this->db->get('categoria');
     
     return $query-> row();
     
  }

  public function get_usuario($id_usuario)
  {
    
     $this->db->where('id_usuario',$id_usuario);
     $query = $this->db->get('usuario');
     
     return $query-> row();
     
  }

  public  function suma($id_centro) 
  {    
    $this->db->select_sum('importe_curso');
    $this->db->as('total_recibo_boleta');
    $this->db->where('id_centro',$id_centro); 
    $query=$this->db->get('recibo_boleta');    
  return $query-> row();
  }

public function update_cantidad_final($cantidad_existente,$id_producto)
  {
    $this->db->where('id_producto',$id_producto);   
   
    return $this->db->update('entrada_producto', $cantidad_existente );  
  }


  public function getVentas($id_producto)
  {
    
     $this->db->select('cantidad_articulo,fecha_venta');
     $this->db->where("id_producto", $id_producto);
     $this->db->order_by("fecha_venta", "asc");
     $query = $this->db->get('venta');
          
     return $query->result_array();
     
  }
    public function getVentasxProducto()
  {
    
    $this->db->select('nombre_producto, cantidad_articulo,fecha_venta');
    $this->db->from('venta'); 
    $this->db->order_by("cantidad_articulo", "asc"); 
    $this->db->join('producto','producto.id_producto = venta.id_producto', 'inner');
       
    $query = $this->db->get();
    
    return $query-> row();
     
  }
   public function devolver_nombre_Producto($id_producto)
    {
     $this->db->select('nombre_producto');   
     $this->db->where('id_producto',$id_producto);
     $query = $this->db->get('producto');
     
     return $query-> row();
     
    }



    public function devolver_datos_almacen($id_almacen)
    {
        
     $this->db->where('id_almacen',$id_almacen);
     $query = $this->db->get('almacen');
     
     return $query-> row();
     
    }

    public function comprobar_ext($id_almacen,$id_categoria,$id_producto,$fecha)
    {
        
     $porciones = explode("/",$fecha);
     $mes = $porciones[1];
     $ano = $porciones[2];
     $this->db->where('id_almacen',$id_almacen);
     $this->db->where('id_categoria',$id_categoria);
     $this->db->where('id_producto',$id_producto);
     $this->db->where('mes',$mes);
     $this->db->where('ano',$ano);
     
     $query = $this->db->get('existencia');
     
     return $query-> row();
     
    }

     public function comprobar_existencia_venta($id_almacen,$id_categoria,$id_producto)
    {
 
     $this->db->where('id_almacen',$id_almacen);
     $this->db->where('id_categoria',$id_categoria);
     $this->db->where('id_producto',$id_producto);
        
     $query = $this->db->get('existencia');
     
     return $query-> row();
     
    }


    public function insertar_ext($id_almacen,$id_categoria,$id_producto,$fecha,$cantidad_inicial)
    {
        
     $porciones = explode("/",$fecha);
     $mes = $porciones[1];
     $ano = $porciones[2];
     
      $data = array(
        'id_almacen' => $id_almacen,
        'id_categoria' => $id_categoria,
        'id_producto' => $id_producto,
        'cantidad_existente' => $cantidad_inicial,
        'mes' => $mes,
        'ano' => $ano);

        $this->db->insert('existencia',$data);

        return true;
     
    }

    public function update_ext($id_almacen,$id_categoria,$id_producto,$fecha,$sumatoria)
    {
        
     $porciones = explode("/",$fecha);
     $mes = $porciones[1];
     $ano = $porciones[2];
     
      $data = array(
        'cantidad_existente' => $sumatoria);

         $this->db->where('id_almacen',$id_almacen);
         $this->db->where('id_categoria',$id_categoria);
         $this->db->where('id_producto',$id_producto);
         $this->db->where('mes',$mes);
         $this->db->where('ano',$ano);
         $this->db->update('existencia',$data);

         return true;
     
    }

    public function update_extente_venta($id_almacen,$id_categoria,$id_producto,$resultado_existente)
    {
        
     
      $data = array(
        'cantidad_existente' => $resultado_existente);

         $this->db->where('id_almacen',$id_almacen);
         $this->db->where('id_categoria',$id_categoria);
         $this->db->where('id_producto',$id_producto);
         $this->db->update('existencia',$data);

         return true;
     
    }

}


