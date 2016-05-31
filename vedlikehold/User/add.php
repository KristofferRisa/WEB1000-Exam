<?php 
$title = "FLY - Admin";

include('./../html/header.html');

include('./../html/admin-start.html');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
      <h1>
        [Header]
        <small>[Description]</small>
      </h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Start</a></li>
      <li>Brukere</li>
      <!-- Denne brukes av javascript for å sette riktig link aktiv i menyen (husk ID i meny må være lik denne) -->
      <li class="active">Ny</li> 
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
              <h3 class="box-title">Ny bruker</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

                  <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail3" name="inputEmail3" placeholder="Email">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword3" name="inputPassword3" placeholder="Password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputPassword4" class="col-sm-2 control-label">Password</label>

                  <div class="col-sm-10">
                    <input type="password" class="form-control" id="inputPassword4" name="inputPassword4" placeholder="Password">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputFornavn" class="col-sm-2 control-label">Fornavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputFornavn" name="inputFornavn" placeholder="Fornavn">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEtternavn" class="col-sm-2 control-label">Etternavn</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="inputEtternavn" name="inputEtternavn" placeholder="Etternavn">
                  </div>
                </div>
                <div class="form-group">
                <label class="col-sm-2 control-label">Date:</label>
                <div class="col-sm-10">
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control" id="datepicker">
                  </div>
                </div>
                <!-- /.input group -->
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

  </section>
  <!-- /.content -->
  
  </div>
  <!-- /.content-wrapper -->
  

<?php
include('./../html/admin-slutt.html');

include('./../html/script.html');

?>