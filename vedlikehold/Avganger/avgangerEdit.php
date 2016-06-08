<?php 
$title = "AVGANG - ENDRE - Admin";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');
include('../php/Plane.php');

// Validering og innsending av skjemadata
include('../php/AdminClasses.php');
include('../php/Avgang.php');

$fly = new Planes;
$dataFly= $fly -> GetPlaneDataset($logg);

$avgang = "";

if(@$_GET['id']){
  
  //returnerer en array
  //brukes av både GET OG POST    
  $id = $_GET['id'];
  $avgang = new avgang;
  $avgangInfo = $avgang->GetAvgang ($id, $logg);
  
  print_r($avgangInfo);
  
  

}


$avgang= "";

$errorMelding = "";
// Validering av skjemainput

if ($_SERVER["REQUEST_METHOD"] == "POST") {


  if (empty($_POST["flyId"]) ||  empty($_POST["fraDestId"]) ||  empty($_POST["tilDestId"]) ||
      empty($_POST["dato"]) ||  empty($_POST["direkte"]) ||  empty($_POST["reiseTid"]) ||  empty($_POST["klokkeslett"]) ||
      empty($_POST["fastpris"]) ) 
 {

    $errorMelding = $html->errorMsg("Error! </strong>Alle felt må fylles ut.");
 }

  
  
  else {
        $valider = new ValiderData;


    $flyId = $valider->valider($_POST["flyId"]);
    $fraDestId = $valider->valider($_POST["fraDestId"]);
    $tilDestId = $valider->valider($_POST["tilDestId"]);
    $dato = $valider->valider($_POST["dato"]);
    $direkte = $valider->valider($_POST["direkte"]);
    $reiseTid = $valider->valider($_POST["reiseTid"]);
    $klokkeslett = $valider->valider($_POST["klokkeslett"]);
    $fastpris = $valider->valider($_POST["fastpris"]);

    $avgang = new avgang; 

    $result = $avgang->UpdateAvgang ($id, $flyId, $fraDestId, $tilDestId, $dato, $direkte, $reiseTid, $klokkeslett, $fastpris, $logg);
    //Henter oppdatert avgang info fra databasen


    if($result == 1){
      //Success
             $errorMelding = "<div class='alert alert-success'><strong>Info! </strong>Data lagt inn i database.</div>";

    } else {
      //not succesfull
             $errorMelding = "<div class='alert alert-warning'><strong>Error! </strong>Data ble ikke lagt inn i database.</div>";

    }

  }

}




?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">

      <h1>
        Rediger avganger
        <small>Her kan du redigere avganger i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Avgang</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Endre avgang</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">


    <!-- Your Page Content Here -->

        <div class="row">
      <div class="col-sm-12">   
                 <!-- Horizontal Form -->
          <div class="box box-info">


