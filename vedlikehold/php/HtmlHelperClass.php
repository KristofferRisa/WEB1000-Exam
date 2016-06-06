<?php

    class HtmlHelperClass{
        public function GenerateSearchSelectionbox($dataset,$elementId, $inputname, $text, $cssClasses,$required = NULL,$value=NULL){
            if(!$required){
                $required = '';
            }
            $html = '
                    <div id="'.$elementId.'" class="ui fluid search selection dropdown">
                        <input type="hidden" '.$required.' name="'.$inputname.'" value="'.$value.'">
                        <i class="dropdown icon"></i>
                        <div class="default text">'.$text.'</div>
                    <div class="menu">';

            $last = count($dataset) - 1;

            foreach ($dataset as $i => $row)
            {
                $isFirst = ($i == 0);
                $isLast = ($i == $last);

                $html .= '<div class="item customItem" data-value="'.$row[0].'"><i class="'.$cssClasses.'"></i>'.$row[1].'</div>';
    
            }

            $html .= '</div></div>';

            return $html;
        }
        
        //Value må være row[0] og navn må være row[1]
        public function GenerateSearchSelectionItem($dataset){
            $html = "";
            $last = count($dataset) - 1;

            foreach ($dataset as $i => $row)
            {
                $isFirst = ($i == 0);
                $isLast = ($i == $last);

                $html .= '<div class="item customItem" data-value="'.$row[0].'"><i></i>'.$row[1].'</div>';
    
            }


            return $html;
        }
        
        public function errorMsg($msg) {
            return "<div class='alert alert-error'><strong>Error!</strong> ".$msg."</div>";
        }
        
        public function successMsg($msg) {
            return "<div class='alert alert-success alert-dismissible'><strong>Success!</strong> ".$msg."</div>";
        }
    }

