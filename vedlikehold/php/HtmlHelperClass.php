<?php

	class HtmlHelperClass{
		public function GeneratSelectionBox($data){
			$html = "<div>";

			foreach($colm in $data) {
				$html .= $colm;
			}

			$html .= "</div>"

			return $html;

		}

		public function CreateDataTable($data){	

			$html =  '';
	        //CSS Styling
	        $oddOrEven = TRUE;
	        $printOddOrEven = '';

            if($oddOrEven){
                $oddOrEven = FALSE;
                $printOddOrEven = 'even';
            } 
            else {
                $oddOrEven = TRUE;
                $printOddOrEven = 'odd';
            }

            $html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$navn.'</td><td>'.$land.'</td><td>'.$statuskode.'
            </td><td>'.$endret.'</td></tr>'	


			$html .= '<tr role="row" class="'.$printOddOrEven.'"><td>'.$id.'</td><td>'.$navn.'</td><td>'.$land.'</td><td>'.$statuskode.'
            </td><td>'.$endret.'</td></tr>'
		}
	}

