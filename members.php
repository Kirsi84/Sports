<?php       
    require('db_server.php'); //checkUser here
?>

<!DOCTYPE html>
<!-- Sports: seura- ja jäsenhaku -->

<html>
    <head>
          
        <title>Sports</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">  
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

        <link rel="stylesheet" href="styles.css">

    </head>
    <body>

        <br>
      
        <form name="membersForm"  method="post"> 
      
      
            <fieldset>
                <legend>Seurojen jäsentiedot</legend>

                <?php callFunctions("fetchClubs", "all"); ?>

                <input type="text" id="inputName" name="nimi" class="txtBox" placeholder="Henkilön etu- tai sukunimi">
               
                <input type="submit" name="searchButton" id="searchButton" class="sButton"  value="Hae">

           </fieldset>
           <br>
         
       </form>
 
    </body>
</html>

<?php
    if(isset($_POST['searchButton'])) // button name
    {      
        if (isset($_SESSION['club_identifiers'])) {
            unset($_SESSION['club_identifiers']);
                
        }
        if (isset($_SESSION['club_id'])) {
            unset($_SESSION['club_id']);
        }
    
        echo callFunctions("fetchClubsAndMembers", "");
    } 
?>