<?php
  $title = 'Bjarum Airlines';
  include('./html/start.php');
  
  include('./html/header.html');
  include('./html/nav.html');
  
  $alleDestinasjoner = $dest->GetAllDestinasjoner($logg);
  $result = "";
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
      $til = $_GET['til'];
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
      
      
      $result = "<h1>Ledige avganger</h1><hr><br>";
      
      // print($dato);

      $ledigeAvganger = $avganger->SokLedigeAvganger($fra,$til,$dato,$logg);
       
      $last = count($ledigeAvganger) - 1;
      $rowCounter = 0;

      foreach ($ledigeAvganger as $i => $row)
      {
          $isFirst = ($i == 0);
          $isLast = ($i == $last);
          
          if($rowCounter == 4){
            $result.='</div><div class="row">';
            $rowCounter = 0;
          }
          
          $result .= '  <div class="col-xs-6 col-md-3">
                      <a href="#" class="thumbnail">
                       <span class="glyphicon glyphicon-plane"></span>
                        '.$row[1].'
                        <div>
                        Fra: '.$row[2]
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
    
    <form class="form-inline" name="finnReiser" role="form" method="GET" onsubmit="return validerFinnReiser();">
    
      <div class="row top-buffer">
        <!-- REISE FRA (START)-->
        <div class="col-sm-4">
          
            <div class="form-group">
              <label>Reise fra:</label>
              <div class="ui fluid search selection dropdown" id="search-select-from">
                <input type="hidden" name="fra" id="fra">
                <i class="dropdown icon"></i>
                <div class="default text">Hvor ønsker du å reise fra?<span class="glyphicon glyphicon-plane"></span></label> </div>
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
                <input type="hidden" name="til" id="til">
                <i class="dropdown icon"></i>
                <div class="default text">Hvor ønsker du å reise til?<span class="glyphicon glyphicon-plane"></span></label> </div>
                <div class="menu" id="tilValg">
                  <div class="item" data-value="zw"><i class="zw flag"></i>Velg utreisested først</div>
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
                        <input type="radio" onclick="$('#fromDatePicker').show();" name="type" value="Retur" checked="checked"> Tur/retur
                      </label>
                <label class="checkbox-inline">
                        <input onclick="$('#fromDatePicker').hide();" type="radio" name="type" value="Enkel"> Enkel
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
                <input style="text" class="form-control" id="datepickerfrom" name="reiseDato" />
              </div>
            </div>
        
        </div>
        <!--REISE FRA (SLUTT)-->
        
        
        <!--REISE TIL (START)-->
        <div class="col-sm-4">
          <div class="form-group" id="fromDatePicker">
            <div class="input-group date">
              <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
              </div>
              <input style="text" class="form-control"  id="datepickerto" name="returDato" />
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
                <option value="1">1 voksen (16+ år)</option>
                <option value="2">2 voksne</option>
                <option value="3">3voksne</option>
                <option value="4">4 voksne</option>
              </select>
              <select class="form-control" id="barn" name="barn">
                <option value="0">0 barn (2-16 år)</option>
                <option value="1">1 barn</option>
                <option value="2">2 barn</option>
                <option value="3">3 barn</option>
                <option value="4">4 barn</option>
              </select>
              <select class="form-control" id="bebis" name="bebis">
                <option value="0">0 bebis (0-23 mnd)</option>
                <option value="1">1 bebis</option>
                <option value="2">2 bebiser</option>
                <option value="3">3 bebiser</option>
                <option value="4">4 bebiser</option>
              </select>
            </div>
          </div>
          
        </div>
        <!--ANTALL PERSONER SLUTT-->
        
      </div>
      <!--ROW SLUTT-->
     <input type="submit" value="Søk og bestill" >
    </form>
    <hr>
    
    <!--RESULTAT START-->
    <div class="row top-buffer">
      
      <?php
        echo $result;
        ?>
    </div>
    
 </div>
 <!--INNHOLD SLUTT-->
 
  
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
  $("#datepickerto").datepicker("setDate", currentDate);
  $("#datepickerfrom").datepicker("setDate", currentDate);
  
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
        return false;
    }
    
  var til = document.forms["finnReiser"]["til"].value;
  if (til == null || til == "") {
        //alert("Name must be filled out");
        return false;
    }
}

function parseDate(str) {
    var d = str.split('/')
    return new Date(parseInt(d[2]),parseInt(d[1]) - 1, parseInt(d[0]));
}
  </script>

  <?php include ("./html/footer.html"); ?>
</body>
</html>