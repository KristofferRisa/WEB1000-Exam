<?php
  $title = 'Bjarum Airlines';
  include('./html/start.php');
  include('./html/header.html');
  include ("./html/nav.html");

  $destinasjoner = $dest->GetAllDestinasjoner($logg);
//   print_r($destinasjoner[0]);
    
?>
  
<div class="container">
  
  <div class="row top-buffer" >
    <h1 class="header">Se våre destinasjoner!</h1>
  </div>

  <div class="row top-buffer">
    
        <div class="panel panel-default">
            <div class="panel-heading">Våre destinasjoner</div>
            <div class="panel-body">
            <div class="col-md-5">
                <p>Vi tilbyr flyvninger til reke fantastiske destinasjoner. Listen under oppdatere kontinuerlig! </p>
                <img src="./www/img/plane.jpg"></img>
            </div>
            <div class="col-md-5">
                   <div class="list-group">
                    <?php 
                    foreach ($destinasjoner as $key => $row) { ?>
                        
                                    
                        <a href="#" class="list-group-item">
                            <h4 class="list-group-item-heading"><?php echo $row[1]; ?></h4>
                            <p class="list-group-item-text">Mer info kommer.</p>
                        </a>
                            
                        <?php } ?>
                </div>   
            </div>
            
            </div>

        </div>


  </div>
</div>

  <?php
  include ("./html/footer.html");
  ?>

</body>

</html>
    