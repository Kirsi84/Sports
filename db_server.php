<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require('checkUser.php');
$usertxt = check_valid_user();

echo "<div id=\"navbar\">";
   
    echo "<a href=\"index.php\"><img src=\"\sports\\images\\football.png\" alt=\"Football\" weight=\"19\" height=\"19\"</a>\n"; 
    echo "<a href=\"createClub.php\">Lisää seura</a>\n";
    echo "<a href=\"members.php\">Seurojen jäsentiedot</a>\n";
   
    echo "<a href=\"users\change_passwd_form.php\">Muuta salasana</a>\n";
    echo "<a href=\"users\logout.php\">Logout</a>\n";
    echo "<a href=\"#usertxt\">" .  htmlspecialchars($usertxt) . "</a>\n";
 
echo "</div>";

 //todo:
 // remove all session variables
 //session_unset();
 
 // destroy the session;
 //session_destroy();
 
#region main
function callFunctions($mode, $param)
{
    $local = ($_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1');
       
    try
    {
        if (!$local )
        {
            $palvelin   = "127.0.0.1:53181";
            $kayttaja   = "azure";  // tämä on tietokannan käyttäjä, ei tekemäsi järjestelmän
            $salasana   = "6#vWHD_$";
            $tietokanta = "sports";

            // Turn off all error reporting
           // error_reporting(0); // in production not showing 
        }
        else {
            $palvelin   = "localhost";
            $kayttaja   = "root";  // tämä on tietokannan käyttäjä, ei tekemäsi järjestelmän
            $salasana   = "";
            $tietokanta = "sports";

            // error_reporting(0); // just testing not to show errors in test environment
            error_reporting(E_ALL);

        }

        log_writing("Server: " . $palvelin . " Database: " .  $tietokanta); // just testing

        $con = mysqli_connect($palvelin, $kayttaja, $salasana, $tietokanta);
    

        if (mysqli_connect_errno()) {
           
            // Send error message to the server log if error connecting to the database
            log_writing("Failed to connect to MySQL: " . mysqli_connect_error());
            show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");

            // exit;
        }

        switch ($mode)
        {
            case "fetchClubs":
                fetchClubs($con, $param);
                break;

            case "fetchClubById":
                fetchClubById($con, $param);
                break;

            case "fetchClubNameById":
                fetchClubNameById($con, $param);
                break;
            
            case "fetchMemberList":
                fetchMemberList($con, $param);
                break;

            case "fetchClubsAndMembers":
                fetchClubsAndMembers($con);
                break;

            case "fetchMemberById":              
                fetchMemberById($con, $param);
                break;

            case "createMember":
                createMember($con);            
                break;
                
            case "deleteMember":
                deleteMember($con, $param);        
                break;  
            
            case "createClub":
                createClub($con);            
                break;       
    
            default:
                log_writing("incorrect mode");
                break;
        }       
    }
    
    catch(Exception $e) {
     
        log_writing($e->getMessage());
        show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
    }

    finally {
   
        mysqli_close($con);
       //  log_writing("db connection closed");
    }
}

//main
#endregion 

#region errors

// log_writin
function log_writing($msg) {       
    $date_utc = new \DateTime("now", new \DateTimeZone("UTC")); //UTC-time is used
     
    $log  = $date_utc->format(\DateTime::ISO8601) . " " . $msg .  "\r\n";
    file_put_contents('./logs/log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
}

// redirect to user error page
function show_user_error($userMessage) {
    $userMessage = urlencode($userMessage);
    header("Location: error.php?Message=".$userMessage);
}
//errors
#endregion 

#region session

function getClubIdByIndFromSession ($ind) {
    $club_id = -1;
    if (isset($_SESSION['club_identifiers'])) {     
        $arr_identifiers = $_SESSION['club_identifiers'];
        $club_id = $arr_identifiers[$ind];

        if (isset($_SESSION['club_id'])) {
            unset($_SESSION['club_id']); 
        }
        $_SESSION['club_id'] = $club_id; // set session data
     
    }
    return $club_id;
}

//***** club id : getClubIdFromSession
function getClubIdFromSession () {
    $club_id = -1;
   
    if (isset($_SESSION['club_id'])) {
        $club_id = $_SESSION['club_id'];               
    }    
    return $club_id;
}

//***** member id : getMemberIdByIndFromSession
function getMemberIdByIndFromSession ($ind) {
    $member_id = -1;
    if (isset($_SESSION['member_identifiers'])) {     
        $arr_identifiers = $_SESSION['member_identifiers'];
        $member_id = $arr_identifiers[$ind];

        if (isset($_SESSION['member_id'])) {
            unset($_SESSION['member_id']); 
        }
        $_SESSION['member_id'] = $member_id; // set session data
     
    }
    return $member_id;
}

//***** member id : getMemberIdFromSession
function getMemberIdFromSession () {
    $member_id = -1;
   
    if (isset($_SESSION['member_id'])) {
        $member_id = $_SESSION['member_id'];               
    }    
    return $member_id;
}
// end session processing
#endregion 

#region clubs processing
function fetchClubById($con, $id)
{     
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($id)) {
        $sql = "SELECT c.id, c.name, c.description, c.updated, c.updatedBy FROM club c where c.id = $id";
 
        $result = mysqli_query($con, $sql);
    
        if ($result == false) {         
            log_writing("fetchClubById: Error description: " . mysqli_error($con));
            show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
        }
    
        else
        {        
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
            }
            else
            {
                echo "Tietoja ei löydy";
            }
        }
    }
    else {
        log_writing("fetchClubById: Error description: ClubId missing.");
        show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
    }
}

