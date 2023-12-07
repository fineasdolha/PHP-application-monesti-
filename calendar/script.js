let objectJSON;
let events = [];
let calendar;
let calendarEl = document.getElementById('calendar');
let Calendar = FullCalendar.Calendar;
let dpt;
let idAssociation = document.getElementById('association-text').innerText; 
dpt = document.getElementById('department').innerText;
if (dpt == 'cleaning'){
  document.getElementById('calendar-wrapper').className = 'col-md-12'
  document.getElementById('form-rights').innerHTML ='';
  document.getElementById('form-rights').className='';
  document.getElementById('association-text').innerHTML='';
  document.getElementById('edit-modal').remove();
}else if (dpt == 'association'){
      document.getElementById('test').innerHTML='';
      document.getElementById('recurrent-choice').setAttribute('disabled','');
}else if (dpt=='admin'){
  document.getElementById('association-text').innerHTML='';
}



document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    calendar = new FullCalendar.Calendar(calendarEl, {
    
    events:'API.php',
    eventClick: function(info) {
      
      $('#event-title').text(info.event.title);
      $('#event-start').text(info.event.start);
      $('#event-number').text(info.event.extendedProps.reservation_number);
      $('#event-description').text(info.event.extendedProps.description);
      $('#event-place').text(info.event.extendedProps.reservation_place);
      $('#event-end').text(info.event.end);
      $('#place-id').text(info.event.extendedProps.place_id);
      $('#association-id').text(info.event.extendedProps.association);
      reservationAssociation = $('#association-id').text();
      console.log(reservationAssociation);
      $('#event-details-modal').modal();
      if(dpt=='association'){ 
        if(reservationAssociation == idAssociation){
          createButton();
        }else {
          deleteButton();
        }
      }  
      if(info.event._def.recurringDef != null){
        if(info.event._def.recurringDef.typeData.endRecur == null) {
          $('#details-recurrency').text(' is recurring from ' + info.event._def.recurringDef.typeData.startRecur);
          $('#details-recurrency').val('infinite')
        }
          else { 
            $('#details-recurrency').val('limited');
            $('#details-recurrency').text('will repeat until ' + info.event._def.recurringDef.typeData.endRecur);}
      } else { $('#details-recurrency').text('will take place once');}
      
    }, 
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

  function createButton(){
    if(!document.getElementById('edit-modal')){
    let button = document.createElement('button');
    button.innerText='Edit';
    button.classList.add('btn','btn-primary','btn-sm','rounded-0');
    button.setAttribute('onclick','getInfosModal()');
    button.setAttribute('id','edit-modal');
    button.setAttribute('type','button');
    document.getElementById('modal-end').append(button);
    }
  }

  function deleteButton(){
    if(document.getElementById('edit-modal')){
      document.getElementById('edit-modal').remove();
    }
  }

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
  document.getElementById('select-place').value ="";
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
  document.getElementById('select-place').value = document.getElementById('place-id').innerText;
  if(document.getElementById('details-recurrency').value == 'limited'){
    document.querySelector('div.form-group option[value=onetime]').removeAttribute('selected');
    document.querySelector('div.form-group option[value=recurrent]').setAttribute('selected','');
    document.getElementById('end_recurrency').removeAttribute('disabled');
    let dateRecurrent = new Date(document.getElementById('details-recurrency').innerText);
    document.getElementById('end_recurrency').value = convertToDateTimeLocalString(dateRecurrent); 
  }else if(document.getElementById('details-recurrency').value == 'infinite'){
    document.querySelector('div.form-group option[value=onetime]').removeAttribute('selected');
    document.querySelector('div.form-group option[value=recurrent]').setAttribute('selected','');
    //document.getElementById('end_recurrency').removeAttribute('disabled');   
  } 
  $('#event-details-modal').modal('hide');
}


