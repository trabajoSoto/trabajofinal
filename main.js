var arrahoras = [];
 var day = null;
  var hour = null;

jQuery(document).ready(function ($) {
 
//Con jquery tenemos la conexión a fullCalendar
//la vista semanal con la opción de incluir mensual
//la información llega a api.php que la lanza en function run en app.php
//así accede a getBookings()
//la información se guarda por ajax, al igual que por ajax se recuperan los datos 
// que permiten mostrar las horas disponibles, las instalaciones tienen value en calendario.php

  $('#calendar').fullCalendar({
    defaultView: 'agendaWeek',
    locale: 'es',
    events: {
      url: '/api.php',
      type: 'POST',
      data: {
        action: 'get-bookings'
      },
      error: function () {
        console.log('there was an error while fetching events!');
      },

    },

    header: {
      left: 'prev,next today',
      center: 'title',
      right: 'agendaWeek,month'
    },

    eventRender: function (event, element, view) {
      return ['all', event.conferencier].indexOf($('#filter-conferencier').val()) >= 0;
    },

    dayClick: function (date, jsEvent, view) {
      $('#select-hora').empty();


      $(".select-instalacion").val("-1");
      day = date.format("YYYY-MM-DD");

      hour = date.format("HH:mm:ss");

      $('#modal-insert-time').modal('show');
    }
  });

  $('#modal-insert-time').on('change', '.select-instalacion', function () {
    $('#select-hora').empty();
    $.ajax({
      url: '/api.php',
      type: "POST",
      data: {
        action: 'get-bookings',
        day: day,
        instalacion: $(this).val(),
      },
      success: function (response) {
        arrahoras = [];
        for (var r = 0; r < response.length; r++) {
          for (var i = 10; i <= 20; i++) {

            if (parseInt(response[r].horaEntrada) == i) {
              console.log(response[r].horaEntrada);
              arrahoras.push(i);
            }
          }
        }
        if (arrahoras.length > 0) {
          for (var i = 0; i < arrahoras.length; i++) {
            for (var h = 10; h <= 20; h++) {

              if (h !== arrahoras[i]) {
                $('#select-hora').append(new Option(h, h));
              }
            }

          }

        } else {
          for (var h = 10; h <= 20; h++) {
            $('#select-hora').append(new Option(h, h));
          }
        }


      },
      error: function (xhr, status, error) {
        console.log(xhr);
        var err = eval("(" + xhr.responseText + ")");
        console.log(err.Message);
      },
    });

  });
});




$("#close-modal-calendar").click(function () {
  $("#modal-insert-time").modal("hide");
});


$("#submit-modal-calendar").click(function () {
  $.ajax({
    url: '/api.php',
    type: "POST",
    data: {
      action: 'insert-reserve',
      datetime: day +" "+ $("#select-hora").val() +":00:00",
      instalacion: $("#select-instalacion").val()
    },
    success: function (response) {
      if(response){
        $("#modal-insert-time").modal("hide");
        $('#calendar').fullCalendar( 'refetchEvents' );  
      }else{
        console.log("Error");
      }
    }
  });
});