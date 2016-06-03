<?php 
$title = "FLY - Admin";

//Includes
include('./html/start.php');
include('./html/header.html');
include('./html/admin-start.html');

include('./php/Logg.php');
include('./php/Tittel.php');

//Globale variabler
$user = new User();
$logg = new Logg();
$t = new Tittel();


?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        Oppsett
        <small>av statuskoder og titler med mer</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>
      <!-- Denne brukes av javascript for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Systemoppsett</li> 
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
              <h3 class="box-title">Statuskoder</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-md-2 control-label">Email</label>

                  <div class="col-md-10">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-md-2 control-label">Password</label>

                  <div class="col-md-10">
                    <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-md-offset-2 col-md-10">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox"> Remember me
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-default">Cancel</button>
                <button type="submit" class="btn btn-info pull-right">Sign in</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
        </div>
      <!-- /.col -->
    </div>

    <div class="row">
      <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Titler</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  
                  <label for="inputTittel" class="col-md-1 control-label">Tittel</label>
                  <div class="col-md-2">
                      
                      <select class="form-control select2 select2-hidden-accessible" name="inputTittel"  form="nybruker" style="width: 100%;" tabindex="-1" aria-hidden="true">
                          <?php print($t->TittelSelectOptions()); ?>
                      </select>
                      
                  </div>
                  <div class="col-md-1">
                      <button class="btn btn-danger">Slett</button>
                  </div>
                  
                  <div class="col-md-1">
                      <button class="btn btn-default">Endre</button>
                  </div>
                  
                  
                  <div class="col-md-1">
                      <button class="btn btn-default">Ny</button>
                  </div>
                  
                  
                </div>
                
              </div>
              <!-- /.box-body -->
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
include('./html/admin-slutt.html');

include('./html/script.html');

?>