let objectJSON;
let events = [];
let calendar;
let calendarEl = document.getElementById('calendar');
let Calendar = FullCalendar.Calendar;
let dpt; 
dpt = document.getElementById('department').innerText;
if (dpt == 'cleaning'){
  document.getElementById('calendar-wrapper').className = 'col-md-12'
  document.getElementById('form-rights').innerHTML ='';
  document.getElementById('form-rights').className='';
  document.getElementById('edit-modal').remove();
  document.getElementById('delete-modal').remove();

  
}



document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
    eventClick: function(info) {
      console.log(info.event.title);  
        $('#event-title').text(info.event.title);
        $('#event-start').text(info.event.start);
        $('#event-number').text(info.event.reservation_number);
        console.log(info.event.reservation_number);
        $('#event-description').text(info.event.extendedProps.description);
        $('#event-end').text(info.event.end);
        $('#event-details-modal').modal();
      },
    events:'API.php',  
    initialView: 'dayGridMonth',
    themeSystem : 'bootstrap5',
    headerToolbar : {
           left:'title',
           center :'prev,next today',
           right : 'dayGridMonth,timeGridWeek,timeGridDay'
       } 
   
      
  });
    calendar.render();

  });

  function checkRecurrency(){
   let input = document.getElementById('end_recurrency');
   if (input.disabled){
    input.removeAttribute('disabled');
   }else {
    input.setAttribute('disabled', '');
    input.value = '';
   }

   
  }

function getInfosModal(){
  document.getElementById('title').value= document.getElementById('event-title').innerText;
  document.getElementById('description').value= document.getElementById('event-description').innerText;
  let test = new Date(document.getElementById('event-start').innerText);
  
  //test=test.toISOString();
  console.log(test);
  document.getElementById('start_datetime').value= test;
  // document.getElementById('end_datetime').value= document.getElementById('event-end').toISOString();
  document.getElementById('positive-button').value = "update";
  document.getElementById('positive-button').innerText = "Update";
  document.getElementById('negative-button').removeAttribute('disabled');
  $('#event-details-modal').modal('hide');
}


