<?php 
$title = "AVGANG - ENDRE - Admin";

include('../html/start.php');

include('../html/header.html');

include('../html/admin-start.html');
include('../php/Plane.php');

include('../php/Destinasjon.php');
// Validering og innsending av skjemadata
include('../php/AdminClasses.php');
include('../php/Avgang.php');

$fly = new Planes;
$dataFly= $fly -> GetPlaneDataset($logg);
$avgang = new Avgang();
$destinasjon = new Destinasjon;
$dataDest = $destinasjon -> GetDestDataset($logg);

if(@$_GET['id']){
  
  //returnerer en array
  //brukes av både GET OG POST    
  $id = $_GET['id'];

  $avgangInfo = $avgang->GetAvgang ($id, $logg);
 
}

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

    $result = $avgang->UpdateAvgang($id, $flyId,$fraDestId, $tilDestId, $dato, $direkte, $reiseTid, $klokkeslett, $fastpris, $logg);
    //Henter oppdatert avgang info fra databasen
    $avgangInfo = $avgang->GetAvgang ($id, $logg);

    if($result == 1 ){
      //Success
             $errorMelding = "<div class='alert alert-success'><strong>Info! </strong>Data lagt inn i database.</div>";

    } else {
      //not succesfull
             $errorMelding = "<div class='alert alert-warning'><strong>Error! </strong>Data ble ikke lagt inn i databasen grunnet ingen endringer gjort.  </div>";

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
                        ,$fly->GetPlane($avgangInfo[0][8], $logg)[0][1],'','', $avgangInfo[0][8]); 
                        ?>

                  
                  </div>
                  </div>


              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fra destinasjon ID">
                  <label for="fraDestId" class="col-sm-2 control-label" >Fra destinasjon</label>
                <div class="col-sm-10">
                    <?php
                    echo $html->GenerateSearchSelectionbox($dataDest,'fraDestId','fraDestId',$destinasjon->GetDestinasjon($avgangInfo[0][1],$logg)[0][1],'','',$avgangInfo[0][1]);
                    ?>
                </div>
              </div>

                            <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Til destinasjon ID">
                  <label for="avgangTilDestId" class="col-sm-2 control-label" >Til destinasjon</label>
                <div class="col-sm-10">
                  <?php
                    echo $html->GenerateSearchSelectionbox($dataDest,'tilDestId','tilDestId',$destinasjon->GetDestinasjon($avgangInfo[0][2],$logg)[0][1],'','',$avgangInfo[0][2]);
                    ?>
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
                  <label for="ReiseTid" class="col-sm-2 control-label" >Reisetid HH:MM</label>
                <div class="col-sm-5">
                
                <select name="reiseTid"> 
                  <option value="0"<?php if($avgangInfo[0][5]== "0"){echo "selected";} ?>>0</option>
                  <option value="1"<?php if($avgangInfo[0][5]== "1"){echo "selected";} ?>>1</option>
                  <option value="2"<?php if($avgangInfo[0][5]== "2"){echo "selected";} ?>>2</option>
                  <option value="3"<?php if($avgangInfo[0][5]== "3"){echo "selected";} ?>>3</option>
                  <option value="4"<?php if($avgangInfo[0][5]== "4"){echo "selected";} ?>>4</option>
                  <option value="5"<?php if($avgangInfo[0][5]== "5"){echo "selected";} ?>>5</option>
                  <option value="6"<?php if($avgangInfo[0][5]== "6"){echo "selected";} ?>>6</option>
                  <option value="7"<?php if($avgangInfo[0][5]== "7"){echo "selected";} ?>>7</option>
                  <option value="8"<?php if($avgangInfo[0][5]== "8"){echo "selected";} ?>>8</option>
                  <option value="9"<?php if($avgangInfo[0][5]== "9"){echo "selected";} ?>>9</option>
                  <option value="10"<?php if($avgangInfo[0][5]== "10"){echo "selected";} ?>>10</option>
                  <option value="11"<?php if($avgangInfo[0][5]== "11"){echo "selected";} ?>>11</option>
                  <option value="12"<?php if($avgangInfo[0][5]== "12"){echo "selected";} ?>>12</option>
                  <option value="13"<?php if($avgangInfo[0][5]== "13"){echo "selected";} ?>>13</option>
                  <option value="14"<?php if($avgangInfo[0][5]== "14"){echo "selected";} ?>>14</option>
                  <option value="15"<?php if($avgangInfo[0][5]== "15"){echo "selected";} ?>>15</option>
                  <option value="16"<?php if($avgangInfo[0][5]== "16"){echo "selected";} ?>>16</option>
                  <option value="17"<?php if($avgangInfo[0][5]== "17"){echo "selected";} ?>>17</option>
                  <option value="18"<?php if($avgangInfo[0][5]== "18"){echo "selected";} ?>>18</option>
                  <option value="19"<?php if($avgangInfo[0][5]== "19"){echo "selected";} ?>>19</option>
                  <option value="20"<?php if($avgangInfo[0][5]== "20"){echo "selected";} ?>>20</option>
                  <option value="21"<?php if($avgangInfo[0][5]== "21"){echo "selected";} ?>>21</option>
                  <option value="22"<?php if($avgangInfo[0][5]== "22"){echo "selected";} ?>>22</option>
                  <option value="23"<?php if($avgangInfo[0][5]== "23"){echo "selected";} ?>>23</option>
                  <option value="24"<?php if($avgangInfo[0][5]== "24"){echo "selected";} ?>>24</option>
                </select>

              <select>
                <option value="0"<?php if($avgangInfo[0][5]== "0"){echo "selected";} ?>>0</option>	
                <option value="1"<?php if($avgangInfo[0][5]== "1"){echo "selected";} ?>>1</option>	
                <option value="2"<?php if($avgangInfo[0][5]== "2"){echo "selected";} ?>>2</option>	
                <option value="3"<?php if($avgangInfo[0][5]== "3"){echo "selected";} ?>>3</option>	
                <option value="4"<?php if($avgangInfo[0][5]== "4"){echo "selected";} ?>>4</option>	
                <option value="5"<?php if($avgangInfo[0][5]== "5"){echo "selected";} ?>>5</option>	
                <option value="6"<?php if($avgangInfo[0][5]== "6"){echo "selected";} ?>>6</option>	
                <option value="7"<?php if($avgangInfo[0][5]== "7"){echo "selected";} ?>>7</option>	
                <option value="8"<?php if($avgangInfo[0][5]== "8"){echo "selected";} ?>>8</option>	
                <option value="9"<?php if($avgangInfo[0][5]== "9"){echo "selected";} ?>>9</option>	
                <option value="10"<?php if($avgangInfo[0][5]== "10"){echo "selected";} ?>>10</option>	
                <option value="11"<?php if($avgangInfo[0][5]== "11"){echo "selected";} ?>>11</option>	
                <option value="12"<?php if($avgangInfo[0][5]== "12"){echo "selected";} ?>>12</option>	
                <option value="13"<?php if($avgangInfo[0][5]== "13"){echo "selected";} ?>>13</option>	
                <option value="14"<?php if($avgangInfo[0][5]== "14"){echo "selected";} ?>>14</option>	
                <option value="15"<?php if($avgangInfo[0][5]== "15"){echo "selected";} ?>>15</option>	
                <option value="16"<?php if($avgangInfo[0][5]== "16"){echo "selected";} ?>>16</option>	
                <option value="17"<?php if($avgangInfo[0][5]== "17"){echo "selected";} ?>>17</option>	
                <option value="18"<?php if($avgangInfo[0][5]== "18"){echo "selected";} ?>>18</option>	
                <option value="19"<?php if($avgangInfo[0][5]== "19"){echo "selected";} ?>>19</option>	
                <option value="20"<?php if($avgangInfo[0][5]== "20"){echo "selected";} ?>>20</option>	
                <option value="21"<?php if($avgangInfo[0][5]== "21"){echo "selected";} ?>>21</option>	
                <option value="22"<?php if($avgangInfo[0][5]== "22"){echo "selected";} ?>>22</option>	
                <option value="23"<?php if($avgangInfo[0][5]== "23"){echo "selected";} ?>>23</option>	
                <option value="24"<?php if($avgangInfo[0][5]== "24"){echo "selected";} ?>>24</option>	
                <option value="25"<?php if($avgangInfo[0][5]== "25"){echo "selected";} ?>>25</option>	
                <option value="26"<?php if($avgangInfo[0][5]== "26"){echo "selected";} ?>>26</option>	
                <option value="27"<?php if($avgangInfo[0][5]== "27"){echo "selected";} ?>>27</option>	
                <option value="28"<?php if($avgangInfo[0][5]== "28"){echo "selected";} ?>>28</option>	
                <option value="29"<?php if($avgangInfo[0][5]== "29"){echo "selected";} ?>>29</option>	
                <option value="30"<?php if($avgangInfo[0][5]== "30"){echo "selected";} ?>>30</option>	
                <option value="31"<?php if($avgangInfo[0][5]== "31"){echo "selected";} ?>>31</option>	
                <option value="32"<?php if($avgangInfo[0][5]== "32"){echo "selected";} ?>>32</option>	
                <option value="33"<?php if($avgangInfo[0][5]== "33"){echo "selected";} ?>>33</option>	
                <option value="34"<?php if($avgangInfo[0][5]== "34"){echo "selected";} ?>>34</option>	
                <option value="35"<?php if($avgangInfo[0][5]== "35"){echo "selected";} ?>>35</option>	
                <option value="36"<?php if($avgangInfo[0][5]== "36"){echo "selected";} ?>>36</option>	
                <option value="37"<?php if($avgangInfo[0][5]== "37"){echo "selected";} ?>>37</option>	
                <option value="38"<?php if($avgangInfo[0][5]== "38"){echo "selected";} ?>>38</option>	
                <option value="39"<?php if($avgangInfo[0][5]== "39"){echo "selected";} ?>>39</option>	
                <option value="40"<?php if($avgangInfo[0][5]== "40"){echo "selected";} ?>>40</option>	
                <option value="41"<?php if($avgangInfo[0][5]== "41"){echo "selected";} ?>>41</option>	
                <option value="42"<?php if($avgangInfo[0][5]== "42"){echo "selected";} ?>>42</option>	
                <option value="43"<?php if($avgangInfo[0][5]== "43"){echo "selected";} ?>>43</option>	
                <option value="44"<?php if($avgangInfo[0][5]== "44"){echo "selected";} ?>>44</option>	
                <option value="45"<?php if($avgangInfo[0][5]== "45"){echo "selected";} ?>>45</option>	
                <option value="46"<?php if($avgangInfo[0][5]== "46"){echo "selected";} ?>>46</option>	
                <option value="47"<?php if($avgangInfo[0][5]== "47"){echo "selected";} ?>>47</option>	
                <option value="48"<?php if($avgangInfo[0][5]== "48"){echo "selected";} ?>>48</option>	
                <option value="49"<?php if($avgangInfo[0][5]== "49"){echo "selected";} ?>>49</option>	
                <option value="50"<?php if($avgangInfo[0][5]== "50"){echo "selected";} ?>>50</option>	
                <option value="51"<?php if($avgangInfo[0][5]== "51"){echo "selected";} ?>>51</option>	
                <option value="52"<?php if($avgangInfo[0][5]== "52"){echo "selected";} ?>>52</option>	
                <option value="53"<?php if($avgangInfo[0][5]== "53"){echo "selected";} ?>>53</option>	
                <option value="54"<?php if($avgangInfo[0][5]== "54"){echo "selected";} ?>>54</option>	
                <option value="55"<?php if($avgangInfo[0][5]== "55"){echo "selected";} ?>>55</option>	
                <option value="56"<?php if($avgangInfo[0][5]== "56"){echo "selected";} ?>>56</option>	
                <option value="57"<?php if($avgangInfo[0][5]== "57"){echo "selected";} ?>>57</option>	
                <option value="58"<?php if($avgangInfo[0][5]== "58"){echo "selected";} ?>>58</option>	
                <option value="59"<?php if($avgangInfo[0][5]== "59"){echo "selected";} ?>>59</option>	
                <option value="60"<?php if($avgangInfo[0][5]== "60"){echo "selected";} ?>>60</option>	
              </select>

              </div>
              </div>

     
              <div class="form-group"  data-toggle="tooltip" data-placement="top" value="<?php echo $avgangInfo[0][6] ?>">
                  <label for="Klokkelsett" class="col-sm-2 control-label" >Klokkelsett HH:MM</label>
                <div class="col-sm-5">
                <select name="klokkeslett"> 
                  <option value="0"<?php if($avgangInfo[0][6]== "0"){echo "selected";} ?>>0</option>
                  <option value="1"<?php if($avgangInfo[0][6]== "1"){echo "selected";} ?>>1</option>
                  <option value="2"<?php if($avgangInfo[0][6]== "2"){echo "selected";} ?>>2</option>
                  <option value="3"<?php if($avgangInfo[0][6]== "3"){echo "selected";} ?>>3</option>
                  <option value="4"<?php if($avgangInfo[0][6]== "4"){echo "selected";} ?>>4</option>
                  <option value="5"<?php if($avgangInfo[0][6]== "5"){echo "selected";} ?>>5</option>
                  <option value="6"<?php if($avgangInfo[0][6]== "6"){echo "selected";} ?>>6</option>
                  <option value="7"<?php if($avgangInfo[0][6]== "7"){echo "selected";} ?>>7</option>
                  <option value="8"<?php if($avgangInfo[0][6]== "8"){echo "selected";} ?>>8</option>
                  <option value="9"<?php if($avgangInfo[0][6]== "9"){echo "selected";} ?>>9</option>
                  <option value="10"<?php if($avgangInfo[0][6]== "10"){echo "selected";} ?>>10</option>
                  <option value="11"<?php if($avgangInfo[0][6]== "11"){echo "selected";} ?>>11</option>
                  <option value="12"<?php if($avgangInfo[0][6]== "12"){echo "selected";} ?>>12</option>
                  <option value="13"<?php if($avgangInfo[0][6]== "13"){echo "selected";} ?>>13</option>
                  <option value="14"<?php if($avgangInfo[0][6]== "14"){echo "selected";} ?>>14</option>
                  <option value="15"<?php if($avgangInfo[0][6]== "15"){echo "selected";} ?>>15</option>
                  <option value="16"<?php if($avgangInfo[0][6]== "16"){echo "selected";} ?>>16</option>
                  <option value="17"<?php if($avgangInfo[0][6]== "17"){echo "selected";} ?>>17</option>
                  <option value="18"<?php if($avgangInfo[0][6]== "18"){echo "selected";} ?>>18</option>
                  <option value="19"<?php if($avgangInfo[0][6]== "19"){echo "selected";} ?>>19</option>
                  <option value="20"<?php if($avgangInfo[0][6]== "20"){echo "selected";} ?>>20</option>
                  <option value="21"<?php if($avgangInfo[0][6]== "21"){echo "selected";} ?>>21</option>
                  <option value="22"<?php if($avgangInfo[0][6]== "22"){echo "selected";} ?>>22</option>
                  <option value="23"<?php if($avgangInfo[0][6]== "23"){echo "selected";} ?>>23</option>
                  <option value="24"<?php if($avgangInfo[0][6]== "24"){echo "selected";} ?>>24</option>

                </select>

                <select>
                  <option value="0"<?php if($avgangInfo[0][6]== "0"){echo "selected";} ?>>0</option>
                  <option value="1"<?php if($avgangInfo[0][6]== "1"){echo "selected";} ?>>1</option>
                  <option value="2"<?php if($avgangInfo[0][6]== "2"){echo "selected";} ?>>2</option>
                  <option value="3"<?php if($avgangInfo[0][6]== "3"){echo "selected";} ?>>3</option>
                  <option value="4"<?php if($avgangInfo[0][6]== "4"){echo "selected";} ?>>4</option>
                  <option value="5"<?php if($avgangInfo[0][6]== "5"){echo "selected";} ?>>5</option>
                  <option value="6"<?php if($avgangInfo[0][6]== "6"){echo "selected";} ?>>6</option>
                  <option value="7"<?php if($avgangInfo[0][6]== "7"){echo "selected";} ?>>7</option>
                  <option value="8"<?php if($avgangInfo[0][6]== "8"){echo "selected";} ?>>8</option>
                  <option value="9"<?php if($avgangInfo[0][6]== "9"){echo "selected";} ?>>9</option>
                  <option value="10"<?php if($avgangInfo[0][6]== "10"){echo "selected";} ?>>10</option>
                  <option value="11"<?php if($avgangInfo[0][6]== "11"){echo "selected";} ?>>11</option>
                  <option value="12"<?php if($avgangInfo[0][6]== "12"){echo "selected";} ?>>12</option>
                  <option value="13"<?php if($avgangInfo[0][6]== "13"){echo "selected";} ?>>13</option>
                  <option value="14"<?php if($avgangInfo[0][6]== "14"){echo "selected";} ?>>14</option>
                  <option value="15"<?php if($avgangInfo[0][6]== "15"){echo "selected";} ?>>15</option>
                  <option value="16"<?php if($avgangInfo[0][6]== "16"){echo "selected";} ?>>16</option>
                  <option value="17"<?php if($avgangInfo[0][6]== "17"){echo "selected";} ?>>17</option>
                  <option value="18"<?php if($avgangInfo[0][6]== "18"){echo "selected";} ?>>18</option>
                  <option value="19"<?php if($avgangInfo[0][6]== "19"){echo "selected";} ?>>19</option>
                  <option value="20"<?php if($avgangInfo[0][6]== "20"){echo "selected";} ?>>20</option>
                  <option value="21"<?php if($avgangInfo[0][6]== "21"){echo "selected";} ?>>21</option>
                  <option value="22"<?php if($avgangInfo[0][6]== "22"){echo "selected";} ?>>22</option>
                  <option value="23"<?php if($avgangInfo[0][6]== "23"){echo "selected";} ?>>23</option>
                  <option value="24"<?php if($avgangInfo[0][6]== "24"){echo "selected";} ?>>24</option>
                  <option value="25"<?php if($avgangInfo[0][6]== "25"){echo "selected";} ?>>25</option>
                  <option value="26"<?php if($avgangInfo[0][6]== "26"){echo "selected";} ?>>26</option>
                  <option value="27"<?php if($avgangInfo[0][6]== "27"){echo "selected";} ?>>27</option>
                  <option value="28"<?php if($avgangInfo[0][6]== "28"){echo "selected";} ?>>28</option>
                  <option value="29"<?php if($avgangInfo[0][6]== "29"){echo "selected";} ?>>29</option>
                  <option value="30"<?php if($avgangInfo[0][6]== "30"){echo "selected";} ?>>30</option>
                  <option value="31"<?php if($avgangInfo[0][6]== "31"){echo "selected";} ?>>31</option>
                  <option value="32"<?php if($avgangInfo[0][6]== "32"){echo "selected";} ?>>32</option>
                  <option value="33"<?php if($avgangInfo[0][6]== "33"){echo "selected";} ?>>33</option>
                  <option value="34"<?php if($avgangInfo[0][6]== "34"){echo "selected";} ?>>34</option>
                  <option value="35"<?php if($avgangInfo[0][6]== "35"){echo "selected";} ?>>35</option>
                  <option value="36"<?php if($avgangInfo[0][6]== "36"){echo "selected";} ?>>36</option>
                  <option value="37"<?php if($avgangInfo[0][6]== "37"){echo "selected";} ?>>37</option>
                  <option value="38"<?php if($avgangInfo[0][6]== "38"){echo "selected";} ?>>38</option>
                  <option value="39"<?php if($avgangInfo[0][6]== "39"){echo "selected";} ?>>39</option>
                  <option value="40"<?php if($avgangInfo[0][6]== "40"){echo "selected";} ?>>40</option>
                  <option value="41"<?php if($avgangInfo[0][6]== "41"){echo "selected";} ?>>41</option>
                  <option value="42"<?php if($avgangInfo[0][6]== "42"){echo "selected";} ?>>42</option>
                  <option value="43"<?php if($avgangInfo[0][6]== "43"){echo "selected";} ?>>43</option>
                  <option value="44"<?php if($avgangInfo[0][6]== "44"){echo "selected";} ?>>44</option>
                  <option value="45"<?php if($avgangInfo[0][6]== "45"){echo "selected";} ?>>45</option>
                  <option value="46"<?php if($avgangInfo[0][6]== "46"){echo "selected";} ?>>46</option>
                  <option value="47"<?php if($avgangInfo[0][6]== "47"){echo "selected";} ?>>47</option>
                  <option value="48"<?php if($avgangInfo[0][6]== "48"){echo "selected";} ?>>48</option>
                  <option value="49"<?php if($avgangInfo[0][6]== "49"){echo "selected";} ?>>49</option>
                  <option value="50"<?php if($avgangInfo[0][6]== "50"){echo "selected";} ?>>50</option>
                  <option value="51"<?php if($avgangInfo[0][6]== "51"){echo "selected";} ?>>51</option>
                  <option value="52"<?php if($avgangInfo[0][6]== "52"){echo "selected";} ?>>52</option>
                  <option value="53"<?php if($avgangInfo[0][6]== "53"){echo "selected";} ?>>53</option>
                  <option value="54"<?php if($avgangInfo[0][6]== "54"){echo "selected";} ?>>54</option>
                  <option value="55"<?php if($avgangInfo[0][6]== "55"){echo "selected";} ?>>55</option>
                  <option value="56"<?php if($avgangInfo[0][6]== "56"){echo "selected";} ?>>56</option>
                  <option value="57"<?php if($avgangInfo[0][6]== "57"){echo "selected";} ?>>57</option>
                  <option value="58"<?php if($avgangInfo[0][6]== "58"){echo "selected";} ?>>58</option>
                  <option value="59"<?php if($avgangInfo[0][6]== "59"){echo "selected";} ?>>59</option>
                  <option value="60"<?php if($avgangInfo[0][6]== "60"){echo "selected";} ?>>60</option>

                </select>
               </div>
              </div>
              
              
  
              <div class="form-group"  data-toggle="tooltip" data-placement="top" title="Fyll ut fastpris">
                  <label for="avgangFastKr" class="col-sm-2 control-label" >Fastpris</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="fastpris" name="fastpris" placeholder="Fastpris KR" value="<?php echo $avgangInfo[0][7] ?>" required>
                </div>
              </div>


              <!-- /.box-body -->
              <div class="box-footer">
                <input type="reset" class="btn btn-default" value="Nullstill" onclick="clearForm(this.form);">
                <button type="submit" class="btn btn-info pull-right">Oppdater</button>

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