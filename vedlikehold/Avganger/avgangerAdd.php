<?php 
$title = "AVGANGER - Admin - Legg til";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');

include('../php/Plane.php');

include('../php/Destinasjon.php');

include('../php/AdminClasses.php');


$fly = new Planes;
$dataFly= $fly -> GetPlaneDataset($logg);
print_r($dataFly);

$destinasjon = new Destinasjon;
$dataDest= $destinasjon -> GetDestDataset($logg);
//print_r($dataDest);

$errorMelding = "";

// Validering av skjemainput
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
  if (empty($_POST["flyId"]) ||  empty($_POST["fraDestId"]) ||  empty($_POST["tilDestId"]) ||
       empty($_POST["dato"]) ||  empty($_POST["direkte"]) ||  empty($_POST["reiseTid"]) ||  empty($_POST["klokkeslett"]) ||
       empty($_POST["fastpris"]) ) 
{

    $errorMelding = $html->errorMsg("Error! </strong>Alle felt må fylles ut.");

}


  
  else {

    include('../php/Avgang.php');

    $valider = new ValiderData;

    $flyId = $valider->valider($_POST["flyId"]);
    $fraDestId = $valider->valider($_POST["fraDestId"]);
    $tilDestId = $valider->valider($_POST["tilDestId"]);
    $dato = $valider->valider($_POST["dato"]);
    $direkte = $valider->valider($_POST["direkte"]);
    $reiseTid = $valider->valider($_POST["reiseTid"]);
    $klokkeslett = $valider->valider($_POST["klokkeslett"]);
    $fastpris = $valider->valider($_POST["fastpris"]);


    $innIDataBaseMedData = new Avgang;

    $result = $innIDataBaseMedData->NewAvgang($flyId, $fraDestId, $tilDestId, $dato, $direkte, $reiseTid, $klokkeslett, $fastpris, $logg);

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
        Registrere ny avgang
        <small>Her kan du registrere nye avganger i databasen</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Avgang</li>
      <!-- Denne lese av script for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Ny avgang</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">



    <!-- Your Page Content Here -->

  <div class="row">
    <div class="col-sm-12">   
                 <!-- Horizontal Form -->
      <div class="box box-info">
        <div class="box-header with-border"><?php echo $errorMelding; ?><div id="melding"></div>
           <h3 class="box-title">Skjema</h3>
        </div>
            <!-- /.box-header -->



            <!-- form start -->

            <form method="post" class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onsubmit="return validerRegistrerAvgang()">
            <div class="box-body">        
                 
                 <div class="form-group" data-toggle="tooltip" data-placement="auto bottom" title="Velg fly ID">
                  <label for="FlyId" class="col-sm-2 control-label">Fly</label>
                  <div class="col-sm-10">
                      <?php 
                        echo $html->GenerateSearchSelectionbox($dataFly,'flyId','flyId','Velg flyID',''); 
                        ?>

                  
                  </div>
                  </div>


                <div class="form-group" data-toggle="tooltip" data-placement="auto bottom" title="Velg fra">
                  <label for="fraDestId" class="col-sm-2 control-label">Fra</label>
                    <div class="col-sm-10">

                      <?php 

                        echo $html->GenerateSearchSelectionbox($dataDest,'fraDestId','fraDestId','Velg fra avgang',''); 
                        ?>

                  </div>
              </div>

                 <div class="form-group"  data-toggle="tooltip" data-placement="auto bottom" title="Velg fra">
                  <label for="tilDestId" class="col-sm-2 control-label">Til</label>
                   <div class="col-sm-10">
                      <?php 

                        echo $html->GenerateSearchSelectionbox($dataDest,'tilDestId','tilDestId','Velg til avgang',''); 
                        ?>

                  </div>
                
                  </div>


              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="YYYY-MM-DD">
                  <label for="Dato" class="col-sm-2 control-label" >Dato</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="dato" name="dato" value="<?php echo @$_POST['avgangDato'] ?>">
                  
                </div>
              </div>
              



            <div class="form-group"  data-toggle="tooltip" data-placement="top" value="<?php echo @$_POST['direkte']?>" >
                  <label for="direkte" class="col-sm-2 control-label" >Avgang direkte</label>

                  <div class="col-sm-2">
                    <label class="radio-inline">
                      <input type="radio" name="direkte" checked value="Ja">Ja
                    </label>
                  </div>

                  <div class="col-sm-2">
                    <label class="radio-inline">
                      <input type="radio" name="direkte" value ="Nei">Nei
                    </label>
                  </div>

              </div>
              


              <div class="form-group"  data-toggle="tooltip" data-placement="top">
                  <label for="ReiseTid" class="col-sm-2 control-label" >Reisetid</label>
                <div class="col-sm-10">
                
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
              
              
              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="HH:MM">
                  <label for="Klokkelsett" class="col-sm-2 control-label" >Klokkelsett</label>
                <div class="col-sm-10">
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
              

              
                <div class="form-group" data-toggle="tooltip" data-placement="auto bottom" title="Skriv fastprisen">
                  <label for="fastpris" class="col-sm-2 control-label">Fastpris</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="fastpris" name="fastpris" placeholder="fastpris" value="<?php echo @$_POST['fastpris'] ?>" onsubmit="return validerRegistrerAvgang()" required>
                  </div>
                </div>
                </div>


              <!-- /.box-body -->
              <div class="box-footer">
                <input type="reset" class="btn btn-default" value="Nullstill" onclick="clearForm(this.form);">
                <button type="submit" class="btn btn-info pull-right">Legg til</button>

              </div>
              
</div>
  
   
</div>
</div>
</div>

<?php
include('../html/admin-slutt.html');

include('../html/script.html');

?>