<?php

//echo "session status: " . session_status();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('checkUser.php');
$usertxt = check_valid_user();

echo "<div id=\"navbar\">";
   
    echo "<a href=\"index.php\"><img src=\"\sports\\images\\football.png\" alt=\"Football\" weight=\"19\" height=\"19\"</a>\n"; 
    echo "<a href=\"createClub.php\">Lisää seura</a>\n";
    echo "<a href=\"members.php\">Seurojen jäsentiedot</a>\n";
    // echo "<a href=\"createMember.php\">Lisää jäsen</a>\n";   
    echo "<a href=\"users\change_passwd_form.php\">Muuta salasana</a>\n";
    echo "<a href=\"users\logout.php\">Logout</a>\n";
    echo "<a href=\"#usertxt\">" .  htmlspecialchars($usertxt) . "</a>\n";
 
echo "</div>";

 //todo:
 // remove all session variables
 //session_unset();
 
 // destroy the session;
 //session_destroy();
 
//**************** */ end the session


function callFunctions($mode, $param)
{
    //log -start
   
    //Write action to txt log
    // $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
    //         "Attempt: ".($result[0]['success']=='1'?'Success':'Failed').PHP_EOL.
    //         "User: ".$username.PHP_EOL.
    //         "-------------------------".PHP_EOL;
    
    // file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
    //log -end
    
    $local = ($_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1');
    
    // 
    // foreach ($_SERVER  as $k => $v)
    // {
    //     echo "key: $k, value: $v <br>";       
    //     
    // }
    // 
    // var_export ($_SERVER);
    if (!$local )
    {
        $palvelin   = "127.0.0.1:53181";
        $kayttaja   = "azure";  // tämä on tietokannan käyttäjä, ei tekemäsi järjestelmän
        $salasana   = "6#vWHD_$";
        $tietokanta = "sports";
    }
    else {
        $palvelin   = "localhost";
        $kayttaja   = "root";  // tämä on tietokannan käyttäjä, ei tekemäsi järjestelmän
        $salasana   = "";
        $tietokanta = "sports";
     }

    $con = mysqli_connect($palvelin, $kayttaja, $salasana, $tietokanta);
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
        exit;
    }

    try {
        switch ($mode)
        {
            case "fetchClubs":
                fetchClubs($con, $param);
                break;

            case "fetchClubById":
                fetchClubById($con, $param);
                break;

            case "fetchMemberList":
                fetchMemberList($con, $param);
                break;

            case "fetchMembers":
                fetchMembers($con);
                break;
    
            case "createMember":
                createMember($con);            
                break;  
                
            case "createClub":
                createClub($con);            
                break;       
    
            default:
                break;
        }
        // $logger->info('This is a log! ^_^ ');
    }
    
    catch(Exception $e) {
     
        $Message = urlencode("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
        header("Location: error.php?Message=".$Message);
    }

    finally {

      //  echo "db connection closed"; //todo:
        mysqli_close($con);
    }
}


function fetchClubById( $con, $ind)
{              
    //****  unset session variable */
    // if (isset($_SESSION['club_id'])) {
    //     unset($_SESSION['club_id']);
    // }

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
  
    $id = -1;
   
    if (isset($_SESSION['club_identifiers'])) {     
        $arr_identifiers = $_SESSION['club_identifiers'];
        $id = $arr_identifiers[$ind];
    }
   
    $sql = "SELECT c.id, c.name, c.description, c.updated, c.updatedBy FROM club c where c.id = $id";

    //   echo $sql ;
    //  exit;

    $result = mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) > 0)
    {
            //******also making session data ****//
       
            while($row = mysqli_fetch_assoc($result)) 
            {   
                              
                $name        = $row['name'];
                $description = $row['description'];              
                $updatedBy = $row["updatedBy"]; 
                $updated = $row["updated"]; 
              
                echo $name; //name of the club
                 
                $clubid_session =  $row['id'];              
            }
            
            if (session_status() == PHP_SESSION_NONE) {
                session_start();              
            }
            $_SESSION['club_id'] = $clubid_session; // set session data
         
          //  echo "kohta C: " .  $_SESSION['club_id'];

 
    }
    else
    {
        echo "Tietoja ei löydy";
    }
}

