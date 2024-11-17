<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
// remove all session variables
session_unset();

// destroy the session
session_destroy();

//izdzēšam cookie
setcookie("pieteicies", "", time() - 3600, "/");

//kad lietotājs ir izlogots, tad sūtām viņu uz publisko daļu
header("Location: index.php");
exit();
?>

</body>
</html>