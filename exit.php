<?php
session_start();

//To Get Exit Of All Session Already entered
session_destroy();

//After Making Exit , Return To Home Page
header("Location: index.php");
?>