function fetchClubs( $con, $param)
{   
    //****  unset session variable */
    if (isset($_SESSION['club_identifiers'])) {
        unset($_SESSION['club_identifiers']);
      
    }

    $sql = "SELECT c.id, c.name, c.description, c.updated, c.updatedBy FROM club c order by c.name";

    $result = mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) > 0)
    {
        //************* list *************//
        //******also making session data ****//
        if ($param == "list") {

            echo "<table id=\"myTableId\" ><tr><th>Seura</th><th>Kuvaus</th><th>Päivittäjä</th><th>Päivitysaika</th><th></th></tr>";
            $ind = 1;
          
            $arr_session = array();
            while($row = mysqli_fetch_assoc($result)) 
            {                                 
                $name        = $row['name'];
                $description = $row['description'];
              
                $updatedBy = $row["updatedBy"]; 
                $updated = $row["updated"]; 
            
                echo "<tr onclick=\"setSelectedRow(this)\"><td>$name</td><td>$description</td><td>$updatedBy</td><td>$updated</td>" .
                "<td hidden name=\"ind\">$ind</td><td><a href=\"createMember.php?ind=$ind\">Lisää jäsen</a></td></tr>";

                $arr_session[$ind] =  $row['id'];
                $ind         = $ind + 1;
            }
            echo "</table>";
         
            
           
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['club_identifiers'] = $arr_session; // set session variable

           
        //    echo "<pre>";     
        //    echo print_r ($_SESSION['club_identifiers']);
        //    echo "</pre>";

        }
         //*********** all or some *************/
        else {
            $valitse = "Valitse urheiluseura";  
      
            echo  "<select name=\"clubid\">";
            if ($param == "all") {
                echo  "<option value=0 selected>$valitse</option>";
            }
    
            while($row = mysqli_fetch_assoc($result)) 
            {
                $id   = $row["id"];
                $name = $row["name"];
        
                echo  "<option value=$id>$name</option>";
            }
        }
    }
    else
    {
        echo "Tietoja ei löydy";
    }
}

function fetchMemberList( $con, $club_id)
{
   
 
    $sql =  
  
    "SELECT c.name as clubname, m.id, m.firstname, m.lastname, m.updatedBy, m.updated " .
    "from member m, club c";
    $sql =  $sql . " WHERE m.club_id = c.id AND m.club_id = $club_id";

    $sql =  $sql . " ORDER BY clubname, m.lastname, m.firstname";
    
    //  echo $sql ;
    //  exit;
     
    $result = mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) > 0)
    {
        echo "<table id=\"myTableId\" ><tr><th>Seura</th><th>Sukunimi</th><th>Etunimi</th><th>Päivittäjä</th><th>Päivitysaika</th></tr>";

        while($row = mysqli_fetch_assoc($result)) 
        {
            $clubname = $row['clubname'];
            $lastname = $row['lastname'];
            $firstname = $row['firstname'];
            $updatedBy = $row["updatedBy"]; 
            $updated = $row["updated"]; 
         
            echo "<tr><td>$clubname</td><td>$lastname</td><td>$firstname</td><td>$updatedBy</td><td>$updated</td></tr>";
        }
        echo "</table>";
    }
    else
    {
        echo "<br>Tietoja ei löydy!";
    } 
}

function fetchMembers( $con)
{
    $nimi        = trim(strip_tags( $_POST['nimi'] ) );
    $nimi        = mysqli_real_escape_string($con, $nimi);

    $club_id = (int)$_POST['clubid'];
 
    $sql =  
  
    "SELECT c.name as clubname, m.id, m.firstname, m.lastname, m.updatedBy, m.updated " .
    "from member m, club c";
    $sql =  $sql . " WHERE m.club_id = c.id";

    if (($club_id !=  0) ||  ($nimi != ""))
    {
        
        if ($club_id !=  0) {
            $sql =  $sql . " AND club_id = " . $club_id;       

        }
        if ($nimi != "") {
            $sql =  $sql . " AND (( m.firstname LIKE '%$nimi%') OR
                              ( m.lastname LIKE '%$nimi%'))";   
        }   
    }
    $sql =  $sql . " ORDER BY clubname, m.lastname, m.firstname";
    
    //  echo $sql ;
    //  exit;
     
    $result = mysqli_query($con, $sql);
    
    if (mysqli_num_rows($result) > 0)
    {
        echo "<table id=\"myTableId\" ><tr><th>Seura</th><th>Sukunimi</th><th>Etunimi</th><th>Päivittäjä</th><th>Päivitysaika</th></tr>";

        while($row = mysqli_fetch_assoc($result)) 
        {
            $clubname = $row['clubname'];
            $lastname = $row['lastname'];
            $firstname = $row['firstname'];
            $updatedBy = $row["updatedBy"]; 
            $updated = $row["updated"]; 
         
            echo "<tr><td>$clubname</td><td>$lastname</td><td>$firstname</td><td>$updatedBy</td><td>$updated</td></tr>";
        }
        echo "</table>";
    }
    else
    {
        echo "<br>Tietoja ei löydy!";
    } 
}