<?php 
  //Viser skjema dersom det både er en GET request med querstring id
  if($_GET && $_GET['id']){ 
?>

            <div class="box-header with-border"><?php echo $errorMelding; ?><div id="melding"></div>
           <h3 class="box-title">Skjema</h3>
            </div>
            <!-- /.box-header -->


            <!-- form start -->
          <form method="post" class="form-horizontal" onsubmit="return validerRegistrerAvgang()">
              <div class="box-body">   

               <div class="form-group" data-toggle="tooltip" data-placement="auto bottom" title="Velg fly ID">
                  <label for="FlyId" class="col-sm-2 control-label">Fly ID</label>
               <div class="col-sm-10">
                      <?php 
                        echo $html->GenerateSearchSelectionbox($dataFly,'flyId','flyId'
                        ,$fly->GetPlane($avgangInfo[0][8], $logg)[0][1]
                        , $avgangInfo[0][8]); 
                        ?>

                  
                  </div>
                  </div>


              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fra destinasjon ID">
                  <label for="fraDestId" class="col-sm-2 control-label" >Fra destinasjon</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="fraDestId" name="fraDestId" placeholder="Fra destinasjons ID" value="<?php echo $avgangInfo[0][1] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                </div>
              </div>

                            <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Til destinasjon ID">
                  <label for="avgangTilDestId" class="col-sm-2 control-label" >Til destinasjon</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="tilDestId" name="tilDestId" placeholder="Til destinasjon ID" value="<?php echo $avgangInfo[0][2] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                </div>
              </div>

                <div class="form-group"  data-toggle="tooltip" data-placement="top" title="YYYY-MM-DD">
                  <label for="Dato" class="col-sm-2 control-label" >Dato</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="dato" name="dato" value="<?php echo $avgangInfo[0][3]?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                  
                </div>
              </div>

            <div class="form-group"  data-toggle="tooltip" data-placement="top"  >
                  <label for="direkte" class="col-sm-2 control-label" >Avgang direkte</label>

                  <div class="col-sm-1">
                    <label class="radio-inline">

                      <input type="radio" name="direkte" value="Ja" <?php 
                      if ($avgangInfo[0][4] == "Ja")
                      {
                        echo "checked";
                      }   ?> >Ja

                    </label>
                  </div>

                  <div class="col-sm-1">
                    <label class="radio-inline">

                      <input type="radio" name="direkte" value="Nei" <?php 
                        if ($avgangInfo[0][4] == "Nei") 
                        {
                            echo "checked";
                        }  ?> >Nei

                    </label>
                  </div>

              </div>

             <div class="form-group"  data-toggle="tooltip" data-placement="top" value="<?php echo $avgangInfo[0][5] ?>">
                  <label for="ReiseTid" class="col-sm-2 control-label" >Reisetid</label>
                <div class="col-sm-5">
                
                <select name="reiseTid"> 
                  <option value="00">00</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option vakue="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                </select>

                <select>
                  <option value="00">00</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                  <option value="32">32</option>
                  <option value="33">33</option>
                  <option value="34">34</option>
                  <option value="35">35</option>
                  <option value="36">36</option>
                  <option value="37">37</option>
                  <option value="38">38</option>
                  <option value="39">39</option>
                  <option value="40">40</option>
                  <option value="41">41</option>
                  <option value="42">42</option>
                  <option value="43">43</option>
                  <option value="44">44</option>
                  <option value="45">45</option>
                  <option value="46">46</option>
                  <option value="47">47</option>
                  <option value="48">48</option>
                  <option value="49">49</option>
                  <option value="50">50</option>
                  <option value="51">51</option>
                  <option value="52">52</option>
                  <option value="53">53</option>
                  <option value="54">54</option>
                  <option value="55">55</option>
                  <option value="56">56</option>
                  <option value="57">57</option>
                  <option value="58">58</option>
                  <option value="59">59</option>
                  <option value="60">60</option>
              </select>

              </div>
              </div>

     
              <div class="form-group"  data-toggle="tooltip" data-placement="top" value="<?php echo $avgangInfo[0][6] ?>">
                  <label for="Klokkelsett" class="col-sm-2 control-label" >Klokkelsett</label>
                <div class="col-sm-5">
                <select name="klokkeslett"> 
                  <option value="00">00</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option vakue="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                </select>
                <select>
                  <option value="00">00</option>
                  <option value="01">01</option>
                  <option value="02">02</option>
                  <option value="03">03</option>
                  <option value="04">04</option>
                  <option value="05">05</option>
                  <option value="06">06</option>
                  <option value="07">07</option>
                  <option value="08">08</option>
                  <option value="09">09</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                  <option value="32">32</option>
                  <option value="33">33</option>
                  <option value="34">34</option>
                  <option value="35">35</option>
                  <option value="36">36</option>
                  <option value="37">37</option>
                  <option value="38">38</option>
                  <option value="39">39</option>
                  <option value="40">40</option>
                  <option value="41">41</option>
                  <option value="42">42</option>
                  <option value="43">43</option>
                  <option value="44">44</option>
                  <option value="45">45</option>
                  <option value="46">46</option>
                  <option value="47">47</option>
                  <option value="48">48</option>
                  <option value="49">49</option>
                  <option value="50">50</option>
                  <option value="51">51</option>
                  <option value="52">52</option>
                  <option value="53">53</option>
                  <option value="54">54</option>
                  <option value="55">55</option>
                  <option value="56">56</option>
                  <option value="57">57</option>
                  <option value="58">58</option>
                  <option value="59">59</option>
                  <option value="60">60</option>
             
             
             
              </select>
               </div>
              </div>
              
              
  
              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fyll ut fastpris">
                  <label for="avgangFastKr" class="col-sm-2 control-label" >Fastpris</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="fastpris" name="fastpris" placeholder="Fastpris KR" value="<?php echo $avgangInfo[0][7] ?>" onmouseover="musOverRK(this)" onmouseout="musUt(this)">
                </div>
              </div>


              <!-- /.box-body -->
              <div class="box-footer">
                <div class="btn btn-default" onclick="fjernMelding();clearForm(this.form);">Nullstill</div>
                <button type="submit" class="btn btn-info pull-right">Legg til</button>

              </div>
           
              
              <!-- /.box-footer -->
            </form>


                        <?php } 
             else {
    //lister en select box med priskategori 
?>

<!-- Your Page Content Here -->
<form class="form-horizontal" method="GET" id="redigerAvgang">
    <div class="row">
      <div class="col-md-12">
        
         <div class="box box-info">
            <div class="box-body">

               <div class="form-group col-md-6">
                  <select class="form-control select2 select2-hidden-accessible" name="id" style="width: 100%;" tabindex="-1" aria-hidden="true">
              
                      <?php 
                      $Avgangselect = new Avgang(); print($Avgangselect-> GetAllAvgangLB($logg)); 
                      ?>
                
                  </select>
              </div>
              
              <div class="form-group col-md-2">
                <button type="submit" class="btn btn-info pull-right">Hent</button>
              </div>
          
      </div>
    </div>
  </form>


<?php } ?>
          </div>
          <!-- /.box -->

      </div>
   
      <!-- /.col -->
    </div>

  </section>
  <!-- /.content -->
  
  </div>
  <!-- /.content-wrapper -->
  

<?php
include('../html/admin-slutt.html');

include('../html/script.html');

?>