<?php
class Planes {
  
    public function ShowAllPlanes()
    {
        include (realpath(dirname(__FILE__)).'/db.php');;
        $html =  '';
        //CSS Styling
        $oddOrEven = TRUE;
        $printOddOrEven = '';
        
        //db-tilkopling
        $query = $db_connection->prepare("SELECT flyId,flyNr,flyModell,type,plasser,aarsmodell,endret FROM fly");
        $query->execute();

        $query->bind_result($id, $flyNr, $modell, $type, $plasser, $flyAarsmodell,$endret);
        
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
                <td>'.$flyNr.'</td>
                <td>'.$modell.'</td>
                <td>'.$type.'
            </td><td>'.$plasser.'</td><td>'.$flyAarsmodell.'</td>
            <td><a href="./Plane/planesAdd.php">Nytt fly</a> | <a href="../vedlikehold/Plane/planesEdit.php?id='.$id.'"">Endre</a> | <a onclick="return confirm(\'Er du sikker du ønsker å slette dette flyet?\')" href="./Plane/delete.php?id='.$id.'">Slett</a> </td></tr>';
        
        }
        //Lukker databasetilkopling
        $query->close();
        $db_connection->close();
        
        return $html;
    }
    
    public function AddNewPlane($flyNr, $flyModell,$flyType,$flyAntallPlasser = NULL,$flyAarsmodell,$logg = NULL) 
    {
        include('../php/db.php');
        
        //Bygger SQL statement
        $query = $db_connection->prepare("INSERT INTO fly (flyNr,flyModell,type,plasser,aarsmodell) VALUES (?,?,?,?,?)");
        $query->bind_param('sssss', $flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell);  

        if ( $query->execute()) { 
            $affectedRows = $query->affected_rows;
            $query->close();
            
                      
        } 
        
        //Legger inn set_error_handler
        
        for ($i=1; $i < $flyAntallPlasser; $i++) { 
            
            $sqlSeter .= "
            select @flyId := max(flyId) from fly;
            insert into sete (flyId, prisKategoriId, seteNr) VALUES (@flyId, '1', '".$i."');
            ";
        }
        
        
        /* execute multi query */
        if ($db_connection->multi_query($sqlSeter)) {
            do {
                /* store first result set */
                if ($result = $db_connection->store_result()) {
                    while ($row = $result->fetch_row()) {
                        if($logg){
                            $logg->Ny('Legger inn flysete, antall rader lagt inn: '.$row[0]);    
                        }
                    }
                    $result->free();
                }
                /* print divider */
                if ($db_connection->more_results()) {
                    //$logg->Ny('Forsøker å leg')
                }
            } while ($db_connection->next_result());
        }
        
        $db_connection->close();
        
        return $affectedRows; 
        
    }

