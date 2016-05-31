<?php

class TableListBox {

	public function makeListBox() {

		 include('../php/db.php');
		 $listBox = "";


		$sql="SELECT navn FROM statusKode";

		$result = $db_connection->query($sql);

		    

			while($row = $result->fetch_assoc()) {       

            $listBox .= "<option value=". $row['navn'] . ">". $row['navn'] ."</option>";
        
    	}

    	//Lukker databasetilkopling
        $result->close();
        $db_connection->close();
        
        return $listBox;
	}
}