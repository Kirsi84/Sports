<?php
    require('db_server.php'); // here
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <link rel="stylesheet" href="styles.css">
    
    </head>
    <body>

        <br>
     
       
        <form id="formABC" action="deleteMember.php" method="post" id="lomake"> 

            <fieldset>
                <legend>Jäsentietojen poistaminen</legend>

                <!-- <label for  ="clubname" class="lbTitle">Seura:</label> -->
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
            
                <input type="submit"  id="btnSubmit" name="deleteButton"  class="sButton" value="Poista tiedot" onclick="disableBtn()"> 

                <!-- <button type="button" onclick="disableBtn()" id="deleteButton" name="deleteButton"  class="sButton" value="Poista tiedot" onclick="disableBtn()">  -->

                <!-- <button id="myBtn"  onclick="disableBtn()">My Button</button>  -->
               
                <input type="button" value="i am normal abc" id="btnTest"></input>

                <!-- <input type="submit" id="btnSubmit" value="Submit"></input> -->

                <script>
                    $(document).ready(function () {

                        $("#formABC").submit(function (e) {

                            //stop submitting the form to see the disabled button effect
                            e.preventDefault();

                            //disable the submit button
                            $("#btnSubmit").attr("disabled", true);

                             //disable the submit button
                             $("#deleteButton").attr("disabled", true);

                            //disable a normal button
                            $("#btnTest").attr("disabled", true);

                            return true;

                        });
                    });
                </script>
           
           
           </fieldset>
            <br>
        
        </form>
        
    </body>
  
 
</html>

<?php
  
    if(isset($_POST['deleteButton'])) // button name
    {        
        echo "jees";
        $member_id = getMemberIdFromSession();
      //  echo callFunctions("deleteMember",  $member_id);
    }

    echo "<br><br><a href=\"memberlist.php\">Paluu</a>";

?>