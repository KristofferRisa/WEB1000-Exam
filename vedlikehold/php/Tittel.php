<?php

class Tittel {
    function Tittel(){
        
    }
    
    public function TittelSelectOptions(){
        include('../php/db.php');
        $listBox = "";


        $sql="SELECT tittelId,navn FROM tittel;";

        $querytittel = $db_connection->prepare($sql);
        
        $querytittel->execute();

        $querytittel->bind_result($id,$navn);
        
        //henter data
        while ($querytittel->fetch()) {
            
            $listBox .= "<option value=". $id . ">". $navn ."</option>";
        
        }

        //Lukker databasetilkopling
        $querytittel->close();
        $db_connection->close();
                
        return $listBox;
    }
    
}