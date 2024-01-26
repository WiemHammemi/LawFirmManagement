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

if(!($_SESSION['type']=='clientMor')){
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
<title> <?php echo   $_SESSION['nom']."  " . $_SESSION['prenom']; ?> | Espace client</title>
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
       
        <a href="clientMor.php" class="icon-a"><i class="fa fa-home icons" ></i>&nbsp;&nbsp;Accueil</a>
        <a href="AvocatClMor.php" class="icon-a"><i class="fa fa-user icons"></i> &nbsp;&nbsp;Avocats</a>
        <a href="affaireClMor.php" class="icon-a"><i class="fa fa-briefcase icons" ></i> &nbsp;&nbsp;Affaires</a>
        <a href="procesClMor.php" class="icon-a"><i class="fa fa-gavel icons"></i> &nbsp;&nbsp;Les procès</a>

        <a href="consultationsClMor.php" class="icon-a"><i class="fa fa-calendar icons"></i> &nbsp;&nbsp;Consultations</a>
        
        <a href="PayerClMor.php" class="icon-a"><i class="fa fa-credit-card icons"></i> &nbsp;&nbsp;Payer</a>
       



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
WHERE user_type='clientmor'
AND id_user=$id
ORDER BY datenotif DESC" ;
$res = mysqli_query($conn, $sql19);
if ($res && $res->num_rows > 0) {
    echo"Notifications </br>";
   while($row19 = $res->fetch_assoc()) {
     echo"<tr>
             <td>".$row19['msg']."</td>  
             </tr>        
         ";
   }
   } 
   else echo 'aucune notification' ;
   ?>
	</div>
	<script type="text/javascript">
    // Récupération de l'icone de notification et du div de notification
    var notiIcon = document.querySelector('.noti-icon');
    var notiDiv = document.querySelector('.notification-div');

    // Fonction pour afficher le div de notification
    function showNotiDiv() {
        notiDiv.style.display = 'block';
    }

    // Fonction pour masquer le div de notification
    function hideNotiDiv() {
        notiDiv.style.display = 'none';
    }

    // Ajout d'un écouteur d'événements au clic sur l'icone de notification
    notiIcon.addEventListener('click', function() {
        if (notiDiv.style.display === 'none') {
            showNotiDiv();
        } else {
            hideNotiDiv();
        }
    });

    // Ajout d'un écouteur d'événements au clic sur le div de notification
    notiDiv.addEventListener('click', function() {
        hideNotiDiv();
    });
</script>

		</div>
                </div>
                <div class="profile">


                <p> <i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                    <?php echo   $_SESSION['nom'].  '<br/> '; ?>  <i class="fa fa-ellipsis-v dots"
                            aria-hidden="true"></i></p>

                    <div class="profile-div">
                        
                        <a href="profileClPhy.php"><p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p></a>
                        
                        <a href="parametresClPhy.php"><p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p></a>
                        
                       <a href="logout.php" class="logoutBtn" id="logoutBtn"><p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p></a>
                    </div>
                </div>
          
            <div class="clearfix"></div>
    
        <div class="content">
        <p class="head-1">Votre affaires</p>
                <br />
                 <?php 
                    function uploadfile ($conn) {
                        if (isset($_POST["importer"])){
                            $target_dir = "../uploads/";
                            $id=$_POST['idaff'] ;
                            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                            echo $target_file;
                            $uploadOk = 1;
                            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                          
                            // Check if file already exists
                            if (file_exists($target_file)) {
                                echo "<script> window.onload = function(){alert('Désolé ,le fichier existe deja ')}</script>";
                              $uploadOk = 0;
                            }
                            
                          
                            // Check file size
                            if ($_FILES["fileToUpload"]["size"] > 5000000000000) {
                                echo "<script> window.onload = function(){alert('Désolé , taille du fichier tres grand ')}</script>";
                              $uploadOk = 0;
                            }
                          
                            // Allow certain file formats
                            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                           && $imageFileType != "pdf" ) {
                            echo "<script> window.onload = function(){alert('Désolé , que de des documents de type PDF , PNG , JPEG ou JPG sont acceptés ')}</script>";
                              $uploadOk = 0;
                            }
                          
                            // Check if $uploadOk is set to 0 by an error
                            if ($uploadOk == 0) {
                                echo "<script> window.onload = function(){alert('erreur d'ajout ')}</script>";
                            // If everything is ok, try to upload file
                            } else {
                              if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                          
                                // Insert file into database
                                $sql = "INSERT INTO document (nomdoc, id_aff, typea) VALUES ('$target_file',$id,'client')";
                                if ($conn->query($sql) === TRUE) {
                                    echo "<script> window.onload = function(){alert('fichier ajouté.')}</script>";
                                } else {
                                    echo "<script> window.onload = function(){alert('Error: " . $sql . "<br>" . $conn->error . "!')};</script>";
                        
                                }
                              } else {
                                echo "<script> window.onload = function(){alert('erreur')}</script>";
                              }
                            }  
                }
                    }
            $sql1="SELECT  affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.id_aff,affaire.commission , avocat.nomA, avocat.prenomA , expert.nomEx, expert.prenomEx
            FROM affaire 
            INNER JOIN avocat ON affaire.id_cin=avocat.id_cin
            INNER JOIN expert ON affaire.id_cin_ex=expert.id_cin_ex 
              
            WHERE affaire.confirmEx='oui' 
            AND affaire.confirmHN='non'
           
             AND  affaire.id_ClMor='" . $_SESSION['id'] . "'  
             
             GROUP BY affaire.id_aff";
               
            $sql2="  SELECT affaire.id_aff , affaire.date_fin, affaire.date_dep ,affaire.commission , avocat.nomA, avocat.prenomA ,houss_not.nomHN,houss_not.prenomHN
               FROM affaire 
               INNER JOIN avocat ON affaire.id_cin=avocat.id_cin
                
               INNER JOIN houss_not ON affaire.id_cin_hn=houss_not.id_cin_hn  
               WHERE affaire.confirmHN='oui'
               AND affaire.confirmEx='non'  
              
                AND  affaire.id_ClMor='" . $_SESSION['id'] . "'
                GROUP BY affaire.id_aff  ";

            $sql3="  SELECT affaire.id_aff , affaire.date_fin, affaire.date_dep ,affaire.commission , avocat.nomA, avocat.prenomA  
            FROM affaire 
            INNER JOIN avocat ON affaire.id_cin=avocat.id_cin
             
            
            WHERE affaire.confirmHN='non' 
            AND affaire.confirmEx='non' 
           
             AND  affaire.id_ClMor='" . $_SESSION['id'] . "' 
             GROUP BY affaire.id_aff ";
            
            $sql4="SELECT affaire.date_fin, affaire.date_dep , affaire.id_aff,affaire.commission , avocat.nomA, avocat.prenomA , expert.nomEx, expert.prenomEx,houss_not.nomHN, houss_not.prenomHN 
            FROM affaire 
            INNER JOIN avocat ON affaire.id_cin=avocat.id_cin
            INNER JOIN expert ON affaire.id_cin_ex=expert.id_cin_ex 
            INNER JOIN houss_not ON affaire.id_cin_hn=houss_not.id_cin_hn  
            WHERE affaire.confirmEx='oui' 
               AND affaire.confirmEx='oui' 
           
           
             AND  affaire.id_ClMor='" . $_SESSION['id'] . "' 
             GROUP BY affaire.id_aff ";
             $res1=$conn->query($sql1);
             $res2=$conn->query($sql2);
             $res3=$conn->query($sql3);
             $res4=$conn->query($sql4);
             echo" <table >
             <tr> <th>Code d'affaire  </th> <th>Date début </th> <th>Date fin </th><th>Avocat </th> <th>Huissier Notaire</th> <th>Expert </th><th>Commession </th> <th> Documents importées par vous </th> <th> Documents importées par votre avocat </th> <th> Importer </th> </tr>";
             if($res4)
             {
                while($row4=$res4->fetch_assoc())
             {
                $comm=$row4['commission'];
                $dateFin=$row4['date_fin'];
                if($row4['date_fin']=='0000-00-00')
                $dateFin="-";
                if($row4['commission']==0)
                $comm="-";
                
                 echo " <tr>
                        <td>".$row4['id_aff']."</td>
                         
                         <td>".$row4['date_dep']."</td>
                         <td>".$dateFin."  </td>
                         <td>".$row4['nomA']." " . $row4['prenomA']."</td>
                         <td>".$row4['nomHN']." " . $row4['prenomHN']."</td>
                         <td>".$row4['nomEx']." " . $row4['prenomEx']."</td>
                         <td>".$comm.'  </td>
                         <td> <a href="showfileClphy.php?id_aff='.$row4['id_aff'].'"> Voir ici </a> </td>
                         <td> <a href="showfileavocat.php?id_aff='.$row4['id_aff'].'"> Voir ici </a> </td>
                         <td> <form method="POST" action="affaireClMor.php" enctype="multipart/form-data">
                         <input type="hidden" name="idaff" value="'.$row4['id_aff'].'">
                         <input type="file" name="fileToUpload" id="fileToUpload">
                         <input type="submit" value="upload" name="importer">
                         </form> </td>
                         </tr>';
             }
             }
             if($res2)
             {
                while($row2=$res2->fetch_assoc())
             {
                $comm=$row2['commission'];
                $dateFin=$row2['date_fin'];
                if($row2['date_fin']=='0000-00-00')
                $dateFin="-";
                if($row2['commission']==0)
                $comm="-";
                
                 echo"<tr>
                        <td>".$row2['id_aff']."</td>
                         <td>".$row2['date_dep']."</td>
                         <td>".$dateFin."  </td>
                         <td>".$row2['nomA']." " . $row2['prenomA']."</td>
                         <td>".$row2['nomHN']." " . $row2['prenomHN']."</td>
                         <td>"."-"."</td>
                         <td>".$comm.'  </td>
                         <td> <a href="showfileClphy.php?id_aff='.$row2['id_aff'].'"> Voir ici </a> </td>
                         <td> <a href="showfileavocat.php?id_aff='.$row2['id_aff'].'"> Voir ici </a> </td>
                         <td> <form method="POST" action="affaireClMor.php" enctype="multipart/form-data">
                         <input type="hidden" name="idaff" value="'.$row2['id_aff'].'">
                         <input type="file" name="fileToUpload" id="fileToUpload">
                         <input type="submit" value="upload" name="importer">
                         </form> </td>
                         </tr>';

             }
             }
            if($res1)
            {
                while($row1=$res1->fetch_assoc())
                {
                   $comm=$row1['commission'];
                   $dateFin=$row1['date_fin'];
                   if($row1['date_fin']=='0000-00-00')
                   $dateFin="-";
                   if($row1['commission']==0)
                   $comm="-";
                   
                    echo"<tr>
                           <td>".$row1['id_aff']."</td>
                            
                            <td>".$row1['date_dep']."</td>
                            <td>".$dateFin."  </td>
                            <td>".$row1['nomA']." " . $row1['prenomA']."</td>
                            <td>"."-"."</td>
                            <td>".$row1['nomEx']." " . $row1['prenomEx']."</td>
                            
                            <td>".$comm.' </td>
                            <td> <a href="showfileClphy.php?id_aff='.$row1['id_aff'].'"> Voir ici </a> </td>
                         <td> <a href="showfileavocat.php?id_aff='.$row1['id_aff'].'"> Voir ici </a> </td>
                         <td> <form method="POST" action="affaireClMor.php" enctype="multipart/form-data">
                         <input type="hidden" name="idaff" value="'.$row1['id_aff'].'">
                         <input type="file" name="fileToUpload" id="fileToUpload">
                         <input type="submit" value="upload" name="importer">
                         </form> </td>
                         </tr>';
   
                            
                }
            }
             if($res3)
             {
                while($row3=$res3->fetch_assoc())
             {
                $comm=$row3['commission'];
                $dateFin=$row3['date_fin'];
                if($row3['date_fin']=='0000-00-00')
                $dateFin="-";
                if($row3['commission']==0)
                $comm="-";
                 echo"<tr>
                        <td>".$row3['id_aff']."</td>
                         <td>".$row3['date_dep']."</td>
                         <td>".$dateFin."  </td>
                         <td>".$row3['nomA']." " . $row3['prenomA']."</td>
                         <td>"."-"."</td>
                         <td>"."-"."</td>
                         <td>".$comm.' </td>
                         <td> <a href="showfileClphy.php?id_aff='.$row3['id_aff'].'"> Voir ici </a> </td>
                         <td> <a href="showfileavocat.php?id_aff='.$row3['id_aff'].'"> Voir ici </a> </td>
                         <td> <form method="POST" action="affaireClMor.php" enctype="multipart/form-data">
                         <input type="hidden" name="idaff" value="'.$row3['id_aff'].'">
                         <input type="file" name="fileToUpload" id="fileToUpload">
                         <input type="submit" value="upload" name="importer">
                         </form> </td>
                         </tr>';
                        
             }
            
             uploadfile($conn) ;
            }
             echo" </table >";
            
            ?>
               </div>
        <div class="clearfix"></div>
        <br />





        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(".menu").click(function() {
        $("#mySidenav").css('width', '70px');
        $("#main").css('margin-left', '70px');
        $(".logo").css('display', 'none');
        $(".logo1").css('display', 'block');
        $(".logo span").css('visibility', 'visible');
        $(".logo span").css('margin-left', '-10px');
        $(".icon-a").css('visibility', 'hidden');
        $(".icon-a").css('height', '55px');
        $(".icons").css('visibility', 'visible');
        $(".icons").css('margin-left', '-8px');
        $(".menu1").css('display', 'block');
        $(".menu").css('display', 'none');
    });

    $(".menu1").click(function() {
        $("#mySidenav").css('width', '300px');
        $("#main").css('margin-left', '300px');
        $(".logo").css('visibility', 'visible');
        $(".logo").css('display', 'block');
        $(".icon-a").css('visibility', 'visible');
        $(".icons").css('visibility', 'visible');
        $(".menu").css('display', 'block');
        $(".menu1").css('display', 'none');
    });
    </script>
    <script>
    $(document).ready(function() {
        $(".profile p").click(function() {
            $(".profile-div").toggle();

        });
       




    });
    </script>

</body>

</html>