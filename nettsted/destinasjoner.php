<?php

if($_GET && $_GET['destinasjon']){
    //gir alle mulig til destinasjoner basert på destinasjon
    $fraDestinasjon = $_GET['destinasjon'];
    
    echo '<div class="item" data-value="zw"><i class="zw flag"></i>Tyskland<span class="glyphicon glyphicon-plane"></span></div>
         <div class="item" data-value="zw"><i class="zw flag"></i>England<span class="glyphicon glyphicon-plane"></span></div>
         <div class="item" data-value="zw"><i class="zw flag"></i>Velg utreisested først</div>
         <div class="item" data-value="zw"><i class="zw flag"></i>Velg utreisested først</div>';
    
} else {
    //gir alle mulige destinasjoner
    echo '<div class="item" data-value="zw"><i class="zw flag"></i>Norge<span class="glyphicon glyphicon-plane"></span></div>
         <div class="item" data-value="zw"><i class="zw flag"></i>England<span class="glyphicon glyphicon-plane"></span></div>
         <div class="item" data-value="zw"><i class="zw flag"></i>Sverige<span class="glyphicon glyphicon-plane"></span></div>';
    
}
