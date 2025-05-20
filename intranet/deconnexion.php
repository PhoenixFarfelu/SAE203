<?php
session_start();
session_unset();  // Unset all session values
session_destroy();  // Destroy the session
echo '<script> window.location.href = "index.php"</script>';  // Redirect to accueil.php

header('Location: index.php');
exit();  // Redirect to accueil.php