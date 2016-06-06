<?php
  $title = 'Bjarum Airlines';

  include('./html/header.html');
  include('./html/nav.html');
  
  
?>
  <!--LOGO-->
  <div class="jumbotron text-center">
    <div class="login-logo">
     <b>B</b>JARUM <b>A</b>IRLINES  
    </div>
  </div>
  
  
  
  <!--START INNHOLD-->
  <div class="container">
    
    <form class="form-inline" role="form" method="GET">
    
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
                  <div class="item" data-value="zw"><i class="zw flag"></i>Zimbabwe</div>
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
                        <input type="radio" onclick="$('#fromDatePicker').show();" name="turreturenkel" value="Tur/retur" checked="checked"> Tur/retur
                      </label>
                <label class="checkbox-inline">
                        <input onclick="$('#fromDatePicker').hide();" type="radio" name="turreturenkel" value="Enkel"> Enkel
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
                <input style="text" class="form-control" id="datepickerfrom" />
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
              <input style="text" class="form-control"  id="datepickerto"/>
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
            <select class="form-control" id="voksne">
                <option>1 voksen (16+ år)</option>
                <option>2 voksne</option>
                <option>3voksne</option>
                <option>4 voksne</option>
              </select>
              <select class="form-control" id="barn">
                <option>0 barn (2-16 år)</option>
                <option>1 barn</option>
                <option>2 barn</option>
                <option>3 barn</option>
                <option>4 barn</option>
              </select>
              <select class="form-control" id="bebis">
                <option>0 bebis (0-23 mnd)</option>
                <option>1 bebis</option>
                <option>2 bebiser</option>
                <option>3 bebiser</option>
                <option>4 bebiser</option>
              </select>
            </div>
          </div>
          
        </div>
        <!--ANTALL PERSONER SLUTT-->
        
      </div>
      <!--ROW SLUTT-->
     <input type="submit" value="Søk og bestill" id="registrer" name="registrer">
    </form>
 
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
    // alert($(this).val());
    
    //henter data fra destinasjoner.php_ini_loaded_file
    $.get("destinasjoner.php", function(data){
      $('#tilValg').html(data);
    })
    
  // Check input( $( this ).val() ) for validity here
});
  
});

function parseDate(str) {
    var d = str.split('/')
    return new Date(parseInt(d[2]),parseInt(d[1]) - 1, parseInt(d[0]));
}
  </script>

  <?php include ("./html/footer.html"); ?>
</body>
</html>