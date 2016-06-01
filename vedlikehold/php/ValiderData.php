<?php

class ValiderData {

	public function valider($data) {
		$data = trim($data);
 		$data = stripslashes($data);
  		$data = htmlspecialchars($data);
  		return $data;
	}
}