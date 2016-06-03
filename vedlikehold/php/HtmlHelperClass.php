<?php

    class HtmlHelperClass{
        public function GeneratSelectionBox($dataset, $inputname, $text, $cssClasses){
            $html = '
                    <div id="fyplassLandValg" class="ui fluid search selection dropdown">
                    <input type="hidden" name="'.$inputname.'">
                    <i class="dropdown icon"></i>
                    <div class="default text">'.$text.'</div>
                    <div class="menu">';

            $last = count($dataset) - 1;

            foreach ($dataset as $i => $row)
            {
                $isFirst = ($i == 0);
                $isLast = ($i == $last);

                //echo '<p> ' . $row[3] .' '. $row[1] .'</p>';
            
                $html .= '<div class="item" data-value="'.$row[0].'"><i class="'.$cssClasses.'"></i>'.$row[0].'</div>';
    
            }

            $html .= '</div></div>';

            return $html;
        }

        public function CreateDataTable($data){    

            // $html =  '';
            // //CSS Styling
            // $oddOrEven = TRUE;
            // $printOddOrEven = '';

            // if($oddOrEven){
            //     $oddOrEven = FALSE;
            //     $printOddOrEven = 'even';
            // } 
            // else {
            //     $oddOrEven = TRUE;
            //     $printOddOrEven = 'odd';
            // }

            // $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$navn.'</td><td>'.$land.'</td><td>'.$statuskode.'
            // </td><td>'.$endret.'</td></tr>'    


            // $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$navn.'</td><td>'.$land.'</td><td>'.$statuskode.'
            // </td><td>'.$endret.'</td></tr>'
        }
    }

