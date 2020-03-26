<?php       
    require('db_server.php'); //checkUser here
?>

<!DOCTYPE html>
<!--
Sports Urheiluseuran asiakasrekisteri
-->

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
        
        <form name="myForm" onsubmit="return validateForm()" method="post">
      
            <fieldset>
                <legend>Seurojen jäsentiedot</legend>

                <input type="text" id="inputName" name="nimi" class="txtBox" placeholder="Henkilön etu- tai sukunimi">
                                        
                <?php callFunctions("fetchClubs", "all"); ?>
              
                <input type="submit" name="button" id="searchButton" class="sButton"  value="Hae">

                <input type='button' value='Tyhjennä' class="sButton" onclick='removeTableBody()'/>

           </fieldset>
           <br>
           
           <p id="message">
           <?php 
                // if (isset($_SESSION['message']))  {     
                //     echo $_SESSION['message'];
                // }
            ?>
            </p>

           <p id="information"></p>
       </form>

       <script>

            //*************validate form
            function validateForm() {
                var searchName = document.forms["myForm"]["nimi"].value;
                var searchClub = document.forms["myForm"]["clubid"].value;
               
                if ((searchName == "") && (searchClub == 0)) {
                    //alert("Haettava nimi on pakollinen tieto");
                    document.getElementById('information').innerHTML = "Syötä hakuehto";
                    return false;
                }
            }

            //****** */ Trigger Button Click on Enter

            var input = document.getElementById("myInput");

            if (input) {
                input.addEventListener("keyup", function(event)  {
                    if (event.keyCode === 13)  {
                        event.preventDefault();
                        document.getElementById("searchButton").click();
                    }
                });
             }
            
            //****** */ When the user scrolls the page, execute myFunction
            window.onscroll = function() {myFunction()};

            // Get the navbar
            var navbar = document.getElementById("navbar");

            // Get the offset position of the navbar
            var sticky = navbar.offsetTop;

            // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
            function myFunction()
            {
                if (window.pageYOffset >= sticky) {
                    navbar.classList.add("sticky")
                } else {
                    navbar.classList.remove("sticky");
                }
            }

            function removeTableBody(){
                $('#myTableId tbody').empty();
              
                document.getElementById("message").innerHTML = "";
                document.getElementById("information").innerHTML = "";
            }
        </script>
    </body>
</html>

<?php
    if(isset($_POST['button'])) // button name
    {      
        if (isset($_SESSION['club_identifiers'])) {
            unset($_SESSION['club_identifiers']);
           // echo "jees1";          
        }
        if (isset($_SESSION['club_id'])) {
            unset($_SESSION['club_id']); 
          //  echo "jees2";               
        }

        // if (isset($_SESSION['message'])) {
        //     unset($_SESSION['message']); 
        //     echo "jees3";               
        // }
        
        
        echo callFunctions("fetchMembers", "");
    } 
?>