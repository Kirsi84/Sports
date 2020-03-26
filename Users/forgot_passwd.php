<?php
  require_once("bookmark_fns.php");
  do_html_header("Resetting password");

  // creating short variable name
  $username = $_POST['username'];

  try {
    $password = reset_password($username);
    notify_password($username, $password);
    echo 'Your new password has been emailed to you.<br>';
  }
  catch (Exception $e) {
    //echo 'Your password could not be reset - please try again later.';
    $Message = "Toiminto ei ole käytössä!"; //KIR
    header("Location: /sports/error.php?Message=".$Message);
  }
  do_html_url('login.php', 'Login');
  do_html_footer();
?>