function fetchClubNameById($con, $id)
{              
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
        
    $sql = "SELECT c.id, c.name FROM club c where c.id = $id";
    //  echo $sql ;
    //  exit;

    $result = mysqli_query($con, $sql);

    if ($result == false) {
     
        log_writing("fetchClubNameById: Error description: " . mysqli_error($con));
        show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
    }
    else
    {
        if (mysqli_num_rows($result) > 0)
        {
            //******also making session data ****//
        
            while($row = mysqli_fetch_assoc($result)) 
            {                              
                $name        = $row['name'];
                $clubid_session =  $row['id'];              
    
                echo $name; //name of the club
            }
            
            if (session_status() == PHP_SESSION_NONE) {
                session_start();              
            }
            $_SESSION['club_id'] = $clubid_session; // set session data
        }
        else
        {
            echo "Tietoja ei löydy";
        }
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

    if ($result == false) {
     
        log_writing("fetchClubs: Error description: " . mysqli_error($con));
        show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
    }
    else {
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
                    "<td hidden name=\"ind\">$ind</td><td>" . 
                    "<a href=\"createMember.php?ind=$ind\">Lisää jäsen</a>" . " " .
                    "<a href=\"memberlist.php?ind=$ind\">Jäsenlistaus</a>" .
                    "</td></tr>";
    
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
                if ($param == "all") {
                    $valitse = "Valitse kaikki";  
                }
                else {
                    $valitse = "Valitse urheiluseura";  
                }
               
          
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
        header("Location: index.php");
    }
    else
    {    
        log_writing( "createClub: Error when inserting club data" . mysqli_error($con));
        show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
    }  
}
// end clubs processing
#endregion 

#region member processing
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

    if ($result == false) {
     
        log_writing("fetchMemberList: Error description: " . mysqli_error($con));
        show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
    }
    else {
    
        if (mysqli_num_rows($result) > 0)
        {
            echo "<table id=\"myTableId\" ><tr><th>Sukunimi</th><th>Etunimi</th>" .
                "<th>Päivittäjä</th><th>Päivitysaika</th><th></th></tr>";

            $ind = 1;
            $arr_session = array();
            
            while($row = mysqli_fetch_assoc($result)) 
            {
                $lastname = $row['lastname'];
                $firstname = $row['firstname'];
                $updatedBy = $row["updatedBy"]; 
                $updated = $row["updated"]; 
                $id = $row["id"]; 

                echo "<tr><td>$lastname</td><td>$firstname</td><td>$updatedBy</td><td>$updated</td>" .
                "<td><a href=\"deletemember.php?ind=$ind\">Poista</a>" .
                "</td></tr>";
                $arr_session[$ind] =  $row['id'];
                $ind         = $ind + 1;
            }
            echo "</table>";

            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['member_identifiers'] = $arr_session; // set session variable
        }
        else
        {
            echo "<br>Seuralla ei ole jäsentietoja!";
        } 
    }
}

