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

//for range
//    start: '2017-05-01',
//end: '2017-06-01'

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
    eventClick: function(info) {
        console.log(info.event.overlap);
        $('#event-title').text(info.event.title);
        $('#event-start').text(info.event.start);
        $('#event-number').text(info.event.extendedProps.reservation_number);
        $('#event-description').text(info.event.extendedProps.description);
        $('#event-end').text(info.event.end);
        if(info.event._def.recurringDef != null){
          if(info.event._def.recurringDef.typeData.endRecur == null) {
            $('#details-recurrency').text(' is recurring from ' + info.event._def.recurringDef.typeData.startRecur);
            $('#details-recurrency').val('infinite')
          }
            else { 
              $('#details-recurrency').val('limited');
              $('#details-recurrency').text('will repeat until ' + info.event._def.recurringDef.typeData.endRecur);}
        } else { $('#details-recurrency').text('will take place once');}
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
function convertToDateTimeLocalString  (date) {
    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, "0");
    const day = date.getDate().toString().padStart(2, "0");
    const hours = date.getHours().toString().padStart(2, "0");
    const minutes = date.getMinutes().toString().padStart(2, "0");

    return `${year}-${month}-${day}T${hours}:${minutes}`;
  }
  
   
function resetForm(){
  document.getElementById('card-title').innerText = 'New reservation'; 
  document.getElementById('title').value="";
  document.getElementById('description').value="";
  document.getElementById('start_datetime').value = "";
  document.getElementById('end_datetime').value ="";
  document.getElementById('positive-button').value = "save";
  document.getElementById('positive-button').innerText = "Save";
  document.getElementById('negative-button').setAttribute('disabled','');

}


function getInfosModal(){
  document.getElementById('card-title').innerText = 'Modify reservation';
  document.getElementById('title').value= document.getElementById('event-title').innerText;
  document.getElementById('description').value= document.getElementById('event-description').innerText;
  let startTime = new Date(document.getElementById('event-start').innerText);
  let endTime = new Date(document.getElementById('event-end').innerText);
  document.getElementById('start_datetime').value = convertToDateTimeLocalString(startTime);
  document.getElementById('end_datetime').value = convertToDateTimeLocalString(endTime);
  document.getElementById('positive-button').value = "update";
  document.getElementById('positive-button').innerText = "Update";
  document.getElementById('negative-button').removeAttribute('disabled');
  if(document.getElementById('details-recurrency').value == 'limited'){
    document.querySelector('div.form-group option[value=onetime]').removeAttribute('selected');
    document.querySelector('div.form-group option[value=recurrent]').setAttribute('selected','');
    document.getElementById('end_recurrency').removeAttribute('disabled');
    let dateRecurrent = new Date(document.getElementById('details-recurrency').innerText);
    document.getElementById('end_recurrency').value = convertToDateTimeLocalString(dateRecurrent); 
  }else if(document.getElementById('details-recurrency').value == 'infinite'){
    document.querySelector('div.form-group option[value=onetime]').removeAttribute('selected');
    document.querySelector('div.form-group option[value=recurrent]').setAttribute('selected','');
    document.getElementById('end_recurrency').removeAttribute('disabled');   
  } 
  $('#event-details-modal').modal('hide');
}


