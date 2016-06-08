<?php
    class Avgang
{
        
        // OPPRETTE NY AVGANG
        public function Avgang()
        {
            
        }
      
        public function SokLedigeAvganger($fra, $til, $dato, $antallReisende , $logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $logg->Ny("Forsøker å finne ledige avganger fra: ".$fra." og til: ".$til." den ".$dato." for ".$antallReisende." reisende.");
            
            $sql = "
            SELECT * FROM eksamen.LedigeAvganger
            where dato > ?
            and fraDestId = ?
            and tilDestId = ?
            and AntallLedige >= ?;";
            
            
            $queryLedige = $db_connection->prepare($sql);
            
            $queryLedige->bind_param('sssi'
                                    , $dato
                                    , $fra
                                    , $til
                                    , $antallReisende);
            
            $queryLedige->execute();
            
            //henter result set
            $resultSet = $queryLedige->get_result();
            
            $ledigeRuter =  $resultSet->fetch_all();
            
            //Error logging
            if($queryLedige == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryLedige->close();
            $db_connection->close(); 
            
            return $ledigeRuter;
        } 
        
        public function SjekkLedigKapasitetAvgangId($id, $antallReisende, $logg) {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "
            SELECT avgangId,AntallLedige FROM eksamen.LedigeAvganger
            where avgangId = ?
            and AntallLedige >= ?;";
            
            
            $queryLedige = $db_connection->prepare($sql);
            
            $queryLedige->bind_param('ii'
                                    , $id
                                    , $antallReisende);
            
            $queryLedige->execute();
            
            //henter result set
            $resultSet = $queryLedige->get_result();
            
            $ledigeRuter =  $resultSet->fetch_all();
            
            //Error logging
            if($queryLedige == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryLedige->close();
            $db_connection->close(); 
            
            return $ledigeRuter;
        }
        
        public function NewAvgang($flyId, $fraDestId, $tilDestId, $dato, $direkte, $reiseTid, $klokkeslett,
                                  $fastPris)
        {   
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $logg->Ny('Forsøker å opprette ny avgang.', 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');
         
            
            $sql = "
                INSERT INTO avgang (flyId, fraDestId, tilDestId, dato, direkte, reiseTid, klokkeslett,
                                    fastPris)
                            values (?, ?, ?, ?, ?, ?, ?, ?)";
            
            $insertAvgang = $db_connection->prepare($sql);
            $insertAvgang->bind_param('iiisssss'
                                    , $flyId, $fraDestId, $tilDestId, $dato, $direkte, $reiseTid, $klokkeslett,
                                      $fastPris);
                                    
            $insertAvgang->execute();
            $affectedrows=$insertAvgang->affected_rows;
           
            
            $logg->Ny('Rows affected: '.$affectedrows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertAvgang == false){
                $logg->Ny('Mislyktes å insert: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedrows == 1) {
                $logg->Ny('Ny avgang opprettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å opprette ny avgang.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            $insertAvgang->close();
            $db_connection->close(); 
            
            return $affectedrows;
        }
        
        
        // OPPDATERER EN AVGANG
        public function UpdateAvgang ($flyId, $fraDestId, $tilDestId, $dato, $direkte, $reiseTid, $klokkeslett,
                                    $fastPris)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = 
            "UPDATE avgang
            SET navn = ?
            WHERE avgangId = ?;";
            
            $insertAvgang = $db_connection->prepare($sql);
            $insertAvgang->bind_param('iiisssss'
                                    , $flyId, $fraDestId, $tiDestId, $dato, $direkte, $reiseTid, $klokkeslett,
                                     $fastPris);
                                                                        
            $insertAvgang->execute();
            $affectedRows = $insertAvgang->affected_rows;
            
            $insertAvgang->close();
            $db_connection->close(); 
            
            
            $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

            if($insertAvgang == false){
                $logg->Ny('Mislyktes å oppdatere avgangs informasjon'.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
                exit;    
            }
            
            if ($affectedRows == 1) {
                $logg->Ny('Avgangen ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } else {
                $logg->Ny('Klarte ikke å oppdatere avgangen.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
            } 
                
            //Lukker databasetilkopling
            
            return $affectedRows;
        }
        
        //VISE ALLE AVGANGER
         public function GetAllAvganger()
         {

            include('../php/db.php');  
            $html =  '';
            $id = "";
            //CSS Styling
            $oddOrEven = TRUE;
            $printOddOrEven = '';
            
            $sql = 'SELECT 
    a.avgangId
    ,f.flynr
    ,d.navn as Fra
    ,d2.navn as Til
    , dato
    , klokkeslett
    , fastpris
FROM avgang a
INNER JOIN fly f on f.flyId = a.flyId
LEFT JOIN destinasjon d on d.destinasjonId = a.fraDestId
LEFT JOIN destinasjon d2 on d2.destinasjonId = a.tilDestId;';    
        
            //  db-tilkopling
            //$query = $db_connection->prepare("SELECT avgangId, flyId, fraDestId, tilDestId, dato, direkte, reiseTid, klokkeslett, fastpris, endret FROM avgang");
            $query = $db_connection->prepare($sql);
            $query->execute();
            $query->bind_result($id,$flynr, $fra, $til, $dato, $klokkeslett, $fastpris);
            
            //henter data
            while ($query->fetch()) {


                if($oddOrEven){
                    $oddOrEven = FALSE;
                    $printOddOrEven = 'even';
                } 
                else {
                    $oddOrEven = TRUE;
                    $printOddOrEven = 'odd';
                }

                $html .= '<tr role="row" class="'.$printOddOrEven.'">
                    <td>'.$flynr.'</td>
                    <td>'.$fra.'</td>
                    <td>'.$til.'</td>
                    <td>'.$dato.'</td>
                    <td>'.$klokkeslett.'</td>
                    <td>'.$fastpris.'</td>
                    <td>
                    <a href="./Avganger/avgangerAdd.php">Ny avgang</a> | <a href="./Avganger/avgangerEdit.php?id='.$id.'"">Endre</a> | <a onclick="return confirm(\'Er du sikker du ønsker å slette denne avgangen?\')" href="./Avganger/delete.php?id='.$id.'">Slett</a> </td></tr>';

            }
            return $html;
         }

        // VISE ALLE AVGANG LISTBOX
        public function GetAllAvgangLB($logg)
        {
            include (realpath(dirname(__FILE__)).'/db.php');;
            $listBox= "";

            $sql = "SELECT avgangId, flyId, fraDestId, tilDestId, dato, direkte, reiseTid, klokkeslett, fastpris FROM avgang;";
            
            $queryAvgang = $db_connection->prepare($sql);
            
            $queryAvgang->execute();

            $queryAvgang ->bind_result($Id, $flyId, $fraDestId, $tilDestId, $dato, $direkte, $reiseTid, $klokkeslett, $fastpris);
            
            while ($queryAvgang->fetch ())
            {
                $listBox .='<option value="'.$Id.'">fraDestId: '.$fraDestId.', tilDestId: '.$tilDestId.', dato: '.$dato.'</option>';
            }

            
            //Error logging
            if($queryAvgang == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $queryAvgang->close();
            $db_connection->close(); 
            
            return $listBox;
        }

        
        //VISE EN AVGANG WHERE avgangId = ?
        public function GetAvgang ($avgangId, $logg)
        {
            
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "SELECT avgangId, fraDestId, tilDestId, dato, direkte, reiseTid, klokkeslett, fastpris 
                    FROM avgang WHERE avgangId= ?;";
            
            $queryAvgang = $db_connection->prepare($sql);
            
            $queryAvgang->bind_param('i'
                                    , $avgangId);
            
            $queryAvgang->execute();
            
            //henter result set
            $resultSet = $queryAvgang->get_result();
            
            $avgang =  $resultSet->fetch_all();
            
            //Error logging
            if($queryAvgang == false){
                $logg->Ny('Mislyktes å hente fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            $resultSet->free();
            $queryAvgang->close();
            $db_connection->close(); 
            
            return $avgang;
        } 
        
        
        //SLETTE EN AVGANG WHERE avgangId = ?
         public function DeleteAvgang($avgangId, $logg)
         {
            include (realpath(dirname(__FILE__)).'/db.php');;
            
            $sql = "DELETE FROM avgang WHERE avgangId=?;";
            
            $deleteAvgang = $db_connection->prepare($sql);
            
            $deleteAvgang->bind_param('i'
                                    , $avgangId);
            
            $deleteAvgang->execute();
            
            $paavirkedeRader = $deleteAvgang->affected_rows;

            
            //Error logging
            if($deleteAvgang == false)
            {
                $logg->Ny('Mislyktes å slette data fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
            }
            
            // Lukker databasen
            $deleteAvgang->close();
            $db_connection->close(); 
            
            return $paavirkedeRader;
            
         }
       
 }    
    
    