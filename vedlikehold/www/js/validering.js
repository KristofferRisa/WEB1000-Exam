function fjernMelding()
{
  document.getElementById("melding").innerHTML="";
}


function validerRegistrerFly()
{
  var flyNr=document.getElementById("flyNr").value;
  var flyModell=document.getElementById("flyModell").value;
  var flyType=document.getElementById("flyType").value;
  var flyAntallPlasser=document.getElementById("flyAntallPlasser").value;
  var flyAarsmodell=document.getElementById("flyAarsmodell").value;

  var feilmelding="<div class='alert alert-error'>";

  if (!flyNr)
    {
        feilmelding=feilmelding + "Flynr er ikke fylt ut.<br />";
    }
  if (!flyModell)
    {
        feilmelding=feilmelding + "Flymodell er ikke fylt ut. <br />";
    }
  if (!flyType)
    {
        feilmelding=feilmelding + "Flytype er ikke fylt ut. <br />";
    }
   if (!flyAntallPlasser)
    {
        feilmelding=feilmelding + "Antall plasser ikke fylt ut. <br />";
    }

    if (!flyAarsmodell)
    {
        feilmelding=feilmelding + "Årsmodell er ikke fylt ut. <br />";
    }

    else {feilmelding=feilmelding + "</div>"}

  if (flyNr && flyModell && flyType && flyAntallPlasser && flyAarsmodell)
    {
        return true;
    }
  else
    {
        document.getElementById("melding").style.color="red"; 
        document.getElementById("melding").innerHTML=feilmelding; 
        return false;
    } 
}

function validerRegistrerFlyplass()
{
  var flyplassNavn=document.getElementById("flyplassNavn").value;

  var feilmelding="<div class='alert alert-error'>";

  if (!flyplassNavn)
    {
        feilmelding=feilmelding + "Flyplass navn er ikke fylt ut.<br />";
    }
    else {feilmelding=feilmelding + "</div>"}

  if (flyplassNavn)
    {
        return true;
    }
  else
    {
        document.getElementById("melding").style.color="red"; 
        document.getElementById("melding").innerHTML=feilmelding; 
        return false;
    } 
} 

function clearForm(oForm) {
    
  var elements = oForm.elements; 
    
  oForm.reset();

  for(i=0; i<elements.length; i++) {
      
  field_type = elements[i].type.toLowerCase();
  
  switch(field_type) {
  
    
    case "text": 
    case "password": 
    case "textarea":
          case "hidden":  
      
      elements[i].value = ""; 
      break;
        
    case "radio":
    case "checkbox":
        if (elements[i].checked) {
          elements[i].checked = false; 
      }
      break;

    /*case "select-one":*/
    case "select-multi":
                elements[i].selectedIndex = -1;
      break;

    default: 
      break;
  }
    }
}


function validerRegistrerPrisKat()
{
  var prisKatNavn=document.getElementById("prisKatNavn").value;
  var prisKatProsentPaaslag=document.getElementById("prisKatProsentPaaslag").value;
  var feilmelding="<div class='alert alert-error'>";

  if (!prisKatNavn)
    {
        feilmelding=feilmelding + "Priskategori navn er ikke fylt ut.<br />";
    }
  if (!prisKatProsentPaaslag)
    {
        feilmelding=feilmelding + "Priskategori prosentpåslag er ikke fylt ut. <br />";
    }
 

    else {feilmelding=feilmelding + "</div>"}

  if (prisKatNavn && prisKatProsentPaaslag)
    {
        return true;
    }
  else
    {
        document.getElementById("melding").style.color="red"; 
        document.getElementById("melding").innerHTML=feilmelding; 
        return false;
    } 
}

function validerRegistrerAvgang()
{
  var prisKatNavn=document.getElementById("prisKatNavn").value;
  var prisKatProsentPaaslag=document.getElementById("prisKatProsentPaaslag").value;
  var feilmelding="<div class='alert alert-error'>";

  if (!prisKatNavn)
    {
        feilmelding=feilmelding + "Priskategori navn er ikke fylt ut.<br />";
    }
  if (!prisKatProsentPaaslag)
    {
        feilmelding=feilmelding + "Priskategori prosentpåslag er ikke fylt ut. <br />";
    }
 

    else {feilmelding=feilmelding + "</div>"}

  if (prisKatNavn && prisKatProsentPaaslag)
    {
        return true;
    }
  else
    {
        document.getElementById("melding").style.color="red"; 
        document.getElementById("melding").innerHTML=feilmelding; 
        return false;
    } 
}

function validerRegistrerDestinasjon()
{
  var flyplassID=document.getElementById("flyplassLandValg").value;
  var navn=document.getElementById("navn").value;
  var landskode=document.getElementById("landskode").value;
  var stedsnavn=document.getElementById("stedsnavn").value;
  var geo_lat=document.getElementById("geo_lat").value;
  var geo_lng=document.getElementById("geo_lng").value;
  var feilmelding="<div class='alert alert-error'>";


  if (!navn)
    {
        feilmelding=feilmelding + "Navn er ikke fylt ut. <br />";
    }
     if (!landskode)
    {
        feilmelding=feilmelding + "Landskode er ikke fylt ut. <br />";
    }
     if (!stedsnavn)
    {
        feilmelding=feilmelding + "Stedsnavn er ikke fylt ut. <br />";
    }
     if (!geo_lat)
    {
        feilmelding=feilmelding + "Geo_lat er ikke fylt ut. <br />";
    }
     if (!geo_lng)
    {
        feilmelding=feilmelding + "Geo_lng er ikke fylt ut. <br />";
    }
 

    else {feilmelding=feilmelding + "</div>"}

  if ( navn && landskode && stedsnavn && geo_lat && geo_lng)
    {
        return true;
    }
  else
    {
        document.getElementById("melding").style.color="red"; 
        document.getElementById("melding").innerHTML=feilmelding; 
        return false;
    }
}