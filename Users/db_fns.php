<?php

require '../dbcon-prod.php';

function db_connect() {
  // $result = new mysqli('localhost', 'bm_user', 'password', 'bookmarks');
  //$result = new mysqli('localhost', 'root', '', 'bookmarks');
 // $result = new mysqli('localhost', 'root', '', 'sports');

	
		 // KIR 20200329
     $local = ($_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1');
     if (!$local )
     {
        $palvelin = $prod_palvelin;
        $kayttaja = $prod_kayttaja;
        $salasana = $prod_salasana;

        $result = new mysqli($palvelin, $kayttaja, $salasana, 'sports');
     }
     else {
         //$result = new mysqli('localhost', 'bm_user', 'password', 'bookmarks');
         $result = new mysqli('localhost', 'root', '', 'sports');
     }
 


   if (!$result) {
     throw new Exception('Could not connect to database server');
   } else {
     return $result;
   }
}

?>