<?php
include('classes/DB.php');
include('classes/Login.php');

$showTimeline = False;
if (Login::isLoggedIn()) {
        $userid = Login::isLoggedIn();
        $showTimeline = True;
} else {
        die('Not logged in');
}

?>