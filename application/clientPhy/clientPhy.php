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
    <link rel="shortcut icon" href="../logo/favicon.ico"/>
    <link rel="stylesheet" href="../style/style.css" type="text/css" />
    <link rel="stylesheet" href="../style/style_av.css" type="text/css" />
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
    /* background:none;
	background-color:#efeff5; */
	font-family: system-ui;
}
    </style>
    <?php
        if (isset($_SESSION['success'] )) {?>
    <div id="modal" class="modal">
        <div class="modal-content">
            <span id="closeModal" class="close">&times;</span>
            <h2>Bienvenue</h2>
            <?php echo '<span class="succ-form">'.$_SESSION["success"] .'</span>';?>
        </div>
    </div>
    <?php }  ?>
    <script>
    var modal = document.getElementById("modal");
    var span = document.getElementById("closeModal");
    var succ = "<?php echo $_SESSION["success"]; ?>";
    if (succ !== "") {
        modal.style.display = "block"; // Affichage de la modale
        <?php  $_SESSION["success"]=""; ?> //supprime message de succ affiche sauf au 1er fois
    }
    span.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>
    <?php $sql = "SELECT COUNT(*) FROM affaire WHERE id_cin_clphy='" . $_SESSION['id'] . "'";
$resultat = mysqli_query($conn, $sql);
if ($resultat) {
    $row = mysqli_fetch_array($resultat);
    
}
$sql1="SELECT COUNT(*) FROM affaire WHERE id_cin_clphy='" . $_SESSION['id'] . "' AND date_fin=NULL";
$res = mysqli_query($conn, $sql);
if ($res ) {
    $row1= mysqli_fetch_array($res);
}
$sql2="SELECT COUNT(*) 
FROM consultation INNER JOIN affaire ON consultation.id_aff=affaire.id_aff where id_cin_clphy='" . $_SESSION['id'] . "'
";
$res2 = mysqli_query($conn, $sql2);
if ($res2 ) {
    $row2= mysqli_fetch_array($res2);
}
$sql3 = "SELECT nomEx, prenomEx, specialiteEx FROM expert";

$sql4="SELECT nomHN,prenomHN FROM houss_not";



