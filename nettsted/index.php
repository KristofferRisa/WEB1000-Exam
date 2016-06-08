<?php
  $title = 'Bjarum Airlines';
  include('./html/start.php');
  include('./html/header.html');
  include('./html/nav.html');
  
  $alleDestinasjoner = $dest->GetAllDestinasjoner($logg);
  
   $resultMsg = "";
   //print_r($alleDestinasjoner);
  
      if($_GET 
        && $_GET['fra']
        && $_GET['til']
        && $_GET['type']
        && $_GET['voksne']
        // && $_GET['barn']
        // && $_GET['bebis']
        && $_GET['reiseDato']
        //&& $_GET['returDato']
        ){
          //finner alle input parametere
          
          $fra = $saner->data($_GET["fra"]);
          $fraFlyplass = $dest->GetDestinasjon($fra,$logg);
          
          
          $til = $saner->data($_GET["til"]);
          $tilFlyplass = $dest->GetDestinasjon($til,$logg);
          // print_r($tilFlyplass);
          
          $type = $saner->data($_GET["type"]);
          $voksne = $saner->data($_GET["voksne"]);

          if($_GET['barn']) {
            $barn = $saner->data($_GET["barn"]);  
          } else {
            $barn = 0;
          }
          
          if ($_GET['bebis']) {
            $bebis = $saner->data($_GET["bebis"]);
          } else {
            $bebis = 0;
          }
          
          if ($_GET['returDato']) {
            $returDato = $saner->data($_GET["returDato"]);
            // $returDato = date('Y-m-d', strtotime(str_replace('-', '/', $returDato)));
          }
          $dato = $saner->data($_GET["reiseDato"]);
          //$dato = date('Y-m-d', strtotime(str_replace('-', '/', $dato)));
          
          $antallReisende = $voksne + $barn;
          $ledigeAvgangerUtreise = $avganger->SokLedigeAvganger($fra,$til,$dato,$antallReisende,$logg);
          
          if(@$type == 'Retur'){
            $ledigeAvgangerHjemReise = $avganger->SokLedigeAvganger($til,$fra,$returDato,$antallReisende,$logg);  
          }
          
          
        } else {
          $logg->Ny('Mangler input parameter', 'WARNING');
        }
      
  
