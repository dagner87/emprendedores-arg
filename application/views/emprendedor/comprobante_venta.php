<div class="row" id="modal-body">
                    <div class="col-md-12">
                        <div class="white-box printableArea">
                            <h3><b>NO. VENTA</b> <span class="pull-right" id="no_vent"></span></h3>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="pull-left">
                                        <address>
                                            <h4> &nbsp;<b class="text-info"><?= $row_venta->nombre_emp." ".$row_venta->apellido ?></b></h4>
                                            <p class="text-muted m-l-5">
                                                <br/><strong>Email: </strong><?= $row_venta->email  ?>
                                                <br/><strong> DNI:</strong><?= $row_venta->dni_emp  ?>,
                                                <br/><strong>Teléfono:</strong><?= $row_venta->telefono_emp  ?>,
                                           </p>
                                        </address>
                                    </div>
                                    <div class="pull-right text-right">
                                        <address>
                                            <h3>Cliente:</h3>
                                            <h4 class="font-bold"><?= $row_venta->nombre_cliente." ".$row_venta->apellidos ?></h4>
                                            <p class="text-muted m-l-30">
                                                <strong> Email: </strong><?= $row_venta->email  ?>,
                                                <br/><strong> Teléfono:</strong><?= $row_venta->telefono  ?>,
                                                <br/><strong> Celular: </strong><?= $row_venta->celular  ?>,
                                                <br/><strong> Direccion:</strong><?= $row_venta->direccion ?></p>
                                         </address>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive m-t-40" style="clear: both;">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th class="text-right">Cantidad</th>
                                                    <th class="text-right">P/U</th>
                                                    <th class="text-right">Importe</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php foreach($detalles_prod as $detalle):?>
                                                    <tr>
                                                        <td><?php echo $detalle->nombre_prod;?></td>
                                                        <td class="text-right"><?php echo $detalle->cantidad;?></td>
                                                        <td class="text-right">$<?php echo $detalle->precio_pedido;?></td>
                                                        <td class="text-right">$<?php echo $detalle->importe;?></td>
                                                    </tr>
                                                    <?php endforeach;?>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="pull-right m-t-30 text-right">
                                        <!--p>Sub - Total amount: $13,848</p>
                                        <p>vat (10%) : $138 </p-->
                                        <hr>
                                        <h3><b>Total :</b> $<?= $row_venta->total  ?></h3> </div>
                                    <div class="clearfix"></div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

 <script type="">
    $(document).ready(function (){
        var numero = generarnumero(<?= $row_venta->no_pedido  ?>);
       $("#no_vent").html("# "+numero);
   });
                    
    function generarnumero(numero){
        if (numero>= 9999 && numero< 99999) {
            return "0" + (Number(numero));
        }
        if (numero>= 999 && numero< 9999) {
            return "00" + (Number(numero));
        }
        if (numero>= 99 && numero< 999) {
            return "000" + (Number(numero));
        }
        if (numero>= 9 && numero< 99) {
            return "0000" + (Number(numero));
        }
        if (numero < 9 ){
            return "00000" + (Number(numero));
        }
    }
</script>

