<?php
// Clear the cookie by setting its expiration time to the past
// Delete the cookie
setcookie("user_id", "", time() - 3600, "/");
setcookie("user_role", "", time() - 3600, "/");

// Redirect to the login page
header("Location: login.php");
exit();
