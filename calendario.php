
<div class="jumbotron text-center"><h1>CALENDARIO</h1></div><!-- aquí aparece el calendario, conjunto de divs, con selelct para las instalaciones y botones para enviar el resultado-->
<div>
  <div class="col-sm-1" style="background:#FFF000">Gimnasio</div>
  <div class="col-sm-1" style="background:#F3DAAE">Fisioterapia</div>
  <div class="col-sm-1" style="background:#AEEEF3">Piscina</div>
  <div class="col-sm-1" style="background:#E7CEF2">Sala</div>
</div>
<div id='calendar'></div>
<div id="modal-insert-time" class="modal fade" tabindex="-1" role="dialog">
  <form id="bookingForm" method="POST" action="index.php?action=insert-reserve">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">RESERVAS</h4>
      </div>
      <div class="modal-body">

          <input type="hidden" name="action" value="insert-reserve">
          <input type="hidden" name="idr" value="">
          <label class="calendari" name="calendari" action="insert-reserve" placeholder="calendar">Instalaciones </label>
            <select id="select-instalacion" class="select-instalacion" name="inst">
              <option value="-1" selected="selected">Elige uno</option> 
              <?php foreach($instalaciones as $instalacion ): ?>
                <option value="<?php echo $instalacion['Id_Instalacion']; ?>"><?php echo $instalacion['Nombre_Instalacion']; ?></option> 
              <?php endforeach; ?>  
            </select>
          <label class="calendarh" name="calendarh" action="insert-reserve" placeholder="calendar">Hora </label>            
            <select name="hora" id="select-hora">
              <option value="-1" selected="selected">Elige uno</option> 
              
            </select>
        
      </div>
      <div class="modal-footer">
        <button id="close-modal-calendar" type="button"  class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button id="submit-modal-calendar" type="button"  value='insert-reserve' type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </form>
</div><!-- /.modal -->