// clubs and members
function fetchClubsAndMembers( $con)
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
            $sql =  $sql . " AND (( m.firstname LIKE '%$nimi%') OR ( m.lastname LIKE '%$nimi%'))";   
        }  
  
    }
    $sql =  $sql . " ORDER BY clubname, m.lastname, m.firstname";
    
    //  echo $sql ;
    //  exit;

    $result = mysqli_query($con, $sql);

    if ($result == false) {     
        log_writing("fetchClubsAndMembers: Error description: " . mysqli_error($con));
        show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
    }
    else {
         
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
            echo "Tietoja ei löydy!";
        } 
    }
}

function fetchMemberById($con, $id) {

    if (isset($id)) {
        $sql =  
  
        "SELECT c.name as clubname, m.id, m.firstname, m.lastname, m.description, m.updatedBy, m.updated " .
        "from member m, club c";
        $sql =  $sql . " WHERE m.id = " . $id . " and m.club_id = c.id";
      
        //  echo $sql ;
        //  exit;
     
        $result = mysqli_query($con, $sql);
    
        if ($result == false) {     
            log_writing("fetchMemberById: Error description: " . mysqli_error($con));
            show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
        }
        else {
         
            if (mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result)) 
                {
                    $clubname = $row['clubname'];
                    $lastname = $row['lastname'];
                    $firstname = $row['firstname'];
                    $description = $row['description'];
                    $updatedBy = $row["updatedBy"]; 
                    $updated = $row["updated"]; 
                
                    echo 
                    
                        "<label for  =\"clubname\" class=\"lbTitle\">Seura:</label>" .            
                        $clubname . "<br>" .
    
                        "<label for  =\"firstname\" class=\"lbTitle\">Etunimi:</label>" .
                        $firstname . "<br>" .
    
                        "<label for  =\"lastname\" class=\"lbTitle\">Sukunimi:</label>" .
                        $lastname . "<br>" . 
    
                        "<label for  =\"description\" class=\"lbTitle\">Kuvaus:</label>" .
                        $description . "<br>" . 
    
                        "<label for  =\"updatedBy\" class=\"lbTitle\">Päivittäjä:</label>" .
                        $updatedBy . "<br>" .
    
                        "<label for  =\"updated\" class=\"lbTitle\">Päivitysaika:</label>" .
                        $updated;
                }     
            }
            else
            {
                echo "<br>Tietoja ei löydy!";
            } 
        }
    }
    else {
        log_writing("fetchMemberById: Error description: memberid missing");
        show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
    }
}

function createMember($con)
{
    try {
      
        $club_id   = -1;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();              
        }
        if (isset($_SESSION['valid_user']))  {     
            $updatedBy = $_SESSION['valid_user'];
        }
        
        if (isset($_SESSION['club_id']))  {     
            $club_id = $_SESSION['club_id'] ; //clubid selected by user in clubs form
        }
         
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

        //  echo $sql ;
        //  exit;
    
        if (mysqli_query($con, $sql))
        {
            header("Location: memberlist.php");
        }
        else
        {
            log_writing("createMember: Error description: " . mysqli_error($con));
            show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
        } 
    } 
    catch(Exception $e) {
     
        log_writing($e->getMessage());
        show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
       
    }  
}

function deleteMember($con, $id)
{
    try
    {        
        $sql = "DELETE from member where id = " . $id;             
    
        //  echo $sql ;
        //  exit;
    
        if (mysqli_query($con, $sql))
        {
            if (mysqli_affected_rows($con) == 1) {
                echo "Jäsentieto poistettu!<br>";
            }
            else {
                log_writing("deleteMember: Error description: not finding anything to delete");
                echo "Jäsentietoa ei löydy!";
            }
        }
        else
        {
            log_writing("deleteMember: Error description: " . mysqli_error($con));
            show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
        } 

    }
    catch(Exception $e) {
     
        log_writing($e->getMessage());
        show_user_error("Virhe tietokantakäsittelyssä. Kokeile hetken kuluttua uudelleen.");
    }
   
}
// member processing
#endregion 
  
?>

<script>
    // When the user scrolls the page, execute pageScrolling
    window.onscroll = function() {pageScrolling()};

    // Get the navbar
    var navbar = document.getElementById("navbar");

    // Get the offset position of the navbar
    var sticky = navbar.offsetTop;

    // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function pageScrolling()
    {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
    }

</script>
