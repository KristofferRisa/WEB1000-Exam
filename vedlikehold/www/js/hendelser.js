function fokus(element) {
    element.style.background = "yellow";
}

function mistetFokus(element) {
	element.style.background ="white";
}

function musOverRK(element) {
	document.getElementById("melding").style.color="black";
	if (element == document.getElementById('flyplassNavn')){
		document.getElementById("jsmelding").innerHTML="Flyplassnavn må fylles ut.";
	}
	if (element == document.getElementById('flyplassLandValg')){
		document.getElementById("jsmelding").innerHTML="Flyplassland må fylles ut.";
	}
}

function musOverRS(element) {
	document.getElementById("melding").style.color="black";
	if (element == document.getElementById('brukernavn')){
		document.getElementById("melding").innerHTML="<div class='alert alert-warning'>Brukernavn må fylles ut.</div>";
	}
	if (element == document.getElementById('fornavn')){
		document.getElementById("melding").innerHTML="<div class='alert alert-warning'>Fornavn må fylles ut.</div>";
	}
	if (element == document.getElementById('etternavn')){
		document.getElementById("melding").innerHTML="<div class='alert alert-warning'>Etternavn må fylles ut.</div>";
	}
		if (element == document.getElementById('klassekode')){
		document.getElementById("melding").innerHTML="<div class='alert alert-warning'>Kun STORE BOKSTAVER og siste tegn ett siffer.</div>";
	}
	if (element == document.getElementById('frist')){
		document.getElementById("melding").innerHTML="<div class='alert alert-warning'>Innleveringsfrist må fylles ut.</div>";
	}
}

function musOverRB(element) {
	document.getElementById("melding").style.color="black";
	if (element == document.getElementById('beskrivelse')){
		document.getElementById("melding").innerHTML="<div class='alert alert-warning'>Beskrivelse må fylles ut. Maks 150 tegn.</div>";
	}
}

function musOverEB(element) {
	document.getElementById("melding").style.color="black";
	if (element == document.getElementById('beskrivelse')){
		document.getElementById("melding").innerHTML="<div class='alert alert-warning'>Beskrivelse må fylles ut. Maks 150 tegn.</div>";
	}

}

function musOverKL(element) {
	document.getElementById("melding").style.color="black";
	if (element == document.getElementById('search')){
		document.getElementById("melding").innerHTML="<div class='alert alert-warning'>Kun STORE BOKSTAVER og siste tegn ett siffer.</div>";
	}
}

function musOverLR(element) {
	document.getElementById("melding").style.color="black";
	if (element == document.getElementById('brukernavn2')){
		document.getElementById("melding").innerHTML="<div class='alert alert-warning'>Må fylles ut.</div>";
	}
		if (element == document.getElementById('passord2')){
		document.getElementById("melding").innerHTML="<div class='alert alert-warning'>Må fylles ut.</div>";
	}
}

function musUt(element){
	document.getElementById("jsmelding").innerHTML="";
}

function tilStore(element){
	element.value=element.value.toUpperCase();
}

function fjernMelding()
{
  document.getElementById("jsmelding").innerHTML="";   
}

function bekreftSlett() {
	return confirm("Er du sikker?");
}