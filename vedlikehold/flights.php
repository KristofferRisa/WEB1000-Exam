<?php 
$title = "FLY - Admin";

include('./html/header.html');

include('./html/admin-start.html');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
        Flyvninger
        <small>Administrer flyvninger</small>
      </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Start</a></li>
        <li class="active">Flyvninger</li>
    </ol>
  </section>
 <!-- Main content -->
  <section class="content">
    
    
    <!-- Your Page Content Here -->
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Alle flyvninger</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
              <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6"></div>
              </div>
              <div class="row">
                <div class="col-sm-12">
                  <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="id">ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nivå: Sortert etter meldingsnivået, INFO, ERROR, DEBUG.">Link</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Melding: Sortert etter meldingsinnhold.">Type</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Module: Sortert etter modul meldingen opprettet i.">Fly</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="BrukerId: sortert etter bruker id">Fra</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Til</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Tidspunkt</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Dato</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Status</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Opprettet</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Hadling</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr role="row" class="odd">
                        <td class="sorting_1">1</td>
                        <td>Error</td>
                        <td>noe feilet</td>
                        <td>innlogging</td>
                        <td>1</td>
                        <td>Error</td>
                        <td>Error</td>
                        <td>Error</td>
                        <td>Error</td>
                        <td>2016-02-02 21:13:00</td>
                        <td><a href="#edit=1">Endre</a></td>
                      </tr>
                      <tr role="row" class="even">
                        <td>2</td>
                        <td>Info</td>
                        <td>Bruker logget inn</td>
                        <td>innlogging</td>
                        <td>1</td>
                        <td>Error</td>
                        <td>Error</td>
                        <td>Error</td>
                        <td>Error</td>
                        <td>2016-02-02 21:13:00</td>
                        <td><a href="#edit=1">Endre</a></td>
                      </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="id">ID</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Nivå: Sortert etter meldingsnivået, INFO, ERROR, DEBUG.">Link</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Melding: Sortert etter meldingsinnhold.">Type</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Module: Sortert etter modul meldingen opprettet i.">Fly</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="BrukerId: sortert etter bruker id">Fra</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Til</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Tidspunkt</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Dato</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Status</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Opprettet</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Datotid: Sortering etter opprettet tidspunkt.">Hadling</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-5">
                  <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing 1 to 10 of 57 entries</div>
                </div>
                <div class="col-sm-7">
                  <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                    <ul class="pagination">
                      <li class="paginate_button previous disabled" id="example2_previous"><a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0">Previous</a></li>
                      <li class="paginate_button active"><a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0">1</a></li>
                      <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0">2</a></li>
                      <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0">3</a></li>
                      <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0">4</a></li>
                      <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0">5</a></li>
                      <li class="paginate_button "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0">6</a></li>
                      <li class="paginate_button next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0">Next</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.box-body -->
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