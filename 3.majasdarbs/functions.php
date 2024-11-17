<?php

include 'config.php';

function pieteicies() {
    $ielogojies = false;

    if (isset($_SESSION["pieteicies"])) {
        $ielogojies = true;
    } elseif (isset($_COOKIE["pieteicies"])) {
        $ielogojies = true;
        $_SESSION["pieteicies"] = true;
        $_SESSION["lietotajs"] = $_COOKIE["pieteicies"];
    } 
    return $ielogojies;
}

function irAdministrators() {
    $admin = false;
    global $conn;

    if (pieteicies()) {
        $id =  $_SESSION["lietotajs"];
        $sql = "SELECT id FROM lietotaji WHERE id='$id' AND loma='admin'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            $admin = true;
        }
    }

    return $admin;
}

function segvards() {
    global $conn;
    $segvards = '';
    
    if (pieteicies()) {
      $lietotajaId = $_SESSION["lietotajs"];
  
      $sql = "SELECT segvards FROM lietotaji WHERE id=$lietotajaId";
      $result = $conn->query($sql);
      if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $segvards = $row["segvards"];
      }
    }
    
    return $segvards;
}

function ieladet_attelu() {

    $target_file = "uploads/default.png";

    if (!empty($_FILES["fileToUpload"]["tmp_name"])) {
    //pārbaudām, vai attēls ir atsūtīts
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }
    
    // Check if file already exists
    if (file_exists($target_file)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 15000000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], "../" . $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
    }//beidzas pārbaude, vai attēls tika ielādēts


    return $target_file;
}

?>