<?php
    require('db_server.php'); 
?>

<!DOCTYPE html>

<!-- Deleting of a member -->

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
       
        <form action="deleteMember.php" method="post" id="lomake"> 

            <fieldset>
                <legend>Jäsentietojen poistaminen</legend>

                <?php 
                    if(isset($_GET['ind'])) {
                        $ind = $_GET['ind'];  
                        $member_id = getMemberIdByIndFromSession($ind);
                    }
                    else {
                        $member_id = getMemberIdFromSession();
                    }
                    $result = callFunctions("fetchMemberById", $member_id); 
                ?>
                                              
                <br><br>

                Haluatko poistaa jäsentiedot?

                <br><br>
            
                <input type="submit" name="deleteButton" id="deleteButton" class="sButton" value="Poista tiedot">  
           
           </fieldset>
           <br>
        
       </form>

       <script type="text/javascript">
            function disableDeleteButton() {              
                document.getElementById("deleteButton").disabled = true;
            }
          
        </script>
      
    </body>
  
 
</html>

<?php
  
    if(isset($_POST['deleteButton'])) // button name
    {    
        $member_id = getMemberIdFromSession();
        echo  callFunctions("deleteMember",  $member_id);
        echo '<script type="text/javascript">'.
              'disableDeleteButton()' .
              '</script>';
    }
    echo "<br><a href=\"memberlist.php\">Paluu</a>";

?>