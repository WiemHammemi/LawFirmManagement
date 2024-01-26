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

if(!($_SESSION['type']=='chef_avocat')){
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
    <link rel="shortcut icon" href="../logo/favicon.ico"/>
    <link rel="stylesheet" href="../style/style_av.css" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-rz/XW1FqhNQ6C5U6f5v5M5KaUTQwKilUUIy5S6RjKfuLyK4ksd9Y+lZPxv4+Qqtn" crossorigin="anonymous">
        </head>
<title>  <?php echo   $_SESSION['nom']."  " . $_SESSION['prenom']; ?> | Espace avocat</title>
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
        <a href="chefavocat.php" class="icon-a"><i class="fa fa-home icons" ></i>&nbsp;&nbsp;Accueil</a>
        <a href="AvocatsChef.php" class="icon-a"><i class="fa fa-user icons"></i> &nbsp;&nbsp;Avocats membres</a>
        <a href="clientAvocatChef.php"class="icon-a"><i class="fa fa-user icons"></i> &nbsp;&nbsp;Clients</a>
       
        <a href="affairesChefAvocat.php" class="icon-a"><i class="fa fa-briefcase icons" ></i> &nbsp;&nbsp;Affaires</a>
        <a href="procesAvocatChef.php" class="icon-a"><i class="fa fa-gavel icons"></i> &nbsp;&nbsp;Les procès</a>

        <a href="consultationsAvocatChef.php" class="icon-a"><i class="fa fa-calendar icons"></i> &nbsp;&nbsp;Consultations</a>
        
        <a href="caisseChef.php"class="icon-a"><i class="fa fa-money icons"></i> &nbsp;&nbsp;Caisse</a>
      


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
WHERE user_type='avocat'
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


                    <p><i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                        <?php echo   $_SESSION['nom']."  " . $_SESSION['prenom']; ?> <i class="fa fa-ellipsis-v dots"
                            aria-hidden="true"></i></p>

                            <div class="profile-div">
                        <!-- <p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p> -->
                        <a href="profileavocatChef.php"><p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p></a>
                        <!-- <p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p> -->
                        <a href="parametresavocatChef.php"><p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p></a>
                        <!-- <p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p> -->
                       <a href="logout.php" class="logoutBtn" id="logoutBtn"><p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p></a>
                    </div>
                </div>
            
            <div class="clearfix"></div>
     
        <?php 
       
        $sql1="SELECT * FROM avocat WHERE id_chef<> id_cin";
        $res1=$conn->query($sql1);
        $sql2="SELECT * from avocat where id_chef=id_cin";
        $res2=$conn->query($sql2);
        ?>
        <div class="content">
                <p class="head-1">Avocats Membres</p>
                <div class="clearfix"></div>
                <br />
                <div class="tableau">
                <?php 
                if ($res2 && $res2->num_rows > 0) {
                    echo" <table  class='ToutTab' >
                  <tr> <th>Nom Chef</th> <th>Specialité </th><th>Numéro de téléphone </th> <th>E-mail</th>  </tr>";
                  $row2 = $res2->fetch_assoc() ;
                    
                     echo"<tr>
                             
                             <td>".$row2['nomA']."  ".$row2['prenomA']."</td>
                             <td>".$row2['specialiteA']."</td> 
                             <td>".$row2['num_telA']."</td> 
                             <td>".$row2['emailA']."</td> 
                             
                             </tr>
                             
                         </table>";
                         
                   
  
                   
                   }
                if ($res1 && $res1->num_rows > 0) {
                  echo" <table class='table-inter ToutTab' >
                <tr> <th>Nom Avocat </th> <th>Specialité </th><th>Numéro de téléphone </th> <th>E-mail</th>  </tr>";
                 while($row1 = $res1->fetch_assoc()) {
                  
                   echo"<tr>
                           
                           <td>".$row1['nomA']."  ".$row1['prenomA']."</td>
                           <td>".$row1['specialiteA']."</td> 
                           <td>".$row1['num_telA']."</td> 
                           <td>".$row1['emailA']."</td> 
                           <td>
                               <form method='POST' action='' >
                               <input type='hidden' name='id' value='". $row1["id_cin"] . "'>
                                  <button type='submit' name='supprimer' style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'>Supprimer</button>
                                </form>
                                
                              </td>
                           </tr>";
                           

                       
                 }
                 echo "</table>";

                 
                 }
                 
                 
                  echo "</table>";
                 ?>
                 <?php if(isset($_POST['supprimer']))
                 {
                    
                    $id=$_POST['id'] ;
                                    
                    //echo $id;
                    $sql2="DELETE FROM avocat
                    WHERE id_cin=$id ";
                 $res=$conn->query($sql2) ;
                 if($res)
                 {
                    echo "<script>
                    window.onload = function(){alert('Avocat supprimé avec succès.')}</script>";
                 }
                }
                ?>
                 
               
               </div>
        <div class="clearfix"></div>
        <br />


        <div class="clearfix"></div>
        <br />
        <a href="ajoutavocat.php" style="text-decoration:none;"><span  style=" background-color:#8f6118f6;
  border-radius: 5px;
    color: white;
    padding: 10px 10px;
    margin-left:150px;
    font-size: 15px;">Ajouter un avocat</span></a> 

       
                <a href="expert.php" style="text-decoration:none;"><span  style=" background-color:#8f6118f6;
  border-radius: 5px;
    color: white;
    padding: 10px 10px;
    margin-right:20px;
    margin-left:20px;
  /* border:solid 1px #8f6118f6; */
    font-size: 15px;">Ajouter un expert</span></a> 
    
     <a href="huiss.php" style="text-decoration:none;"><span  style=" background-color:#8f6118f6;
  border-radius: 5px;
    color: white;
    padding: 10px 10px;
  margin-right :20px;
    font-size: 15px;">Ajouter un huissier notaire</span></a> 




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