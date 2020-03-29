<?php

function db_connect() {
    // KIR 20200329
    $local = ($_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1');
    if (!$local )
    {
        $result = new mysqli('127.0.0.1:53181', 'azure', '6#vWHD_$', 'sports');
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