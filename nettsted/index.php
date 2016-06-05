<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bjarum Airlines</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script type="text/javascript" src="semantic/moment.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <link rel="stylesheet" type="text/css" href="semantic/dropdown.min.css">
  <link rel="stylesheet" type="text/css" href="semantic/transition.min.css">
  <link rel="stylesheet" type="text/css" href="www/css/adminLTE.min.css">
  <link rel="stylesheet" type="text/css" href="www/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

  <link rel="stylesheet" type="text/css" href="semantic/daterangepicker.css">
  <link rel="stylesheet" href="./www/plugins/datepicker/datepicker3.css">

  <!--<link rel="stylesheet" type="text/css" href="semantic/jquery-ui.css">-->
  <!--<script src="semantic/jquery-ui.js"></script>-->

  <script src="semantic/daterangepicker.js"></script>
  <script src="semantic/dropdown.min.js"></script>
  <script src="semantic/transition.min.js"></script>

  <script src="./www/plugins/datepicker/bootstrap-datepicker.js"></script>

</head>

<body>
  
  <?php
    include ("./html/nav.html");
  ?>


  <div class="jumbotron text-center">
    <div class="login-logo">
     <b>B</b>JARUM <b>A</b>IRLINES  
    </div>
  </div>
  
  <div class="container">
    <div class="row">


      <div class="col-sm-4">
        <form class="form-inline" role="form">
          <div class="form-group">

            <p>Reise fra:</p>

            <div class="ui fluid search selection dropdown" id="search-select-from">
              <input type="hidden" name="country">
              <i class="dropdown icon"></i>

              <div class="default text">Hvor ønsker du å reise fra?<span class="glyphicon glyphicon-plane"></span></label> </div>

              <div class="menu">
                <div class="item" data-value="af"><i class="af flag"></i>Afghanistan</div>
                <div class="item" data-value="ax"><i class="ax flag"></i>Aland Islands</div>
                <div class="item" data-value="al"><i class="al flag"></i>Albania</div>
                <div class="item" data-value="dz"><i class="dz flag"></i>Algeria</div>
                <div class="item" data-value="as"><i class="as flag"></i>American Samoa</div>
                <div class="item" data-value="ad"><i class="ad flag"></i>Andorra</div>
              </div>

            </div>
            </br>

            <table>
              <tr>
                <td>
                  <!--<input style="text" class="form-control" id="datepickerfrom" />-->
                  <div class="form-group">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input style="text" class="form-control" id="datepickerfrom" />
                      </div>
                    </div>
                </td>
              </tr>
            </table>


          </div>
        </form>
      </div>
      
      
      <div class="col-sm-4 ">
        <form class="form-inline " role="form ">
          <div class="form-group ">
            <p> Reise til: </p>

            <div class="ui fluid search selection dropdown" id="search-select-to">
              <input type="hidden" name="country">
              <i class="dropdown icon"></i>

              <div class="default text">Hvor ønsker du å reise til?<span class="glyphicon glyphicon-plane"></span></label> </div>

              <div class="menu">
                <div class="item" data-value="af"><i class="af flag"></i>Afghanistan</div>
                <div class="item" data-value="ax"><i class="ax flag"></i>Aland Islands</div>
                <div class="item" data-value="al"><i class="al flag"></i>Albania</div>
                <div class="item" data-value="dz"><i class="dz flag"></i>Algeria</div>
                <div class="item" data-value="as"><i class="as flag"></i>American Samoa</div>
                <div class="item" data-value="ad"><i class="ad flag"></i>Andorra</div>
              </div>

            </div>
            <br>

            <table>
              <tr>
                <td>
                    <div class="form-group" id="fromDatePicker">
                      <div class="input-group date">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input style="text" class="form-control"  id="datepickerto"/>
                      </div>
                    </div>
                </td>
              </tr>
            </table>



          </div>
        </form>
      </div>

      <div class="col-sm-4">
        <form role="form">
          <div class="form-group">
            <form role="form">
              <label class="checkbox-inline">
                      <input type="radio" onclick="$('#fromDatePicker').show();" name="turreturenkel" value="Tur/retur" checked="checked"> Tur/retur
                    </label>
              <label class="checkbox-inline">
                      <input onclick="$('#fromDatePicker').hide();" type="radio" name="turreturenkel" value="Enkel"> Enkel
                    </label>
            </form>
          </div>



          <select class="form-control" id="voksne">
        <option>1 voksen (16+ år)</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
      </select>

      <select class="form-control" id="barn">
        <option>0 barn (2-16 år)</option>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
      </select>


      <select class="form-control" id="bebis">
        <option>0 bebis (0-23 mnd)</option>
        <option>1</option>
        <option>2</option>
        <option>3</option>
        <option>4</option>
      </select>

          <br> <br>
          <input type="submit" value="Søk og bestill" id="registrer" name="registrer">

        </form>
      </div>


    </div>
  </div>


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


});
function parseDate(str) {
    var d = str.split('/')
    return new Date(parseInt(d[2]),parseInt(d[1]) - 1, parseInt(d[0]));
}

  </script>

  
  <script>
$(document).ready(function(){
  $("#hide").click(function(){
    $("turretur").show();
  })
})
   </script>

  <?php
  include ("./html/footer.html");
  ?>

</body>

</html>