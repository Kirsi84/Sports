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
        
        <!-- <form name="myForm" onsubmit="return validateForm()" method="post"> -->
        <form action="createMember.php" method="post">
      
            <fieldset>
                <legend>Urheiluseurat</legend>
            </fieldset>
            <br>

            <?php 
                // if (isset($_SESSION['message']))  {     
                //     echo $_SESSION['message'];
                // }
            ?>

           <p id="information"></p>
                                  
           <?php callFunctions("fetchClubs", "list"); ?>
       </form>

       <script>

      
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
            }
        </script>


        <script>
            function setSelectedRow(x) {
                // alert("Row index is: " + x.rowIndex);
                // var n=document.getElementsByName("ind").value;
                // alert("row x: " + n);
            }
        </script>
    </body>
</html>

<?php
    // if(isset($_POST['createMember'])) // button name
    // {      
    //     echo "jees" . $_POST['ind'];
    //     //echo callFunctions("fetchClubs", "list");
    // } 
?>