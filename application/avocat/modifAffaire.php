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

if(!($_SESSION['type']=='avocat')){
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
h5{
        text-align:center;
        margin-bottom:10px;
        font-size:20px;
        color:#8f6118f6;
    }
    .form{
        width: 500px;
    }
    </style>
    
<div id="mySidenav" class="sidenav">
        <p class="logo"> <span class="menu">&#9776;</span></p>
        <p class="logo1"> <span class="menu1">&#9776;</span></p>
        <a href="#" class="icon-a"><i class="fa fa-dashboard icons"></i> &nbsp;&nbsp;Table de bord</a>
        <a href="avocat.php" class="icon-a"><i class="fa fa-home icons" ></i>&nbsp;&nbsp;Accueil</a>
        <a href="Avocats.php" class="icon-a"><i class="fa fa-user icons"></i> &nbsp;&nbsp;Avocats membres</a>
        <a href="ClientsAvocat.php"class="icon-a"><i class="fa fa-user icons"></i> &nbsp;&nbsp;Clients</a>
       
        <a href="affaireAvocat.php" class="icon-a"><i class="fa fa-briefcase icons" ></i> &nbsp;&nbsp;Affaires</a>
        <a href="procesAvocat.php" class="icon-a"><i class="fa fa-gavel icons"></i> &nbsp;&nbsp;Les procès</a>

        <a href="consultationsAvocat.php" class="icon-a"><i class="fa fa-calendar icons"></i> &nbsp;&nbsp;Consultations</a>
        
        <a href="caisse.php"class="icon-a"><i class="fa fa-money icons"></i> &nbsp;&nbsp;Caisse</a>
       


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


                <div class="profile">


                    <p><i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                        <?php echo   $_SESSION['nom']."  " . $_SESSION['prenom']; ?> <i class="fa fa-ellipsis-v dots"
                            aria-hidden="true"></i></p>

                    <div class="profile-div">
                        <!-- <p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p> -->
                        <a href="profileavocat.php"><p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p></a>
                        <!-- <p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p> -->
                        <a href="parametresavocat.php"><p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p></a>
                        <!-- <p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p> -->
                       <a href="logout.php" class="logoutBtn" id="logoutBtn"><p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p></a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="content">
        <p class="head-1">Modifier affaire</p>
                <br />
    
                <div class="col-div-4-1">
		<div class="box-1">
			<div class="content-box-1">
			<p class="head-1">Ajouter ou modifier un expert</p>
			<br/>
			
            <form  method="POST" class="form">
            <div class="inputBox1">
                    <input type="text" id="code" name="code"  placeholder="Code affaire" ><br></div>
                    
                    <div class="inputBox1">
                    <input type="text" id="cinex" name="cinex"  placeholder="Numéro de CIN d'expert" ><br></div>
                    <!-- <input type="submit" name="ajoutexp" value="Enregistrer"> -->
                    <button type="submit" name="ajoutexp" >Enregistrer</button>
                    </form><br>
		
			
		</div>
	</div>
	</div>

    <div class="col-div-4-1">
		<div class="box-1">
			<div class="content-box-1">
			<p class="head-1"> Supprimer un expert</p>
			<br/>
			
            <form action="" method="POST" class="form">
            <div class="inputBox1" >
            <input type="text" id="code" name="code"  placeholder="Code affaire" ><br></div>

<div class="inputBox1" >
                    <input type="text" id="cinex" name="cinex"  placeholder="Numéro de CIN d'expert" ><br></div>

                    <!-- <input type="submit" name="ajoutex" value="Supprimer"> -->
                    <button type="submit" name="suppex" >Supprimer</button>
                        </form>
			
			
		</div>
	</div>
	</div>
    <div class="col-div-4-1">
		<div class="box-1">
			<div class="content-box-1">
			<p class="head-1"> Ajouter ou modifier un Huissier notaire</p>
			<br/>
			<form  method="POST" class="form">
            <div class="inputBox1" >
            <input type="text" id="code" name="code"  placeholder="Code affaire" ><br></div>
                  
<div class="inputBox1" >
                   <input type="text" id="cinhn" name="cinhn"  placeholder="Numéro de CIN d'huissier notaire" ><br></div>
                    <!-- <input type="submit" name="ajouthn" value="Enregistrer"> -->
                    <button type="submit" name="ajouthn" >Enregistrer</button>
                        
                    </form>
                    
			
		</div>
	</div>
	</div>
    <div class="col-div-4-1" style="margin-top:10px;">
		<div class="box-1">
			<div class="content-box-1">
			<p class="head-1"> Supprimer un Huissier notaire</p>
			<br/>
			
            <form action="" method="POST" class="form">
            <div class="inputBox1" >
            <input type="text" id="code" name="code"  placeholder="Code affaire" ><br></div>

<div class="inputBox1" >
                    <input type="text" id="cinhn" name="cinhn"  placeholder="Numéro de CIN d'huissier notaire" ><br></div>

                    <!-- <input type="submit" name="ajoutex" value="Supprimer"> -->
                    <button type="submit" name="supphn" >Supprimer</button>
                        </form>
			
			
		</div>
	</div>
	</div>
    <div class="col-div-4-1" style="margin-top:10px;">
		<div class="box-1">
			<div class="content-box-1">
			<p class="head-1"> Ajouter ou modifier Commission</p>
			<br/>
            <form action ="" method="POST" class="form">
            <div class="inputBox1" >
            <input type="text" id="code" name="code"  placeholder="Code affaire" ><br></div>
                   <div class="inputBox1" >
                  
                   <input type="text" id="comm" name="comm"  placeholder="Commission (dt)"><br></div>

                   <!-- <input type="submit" name="ajoutcomm" value="Enregistrer"> -->
                   <button type="submit" name="ajoutcomm" >Enregistrer</button>
                    </form>
			
		</div>
	</div>
	</div>
    <div class="col-div-4-1" style="margin-top:10px;">
		<div class="box-1">
			<div class="content-box-1">
			<p class="head-1"> Saisir une date fin</p>
			<br/>
			
            <form action="" method="POST" class="form">
            <div class="inputBox1" >
            <input type="text" id="code" name="code"  placeholder="Code affaire" ><br></div>

<div class="inputBox1" >
<input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" name="datefin" id="datefin" required placeholder= "Date debut"><br></div>

                    <!-- <input type="submit" name="ajoutex" value="Supprimer"> -->
                    <button type="submit" name="ajoutdate" >Enregistrer</button>
                        </form>
			
			
		</div>
	</div>
	</div>
                

                   

                  
                   
                   
        
               
               
        <div class="clearfix"></div>
        <br />
        <?php 
           
               
                
                
           if(isset($_POST['ajoutexp']))
           
               if(isset($_POST['cinex'])&& isset($_POST['code']))
               {    $cinex=$_POST['cinex'];
                   $code=$_POST['code'];
                   
                   if(strlen((string)$cinex)==8)
                   {
                       $sql1="SELECT * from expert where id_cin_ex='$cinex'";
                       $res1=$conn->query($sql1);
                       $sql3="SELECT *  from affaire where id_aff='$code' and id_cin='" . $_SESSION['id'] . "'";
                       $res3=$conn->query($sql3);
                       if($res3 && $res3->num_rows>0)
                       {
                           if($res1 && $res1->num_rows>0)
                           {
                               $sql2="UPDATE   affaire  set id_cin_ex = '$cinex', confirmEx='oui' where id_aff='$code'";
                           $res2=$conn->query($sql2);
                           if($res2)
                           echo"<script> window.onload = function(){alert('Expert ajouté avec succé.')}</script>";
                           


                           } else  echo"<script> window.onload = function(){alert('Cet expert n\'existe pas dans la base !')}</script>";
                       }
                      else echo "<script> window.onload = function(){alert('Cette affaire n\'existe pas dans la base !')}</script>";

                      



                   }else  echo"<script> window.onload = function(){alert('Le longuer de numero de CIN doit etre égale à 8 !')}</script>";
                  
               } 
               ///////////////////////////////////////////////
               if(isset($_POST['ajouthn']))
           
               if(isset($_POST['cinhn'])&& isset($_POST['code']))
               {    $cinhn=$_POST['cinhn'];
                   $code=$_POST['code'];
                   
                   if(strlen((string)$cinhn)==8)
                   {
                       $sql1="SELECT * from houss_not where id_cin_hn='$cinhn'";
                       $res1=$conn->query($sql1);
                       $sql3="SELECT *  from affaire where id_aff='$code' and id_cin='" . $_SESSION['id'] . "'";
                       $res3=$conn->query($sql3);
                       if($res3 && $res3->num_rows>0)
                       {
                           if($res1 && $res1->num_rows>0)
                           {
                               $sql2="UPDATE   affaire  set id_cin_hn = $cinhn , confirmHN='oui' where id_aff='$code'";
                           $res2=$conn->query($sql2);
                           if($res2)
                           echo"<script> window.onload = function(){alert('Houssier notaire ajouté avec succé.')}</script>";
                           


                           } else  echo"<script> window.onload = function(){alert('Cet houssier notaire n\'existe pas dans la base !')}</script>";
                       }
                      else echo "<script> window.onload = function(){alert('Cette affaire n\'existe pas dans la base !')}</script>";

                      



                   }else  echo"<script> window.onload = function(){alert('Le longuer de numero de CIN doit etre égale à 8 !')}</script>";
                  
               } 
               ////////////////////////////////////////////////////////////////////////

               if(isset($_POST['suppex']))
           
               if(isset($_POST['cinex'])&& isset($_POST['code']))
               {    $cinex=$_POST['cinex'];
                   $code=$_POST['code'];
                   
                   if(strlen((string)$cinex)==8)
                   {
                       $sql1="SELECT * from expert where id_cin_ex='$cinex'";
                       $res1=$conn->query($sql1);
                       $sql3="SELECT *  from affaire where id_aff='$code' and id_cin='" . $_SESSION['id'] . "'";
                       $res3=$conn->query($sql3);
                       $sql4="SELECT *  from affaire where id_aff='$code' and id_cin_ex='$cinex' and id_cin='" . $_SESSION['id'] . "'";
                       $res4=$conn->query($sql4);
                       if($res3 && $res3->num_rows>0)
                       {
                           if($res1 && $res1->num_rows>0)
                           {
                              if($res4 && $res4->num_rows>0)
                              {
                                $sql2="UPDATE   affaire  set id_cin_ex = 0 , confirmEx='non' where id_aff='$code'";
                                $res2=$conn->query($sql2);
                                if($res2)
                                echo"<script> window.onload = function(){alert('Expert supprimé avec succé.')}</script>";
                                
                              }else echo "<script> window.onload = function(){alert('Cet expert n\'intervient pas dans cette affaire !')}</script>";


                           } else  echo"<script> window.onload = function(){alert('Cet expert n\'existe pas dans la base !')}</script>";
                       }
                      else echo "<script> window.onload = function(){alert('Cette affaire n\'existe pas dans la base !')}</script>";

                      



                   }else  echo"<script> window.onload = function(){alert('Le longuer de numero de CIN doit etre égale à 8 !')}</script>";
                  
               } 
               //////////////////////////////////
               if(isset($_POST['supphn']))
           
               if(isset($_POST['cinhn'])&& isset($_POST['code']))
               {    $cinhn=$_POST['cinhn'];
                   $code=$_POST['code'];
                   
                   if(strlen((string)$cinhn)==8)
                   {
                       $sql1="SELECT * from houss_not where id_cin_hn='$cinhn'";
                       $res1=$conn->query($sql1);
                       $sql3="SELECT *  from affaire where id_aff='$code' and id_cin='" . $_SESSION['id'] . "'";
                       $res3=$conn->query($sql3);
                       $sql4="SELECT *  from affaire where id_aff='$code' and id_cin_hn='$cinhn' and id_cin='" . $_SESSION['id'] . "'";
                       $res4=$conn->query($sql4);
                       if($res3 && $res3->num_rows>0)
                       {
                           if($res1 && $res1->num_rows>0)
                           {
                              if($res4 && $res4->num_rows>0)
                              {
                                $sql2="UPDATE   affaire  set id_cin_hn = 0 , confirmHN='non' where id_aff='$code'";
                                $res2=$conn->query($sql2);
                                if($res2)
                                echo"<script> window.onload = function(){alert('Houss_not supprimé avec succé.')}</script>";
                                
                              }else echo "<script> window.onload = function(){alert('Cet houss_not n\'intervient pas dans cette affaire !')}</script>";


                           } else  echo"<script> window.onload = function(){alert('Cet houss_not n\'existe pas dans la base !')}</script>";
                       }
                      else echo "<script> window.onload = function(){alert('Cette affaire n\'existe pas dans la base !')}</script>";

                      



                   }else  echo"<script> window.onload = function(){alert('Le longuer de numero de CIN doit etre égale à 8 !')}</script>";
                  
               } 
               ////////////////////////////////////////////
               if(isset($_POST['ajoutcomm']))
           
               if(isset($_POST['comm'])&& isset($_POST['code']))
               {    $comm=$_POST['comm'];
                   $code=$_POST['code'];
                   
                   
                   
                      
                       $sql3="SELECT *  from affaire where id_aff='$code' and id_cin='" . $_SESSION['id'] . "'";
                       $res3=$conn->query($sql3);
                      
                       if($res3 && $res3->num_rows>0)
                       {
                           
                              
                                $sql2="UPDATE   affaire  set commission = $comm where id_aff='$code'";
                                $res2=$conn->query($sql2);
                                if($res2)
                                echo"<script> window.onload = function(){alert('Commission ajoutée  avec succé.')}</script>";
                                
                             

                           
                       }
                      else echo "<script> window.onload = function(){alert('Cette affaire n\'existe pas dans la base !')}</script>";

                      



                    }
              
           ///////////////////////////////////////////////////
           if(isset($_POST['ajoutdate']))
           
               if(isset($_POST['datefin'])&& isset($_POST['code']))
               {    $datefin=$_POST['datefin'];
                   $code=$_POST['code'];
                   $date_fin= date('Y-m-d', strtotime($datefin));
                   
                   
                   
                      
                       $sql3="SELECT *  from affaire where id_aff='$code' and id_cin='" . $_SESSION['id'] . "'";
                       $res3=$conn->query($sql3);
                      
                       if($res3 && $res3->num_rows>0)
                       {
                           
                              
                                $sql2="UPDATE   affaire  set date_fin =' $date_fin' where id_aff='$code'";
                                $res2=$conn->query($sql2);
                                if($res2)
                                echo"<script> window.onload = function(){alert('Date ajoutée  avec succé.')}</script>";
                                
                             

                           
                       }
                      else echo "<script> window.onload = function(){alert('Cette affaire n\'existe pas dans la base !')}</script>";

                      



                    }
              
           
           

              
           
           
       
       
       ?>




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