?>
  
  
  <!--START INNHOLD-->
  <div class="container">
     <!--Melding-->
    <div class="row">
      <div class="col-md-12">
        <div id="melding"></div>    
      </div>
    </div>
    
    <!--FINN REISER-->
    <div class="row">
      <div class="col-md-12">
        
        <form class="" name="finnReiser" role="form" method="GET" onsubmit="return validerFinnReiser();">
    
        <div class="row top-buffer">
          <!-- REISE FRA (START)-->
          <div class="col-sm-4">
            
              <div class="form-group">
                <label>Reise fra:</label>
                <div class="ui fluid search selection dropdown" id="search-select-from">
                  <input type="hidden" name="fra" id="fra" value="<?php echo @$_GET['fra']; ?>">
                  <i class="dropdown icon"></i>
                    <?php if(@$fraFlyplass){ ?>
                        
                          <div class="text">
                        <?php echo @$fraFlyplass[0][1]; }else{ ?>
                          
                          <div class="default text">
                          Hvor ønsker du å reise fra?
                        <?php } ?>
                        
                  <span class="glyphicon glyphicon-plane"></span></label> </div>
                  <div class="menu">
                    <!--<div class="item" data-value="zw"><i class="zw flag"></i>Zimbabwe</div>-->
                    
                    <?php 
                    
                      echo $html->GenerateSearchSelectionItem($alleDestinasjoner);
                      
                    ?>
                  </div>
                </div>
              </div>
                
          </div>
          
          <!--REISE TIL (START)-->
          <div class="col-sm-4 ">
            
              <div class="form-group ">
                <label> Reise til: </label>
                <div class="ui fluid search selection dropdown" id="search-select-to">
                  <input type="hidden" name="til" id="til" value="<?php echo @$_GET['til']; ?>">
                  <i class="dropdown icon"></i>
                  <?php if(@$tilFlyplass &&  @$_GET['til']){ ?>
                        
                          <div class="text">
                        <?php echo @$tilFlyplass[0][1]; }else{ ?>
                          
                          <div class="default text">
                          Hvor ønsker du å reise til?
                        <?php } ?>
                  <span class="glyphicon glyphicon-plane"></span></label> </div>
                  <div class="menu" id="tilValg">
                    <?php if(!@$_GET['til']){ ?>
                        <div class="item" data-value="zw"><i class="col-md-2"></i>Velg utreisested først</div>  
                  <?php } ?> 
                    
                  </div>
                </div>
              </div>
              
          </div>
          <!--REISE TIL (SLUTT)-->
          
          
          <!--DETALJER (START)-->
          <div class="col-sm-4">
              <div class="form-group">
                <label>Velg type:</label>
                <br>
                  <label class="checkbox-inline">
                          <input type="radio" onclick="$('#fromDatePicker').show();" name="type" value="Retur" 
                          <?php if(!@$_GET['type'] || @$type == 'Retur'){
                            echo 'checked';
                          } ?>
                          > Tur/retur
                        </label>
                  <label class="checkbox-inline">
                          <input onclick="$('#fromDatePicker').hide();" type="radio" name="type" value="Enkel"
                          <?php
                            if(@$type == 'Enkel'){
                              echo 'checked';
                            } ?>
                          > Enkel
                        </label>
              </div>
        
          </div>
          
        </div>
    
    
        <div class="row top-buffer">
          
            <!-- REISE FRA (START)-->
            <div class="col-sm-4">
              <div class="form-group">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input style="text" class="form-control" id="datepickerfrom" name="reiseDato" 
                    <?php 
                      if(@$_GET['reiseDato']){
                        echo 'value="'.$_GET['reiseDato'].'"';
                      }
                      ?>
                    />
                  </div>
                </div>
            
            </div>
            <!--REISE FRA (SLUTT)-->
            
            
            <!--REISE TIL (START)-->
            <div class="col-sm-4">
              <div class="form-group" id="fromDatePicker" <?php if(@$type == "Enkel") { echo 'style="display: none;"'; } ?> >
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input style="text" class="form-control"  id="datepickerto" name="returDato" 
                  <?php 
                      if(@$_GET['returDato']){
                        echo 'value="'.$_GET['returDato'].'"';
                      }
                      ?>
                  />
                </div>
              </div>
              
            </div>
            <!--REISE TIL (SLUTT)-->
            
            <!--ANTALL PERSONER-->
            <div class="col-sm-4">
              
              <div class="form-group">
                <label>Antall personer:</label>
                <br>
                <div class="input-group">
                <select class="form-control" id="voksne" name="voksne">
                    <option value="1" <?php if(@$voksne == 1) echo 'selected'; ?> >1 voksen (16+ år)</option>
                    <option value="2" <?php if(@$voksne == 2) echo 'selected'; ?> >2 voksne</option>
                    <option value="3" <?php if(@$voksne == 3) echo 'selected'; ?> >3voksne</option>
                    <option value="4" <?php if(@$voksne == 4) echo 'selected'; ?> >4 voksne</option>
                  </select>
                  <select class="form-control" id="barn" name="barn">
                    <option value="0" <?php if(@$barn == 0) echo 'selected'; ?> >0 barn (2-16 år)</option>
                    <option value="1" <?php if(@$barn == 1) echo 'selected'; ?> >1 barn</option>
                    <option value="2" <?php if(@$barn == 2) echo 'selected'; ?> >2 barn</option>
                    <option value="3" <?php if(@$barn == 3) echo 'selected'; ?> >3 barn</option>
                    <option value="4" <?php if(@$barn == 4) echo 'selected'; ?> >4 barn</option>
                  </select>
                  <select class="form-control" id="bebis" name="bebis">
                    <option value="0" <?php if(@$bebis == 0) echo 'selected'; ?> >0 bebis (0-23 mnd)</option>
                    <option value="1" <?php if(@$bebis == 1) echo 'selected'; ?> >1 bebis</option>
                    <option value="2" <?php if(@$bebis == 2) echo 'selected'; ?> >2 bebis</option>
                    <option value="3" <?php if(@$bebis == 3) echo 'selected'; ?> >3 bebis</option>
                    <option value="4" <?php if(@$bebis == 4) echo 'selected'; ?> >4 bebis</option>
                  </select>
                </div>
              </div>
              
            </div>
            <!--ANTALL PERSONER SLUTT-->
        
        </div>
       
        <div clas="row top-buffer">
          <div class="col-md-12">
            <input type="submit" class="btn btn-primary pull-right btn-flat" value="Søk" >
          </div>
        </div>     
         <!--ROW SLUTT-->
    
    
      
       </form>
      </div>
    </div>
    
    <hr>
 
    <!--RESULTAT START-->
    <div class="row">
      
      <!--START Visning av resultat av søk!-->
      
      <?php
      if(@$_GET['fra']){
          if(@$ledigeAvgangerUtreise
          && !count($ledigeAvgangerUtreise)==0){
            
            $resultMsg.='<div class="col-md-5">
                            <h2>Avreise</h2>
                            <div class="list-group">';
                          
              
              
            $last = count($ledigeAvgangerUtreise) - 1;
            $rowCounter = 0;

            foreach ($ledigeAvgangerUtreise as $i => $row)
            {
                $isFirst = ($i == 0);
                $isLast = ($i == $last);
                
                $resultMsg .= '
                      <button class="list-group-item avreise" onclick="avreiseBestilling(this);" data-destinasjonId="'.$til.'" data-avgangId="'.$row[0].'" data-antall="'.$antallReisende.'" data-bebis="'.$bebis.'" >
                         <span class="glyphicon glyphicon-plane"></span>
                         '.$row[1].' kl.'.$row[2].
                         '<br><span class="glyphicon glyphicon-euro"></span>'.$row[5].'
                         </button>';
              }
              
              $resultMsg .='</div>
                  </div>
                  <!--Splitter-->
                  <div class="col-md-2"></div>';
              $resultMsg .= '<div class="col-md-5">';
              if(count($ledigeAvgangerHjemReise) > 0){
                $resultMsg .= '<h2>Retur</h2>
                                 <div class="list-group">';
                                
                foreach ($ledigeAvgangerHjemReise as $i => $row)
                {
                    $isFirst = ($i == 0);
                    $isLast = ($i == $last);
                    
                    $resultMsg .= '
                          <button class="list-group-item retur" onclick="returBestilling(this);" data-destinasjon="'.$row[0].'" >
                            <span class="glyphicon glyphicon-plane"></span>
                            '.$row[1].' kl.'.$row[2].
                            '<br><span class="glyphicon glyphicon-euro"></span> '.$row[5].'
                            </button>';
                    
                  }
                  
                  $resultMsg .=' 
                    </div>';
              
              } else {
                $resultMsg .= '<h2>Fant ingen retur reiser!</h2>';
              }
               $resultMsg .= '</div></div>';
            echo $resultMsg;
            ?>
            
              <div class="row">
                <div class="col-md-12">
                  <form type="hidden" method="GET" id="bestillskjema" action="order.php" >
                    <input type="hidden" name="reise" id="avgangIdReise" >
                    <input type="hidden" name="retur" id="avgangIdRetur" >
                    <input type="hidden" name="antall" id="antall" >
                    <input type="hidden" name="bebis" id="antallbebis" >
                    <input type="submit" class="btn btn-primary pull-right btn-flat" id="bestilling" onclick="hentBillettInfo();" disabled value="Bestill">
                  </form>
                </div>
              </div>
            <?php
            } else {
              echo "<h1>Fant ingen ledig flyvninger </h1><hr><br>";
            }
            
       }
      
        
        ?>
        
        <!--SLUTT VISNING AV RESULTAT-->
        
    </div>
 
 </div>
 
 
 
 <!--INNHOLD SLUTT-->
 
 
  <?php include ("./html/footer.html"); ?>
 
  
