

function disableSelect(){
	document.getElementById('association-choice').removeAttribute('required');
	document.getElementById('association-choice').setAttribute('disabled','');
	document.querySelector('div.mb-3 option').removeAttribute('selected');
	document.getElementById('choice-none').setAttribute('selected','');
};
// on modifie la page en fonction de l’utilisateur ne récupérant le texte de l’élément //department

function enableSelect(){
	document.getElementById('association-choice').removeAttribute('disabled');
	document.getElementById('association-choice').setAttribute('required','');
	document.getElementById('choice-none').removeAttribute('selected');
	document.querySelector('div.mb-3 option').setAttribute('selected','');
}

