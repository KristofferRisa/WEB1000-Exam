<?php

class TableListBox {

	public function makeListBox() {

		 include('../php/db.php');
		 $listBox = "";


		$sql="SELECT statusKodeId, navn FROM statusKode";

		$result = $db_connection->query($sql);

		    

			while($row = $result->fetch_assoc()) {       

            $listBox .= "<option value=". $row['statusKodeId'] . ">". $row['navn'] ." - Id: ".$row['statusKodeId']."</option>";
        
    	}

    	//Lukker databasetilkopling
        $result->close();
        $db_connection->close();
        
        return $listBox;
	}
}