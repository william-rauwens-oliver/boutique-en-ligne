<?php
session_start();
session_unset();
session_destroy();
header("Location: ../Authentification/Authentification.html");
exit();
?>
