
<div id="container2"> <!-- aqui tenemos la tabla de los empleados-->
<div class="jumbotron text-center"><h1>EMPLEADOS</h1></div>
<div class="container">
    <div class="control-group">  
        <?php App::get_template('empleados/pidempleado'); ?>

        <table name="booklist" id="dtable" class="table table-striped">
            <thead>
                <th style="text-align: left" width="5%" class="tide">ID</th>
                <th style="text-align: left" width="10%"class="tdnie">DNI</th>                 
                <th style="text-align: left" width="10%"class="tnome">Nombre</th>
                <th style="text-align: left" width="10%"class="tsuele" >Sueldo</th>
            </thead>
            <tbody>
                
                <?php foreach( $empleados as $empleado ): ?>

                    <tr style="text-align: center" class='tb1' width="90%" >
                        <td style="text-align: left" width="5%"class="eiduser" ><?php echo $empleado['IdUser']; ?></td>
                        <td style="text-align: left" width="10%"class="edni" ><?php echo $empleado['DNI']; ?></td>                        
                        <td style="text-align: left" width="10%"class="enombre" ><?php echo $empleado['Nombre']; ?></td>
                        <td style="text-align: left" width="10%"class="esueldo" ><?php echo $empleado['Sueldo']; ?></td>
                        <td class="idede"> <a href='index.php?action=edit-employee&id=<?php echo $empleado['IdUser']; ?>' id='idede'>Editar</a></td>
                        <td class="idboe"> <a href='index.php?action=delete-employee&id=<?php echo $empleado['IdUser']; ?>' onclick="return confirm('¿Seguro borrar este empleado?');" id='idboe'>Borrar</a></td>
                    </tr>

                <?php endforeach ?>

            <tbody>

        </table>
    </div>
</div>
</div>
<?php App::get_template('footer'); ?>