$res3 = $conn->query($sql3);
$res4 = $conn->query($sql4);




 ?>
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
       


    </div>
    <div id="main" style="margin-left:19%;">

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
<?php $id=$_SESSION['id'] ;
$sql19="SELECT msg FROM notif
WHERE user_type='clientphy'
AND id_user=$id
ORDER BY datenotif DESC" ;
$res = mysqli_query($conn, $sql19);
if ($res && $res->num_rows > 0) {
    echo"Notifications </br>";
   while($row19 = $res->fetch_assoc()) {
     echo"<tr>
             <td>".$row19['msg']."</td>  <br>
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
               
                <div class="profile" >


                    <p><i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                        <?php echo   $_SESSION['nom']."  " . $_SESSION['prenom']; ?> <i class="fa fa-ellipsis-v dots"
                            aria-hidden="true"></i></p>

                    <div class="profile-div">
                        
                        <a href="profileClPhy.php"><p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p></a>
                        
                        <a href="parametresClPhy.php"><p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p></a>
                 
                       <a href="logout.php" class="logoutBtn" id="logoutBtn"><p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p></a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
        <br />

        <div class="col-div-4-1">
            <div class="box">
                <p class="head-1">Consultations</p>
                <p class="number"><?php  echo $row2[0];?></p>
               

                <i class="fa fa-calendar box-icon"></i>
            </div>
        </div>
        <div class="col-div-4-1">
            <div class="box">
                <p class="head-1">Affaires totales</p>
                <p class="number"><?php  echo $row[0];?></p>
          

                <i class="fa fa-check box-icon"></i>
            </div>
        </div>
        <div class="col-div-4-1">
            <div class="box">
                <p class="head-1">Affaires en cours</p>
                <p class="number"><?php  echo $row1[0];?></p>

                <i class="fa fa-circle-o-notch box-icon"></i>
            </div>
        </div>

        <div class="clearfix"></div>
        <br />




        <div class="col-div-4-1">
            <div class="box-1">
                <div class="content-box-1">
                    <p class="head-1">Nos intervenants <a href="interv.php"><span class="voir-tout">Voir tout</span><a></p>
                    <?php 
                if ($res3 && $res3->num_rows > 0) {
                  echo" <table class='table-inter' >
                <tr> <th>Type </th> <th>Nom </th><th>Prenom </th><th>Specialité </th>  </tr>";
                 while($row3 = $res3->fetch_assoc()) {
                  
                   echo"<tr>
                           <td>Expert</td>
                           <td>".$row3['nomEx']."</td>
                           <td>".$row3['prenomEx']."</td> 
                           <td>".$row3['specialiteEx']."</td> 
                           </tr>
                           
                       ";
                       break;
                 }

                 
                 }
                 if ($res4 && $res4->num_rows > 0) {
                  
                 while($row4 = $res4->fetch_assoc()) {
                   echo"<tr>
                           <td>Huissier Notaire</td>
                           <td>".$row4['nomHN']."</td>
                           <td>".$row4['prenomHN']."</td> 
                           <td>-</td> 
                           </tr>
                           
                       ";
                       break;
                 } 

                 
                 }
                 else {echo"<tr>
                  <td>Huissier Notaire</td>
                  <td>-</td>
                  <td>-</td> 
                  <td>-</td> 
                  </tr>
                  
              ";}

                 echo "</table>";
                 ?>
                </div>
            </div>


        </div>
        <div class="col-div-4-1">
            <div class="box-1">
                <div class="content-box-1">
                    <p class="head-1">Demande d'intervention d'un </br> huissier notaire ou d'un expert<span><i
                                class="fa fa-user icons"></i> </span></p>
                    <br />
                    <div class="formulaire">
                        <form action="" method="POST">
                            <div class="inputBox">

                                <input type="text" name="nomInter" placeholder="Nom Intervenant" required>
                                <input type="text" name="prenomInter" placeholder="Prenom Intervenant" required>


                            </div>
                    
                        

                            <div class="inputBox">
                        
                                <input type="text"
                             name="affaire" placeholder="Identifiant d'affaire" required>

                            </div>
                            <button type="submit" name="DemInter" class="envoyer">Envoyer</button>
                       


                        </form>
                        <?php 
                        
                        
                       
                        if(isset($_POST['DemInter']))
                       
                        {  

                            if(isset($_POST['nomInter'])&& isset($_POST['prenomInter'])&& isset($_POST['affaire']))
                            {
                                $nomInter=$_POST['nomInter'];
                                $prenomInter=$_POST['prenomInter'];
                                
                                $affaire = (int)($_POST['affaire']);
                                
                                $sql10="SELECT * FROM expert WHERE nomEx='$nomInter' and prenomEx='$prenomInter'  ";
                                  
                                  $res10=$conn->query($sql10);
                                  $sql20="SELECT * from houss_not where nomHN='$nomInter' and prenomHN='$prenomInter'";
                                $res20=$conn->query($sql20);
                        
                                 
                               $sql22="SELECT * from affaire where id_aff='$affaire'AND id_cin_clphy='" . $_SESSION['id'] . "'";
                               $res22=$conn->query($sql22);
                               if($res22 && $res22->num_rows>0)
                               {
                                if($res10 && $res10->num_rows>0)
                                {     
                                    $row10 = $res10->fetch_assoc();
                                    
                                        
                                    
                                        $sql30="UPDATE affaire 
                                        SET  id_cin_ex='$row10[id_cin_ex]' WHERE  id_aff='$affaire ' AND id_cin_clphy='" . $_SESSION['id'] . "' ";
                                        $res30=$conn->query($sql30);
                                        if($res30)
                                        { echo "<script>
                                          window.onload = function() {
                                           alert('Votre demande a été enregistrée .');
                                            }
                                             </script>";}
                                        else { echo "<script>
                                            window.onload = function() {
                                               alert('Erreur se produite , Veuillez ressayer. ');
                                              }
                                             </script>";
                                              } 
                                  
                                    
                                }
                               
                                

                               else if($res20 && $res20->num_rows>0)
                                {
                                    $row20 = $res20->fetch_assoc();
                                    
                                        
                                    
                                        $sql40="UPDATE affaire 
                                        SET  id_cin_hn='$row20[id_cin_hn]' WHERE  id_aff='$affaire ' AND id_cin_clphy='" . $_SESSION['id'] . "'";
                                        $res40=$conn->query($sql40);
                                        if($res40)
                                          { echo "<script>
                                              window.onload = function() {
                                                  alert('Votre demande a été enregistrée .');
                                              }
                                            </script>";}
                                          else { echo "<script>
                                              window.onload = function() {
                                                  alert('Erreur . ');
                                              }
                                            </script>";
                                          } 

                                    
                                    
                                }  else echo "<script>
                                window.onload = function() {
                                    alert('Erreur , Nom ou prenom d\\'intervenant incorrect, Veuillez ressayer. ');
                                }
                              </script>";

                               } else echo 
                               "<script>
                                          window.onload = function() {
                                           alert('Vous n\\'avez pas une affaire avec cet identifiant , Veuillez ressayer.');
                                            }
                                             </script>";
                            } 
                        } //else echo"error";
                        


                

                        
                        ?>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-div-4-1">
            <div class="box-1">
                <div class="content-box-1">
                    <p class="head-1">Demande Consultations <span><i class="fa fa-calendar icons"></i></span></p>
                    <br />
                    <div class="formulaire1">
                        <form action="" method="POST">
                        <div class="inputBox">

                        
                        <input type="text" 
                        name="affaire" required placeholder="Affaire (Identifiant)">

                         </div>
                         
                         
                            <div class="inputBox">

                                <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')"
                                    name="demDate" required placeholder="Date">
                                    

                            </div>
                            
                            <div class="inputBox">
                                <input type="text" onfocus="(this.type='time')" onblur="(this.type='text')"
                                    name="demHeure" required placeholder="Heure">
                            </div>
                            <button type="submit" name="demCons">Envoyer</button>

                        </form>
                        <?php 
                if(isset($_POST['demCons'])){
                    if(isset($_POST['demDate'])&& (isset($_POST['demHeure']))&&  isset($_POST['affaire']))
                  {
                    $affaire=(int)($_POST['affaire']);
                    
                    $sql8 = "SELECT * FROM affaire WHERE id_cin_clphy='" . $_SESSION['id'] . "' and id_aff=$affaire";
                    $res8 = $conn->query($sql8);
                    if($res8 && $res8->num_rows > 0) {
                        while($row8 = $res8->fetch_assoc()) {
                            
                            
                           
                            
                                $demDate=$_POST['demDate'];
                                $demDate1 = date('Y-m-d', strtotime($demDate));
                                $demHeure=$_POST['demHeure'];
                                
                                
                                $sql7="INSERT INTO consultation(dateCons,id_aff,heure,confirm) values ('$demDate1',$affaire,'$demHeure','non')";
                                $res7=$conn->query($sql7);
                                if($res7)
                                { echo "<script>
                                    window.onload = function() {
                                        alert('Votre demande a été enregistrée avec succe .');
                                    }
                                  </script>";}
                                  
                                else { echo "<script>
                                    window.onload = function() {
                                        alert('Erreur !');
                                    }
                                  </script>";
                                } 
            
                              
                            } 
        
            

                            }
                               
                            
                        } else  echo "<script>
                        window.onload = function() {
                            alert('Vous n\\'avez pas une affaire avec cet identifiant ! ');
                        }
                      </script>";
                    }
                   

                    
                
            
                
                  ?>
                        
                

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    <br />
     <div class="col-div-12" style="	width: 80%; float:left; border-radius: 10px;">
        <div class="box-8" style="width: 97.8%; margin-left:25%; background-color: #fff; height: auto; border-radius: 10px;">
        <div class="content-box">
                <p class="head-1">Consultations de ce mois<a href="consultationsClPhy.php"><span class="voir-tout">Voir tout</span><a></p>
                <br />
                <?php 
                $mois= date('m');
                $annee=date('Y');
                
                $sql5="SELECT  consultation.id_cons ,consultation.dateCons, consultation.heure, avocat.nomA, avocat.prenomA, avocat.id_cin ,consultation.id_aff
                FROM consultation 
                
                INNER JOIN affaire ON  consultation.id_aff = affaire.id_aff
                INNER JOIN client_phy ON affaire.id_cin_clphy = client_phy.id_cin_clphy 
                INNER JOIN avocat ON affaire.id_cin = avocat.id_cin 
                WHERE  Year(dateCons)='$annee' 
                AND  MONTH(dateCons) = '$mois' 
                AND consultation.confirm='oui'
                AND client_phy.id_cin_clphy='" . $_SESSION['id'] . "'
                GROUP BY consultation.id_cons";
                
                
                
                $res5 = $conn->query($sql5);
                if ($res5 && $res5->num_rows > 0) {
                  echo" <table  >
                <tr> <th>Avocat </th> <th>Date </th></th> <th>Heure </th><th>Affaire </th>   </tr>";
                
                 while($row5 = $res5->fetch_assoc()) {
                  
                  
                  
                   echo"<tr>
                           
                   <td>".$row5['nomA']."  ".$row5['prenomA']."</td>
                   <td>".$row5['dateCons']." </td>
                   <td>".$row5['heure']." </td>
                   <td>".$row5['id_aff']." </td> 
                   </tr>
                           
                           
                           
                       ";
                 } 
                 echo "</table>";
               }
               else { echo "<table>
                <tr>
                  <th>Avocat</th>
                  <th>Date</th>
                  <th>Heure</th>
                  

                </tr>
                <tr>
                  <td>-</td>
                  <td>-</td> 
                  <td>-</td> 
                </tr>
              </table>";
                  
              ;}

                 
                
               ?>
              
                 
            </div>
        </div>
    </div> 
 



    <div class="clearfix"></div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
    $(".menu").click(function() {
        $("#mySidenav").css('width', '6%');
        $("#main").css('margin-left', '6%');
        $(".box-8").css('margin-left', '10%');
       // $(".box-8").css('margin-right', '3%');
        $(".logo").css('display', 'none');
        $(".logo1").css('display', 'block');
        $(".logo span").css('visibility', 'visible');
        $(".logo span").css('margin-left', '-1%');
        $(".icon-a").css('visibility', 'hidden');
        $(".icon-a").css('height', '55px');
        $(".icons").css('visibility', 'visible');
        $(".icons").css('margin-left', '-3%');
        $(".menu1").css('display', 'block');
        $(".menu").css('display', 'none');
    });

    $(".menu1").click(function() {
        $("#mySidenav").css('width', '19%');
        $("#main").css('margin-left', '19%');
        $(".box-8").css('margin-left', '23%');
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