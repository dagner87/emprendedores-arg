<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Compra confirmada</title>
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
          <td style="background:#7ace4c; padding:20px; color:#fff; text-align:center;"><h2> Compra confirmada</h2></td>
        </tr>
      </tbody>
    </table>
    <div style="padding: 40px; background: #fff;">
      <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
        <tbody>
          <tr>  
            <td><p style="margin-top:0px;"><strong>No Compra: </strong> #<?= $compra->no_compra ?></p></td>
            <?php $fecha_comp = date("d/m/Y H:i:s", strtotime("$compra->fecha_comp"));?>
            <td align="right" width="100"> <?= $fecha_comp ?></td>
          </tr>
          <tr>
            <td colspan="2" style="padding:20px 0; border-top:1px solid #f6f6f6;"><div>
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tbody>

                       <?php 
                            if(!empty($detalle)):
                             $cont=1;   
                            foreach ($detalle as $row) :
                              $nombre = '';  

                             if ($row->es_combo == 0) {
                                     $nombre = $row->nombre_prod;
                                } else { 
                                    $nomb = $this->modelogeneral->datoscombo($row->id_producto);
                                    $nombre = $nomb->nombre_combo;
                                }
                                   

                             ?>
                             <tr>
                              <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0; padding: 9px 0;"><?= $row->cantidad_comp ?> <?= $nombre ?></td>
                              <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; margin: 0; padding: 9px 0;"  align="right">$ <?= $row->precio_comp ?></td>
                            </tr>
                            <?php endforeach; ?>

                            <tr class="total">
                              <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; border-top-width: 1px; border-top-color: #f6f6f6; border-top-style: solid; margin: 0; padding: 9px 0; font-weight:bold;" width="80%">Envío</td>
                              <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; border-top-width: 1px; border-top-color: #f6f6f6; border-top-style: solid; margin: 0; padding: 9px 0; font-weight:bold;" align="right">$ <?= $compra->precio_envio ?></td>
                            </tr> 


                            <tr class="total">
                              <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; border-top-width: 1px; border-top-color: #f6f6f6; border-top-style: solid; margin: 0; padding: 9px 0; font-weight:bold;" width="80%">Total</td>
                              <td style="font-family: 'arial'; font-size: 14px; vertical-align: middle; border-top-width: 1px; border-top-color: #f6f6f6; border-top-style: solid; margin: 0; padding: 9px 0; font-weight:bold;" align="right">$ <?= $compra->total_comp ?></td>
                            </tr> 
                            <?php endif; ?>

                   

                  </tbody>
                </table>
              </div></td>
          </tr>
        </tbody>
      </table>
    </div>
    
  </div>
</div>
</body>
</html>
