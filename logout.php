<?php
// Clear the cookie by setting its expiration time to the past
setcookie("user_id", "", time() - 3600, "/"); // Delete the cookie

// Redirect to the login page
header("Location: login.php");
exit();

?>
