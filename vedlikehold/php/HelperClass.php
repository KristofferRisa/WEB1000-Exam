<?php 

	class HelperClass{
		class Count {


        public function AntallRader($tabell){
        include('../php/db.php');  
  

        $query = $db_connection->query('SELECT COUNT(*) FROM ' . $tabell .'');
        $query = $query->fetch_row();

        $antallRader = 'Antall rader i tabellen: ' . $query[0]  ;   


         return $antallRader;

    }


	}