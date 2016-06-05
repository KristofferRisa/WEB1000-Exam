<?php

class Tittel {
    function Tittel(){
        
    }
    
    public function TittelSelectOptions($aktivTittel = NULL){
        include('db.php');
        $listBox = "";


        $sql="SELECT tittelId,navn FROM tittel;";

        $querytittel = $db_connection->prepare($sql);
        
        $querytittel->execute();

        $querytittel->bind_result($id,$navn);
        
        //henter data
        while ($querytittel->fetch()) {
            
            if($aktivTittel && ($navn == $aktivTittel || $id == $aktivTittel)){
                $listBox .= "<option value=". $id . " selected>". $navn ."</option>";    
            } else {
                $listBox .= "<option value=". $id . ">". $navn ."</option>";    
            }
        }

        //Lukker databasetilkopling
        $querytittel->close();
        $db_connection->close();
                
        return $listBox;
    }
    
}