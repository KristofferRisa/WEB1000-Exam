<?php

    class HtmlHelperClass{
        public function GenerateSearchSelectionbox($dataset,$elementId, $inputname, $text, $cssClasses){
            $html = '
                    <div id="'.$elementId.'" class="ui fluid search selection dropdown">
                        <input type="hidden" name="'.$inputname.'">
                        <i class="dropdown icon"></i>
                        <div class="default text">'.$text.'</div>
                    <div class="menu">';

            $last = count($dataset) - 1;

            foreach ($dataset as $i => $row)
            {
                $isFirst = ($i == 0);
                $isLast = ($i == $last);

                $html .= '<div class="item" data-value="'.$row[0].'"><i class="'.$cssClasses.'"></i>'.$row[1].'</div>';
    
            }

            $html .= '</div></div>';

            return $html;
        }
    }

