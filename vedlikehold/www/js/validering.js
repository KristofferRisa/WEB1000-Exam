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
  var flyStatusKode=document.getElementById("flyStatusKode").value;

  var feilmelding="<div class='alert alert-error'>";

  if (!flyNr)
    {
        feilmelding=feilmelding + "Fly nr er ikke korrekt fylt ut.<br />";
    }
  if (!flyModell)
    {
        feilmelding=feilmelding + "Fly modell er ikke fylt ut. <br />";
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

    if (!flyStatusKode)
    {
        feilmelding=feilmelding + "Statuskode mangler. <br />";
    }

    else {feilmelding=feilmelding + "</div>"}

  if (flyNr && flyModell && flyType && flyAntallPlasser && flyAarsmodell && flyStatusKode)
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
  var flyplassLAnd=document.getElementById("flyplassLand").value;
  var flyType=document.getElementById("flyType").value;
  var flyAntallPlasser=document.getElementById("flyAntallPlasser").value;
  var flyAarsmodell=document.getElementById("flyAarsmodell").value;
  var flyStatusKode=document.getElementById("flyStatusKode").value;

  var feilmelding="<div class='alert alert-error'>";

  if (!flyNr)
    {
        feilmelding=feilmelding + "Fly nr er ikke korrekt fylt ut.<br />";
    }
  if (!flyModell)
    {
        feilmelding=feilmelding + "Fly modell er ikke fylt ut. <br />";
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

    if (!flyStatusKode)
    {
        feilmelding=feilmelding + "Statuskode mangler. <br />";
    }

    else {feilmelding=feilmelding + "</div>"}

  if (flyNr && flyModell && flyType && flyAntallPlasser && flyAarsmodell && flyStatusKode)
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