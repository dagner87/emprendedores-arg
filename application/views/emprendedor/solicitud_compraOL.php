<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Solicitud de Compra</title>
</head>
<body style="margin:0px; background: #f8f8f8; ">
<div width="100%" style="background: #f8f8f8; padding: 0px 0px; font-family:arial; line-height:28px; height:100%;  width: 100%; color: #514d6a;">
  <div style="max-width: 700px; padding:50px 0;  margin: 0px auto; font-size: 14px">
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-bottom: 20px">
      <tbody>
        <tr>
          <td style="vertical-align: top; padding-bottom:30px;" align="center"><a href="javascript:void(0)" target="_blank"><img src="<?php echo base_url();?>assets/plugins/images/admin-logo2.png" alt="Compra Pendiente" style="border:none"><br/>
          </td>
        </tr>
      </tbody>
    </table>
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
      <tbody>
        <tr>
          <td style="background:#ffbb44; padding:20px; color:#fff; text-align:center;"><h2> Compra está pendiente de confirmación</h2></td>
        </tr>
      </tbody>
    </table>
    <div style="padding: 40px; background: #fff;">
      <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
        <tbody>
          <tr>
            <td><b>Cliente: <?= $datos_hijo->nombre_emp ?> </b>
              <address>
                <p class="text-muted m-l-30"><strong> Email: </strong><?= $datos_hijo->email ?>
                    <br/><strong> Teléfono:</strong><?= $datos_hijo->telefono_emp  ?>
             </address>
            </td>
           </tr>
          <tr>  
            <td><p style="margin-top:0px;">No Compra: #<?= $compra->no_compra ?></p></td>
            <?php $fecha_comp = date("d/m/Y H:i:s", strtotime("$compra->fecha_comp"));?>
            <td align="right" width="100"> <?= $fecha_comp ?></td>
          </tr>
          <tr>
            <td colspan="2" style="padding:20px 0; border-top:1px solid #f6f6f6;"><div>
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tbody>

                       <?php 
                            if(!empty($productos)):
                             $cont=1;   
                            foreach ($productos as $row) :
                            ?>

                             <tr>
                              <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0; padding: 9px 0;"><?= $row->cantidad_comp ?>
                              <?php 
                                $nombre_prod = $this->modelogeneral->getdatos_prod_combo($row->id_producto,$row->es_combo);
                                 echo  $nombre_prod->nombre_prod;
                                ?>
                               </td>
                           
                            <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0; padding: 9px 0;"  align="right">$ <?= $row->precio_comp ?></td>
                            </tr>
                            <?php endforeach; ?>

                            <tr class="total">
                              <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; border-top-width: 1px; border-top-color: #f6f6f6; border-top-style: solid; margin: 0; padding: 9px 0; font-weight:bold;" width="80%">Total</td>
                              <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; border-top-width: 1px; border-top-color: #f6f6f6; border-top-style: solid; margin: 0; padding: 9px 0; font-weight:bold;" align="right">$ <?= $compra->total_comp ?></td>
                            </tr> 
                            <?php endif; ?>

                   

                  </tbody>
                </table>
              </div></td>
          </tr>
          <tr>
            <td colspan="2"><center>
                <a href="<?php echo base_url();?>panel_admin/ventas" style="display: inline-block; padding: 11px 30px; margin: 20px 0px 30px; font-size: 15px; color: #fff; background: #1e88e5; border-radius: 60px; text-decoration:none;">Calcular Envio</a>
              </center>
              <b></b> </td>
          </tr>
        </tbody>
      </table>
    </div>
    <!--div style="text-align: center; font-size: 12px; color: #b2b2b5; margin-top: 20px">
      <p> Powered by Themedesigner.in <br>
        <a href="javascript: void(0);" style="color: #b2b2b5; text-decoration: underline;">Unsubscribe</a> </p>
    </div-->
  </div>
</div>
</body>
</html>
