<?php 
$title = "FLY - Admin ";

include('../html/start.php');
include('../html/header.html');
include('../html/admin-start.html');
include('../php/Plane.php');
include('../php/PrisKat.php');

$fly = new Planes;
$prisKat = new PrisKat();

if(@$_POST)
{
  //Sjekker POST data
  if($_POST['seteId']
    && $_POST['flyId']
    && $_POST['seteNr']
    && $_POST['forklaring']
    && $_POST['noedutgang']
    && $_POST['prisKatId'])
    {
      //Oppdatere sete inf
      $result = $fly->UpdateSete($_POST['seteId'], $_POST['prisKatId'], $_POST['seteNr'], $_POST['noedutgang'], $_POST['forklaring'], $logg);
      
      if($result == 1){
          $responseMsg .= $html->successMsg("Sete informasjonen ble oppdatert.");
        } else {
          $responseMsg .= $html->errorMsg("Noe feilet, klarte ikke å oppdatere sete informasjon!");
        }
      
    } else {
      $responseMsg = $html->errorMsg('Alle felter var ikke utfylt');
    }
    
}

if(@$_GET['nr']){
  
  //returnerer en array
  //brukes av både GET OG POST    
  $nr = $_GET['nr'];
  
  $prisKatData = $prisKat->GetAllePrisKategoriDataset($logg);
  
  // $seter = $fly->GetSeteByPlaneId($id,$logg);
  $seter = $fly->GetSeteByPlaneNr($nr,$logg);
  $flyInfo = $fly->GetPlaneByNr($nr,$logg);
  
  // print_r($seter);
  // echo '<br>';
  // print_r($prisKatData);
  // echo '<br>';
  // print_r($flyInfo);

}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Vis alle seter tilknyttet flynr <?php echo @$flyInfo[0][1]; ?>
      </h1>
    <ol class="breadcrumb">
      <li><a href="../"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Fly og seteoversikt</li>
      <li class="active">Sete</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-sm-12">   
<?php if($_GET && $_GET['nr']){ ?>

  <?php echo @$responseMsg; ?>

  <?php foreach ($seter as $i => $row) { // START LOOP ?>
        
          <!-- Horizontal Form -->
          <div class="box box-info">


        <div class="box-header with-border">
  
          <div id="melding"></div>
            
              <h3 class="box-title">Editer sete informasjon for sete id <?php echo $row[0]; ?></h3>
               </div>
               <!-- /.box-header -->
        
          <!-- form start -->
          <form method="POST" class="form-horizontal" onsubmit="return validerRegistrerFly()">
            <div class="box-body">
              <!--SETE ID-->
              <input type="hidden" class="form-control" id="seteId" name="seteId" value="<?php echo $row[0] ?>">
              <!--FLY ID-->
              <input type="hidden" class="form-control" id="flyId" name="flyId" value="<?php echo $row[1] ?>">
              
              <!--SETE NR-->
              <div class="form-group">
                <label for="seteNr" class="col-sm-2 control-label">Sete NR</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="seteNr" name="seteNr" value="<?php echo @$row[3] ?>">
                </div>
              </div>
              
              <!--FORKLARING-->
              <div class="form-group">
                <label for="flyModell" class="col-sm-2 control-label">Kort forklaring</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="forklaring" name="forklaring" value="<?php echo @$row[5] ?>">
                </div>
              </div>
              
              <!--NOEDUTGANG-->
              <div class="form-group">
                <label for="flyType" class="col-sm-2 control-label">Er sete ved nødutgang</label>
                <div class="col-sm-10">
                  <select name="noedutgang" class="form-control">
                    <option value="Nei" <?php if ($row[4] == 'Ja') echo 'selected'; ?> >Nei</option>
                    <option value="Ja" <?php if ($row[4] == 'Nei') echo 'selected'; ?>  >Ja</option>
                  </select>
                </div>
              </div>

              <!--PRISKATEGORI-->
              <div class="form-group">
                <label for="flyAntallPlasser" class="col-sm-2 control-label">Velg riktig priskategori</label>
                <div class="col-sm-10">
                  <?php echo $html->GenerateSearchSelectionbox($prisKatData
                                                              ,'prisKatId'
                                                              ,'prisKatId'
                                                              ,$prisKat->getPrisKat($row[2],$logg)[0][1]
                                                              , ''
                                                              , TRUE
                                                              ,$row[2]); ?>
                </div>
              </div>

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Oppdater</button>
              </div>
              <!-- /.box-footer -->
            </form>

          </div>
          <!-- /.box -->
    <?php } ?>   
    
      </div>
      <!-- /.col -->
    
    </div>
    
                     <?php } else { //lister en select box med flyplass ?>
            
            <!--VISER ALLE FLYENE I EN DROPDOWN LISTE-->
            <form class="form-horizontal" method="GET" id="redigerFly">
                <div class="row">
                <div class="col-md-12">
                    
                    <div class="box box-info">
                        <div class="box-body">

                        <div class="form-group col-md-6">
                            <select class="form-control select2 select2-hidden-accessible" name="id" style="width: 100%;" tabindex="-1" aria-hidden="true">
                        
                                <?php $planeselect = new Planes; print($planeselect-> PlaneSelectOptions()); ?>
                            
                            </select>
                        </div>
                        
                        <div class="form-group col-md-2">
                            <button type="submit" class="btn btn-info pull-right">Hent</button>
                        </div>
                    </div>
                </div>
            </form>


            

        <?php } ?>
  </section>
  <!-- /.content -->
 
</div>
<!-- /.content-wrapper -->
  

<?php


include('../html/admin-slutt.html');

include('../html/script.html');

?>