<script type="text/javascript">
$('#search-select-from').dropdown();
$('#search-select-to').dropdown();

$(function() {
  
  var currentDate = new Date();
  $('#datepickerto,#datepickerfrom').datepicker({
      inline: true,
      showOtherMonths: true,
      startDate:currentDate,
      calendarWeeks: true,
      todayBtn: "linked",
      todayHighlight: true,
      dayNamesMin: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat','Sun'],
      autoclose: true,
      format: 'dd/mm/yyyy'
  });
  
  $("#datepickerfrom").on('changeDate', function(ev) {
        // alert($(this).val());
        $("#datepickerto").datepicker("setDate", $(this).val());
        var currentDate = new Date();
        var d = parseDate($(this).val());
        var newDate = new Date(d);
        console.log(currentDate);
        console.log(d);
        $("#datepickerto").datepicker("setStartDate", newDate);
    });
    
    // $("#datepickerfrom").datepicker("setDate", currentDate);
    
    <?php
      if(@!$_GET['reiseDato']){
        echo '$("#datepickerfrom").datepicker("setDate", currentDate);';      
      } 
      if(@!$_GET['returDato']){
        echo '$("#datepickerto").datepicker("setDate", currentDate);';      
      }
      
      ?>
  
  
  
  //når man går ut av reiser fra input så hentes alle mulig til destinasjoner
  $("#fra").change(function() {
    $('#melding').html("");
    console.log('ny fra destinasjon satt');
     //alert($(this).val());
    
    $('#search-select-to > div.text').html('Velg utreisested først');
    //henter data fra destinasjoner.php_ini_loaded_file
    $.get("destinasjoner.php?id="+$(this).val(), function(data){
      $('#tilValg').html(data);
      });
    });
    
    $("#til").change(function() {
      $('#melding').html("");
    });
  

});

