
    <div id="container2"> <!-- aqui tenemos la tabla de los deudores-->
        <div class="jumbotron text-center"><h1>DEUDORES</h1></div>
        <div class="container">
            <div class="control-group">
                <table class="table table-striped" name="booklist" id="dtables" width="100%">
                    <thead>
                        <th style="text-align: center" >ID</th>
                        <th style="text-align: center" width="5%">Metodo Pago</th>

                    </thead>
                    <tbody>
                        
                    <?php foreach( $socios as $socio ): ?>

                                <tr style="text-align: center" class='tb1' width="100%">
                                    <td class="text-danger" width="5%"><?php echo $socio['idPago']; ?></td>
                                    <td class="text-danger" width="5%"><?php echo $socio['tipoPago']; ?></td>
                                </tr>

                    <?php endforeach; ?>
                    
                    </tbody>
                </table>
        </div>
        </div>
        </div>
    </div>

