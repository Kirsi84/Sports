<?php

function db_connect() {
  // $result = new mysqli('localhost', 'bm_user', 'password', 'bookmarks');
  //$result = new mysqli('localhost', 'root', '', 'bookmarks');
  $result = new mysqli('localhost', 'root', '', 'sports');

   if (!$result) {
     throw new Exception('Could not connect to database server');
   } else {
     return $result;
   }
}

?>