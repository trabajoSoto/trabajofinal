
<div id="container2"> <!-- aqui tenemos la tabla de materiales-->
<div class="jumbotron text-center"><h1>INVENTARIO</h1></div>
    <div class="container">
        <div class="control-group"> 


            <table name="booklist" id="drtable" class="table table-striped">
                <thead class="schedule">
                <tr>
                    <th>Material</th>			
                    <th>Instalacion</th>
                    <th>Unidades</th>
                </tr>

                </thead>
                <tbody class="schedule" >
                    <?php foreach( $materiales as $material ): ?>
                            <tr class='tb1'>

                                <td><?php echo $material['nomMaterial']; ?></td>

                                <td><?php echo $material['Nombre_Instalacion']; ?></td>

                                <td><?php echo $material['unidades']; ?></td>
                            </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>
