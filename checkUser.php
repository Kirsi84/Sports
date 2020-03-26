<?PHP
function check_valid_user() {
     
    // see if somebody is logged in and notify them if not
      if (isset($_SESSION['valid_user']))  {
      
        return "Kirjautunut käyttäjä: ".$_SESSION['valid_user'];

      }
      
      else {
         // they are not logged in
        $Message = urlencode("Virhe kirjautumisessa. Kokeile hetken kuluttua uudelleen.");
        header("Location: error.php?Message=".$Message);
        exit;
      }
    }

?>