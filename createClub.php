<?php
     require('db_server.php'); 
?>

<!DOCTYPE html>

<!-- Create Club -->

<html>
    <head>
          
        <title>Sports</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">    

        <link rel="stylesheet" href="styles.css">
    
    </head>
    <body>

        <br>
        <form action="createClub.php" method="post" id="lomake"> 

            <fieldset>
                <legend>Lisää seuran tiedot</legend>

                <label for  ="name" class="lbTitle">Seuran nimi:</label>
                <input type ="text" id="name" name="name" class="txtBox" required><br><br>
  
                <label for  ="description" class="lbTitle">Kuvaus:</label>
                <textarea id="description" name="description" rows="4" cols="54" required></textarea>
                  
                <br><br>
               
                <label for  ="button" class="lbTitle"></label>
                <input type="submit" name="button"  class="sButton" value="Tallenna"> 
               
           </fieldset>
          
           <br><a href="index.php">Paluu</a>
           
           <br>
           
       </form>
      
    </body>
 
</html>

<?php
    if(isset($_POST['button'])) // button name
    {      
        echo callFunctions("createClub", "");
    }

?>