function createMember($con)
{
    try {

        // $club_id              = (int)$_POST['clubid'];
        $club_id   = -1;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();              
        }
        if (isset($_SESSION['valid_user']))  {     
            $updatedBy = $_SESSION['valid_user'];
        }
        
        if (isset($_SESSION['club_id']))  {     
            $club_id = $_SESSION['club_id'] ; //clubid selected by user in clubs form

           // echo "kohta A: " . $club_id;
        }

        echo "jees3: " . $club_id;
        
        $firstname         = trim(strip_tags( $_POST['firstname']));
        $firstname         = mysqli_real_escape_string($con,  $firstname );

        $lastname          = trim(strip_tags( $_POST['lastname']));
        $lastname          = mysqli_real_escape_string($con, $lastname );

        $description        = trim(strip_tags( $_POST['description'])); 
        $description        = mysqli_real_escape_string($con, $description);
    
        $sql = "INSERT INTO member (                
                    description,
                    firstname,
                    lastname,
                    club_id,
                    updatedBy                     
                )
                VALUES (
                    '$description',
                    '$firstname',
                    '$lastname',
                    '$club_id',
                    '$updatedBy')";

        // echo $sql ;
        // exit;
    
        if (mysqli_query($con, $sql))
        {
            // $Message = "Seuran jäsen lisätty onnistuneesti tietokantaan!";
            // header("Location: members.php?Message=".$Message);

            // set session variable
           // $_SESSION['message'] = "Seuran jäsen lisätty onnistuneesti tietokantaan!"; 
            header("Location: memberlist.php");
        }
        else
        {
            // todo: $error = "Virhe tietojen päivityksessä: " . mysqli_error($con);

            $Message = "Virhe tietojen päivityksessä: seuran jäsenen lisääminen";
            header("Location: error.php?Message=".$Message);

        } 
    }
    finally {
        //****  unset session variable */
        // if (isset($_SESSION['club_id'])) {
        //     unset($_SESSION['club_id']);
        //     echo "kohta B: unset <br> "; 
        // }
       // echo "kohta B: unset <br> "; 

    } 
}


function createClub($con)
{
    if (isset($_SESSION['valid_user']))  {     
        $updatedBy = $_SESSION['valid_user'];
    }
    
    $name         = trim(strip_tags( $_POST['name']));
    $name         = mysqli_real_escape_string($con,  $name );
 
    $description        = trim(strip_tags( $_POST['description'])); 
    $description        = mysqli_real_escape_string($con, $description);
  
    $sql = "INSERT INTO club (  
                name,              
                description,
                updatedBy                     
            )
            VALUES (
                '$name',
                '$description',
                '$updatedBy')";

    //  echo $sql ;
    //  exit;

    if (mysqli_query($con, $sql))
    {
       // $Message = "Seura $name on lisätty onnistuneesti tietokantaan!";

      //  $_SESSION['message'] = "Seura $name on lisätty onnistuneesti tietokantaan!"; 
        header("Location: index.php");
    }
    else
    {
       // $Message = "Virhe tietojen päivityksessä: " . mysqli_error($con); //todo: log process
        $Message = "Virhe tietojen päivityksessä: seuran tiedot";
        header("Location: error.php?Message=".$Message);
    }  
}
  
?>

<script>
       // When the user scrolls the page, execute myFunction
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

</script>
