<?php  
$title = "FLY - Admin";

//Includes
include('./../html/start.php');
include('./../html/header.html');
include('./../html/admin-start.html');

$responseMsg = "";

if($_POST){

  $logg->Ny('POST av nytt passord skjema', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), 'NA');
  
  $userId = $_GET["id"];
  $passord1 = $_POST["passord1"];
  $passord2 = $_POST["passord2"];
  
  //Sjekk input parametere
  if($userId
    && $passord1
    && $passord2
    && $passord1 == $passord2){
      
      $logg->Ny('Alle input felter funnet', 'DEBUG','users/add.php', 'NA');
      
      //RegEx pattern
      $klassekodepattern = "/^[A-Z]{2,}[0-9]{1,}$/";
      $klassenavnpattern = "/^[A-Za-z]{1,}/";

      //Validering av felter ved RegEx kode
      //http://php.net/manual/en/function.ereg.php 
      // if(preg_match($klassekodepattern, $klassekode)) {
        
      // }
      
      $result = $user->ChangePassword($userId, $passord1, $logg);     
      
      if($result == 1){
        $responseMsg = "<div class='alert alert-success alert-dismissible'><strong>Success!</strong> Brukeren ble oppdatert.</div>";
      } else {
        $responseMsg = "<div class='alert alert-error'><strong>Error!</strong> Klarte ikke å oppdatere bruker</div>";
      }
      
      echo $result; 
    }  else {
        $responseMsg = "<div class='alert alert-error'><strong>Error!</strong> Passordene er ikke like!</div>";
        }
  
} 

if($_GET && $_GET['id']){
  
  $id = $_GET['id'];
  
  //returnerer en array med bruker info    
  $userinfo = $user->GetUser($id, $logg);
  
  //DEBUG
  //print_r($userinfo);
  
} elseif($_GET) {
  // header('location: ./users.php');
  // exit;
} 

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Bytt passord
        <small></small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Brukere</li>
      <!-- Denne brukes av javascript for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Endre</li> 
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">

    <!-- Your Page Content Here -->
    <div class="row">
   <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <?php echo $responseMsg ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" method="POST" >
              <div class="box-body">
               
               <!-- UserId -->
                <div class="form-group">
                  <label for="inputId" class="col-sm-2 control-label">Id</label>
                  <div class="col-sm-10">
                    <input type="text" disabled class="form-control" id="inputId" name="inputId" value="<?php echo $id ?>">
                  </div>
                </div>
               
               <!-- Passord -->
                <div class="form-group">
                  <label for="passord1" class="col-sm-2 control-label">Nytt passord</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3" name="passord1" >
                  </div>
                </div>
                
                <!-- Passord 2 -->
                <div class="form-group">
                  <label for="passord2" class="col-sm-2 control-label">Gjenta passord</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword4" name="passord2" >
                  </div>
                </div>
           
                
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <div class="btn btn-default" onclick="location.href='./User/users.php';">Tilbake</div>
                
                
                <button type="submit" class="btn btn-info pull-right">Bytt</button>
              </div>
              <!-- /.box-footer -->
            </form>
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

include('./../html/admin-slutt.html');

include('./../html/script.html');

?>