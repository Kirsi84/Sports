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
        
        <form name="myForm" method="post">
      
            <fieldset>
                <legend>Seuran jäsenlista</legend>
                <h2>
                <?PHP                    
                    $club_id = getClubId();
                    echo callFunctions("fetchClubNameById", $club_id);
                ?>
                </h2>
           </fieldset>
           <br>
           
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
              
                document.getElementById("message").innerHTML = "";
                document.getElementById("information").innerHTML = "";
            }
        </script>
    </body>
</html>

<?php
    function getClubId() {
        $club_id = -1;
        if(isset($_GET['ind'])) {
            $ind = $_GET['ind'];
            $club_id = getClubIdByIndFromSession($ind);
        }
        else {
            $club_id = getClubIdFromSession();
        }
        return $club_id;
    }
  
    $club_id = getClubId();

    if (isset($_SESSION['club_identifiers'])) {
        unset($_SESSION['club_identifiers']);              
    }

    echo callFunctions("fetchMemberList", $club_id);

?>