function avreiseBestilling(element){
  
  console.log(element);
  $('.list-group-item.avreise').removeClass('active');
  element.classList.add('active');
  
  //sjekker om det finnes retur alternativer, dersom ikke kan man aktivere bestillingsknappen
  if($('.list-group-item.retur.active').length
      || $('.list-group-item.retur').length == 0){
    $('#bestilling').removeAttr('disabled');
  } 
}

function returBestilling(element){
    console.log(element);
    $('.list-group-item.retur').removeClass('active');
    element.classList.add('active');
   
   $('#bestilling').removeAttr('disabled');
}

function hentBillettInfo(){
 
  var utReise = $('.list-group-item.avreise.active');
  
  if(utReise.length == 0){
    $("#bestillskjema").submit(function(){
      return false;
    });
    console.log('Fant ingen retur reise');
    $('#bestilling').attr('disabled', true);
  }
  
  
  var retur = $('.list-group-item.retur.active');
  
  if(retur.length == 0){
    //Sender ikke skjema og deaktivere bestill knapp
      $("#bestillskjema").submit(function(){
        return false;
      });
      console.log('Fant ingen retur reise');
      $('#bestilling').attr('disabled', true);
    }
  
  
  
  //Mapper data- attributter til input felter i hidden form
  $('#avgangIdReise').val(utReise.attr('data-avgangId'));
  $('#avgangIdRetur').val(retur.attr('data-destinasjon'));  
  $('#antall').val(utReise.attr('data-antall'));
  $('#antallbebis').val(utReise.attr('data-bebis'));
  
}

function validerFinnReiser(){
  $('#melding').html("");
  var fra = document.forms["finnReiser"]["fra"].value;
  if (fra == null || fra == "") {
        //alert("Name must be filled out");
        console.log('Validering av utresie flyplass feilet');
        $('#melding').append('<div class="alert alert-error"><strong>Error!</strong> Du må velge en utreise.</div>');
        
        return false;
    }
    
  var til = document.forms["finnReiser"]["til"].value;
  if (til == null || til == "") {
        $('#melding').append('<div class="alert alert-error"><strong>Error!</strong> Du må velge en destinasjon.</div>');
        //alert("Name must be filled out");
        return false;
    }
}

function parseDate(str) {
    var d = str.split('/')
    return new Date(parseInt(d[2]),parseInt(d[1]) - 1, parseInt(d[0]));
}
  </script>

</body>
</html>