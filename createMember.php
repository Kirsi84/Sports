<?php
   
    require('db_server.php'); // here
    //$_POST['virheet']['kuvaus'] = "Kuvaus on jo olemassa";


    // $ind = $_GET['ind'];

    // echo "indeksi: " . $ind;
    // callFunctions("fetchClubById", $ind); //this is index of the table, not identifi
?>

<!DOCTYPE html>
<!--

-->

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
     
       
        <form action="createMember.php" method="post" id="lomake"> 

            <fieldset>
                <legend>Lisää jäsentiedot</legend>

                <label for  ="clubname" class="lbTitle">Seura:</label>
                <?php 

                    if(isset($_GET['ind'])) {
                        $ind = $_GET['ind'];  
                        $club_id = getClubIdByIndFromSession($ind);
                    }
                    else {
                        $club_id = getClubIdFromSession();
                    }

                    callFunctions("fetchClubById", $club_id); 
                ?>
                                              
                <br><br>

                <label for  ="firstname" class="lbTitle">Etunimi:</label>
                <input type ="text" id="firstname" name="firstname" class="txtBox" required><br><br>

                <label for  ="lastname" class="lbTitle">Sukunimi:</label>
                <input type ="text" id="lastname" name="lastname" class="txtBox" required><br><br>

                <label for  ="description" class="lbTitle">Kuvaus:</label>
                <textarea id="description" name="description" rows="4" cols="54"></textarea>
             
                <!-- <label for  ="club" class="lbTitle">Seura:</label> -->
                <?php 
                   // callFunctions("fetchClubs", "some");                   
                ?>
                
                <br><br>
                <label for  ="button" class="lbTitle"></label>
                <input type="submit" name="button"  class="sButton" value="Tallenna"> 
               
           </fieldset>
           
           <br>
           
       </form>
      
    </body>

 
</html>

<?php
  
    if(isset($_POST['button'])) // button name
    { 
        echo callFunctions("createMember", "");
    }

?>