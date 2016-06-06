<?php
  $title = 'Bjarum Airlines';
  include('./html/start.php');
  
  include('./html/header.html');
  include('./html/nav.html');
  
  $alleDestinasjoner = $dest->GetAllDestinasjoner($logg);
  $resultMsg = "";
  // print_r($alleDestinasjoner);
  
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
      $fra = $_GET['fra'];
      $fraFlyplass = $dest->GetDestinasjon($fra,$logg);
      
      $til = $_GET['til'];
      $tilFlyplass = $dest->GetDestinasjon($til,$logg);
      
      echo 'Til flyplass '.$til;
      
      print_r($tilFlyplass);
      
      
      $type = $_GET['type'];
      $voksne = $_GET['voksne'];
      if($_GET['barn']) {
        $barn = $_GET['barn'];  
      } else {
        $barn = 0;
      }
      
      if ($_GET['bebis']) {
        $bebis = $_GET['bebis'];
      } else {
        $bebis = 0;
      }
      
      if ($_GET['returDato']) {
        $returDato = $_GET['returDato'];
        $returDato = date('Y-m-d', strtotime(str_replace('-', '/', $returDato)));
      }
      
      $dato = $_GET['reiseDato'];
      $dato = date('Y-m-d', strtotime(str_replace('-', '/', $dato)));
      
      
      // print($dato);
      
      $antallReisende = $voksne + $barn;
      
      $ledigeAvganger = $avganger->SokLedigeAvganger($fra,$til,$dato,$antallReisende,$logg);
      
      if(count($ledigeAvganger)==0){
        $resultMsg = "<h1>Fant ingen ledig flyvninger </h1><hr><br>";  
      } else {
        $resultMsg = "<h1>Ledige avganger</h1><hr><br>";  
      }
      
      
       
      $last = count($ledigeAvganger) - 1;
      $rowCounter = 0;

      foreach ($ledigeAvganger as $i => $row)
      {
          $isFirst = ($i == 0);
          $isLast = ($i == $last);
          
          if($rowCounter == 4){
            $resultMsg.='</div><div class="row">';
            $rowCounter = 0;
          }
          
          $resultMsg .= '  <div class="col-xs-6 col-md-3">
                            <a href="./booking.php?id='.$row[0].'" class="thumbnail">
                            <span class="glyphicon glyphicon-plane"></span>
                              '.$row[1].' kl.'.$row[2].'
                              <div>
                              Fra: '.$row[3].' -  Til: '.$row[4].'
                              </div>
                            </a>
                          </div>';
          
          $rowCounter++;
          echo $rowCounter;
      }
     
      
      print_r($ledigeAvganger);
      
    } else {
      $logg->Ny('Mangler input parameter', 'WARNING');
    }
  
?>
  <!--LOGO-->
  <div class="jumbotron text-center">
    <div class="login-logo">
     <b>B</b>JARUM <b>A</b>IRLINES  
    </div>
  </div>
  
  
  <!--START INNHOLD-->
  <div class="container">
    <div id="melding"></div>
    <form class="form-inline" name="finnReiser" role="form" method="GET" onsubmit="return validerFinnReiser();">
    
      <div class="row top-buffer">
        <!-- REISE FRA (START)-->
        <div class="col-sm-4">
          
            <div class="form-group">
              <label>Reise fra:</label>
              <div class="ui fluid search selection dropdown" id="search-select-from">
                <input type="hidden" name="fra" id="fra" value="<?php echo @$fraFlyplass[0][1]; ?>">
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
                <input type="hidden" name="til" id="til" value="<?php echo @$tilFlyplass[0][1]; ?>">
                <i class="dropdown icon"></i>
                <?php if(@$tilFlyplass){ ?>
                      
                        <div class="text">
                      <?php echo @$tilFlyplass[0][1]; }else{ ?>
                        
                        <div class="default text">
                        Hvor ønsker du å reise til?
                      <?php } ?>
                <span class="glyphicon glyphicon-plane"></span></label> </div>
                <div class="menu" id="tilValg">
                  <div class="item" data-value="zw"><i class="col-md-2"></i>Velg utreisested først</div>
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
          <div class="form-group" id="fromDatePicker" <?php if($type == "Enkel") { echo 'style="display: none;"'; } ?> >
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
                <option value="1" <?php if($voksne == 1) echo 'selected'; ?> >1 voksen (16+ år)</option>
                <option value="2" <?php if($voksne == 2) echo 'selected'; ?> >2 voksne</option>
                <option value="3" <?php if($voksne == 3) echo 'selected'; ?> >3voksne</option>
                <option value="4" <?php if($voksne == 4) echo 'selected'; ?> >4 voksne</option>
              </select>
              <select class="form-control" id="barn" name="barn">
                <option value="0" <?php if($barn == 0) echo 'selected'; ?> >0 barn (2-16 år)</option>
                <option value="1" <?php if($barn == 1) echo 'selected'; ?> >1 barn</option>
                <option value="2" <?php if($barn == 2) echo 'selected'; ?> >2 barn</option>
                <option value="3" <?php if($barn == 3) echo 'selected'; ?> >3 barn</option>
                <option value="4" <?php if($barn == 4) echo 'selected'; ?> >4 barn</option>
              </select>
              <select class="form-control" id="bebis" name="bebis">
                <option value="0" <?php if($bebis == 0) echo 'selected'; ?> >0 bebis (0-23 mnd)</option>
                <option value="1" <?php if($bebis == 1) echo 'selected'; ?> >1 bebis</option>
                <option value="2" <?php if($bebis == 2) echo 'selected'; ?> >2 bebiser</option>
                <option value="3" <?php if($bebis == 3) echo 'selected'; ?> >3 bebiser</option>
                <option value="4" <?php if($bebis == 4) echo 'selected'; ?> >4 bebiser</option>
              </select>
            </div>
          </div>
          
        </div>
        <!--ANTALL PERSONER SLUTT-->
        
      </div>
      <!--ROW SLUTT-->
     <input type="submit" class="btn btn-primary " value="Søk og bestill" >
     
    </form>
    <hr>
    
    <!--RESULTAT START-->
    <div class="row top-buffer">
      
      <?php
        echo $resultMsg;
        ?>
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
    console.log('ny fra destinasjon satt');
     //alert($(this).val());
    
    $('#search-select-to > div.text').html('Velg utreisested først');
    //henter data fra destinasjoner.php_ini_loaded_file
    $.get("destinasjoner.php?id="+$(this).val(), function(data){
      $('#tilValg').html(data);
    })
    
  // Check input( $( this ).val() ) for validity here
});
  
});


function validerFinnReiser(){
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
        alert("Name must be filled out");
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