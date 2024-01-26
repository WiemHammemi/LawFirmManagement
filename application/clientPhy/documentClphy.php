<?php

$servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "bureau_avocats";
 $conn = new mysqli($servername, $username, $password, $dbname);
 if ($conn->connect_error) {
   die("Erreur de connection : " . $conn->connect_error);
 }

session_start();

if(!($_SESSION['type']=='clientPhy')){
   header('location:../index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css" type="text/css" />
    <link rel="stylesheet" href="../style/style_av.css" type="text/css" />
    <link rel="shortcut icon" href="../logo/favicon.ico"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-rz/XW1FqhNQ6C5U6f5v5M5KaUTQwKilUUIy5S6RjKfuLyK4ksd9Y+lZPxv4+Qqtn" crossorigin="anonymous">
</head>
<title>  <?php echo   $_SESSION['nom']."  " . $_SESSION['prenom']; ?> | Espace client</title>
</head>

<body>
 
<style>body{
	margin:0px;
	padding: 0px;
    background:none;
	background-color:#efeff5;
	font-family: system-ui;
}
    </style>
    
    <div id="mySidenav" class="sidenav">
        <p class="logo"> <span class="menu">&#9776;</span></p>
        <p class="logo1"> <span class="menu1">&#9776;</span></p>
        <a href="#" class="icon-a"><i class="fa fa-dashboard icons"></i> &nbsp;&nbsp;Table de bord</a>
        <a href="clientPhy.php" class="icon-a"><i class="fa fa-home icons" ></i>&nbsp;&nbsp;Accueil</a>
        <a href="AvocatsClPhy.php" class="icon-a"><i class="fa fa-user icons"></i> &nbsp;&nbsp;Avocats</a>
        <a href="affaireClPhy.php" class="icon-a"><i class="fa fa-briefcase icons" ></i> &nbsp;&nbsp;Affaires</a>
        <a href="procesClPhy.php" class="icon-a"><i class="fa fa-gavel icons"></i> &nbsp;&nbsp;Les procès</a>

        <a href="consultationsClPhy.php" class="icon-a"><i class="fa fa-calendar icons"></i> &nbsp;&nbsp;Consultations</a>
        
        <a href="PayerClPhy.php" class="icon-a"><i class="fa fa-credit-card icons"></i> &nbsp;&nbsp;Payer</a>
        <a href="documentClphy.php" class="icon-a"><i class="fa fa-bell icons"></i> &nbsp;&nbsp;Documents</a>


    </div>
    <div id="main">

        <div class="head">
            <div class="col-div-6">
                <p class="nav"> Table de bord</p>

            </div>

            <div class="col-div-6">
                <i class="fa fa-search search-icon"></i>


                <i class="fa fa-bell noti-icon"></i>
                <div class="notification-div">
                    <p class="noti-head">Notification <span>2</span></p>
                    <hr class="hr" />
                    <?php
 $id=$_SESSION['id'] ;
$sql19="SELECT msg FROM notif
WHERE user_type='clientphy'
AND id_user=$id
ORDER BY datenotif DESC" ;
$res = mysqli_query($conn, $sql19);
if ($res && $res->num_rows > 0) {
    echo"Notifications </br>";
   while($row19 = $res->fetch_assoc()) {
     echo"<tr>
             <td>".$row19['msg']."</td> <br>
             </tr>        
         ";
   }
   } 
   else echo 'aucune notification' ;
   ?>
                </div>
                <div class="profile">


                    <p><i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                        <?php echo   $_SESSION['nom']."  " . $_SESSION['prenom']; ?> <i class="fa fa-ellipsis-v dots"
                            aria-hidden="true"></i></p>

                    <div class="profile-div">
                        <!-- <p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p> -->
                        <a href="profileClPhy.php"><p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p></a>
                        <!-- <p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p> -->
                        <a href="parametresClPhy.php"><p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p></a>
                        <!-- <p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p> -->
                       <a href="logout.php" class="logoutBtn" id="logoutBtn"><p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p></a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="content">
        <form action="documentClphy.php" method="post" enctype="multipart/form-data">
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="id" name="idaff" placeholder="entrez l'id de l'affaire" >
  <input type="submit" value="Importer un fichier" name="submit">
</form>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bureau_avocats";

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if file was uploaded
if(isset($_POST["submit"])) {
  $target_dir = "../uploads/";
  $id=$_POST['idaff'] ;
  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
  echo $target_file;
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

  // Check if file already exists
  if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["fileToUpload"]["size"] > 5000000000000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
 && $imageFileType != "pdf" ) {
    echo "Désolée , que de des documents de type PDF , PNG , JPEG ou JPG sont acceptés";
    $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    echo "Désolé , erreur d'importation.";
  // If everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
      echo "Le fichier  ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " a été importé.";

      // Insert file into database
      $sql = "INSERT INTO document (nomdoc, id_aff, typea) VALUES ('$target_file',$id,'client')";
      if ($conn->query($sql) === TRUE) {
        echo "File added to database";
      } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    } else {
      echo "Sorry, there was an error uploading your file.";
    }
  }
}


?>