    public function UpdatePlane($flyId,$flyNr, $flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell, $logg)
    {
        include (realpath(dirname(__FILE__)).'/db.php');
        
        $sql = "
        update fly 
        set flynr = ?, flyModell = ?, type = ?, plasser = ?, aarsmodell = ?
        where flyId = ?;";
        
        $insertFly = $db_connection->prepare($sql);
        $insertFly->bind_param('sssiii'
                                , $flyNr,$flyModell,$flyType,$flyAntallPlasser,$flyAarsmodell
                                , $flyId);
                                
        $insertFly->execute();

        $affectedRows = $insertFly->affected_rows;
        
        $insertFly->close();
        $db_connection->close(); 
        
        
        $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

        if($insertFly == false){
            $logg->Ny('Failed to update: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
            exit;    
        }
        
        if ($affectedRows == 1) {
            $logg->Ny('Fly ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
        } else {
            $logg->Ny('Klarte ikke å oppdatere fly.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
        } 
        
        return $affectedRows;
    }
        
    public function GetPlane($flyId, $logg)
    {
        include (realpath(dirname(__FILE__)).'/db.php');;
        
        
        $sql = "select * FROM fly WHERE flyId=?;";
        
        $queryPlanes = $db_connection->prepare($sql);
        
        $queryPlanes->bind_param('i', $flyId);
        $queryPlanes->execute();
        
        //henter result set
        $resultSet = $queryPlanes->get_result();
        
        $fly =  $resultSet->fetch_all();
        
        //Error logging
        if($queryPlanes == false){
            $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
        }
        
        $resultSet->free();
        $queryPlanes->close();
        $db_connection->close(); 
        
        return $fly;
    } 

    public function PlaneSelectOptions()
    {
        include (realpath(dirname(__FILE__)).'/db.php');;
            $listBox = "";
        
        $sql="SELECT flyId, flyNr, flyModell, type from fly";
        
        $queryPlanes = $db_connection->prepare($sql);
        
        $queryPlanes->execute();

        $queryPlanes->bind_result($id, $flyNr, $flyModell, $flyType);
                    
        while ($queryPlanes->fetch()) {
            
                $listBox .= "<option value=".$id. ">".$flyModell." - ".$flyType." (".$flyNr.")</option>";
        }
        
        //$htmlSelect .= '</select>';
        //Error logging
        if($queryPlanes == false){
            $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
        }
        
        $queryPlanes->close();
        $db_connection->close();  

        return $listBox;        
        
    }
    
    public function DeletePlane($planeId, $logg)
    {
        include (realpath(dirname(__FILE__)).'/db.php');;
        
        $sql = "delete from fly where flyId = ?;";
        
        $sqlSeter = "delete from sete where flyId = ?";
        
        $logg->Ny('Forsøker å slette flyId: '.$planeId);
        
        $deletePlane = $db_connection->prepare($sql);
        $deletePlane->bind_param('i', $planeId);
                                
        $deletePlane->execute();

        $affectedRows = $deletePlane->affected_rows;
        
        $deletePlane->close();
        
        //Sletter tilhørende seter
        $deleteSeter = $db_connection->prepare($sqlSeter);
        $deleteSeter->bind_param('i', $planeId);
        $deleteSeter->execute();
        $deletedRows = $deleteSeter->affected_rows;
        
        $deleteSeter->close();
        
        $logg->Ny('Sletter tilhørende setere, antall rader slettet: '.$deletedRows);
            
        //Lukker database tilkopling
        $db_connection->close(); 
        
        $logg->Ny('Sletter fly, antall rader slettet: '.$affectedRows);

        if($deletePlane == false){
            $logg->Ny('Klarte ikke slette fly, feilmelding: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
            exit;       
        }
        
        if ($affectedRows == 1) {
            $logg->Ny('Fly ble slettet.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
        } else {
            $logg->Ny('Klarte ikke å slette fly.', 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
        } 
        
        return $affectedRows;
    }

    public function GetPlaneDataset($logg){
        include (realpath(dirname(__FILE__)).'/db.php');
        
        
        $sql = "select * FROM fly;";
        
        $queryPlanes = $db_connection->prepare($sql);
    
        $queryPlanes->execute();
        
        //henter result set
        $resultSet = $queryPlanes->get_result();
        
        $fly =  $resultSet->fetch_all();
        
        //Error logging
        if($queryPlanes == false){
            $logg->Ny('Failed to get from db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
        }
        
        $resultSet->free();
        $queryPlanes->close();
        $db_connection->close(); 
        
        return $fly;
    }   
    
    public function GetSeteByPlaneId($planeId, $logg)
    {
        include (realpath(dirname(__FILE__)).'/db.php');;
        
        $logg->Ny('Forsoeker å hente seter for fly id = '.$planeId);
        
        $sql = "select * from sete where flyId=?;";
        
        $seterQuery = $db_connection->prepare($sql);
        
        $seterQuery->bind_param('i', $planeId);
        $seterQuery->execute();
        
        //henter result set
        $resultSet = $seterQuery->get_result();
        
        $seter =  $resultSet->fetch_all();
        
        //Error logging
        if($seterQuery == false){
            $logg->Ny('Klarte ikke å hente seter fra db: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');    
        }
        
        $resultSet->free();
        $seterQuery->close();
        $db_connection->close(); 
        
        return $seter;
    }
    
    public function UpdateSete($id, $prisKat, $setenr, $nodutgang, $forklaring, $logg)
    {
        include (realpath(dirname(__FILE__)).'/db.php');
        
        $logg->Ny('Forsoeker aa oppdatere seteId '.$id);
        
        $sql = "
        update sete 
        set seteNr = ?, nodutgang = ?, forklaring = ?, prisKategoriId = ?
        where seteId = ?;";
        
        $updateSete = $db_connection->prepare($sql);
        $updateSete->bind_param('sssii'
                                , $setenr
                                , $nodutgang
                                ,$forklaring
                                ,$prisKat
                                ,$id);
                                
        $updateSete->execute();

        $affectedRows = $updateSete->affected_rows;
        
        $updateSete->close();
        $db_connection->close(); 
        
        
        $logg->Ny('Rows affected: '.$affectedRows, 'DEBUG', htmlspecialchars($_SERVER['PHP_SELF']), '');

        if($updateSete == false){
            $logg->Ny('Klarte ikke å oppdatere sete: '.mysql_error($db_connection), 'ERROR', htmlspecialchars($_SERVER['PHP_SELF']), '');
            exit;    
        }
        
        if ($affectedRows == 1) {
            $logg->Ny('SeteID= '.$id.' ble oppdatert.', 'DEBUG',htmlspecialchars($_SERVER['PHP_SELF']), '');
        } else {
            $logg->Ny('Klarte ikke å oppdatere seteId '.$id, 'ERROR',htmlspecialchars($_SERVER['PHP_SELF']), '');
        } 
        return $affectedRows;
    }

}
