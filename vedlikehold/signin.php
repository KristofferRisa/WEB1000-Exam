<?php 
$title = "FLY - Admin";

include('./html/header.html');
?>

<div class="row">
    <div class="col-md-8">
<!-- form start -->
<form class="form-horizontal">
    <div class="box-body">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">Email</label>

        <div class="col-sm-10">
        <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
        </div>
    </div>
    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">Passord</label>

        <div class="col-sm-10">
        <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
        <div class="checkbox">
            <label>
            <input type="checkbox"> Husk meg
            </label>
        </div>
        </div>
    </div>
    </div>
    <!-- /.box-body -->
    <div class="box-footer">
    <button type="submit" class="btn btn-info pull-right">Logg inn</button>
    </div>
    <!-- /.box-footer -->
</form>
</div>
</div>
 
