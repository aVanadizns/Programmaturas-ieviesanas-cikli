<?php
// Start the session
session_start();
include 'functions.php';
include 'config.php';
?>
<!DOCTYPE html>
<html lang="lv">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Pieteikties</title>
</head>
<body>
<h1>Pieteikties</h1>

<form action="" method="post">
  <input type="text" name="lietotajs" placeholder="Ievadiet e-pasta adresi" required><br><br>
  <input type="password" name="parole" placeholder="Ievadiet paroli" required><br><br>
  <input type="checkbox" name="atcereties" id="atcereties">
  <label for="atcereties">atcerēties mani</label><br><br>
  <input type="submit" value="Pieteikties" name="pieteikties">&nbsp;
  <a href='register.php'>Reģistrēties</a>
  <br><br>
</form>

<?php
  if (isset($_POST["pieteikties"])) {
  //vai forma tika iesniegta

    $lietotajs = $_POST["lietotajs"];
    $parole = $_POST["parole"];

    $sql = "SELECT id, parole FROM lietotaji WHERE e_pasts='$lietotajs'";
    //echo $sql;
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
      //ja dati pareizi, tad ielogojam lietotāju sistēmā
      
      $row = $result->fetch_assoc();

      if (password_verify($parole, $row["parole"])) {
        //pārbaudām sajaukto paroli ar formā ievadīto
      
        $_SESSION["pieteicies"] = true;
        $_SESSION["lietotajs"] = $row["id"];
      
        //pārbaudām, vai ielikts ķeksītis pie atcerēties mani
        if (isset($_POST["atcereties"])) {
          setcookie("pieteicies", $_SESSION["lietotajs"], time() + (86400 * 30), "/");
        }
      
        //pēc ielogošanas pāršutām lietotāju uz administrācijas paneli
        header("Location: admin/index.php");
        exit();

      } else {
        echo "<p>Ievadītā e-pasta adrese vai parole nav pareiza!</p>";
      }

    } else {
      echo "<p>Ievadītā e-pasta adrese vai parole nav pareiza!</p>";
    }

  } //beidzas pārbaude, vai forma tika iensiegta
?>

</body>
</html>