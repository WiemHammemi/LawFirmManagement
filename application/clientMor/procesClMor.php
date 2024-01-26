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
                        <!-- <p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p> -->
                        <a href="profileClPhy.php"><p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p></a>
                        <!-- <p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p> -->
                        <a href="parametresClPhy.php"><p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p></a>
                        <!-- <p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p> -->
                       <a href="logout.php" class="logoutBtn" id="logoutBtn"><p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p></a>
                    </div>
                </div>
           
            <div class="clearfix"></div>
        
       
        <div class="content">
                <p class="head-1">Procès</p>
                <div class="clearfix"></div>
                <br />
                <div class="tableau">
                <?php 
        $sql1="SELECT seance_trib.date_seance, seance_trib.heure_seance, tribunal.nomT, tribunal.zone, avocat.nomA,avocat.prenomA, seance_trib.id_aff 
        FROM seance_trib 
        INNER JOIN tribunal ON seance_trib.id_trib = tribunal.id_trib 
        INNER JOIN affaire ON seance_trib.id_aff = affaire.id_aff 
        INNER JOIN avocat ON affaire.id_cin = avocat.id_cin  
        
        WHERE affaire.id_ClMor='" . $_SESSION['id'] . "'
        GROUP BY seance_trib.id_aff ";
        $res1=$conn->query($sql1);
        if ($res1) {
            echo" <table  >
            <tr> <th>Date</th> <th>Heure</th><th>Affaire</th><th>Avocat</th><th>Tribunal</th><th>Zone du tribunal</th> </tr>";
            
            while($row1 = $res1->fetch_assoc()){
                echo"<tr>
                           
                           <td>".$row1['date_seance']."</td>
                           <td>".$row1['heure_seance']."</td>
                           <td>".$row1['id_aff']."</td>
                           <td>".$row1['nomA']."  ".$row1['prenomA']."</td>
                           <td>".$row1['nomT']."</td>
                           <td>".$row1['zone']."</td>

                           
                           </tr>";
    
       
    }
    echo "</table>";
} else echo "erreur ";

        
        ?>
               </div>
        <div class="clearfix"></div>
        <br />
        <div class="clearfix"></div>
    <br />
     <div class="col-div-12">
        <div class="box-8">
            <div class="content-box">
                <p class="head-1">Procès de ce mois</p>
                <br />
                <?php 
                $mois= date('m');
                $annee=date('Y');
                
                $sql5="SELECT consultation.dateCons, consultation.heure, avocat.nomA, avocat.prenomA, avocat.id_cin 
                FROM consultation 
                INNER JOIN client_phy ON consultation.id_ClMor = client_phy.id_ClMor 
                INNER JOIN affaire ON client_phy.id_ClMor = affaire.id_ClMor 
                INNER JOIN avocat ON affaire.id_cin = avocat.id_cin WHERE  Year(dateCons)='$annee' 
                AND  MONTH(dateCons) = '$mois' 
                AND consultation.confirm='oui'
                AND client_phy.id_ClMor='" . $_SESSION['id'] . "'";
                
                
                
                $sql2="SELECT seance_trib.date_seance, seance_trib.heure_seance, tribunal.nomT, tribunal.zone, avocat.nomA,avocat.prenomA, seance_trib.id_aff
        FROM seance_trib 
        INNER JOIN tribunal ON seance_trib.id_trib = tribunal.id_trib 
        INNER JOIN affaire ON seance_trib.id_aff = affaire.id_aff 
        INNER JOIN avocat ON affaire.id_cin = avocat.id_cin  
        
        WHERE  Year(date_seance)='$annee' 
                AND  MONTH(date_seance) = '$mois' AND affaire.id_ClMor='" . $_SESSION['id'] . "'
                GROUP BY seance_trib.id_aff";
        $res2=$conn->query($sql2);
        if ($res2 && $res2->num_rows > 0) {
            echo" <table  >
            <tr> <th>Date</th> <th>Heure</th><th>Affaire</th><th>Avocat</th><th>Tribunal</th><th>Zone du tribunal</th> </tr>";
            
            while($row2 = $res2->fetch_assoc()){
                echo"<tr>
                           
                           <td>".$row2['date_seance']."</td>
                           <td>".$row2['heure_seance']."</td>
                           <td>".$row2['id_aff']."</td>
                           <td>".$row2['nomA']."  ".$row2['prenomA']."</td>
                           <td>".$row2['nomT']."</td>
                           <td>".$row2['zone']."</td>

                           
                           </tr>";
    
       
    }
    echo "</table>";
} 
               
                
               ?>
            </div>
        </div>
    </div> 
 



    <div class="clearfix"></div>
    </div>





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