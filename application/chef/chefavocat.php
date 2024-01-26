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

$sql1="SELECT COUNT(*)
FROM client_phy AS c1
JOIN affaire ON c1.id_cin_clphy = affaire.id_cin_clphy 
WHERE affaire.id_cin =  '" . $_SESSION['id'] . "'; ";
$sql2="SELECT COUNT(*)
FROM client_mor AS m1
JOIN affaire ON m1.id_ClMor = affaire.id_ClMor 
WHERE affaire.id_cin =  '" . $_SESSION['id'] . "'; ";
$res1=mysqli_query($conn, $sql1);
if ($res1 ) {
    $row1= mysqli_fetch_array($res1);
}
$res2=mysqli_query($conn, $sql2);
if ($res2) {
    $row2= mysqli_fetch_array($res2);
}
$date = date('Y-m-d');
$mois= date('m');
$annee=date('Y');

$sql3="SELECT consultation.id_cons,consultation.dateCons, consultation.heure, client_phy.id_cin_clphy , client_phy.nomClphy,client_phy.prenomClphy, affaire.id_aff, affaire.id_cin
FROM consultation 
INNER JOIN affaire ON consultation.id_aff=affaire.id_aff
INNER JOIN client_phy ON affaire.id_cin_clphy=client_phy.id_cin_clphy


WHERE Year(dateCons)='$annee' 
                AND  MONTH(dateCons) = '$mois' 
                
AND consultation.confirm='oui'
 AND affaire.id_cin='" . $_SESSION['id'] . "'
 GROUP BY consultation.id_cons";
 $sql4="SELECT consultation.id_cons ,consultation.dateCons, consultation.heure,client_mor.id_ClMor , client_mor.nomClMor, affaire.id_aff, affaire.id_cin
 FROM consultation 
 INNER JOIN affaire ON consultation.id_aff=affaire.id_aff
 INNER JOIN client_mor ON affaire.id_ClMor=client_mor.id_ClMor
 
  WHERE   Year(dateCons)='$annee' 
                AND  MONTH(dateCons) = '$mois' 
 AND consultation.confirm='oui'
  AND affaire.id_cin='" . $_SESSION['id'] . "'
  GROUP BY consultation.id_cons";
$res3 = $conn->query($sql3);

$res4 = $conn->query($sql4);
$sql5="SELECT COUNT(*) FROM affaire WHERE id_cin='" . $_SESSION['id'] . "'";
$sql6="SELECT COUNT(*) FROM affaire WHERE date_fin='0000-00-00' AND  id_cin='" . $_SESSION['id'] . "'";
$res5 = $conn->query($sql5);
$res6 = $conn->query($sql6);
$row5= mysqli_fetch_array($res5);
$row6= mysqli_fetch_array($res6);

?>




<!Doctype HTML>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="../style/style_av.css" type="text/css"/>
	<link rel="shortcut icon" href="../logo/favicon.ico"/>
	<link rel="stylesheet" href="../style/style.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-rz/XW1FqhNQ6C5U6f5v5M5KaUTQwKilUUIy5S6RjKfuLyK4ksd9Y+lZPxv4+Qqtn" crossorigin="anonymous">
		<title>  <?php echo   $_SESSION['nom']."  " . $_SESSION['prenom']; ?> | Espace avocat</title>
		</head>
</head>






<body>
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
	<div class="profile">
		
		<p><i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                        <?php echo   $_SESSION['nom']."  " . $_SESSION['prenom']; ?> <i class="fa fa-ellipsis-v dots"
                            aria-hidden="true"></i></p>

                    <div class="profile-div">
                        
                        <a href="profileavocat.php"><p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p></a>
                        
                        <a href="parametresavocat.php"><p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p></a>
                 
                       <a href="logout.php" class="logoutBtn" id="logoutBtn"><p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p></a>
                    </div>
                </div>
            <div class="clearfix"></div>
        </div>

        <div class="clearfix"></div>
        <br />
		
	<div class="col-div-4-1">
		<div class="box">
			<p class="head-1">Clients</p>
			<p class="number"><?php $s=$row1[0]+$row2[0]; echo" $s"; ?></p>
			
			<i class="fa fa-user box-icon"></i>
		</div>
	</div>
	<div class="col-div-4-1">
		<div class="box">
			<p class="head-1">Affaires totales</p>
			<p class="number"><?php echo "$row5[0]" ;?></p>
			
			<i class="fa fa-check box-icon"></i>
		</div>
	</div>
	<div class="col-div-4-1">
		<div class="box">
			<p class="head-1">Affaires en cours</p>
			<p class="number"><?php echo "$row6[0]" ;?></p>
			
			<i class="fa fa-circle-o-notch box-icon"></i>
		</div>
	</div>
	
	<div class="clearfix"></div>
	<br/>

	
	<div class="col-div-4-1">
		<div class="box-1" style="overflow-y:scroll;">
			<div class="content-box-1" >
			<p class="head-1">Demande des clients</p>
			<br/>
			<?php 
			$sql11="SELECT   affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.commission ,client_phy.nomClphy,client_phy.prenomClphy, houss_not.nomHN, houss_not.prenomHN
			FROM affaire 
			INNER JOIN client_phy ON affaire.id_cin_clphy=client_phy.id_cin_clphy
			INNER JOIN houss_not ON affaire.id_cin_hn=houss_not.id_cin_hn 
			   where confirmHN='non' AND affaire.id_cin_hn<>0 
			   AND confirmEx='oui' 
			   AND affaire.id_cin='" . $_SESSION['id'] . "'
			   GROUP BY id_aff";
			   
			$res11=$conn->query($sql11);
			$sql12="SELECT   affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.commission ,client_phy.nomClphy,client_phy.prenomClphy, houss_not.nomHN, houss_not.prenomHN
			FROM affaire 
			INNER JOIN client_phy ON affaire.id_cin_clphy=client_phy.id_cin_clphy
			INNER JOIN houss_not ON affaire.id_cin_hn=houss_not.id_cin_hn 
			    where confirmHN='non' AND affaire.id_cin_hn<>0 AND confirmEx='non' AND affaire.id_cin_ex=0
			    AND affaire.id_cin='" . $_SESSION['id'] . "'
				GROUP BY id_aff";//demande pour hn et non expert
			$res12=$conn->query($sql12);

			$sql13="SELECT  affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.commission ,client_phy.nomClphy,client_phy.prenomClphy, expert.nomEx, expert.prenomEx,
			houss_not.nomHN, houss_not.prenomHN
			FROM affaire 
			INNER JOIN client_phy ON affaire.id_cin_clphy=client_phy.id_cin_clphy
			INNER JOIN expert ON affaire.id_cin_ex=expert.id_cin_ex 
			INNER JOIN houss_not ON affaire.id_cin_hn=houss_not.id_cin_hn 
			  where confirmHN='non' AND affaire.id_cin_hn<>0 AND confirmEx='non'AND affaire.id_cin_ex<>0 
			   AND affaire.id_cin='" . $_SESSION['id'] . "'
			   GROUP BY id_aff";//demande our les 2
			$res13=$conn->query($sql13);

			$sql14="SELECT  affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.commission ,client_phy.nomClphy,client_phy.prenomClphy, expert.nomEx, expert.prenomEx
			FROM affaire 
			INNER JOIN client_phy ON affaire.id_cin_clphy=client_phy.id_cin_clphy
			INNER JOIN expert ON affaire.id_cin_ex=expert.id_cin_ex 
			 where confirmEx='non' AND affaire.id_cin_ex<>0 AND confirmHN='oui'
			    AND affaire.id_cin='" . $_SESSION['id'] . "'
				group by id_aff";//demande pour  exp et hn deja existe
			$res14=$conn->query($sql14);
			$sql15="SELECT  affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.commission ,client_phy.nomClphy,client_phy.prenomClphy, expert.nomEx, expert.prenomEx
			FROM affaire 
			INNER JOIN client_phy ON affaire.id_cin_clphy=client_phy.id_cin_clphy
			INNER JOIN expert ON affaire.id_cin_ex=expert.id_cin_ex 
			 where confirmEx='non' AND affaire.id_cin_ex<>0 AND confirmHN='non' AND affaire.id_cin_hn=0 
			   AND affaire.id_cin='" . $_SESSION['id'] . "'
			   group by id_aff";//demande pour hn et non expert
			$res15=$conn->query($sql15);
			//$sql13="SELECT * from affaire where confirmHN='non' AND confirmEx='non' ";
			$res11=$conn->query($sql11);
			$res12=$conn->query($sql12);
			$res13=$conn->query($sql13);
			////////////////////////////////////////////////////////////////////////////////////////////////
			////////////////////////////////////////////////////////////////////////////////////////////////
			$sql16="SELECT   affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.commission ,client_mor.nomClMor, houss_not.nomHN, houss_not.prenomHN
			FROM affaire 
			INNER JOIN client_mor ON affaire.id_ClMor=client_mor.id_ClMor
			INNER JOIN houss_not ON affaire.id_cin_hn=houss_not.id_cin_hn 
			   where confirmHN='non' AND affaire.id_cin_hn<>0 
			   AND confirmEx='oui' 
			   AND affaire.id_cin='" . $_SESSION['id'] . "'
			   GROUP BY id_aff";
			   
			$res16=$conn->query($sql16);
			$sql17="SELECT   affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.commission ,client_mor.nomClMor, houss_not.nomHN, houss_not.prenomHN
			FROM affaire 
			INNER JOIN client_mor ON affaire.id_ClMor=client_mor.id_ClMor
			INNER JOIN houss_not ON affaire.id_cin_hn=houss_not.id_cin_hn 
			    where confirmHN='non' AND affaire.id_cin_hn<>0 AND confirmEx='non' AND affaire.id_cin_ex=0
			    AND affaire.id_cin='" . $_SESSION['id'] . "'
				GROUP BY id_aff";//demande pour hn et non expert
			$res17=$conn->query($sql17);

			$sql18="SELECT  affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.commission ,client_mor.nomClMor, expert.nomEx, expert.prenomEx,
			houss_not.nomHN, houss_not.prenomHN
			FROM affaire 
			INNER JOIN client_mor ON affaire.id_ClMor=client_mor.id_ClMor
			INNER JOIN expert ON affaire.id_cin_ex=expert.id_cin_ex 
			INNER JOIN houss_not ON affaire.id_cin_hn=houss_not.id_cin_hn 
			  where confirmHN='non' AND affaire.id_cin_hn<>0 AND confirmEx='non'AND affaire.id_cin_ex<>0 
			   AND affaire.id_cin='" . $_SESSION['id'] . "'
			   GROUP BY id_aff";//demande our les 2
			$res18=$conn->query($sql18);

			$sql19="SELECT  affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.commission ,client_mor.nomClMor, expert.nomEx, expert.prenomEx
			FROM affaire 
			INNER JOIN client_mor ON affaire.id_ClMor=client_mor.id_ClMor
			INNER JOIN expert ON affaire.id_cin_ex=expert.id_cin_ex 
			 where confirmEx='non' AND affaire.id_cin_ex<>0 AND confirmHN='oui'
			    AND affaire.id_cin='" . $_SESSION['id'] . "'
				group by id_aff";//demande pour  exp et hn deja existe
			$res19=$conn->query($sql19);
			$sql20="SELECT  affaire.id_aff ,affaire.date_fin, affaire.date_dep , affaire.commission ,client_mor.nomClMor, expert.nomEx, expert.prenomEx
			FROM affaire 
			INNER JOIN client_mor ON affaire.id_ClMor=client_mor.id_ClMor
			INNER JOIN expert ON affaire.id_cin_ex=expert.id_cin_ex 
			 where confirmEx='non' AND affaire.id_cin_ex<>0 AND confirmHN='non' AND affaire.id_cin_hn=0 
			   AND affaire.id_cin='" . $_SESSION['id'] . "'
			   group by id_aff";//demande pour hn et non expert
			$res20=$conn->query($sql20);
			//$sql18="SELECT * from affaire where confirmHN='non' AND confirmEx='non' ";
			$res16=$conn->query($sql16);
			$res17=$conn->query($sql17);
			$res18=$conn->query($sql18);
			//////////////////////////////////////////////////////////////////////////////////////////////
			//////////////////////////////////////////////////////////////////////////////

			if(($res11 && $res11->num_rows>0)||($res12 && $res12->num_rows>0) ||($res13 && $res13->num_rows>0) ||($res14 && $res14->num_rows>0)||($res15 && $res15->num_rows>0) ||($res16 && $res16->num_rows>0) ||($res17 && $res17->num_rows>0) || ($res18 && $res18->num_rows>0)||($res19 && $res19->num_rows>0)||($res20 && $res20->num_rows>0))
			{   echo "<table >
				 <tr><th>Client</th><th>affaire</th><th>Huissier notaire</th><th>expert</th></tr>";
				while($row11 = $res11->fetch_assoc())
				{
					echo"<tr>
					<td>".$row11['nomClphy']." " . $row11['prenomClphy']."</td>
                             
							<td>".$row11['id_aff']."</td>
                             
							<td>".$row11['nomHN']." " . $row11['prenomHN']."</td>
                             <td>"."-"."</td>
							 <td> 
                   <form method='POST' action=''>
                    <input type='hidden' name='id' value='".$row11['id_aff']."'>
					<input type='hidden' name='nameHN' value='".$row11['nomHN']." ".$row11['prenomHN']."'>
                      <button type='submit' name='confirmerHN' style='background-color:#4CAF50; padding:3px; margin-bottom:7px;border-radius :10px;font-size:12px; display:float;pointer:cursor; ;width:80px;color:white;border:none;height:20px;' > Confirmer </button> 
                      
					  <button type='submit' name='refuserHN'style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'> Refuser </button> </form> 
                      </td>
                             </tr>";
				}
				while($row12 = $res12->fetch_assoc())
				{
					echo"<tr>
					<td>".$row12['nomClphy']." " . $row12['prenomClphy']."</td>
                             
                             <td>".$row12['id_aff']."</td>
                             
                             <td>".$row12['nomHN']." " . $row12['prenomHN']."</td>
                             <td>"."-"."</td>
							<td> <form method='POST' action=''>
                    <input type='hidden' name='id' value='".$row12['id_aff']."'>
					<button type='submit' name='confirmerHN' style='background-color:#4CAF50; padding:3px; margin-bottom:7px;border-radius :10px;font-size:12px; display:float;pointer:cursor; ;width:80px;color:white;border:none;height:20px;' > Confirmer </button> 
					<button type='submit' name='refuserHN'style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'> Refuser </button> </form> 
                      </td>
                             </tr>";
				}
				while($row15 = $res15->fetch_assoc())
				{
					echo"<tr>
					<td>".$row15['nomClphy']." " . $row15['prenomClphy']."</td>
                             
                             <td>".$row15['id_aff']."</td>
                             
                             
                             <td>"."-"."</td>
							 <td>".$row15['nomEx']." " . $row15['prenomEx']."</td>
							 <td> 
                   <form method='POST' action=''>
                    <input type='hidden' name='id' value='".$row15['id_aff']."'>
					<input type='hidden' name='nameEx' value='".$row15['nomEx']." ".$row15['prenomEx']."'>
                      <button type='submit' name='confirmerEX' style='background-color:#4CAF50; padding:3px; margin-bottom:7px;border-radius :10px;font-size:12px; display:float;pointer:cursor; ;width:80px;color:white;border:none;height:20px;' > Confirmer </button> 
                      <button type='submit' name='refuserEX'style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'> Refuser </button> </form> 
                      </td>
                             </tr>";
				}
				while($row14 = $res14->fetch_assoc())
				{
					echo"<tr>
					<td>".$row14['nomClphy']." " . $row14['prenomClphy']."</td>
                             
                             <td>".$row14['id_aff']."</td>
                             
                             
                             <td>"."-"."</td>
							 <td>".$row14['nomEx']." " . $row14['prenomEx']."</td>
							 <td> 
                   <form method='POST' action=''>
                    <input type='hidden' name='id' value='".$row14['id_aff']."'>
					<input type='hidden' name='nameEx' value='".$row14['nomEx']." ".$row14['prenomEx']."'>
                      <button type='submit' name='confirmerEX' style='background-color:#4CAF50; padding:3px; margin-bottom:7px;border-radius :10px;font-size:12px; display:float;pointer:cursor; ;width:80px;color:white;border:none;height:20px;' > Confirmer </button> 
                      <button type='submit' name='refuserEX'style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'> Refuser </button> </form> 
                      </td>
                             </tr>";
				}
				while($row13 = $res13->fetch_assoc())
				{
					echo"<tr>
					<td>".$row13['nomClphy']." " . $row13['prenomClphy']."</td>
                             
                             <td>".$row13['id_aff']."</td>
                             
                             <td>".$row13['nomHN']." " . $row13['prenomHN']."</td>
                             
							 <td>".$row13['nomEx']." " . $row13['prenomEx']."</td>
							 <td> 
                   <form method='POST' action=''>
                    <input type='hidden' name='id' value='".$row13['id_aff']."'>
                      <button type='submit' name='confirmer2' style='background-color:#4CAF50; padding:3px; margin-bottom:7px;border-radius :10px;font-size:12px; display:float;pointer:cursor; ;width:80px;color:white;border:none;height:20px;' > Confirmer </button> 
                      <input type='hidden' name='nameHN' value='".$row13['nomHN']." ".$row13['prenomHN']."'>
					  <input type='hidden' name='nameEx' value='".$row13['nomEx']." ".$row13['prenomEx']."'>
					  <button type='submit' name='refuser2'style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'> Refuser </button> </form> 
                      </td>
                             </tr>";
				}
				while($row16 = $res16->fetch_assoc())
				{
					echo"<tr>
					<td>".$row16['nomClMor']."</td>
                             
                             <td>".$row16['id_aff']."</td>
                             
                             <td>".$row16['nomHN']." " . $row16['prenomHN']."</td>
							
							 <td>"."-"."</td>
							 <td> 
							 <form method='POST' action=''>
							  <input type='hidden' name='id' value='".$row16['id_aff']."'>
							  <input type='hidden' name='nameHN' value='".$row16['nomHN']." ".$row16['prenomHN']."'>
								<button type='submit' name='confirmerHN' style='background-color:#4CAF50; padding:3px; margin-bottom:7px;border-radius :10px;font-size:12px; display:float;pointer:cursor; ;width:80px;color:white;border:none;height:20px;' > Confirmer </button> 
								<button type='submit' name='refuserHN'style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'> Refuser </button> </form> 
								</td>
									   
                             </tr>";
				}
				while($row17 = $res17->fetch_assoc())
				{
					echo"<tr>
					<td>".$row17['nomClMor']."</td>
                             
                             <td>".$row17['id_aff']."</td>
                             
                             <td>".$row17['nomHN']." " . $row17['prenomHN']."</td>
                             
							 <td>"."-"."</td>
							 <td> 
							 <form method='POST' action=''>
							  <input type='hidden' name='id' value='".$row17['id_aff']."'>
							  <input type='hidden' name='nameHN' value='".$row17['nomHN']." ".$row17['prenomHN']."'>
								<button type='submit' name='confirmerHN' style='background-color:#4CAF50; padding:3px; margin-bottom:7px;border-radius :10px;font-size:12px; display:float;pointer:cursor; ;width:80px;color:white;border:none;height:20px;' > Confirmer </button> 
								<button type='submit' name='refuserHN'style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'> Refuser </button> </form> 
								</td>
									   
                             </tr>";
				}
				while($row18 = $res18->fetch_assoc())
				{
					echo"<tr>
					<td>".$row18['nomClMor']."</td>
                             
                             <td>".$row18['id_aff']."</td>
                             
                             <td>".$row18['nomHN']." " . $row18['prenomHN']."</td>
                             
							 <td>".$row18['nomEx']." " . $row18['prenomEx']."</td>
							 <td> 
							 <form method='POST' action=''>
							  <input type='hidden' name='id' value='".$row18['id_aff']."'>
							  <input type='hidden' name='nameHN' value='".$row18['nomHN']." ".$row18['prenomHN']."'>
							  <input type='hidden' name='nameEx' value='".$row18['nomEx']." ".$row18['prenomEx']."'>
								<button type='submit' name='confirmer2' style='background-color:#4CAF50; padding:3px; margin-bottom:7px;border-radius :10px;font-size:12px; display:float;pointer:cursor; ;width:80px;color:white;border:none;height:20px;' > Confirmer </button> 
								<button type='submit' name='refuser2'style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'> Refuser </button> </form> 
								</td>
									   
                             </tr>";
				}
				while($row19 = $res19->fetch_assoc())
				{
					echo"<tr>
					<td>".$row19['nomClMor']."</td>
                             
                             <td>".$row19['id_aff']."</td>
                             
							 <td>"."-"."</td>
                             
							 <td>".$row19['nomEx']." " . $row19['prenomEx']."</td>
							 <td> 
							 <form method='POST' action=''>
							  <input type='hidden' name='id' value='".$row19['id_aff']."'>
							  <input type='hidden' name='nameEx' value='".$row19['nomEx']." ".$row19['prenomEx']."'>
								<button type='submit' name='confirmerEX' style='background-color:#4CAF50; padding:3px; margin-bottom:7px;border-radius :10px;font-size:12px; display:float;pointer:cursor; ;width:80px;color:white;border:none;height:20px;' > Confirmer </button> 
								<button type='submit' name='refuserEX'style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'> Refuser </button> </form> 
								</td>
									   
                             </tr>";
				}
				while($row20 = $res20->fetch_assoc())
				{
					echo"<tr>
					<td>".$row20['nomClMor']."</td>
                             
                             <td>".$row20['id_aff']."</td>
                             
							 <td>"."-"."</td>
                             
							 <td>".$row20['nomEx']." " . $row20['prenomEx']."</td>
							 <td> 
							 <form method='POST' action=''>
							  <input type='hidden' name='id' value='".$row20['id_aff']."'>
							  <input type='hidden' name='nameEx' value='".$row20['nomEx']." ".$row20['prenomEx']."'> ;
								<button type='submit' name='confirmerEX' style='background-color:#4CAF50; padding:3px; margin-bottom:7px;border-radius :10px;font-size:12px; display:float;pointer:cursor; ;width:80px;color:white;border:none;height:20px;' > Confirmer </button> 
								<button type='submit' name='refuserEX'style='background-color: rgba(205, 60, 31, 0.981); border-radius :10px;font-size:12px;width:80px;pointer:cursor;color:white;border:none;height:20px;'> Refuser </button> </form> 
								</td>
									   
                             </tr>";
				}
				echo"</table>";
			} else echo "Aucune demande pour le moment."
			?>
			<?php 
			if (isset($_POST['confirmerHN'])) {
				$id = $_POST['id'];
				$nameHN=$_POST['nameHN'] ;
				$sql = "UPDATE affaire SET confirmHN='oui' WHERE id_aff=$id";
				$sql2="SELECT id_cin_clphy, id_ClMor from affaire where id_aff=$id";
				$res2=$conn->query($sql2) ;
				while ($row2 = $res2->fetch_assoc()){
					if ($row2['id_ClMor'] ==0) 
					    {$id_user=$row2['id_cin_clphy'] ;
						$type='clientphy' ;}
						else { $id_user=$row2['id_ClMor'] ;
						$type="clientmor" ;
						}
 ;				}
                $msg="Votre demande d'ajout du huissier notaire ".$nameHN."  pour votre affaire n° ".$id." a été acceptée." ;
				$msg1=mysqli_real_escape_string($conn,$msg) ;
				$sql3="INSERT into notif(id_user, user_type, msg,id_aff) VALUES ($id_user,'$type','$msg1',$id)" ;
				$res=$conn->query($sql) ;
				if($res)
				{$res3=$conn->query($sql3) ;
				echo "<script> window.onload = function(){alert('Demande acceptée, huissier notaire ajouté.')}</script>"; 
				}
			  }
			 else if (isset($_POST['refuserHN'])) {
				  $id=$_POST['id'] ;
				$nameHN=$_POST['nameHN'] ;
				 $sql="UPDATE  affaire SET id_cin_hn=0 , confirmHHN='non'
				 WHERE id_aff=$id ";
				 $sql2="SELECT id_cin_clphy, id_ClMor from affaire where id_aff=$id";
				 $res2=$conn->query($sql2) ;
				 while ($row2 = $res2->fetch_assoc()){
					 if ($row2['id_ClMor'] ==0) 
						 {$id_user=$row2['id_cin_clphy'] ;
						 $type="clientphy" ;}
						 else { $id_user=$row2['id_ClMor'] ;
						 $type="clientmor" ;
						 }
  ;				}
				 $msg="Désolé, votre demande d'ajout du huissier notaire ".$nameHN."  pour votre affaire n° ".$id." a été refusée." ;
				 $msg1=mysqli_real_escape_string($conn,$msg) ;
				 $sql3="INSERT into notif(id_user, user_type, msg,id_aff) VALUES ($id_user,'$type','$msg1',$id)" ;
				 $res=$conn->query($sql) ;
				 if($res) {$res3=$conn->query($sql3) ;
				 echo "<script> window.onload = function(){alert('Demande refusée .')}</script>";
				 }
			  }
			  if (isset($_POST['confirmerEX'])) {
				$id = $_POST['id'];
				$nameEx=$_POST['nameEx'] ;
				$sql2="SELECT id_cin_clphy, id_ClMor from affaire where id_aff=$id";
				$res2=$conn->query($sql2) ;
				while ($row2 = $res2->fetch_assoc()){
					if ($row2['id_ClMor'] ==0) 
					    {$id_user=$row2['id_cin_clphy'] ;
						$type="clientphy" ;}
						else { $id_user=$row2['id_ClMor'] ;
						$type="clientmor" ;
						}
 			}
                $msg="Votre demande d'ajout d'expert ".$nameEx." pour votre affaire n° ".$id." a été acceptée." ;
				$msg1=mysqli_real_escape_string($conn,$msg) ;
				$sql3="INSERT INTO notif (id_user, user_type, msg,id_aff) VALUES ($id_user,'$type','$msg1',$id)" ;
		
				$sql = "UPDATE affaire SET confirmEx='oui' WHERE id_aff=$id";
				$res=$conn->query($sql) ;
				if($res) {$res=$conn->query($sql3) ;
				echo "<script> window.onload = function(){alert('Demande acceptée, expert ajouté.')}</script>";
				}
			  }
			 if (isset($_POST['refuserEX'])) {
				  $id=$_POST['id'] ;
				  $nameEx=$_POST['nameEx'] ;
				  $sql2="SELECT id_cin_clphy, id_ClMor from affaire where id_aff=$id";
				$res2=$conn->query($sql2) ;
				while ($row2 = $res2->fetch_assoc()){
					if ($row2['id_ClMor'] ==0) 
					    {$id_user=$row2['id_cin_clphy'] ;
						$type="clientphy" ;}
						else { $id_user=$row2['id_ClMor'] ;
						$type="clientmor" ;
						}
						$msg="Désolée , votre demande d'ajout du huissier notaire ".$nameEx."  pour votre affaire n° ".$id." a été refusée." ;
						$msg1=mysqli_real_escape_string($conn,$msg) ;
						$sql3="INSERT INTO notif(id_user, user_type, msg,id_aff) VALUES ($id_user,'$type','$msg1',$id)" ;
						 $sql="UPDATE affaire SET id_cin_ex=0 , confirmEx='non'
						 WHERE id_aff=$id ";
						 $res=$conn->query($sql) ;
						 if($res) {
						 echo "<script> window.onload = function(){alert('Demande refusée .')}</script>";
						 $res3=$conn->query($sql3) ;
						 }
 			}
			  }
			else  if (isset($_POST['confirmer2'])) {
				$id = $_POST['id'];
				$nameEx=$_POST['nameEx'] ;
				$nameHN=$_POST['nameHN'] ;
				$sql2="SELECT id_cin_clphy, id_ClMor from affaire where id_aff=$id";
				$res2=$conn->query($sql2) ;
				while ($row2 = $res2->fetch_assoc()){
					if ($row2['id_ClMor'] ==0) 
					    {$id_user=$row2['id_cin_clphy'] ;
						$type="clientphy" ;}
						else { $id_user=$row2['id_ClMor'] ;
						$type="clientmor" ;
						}
			}
                $msg="Votre demande d'ajout du huissier notaire ".$nameHN."  pour votre affaire n° ".$id." a été acceptée , ainsi que celle d ajout de l expert ".$nameEx ;
				$msg1=mysqli_real_escape_string($conn,$msg) ;
				$sql3="INSERT INTO notif(id_user, user_type, msg,id_aff) VALUES ($id_user,'$type','$msg1',$id)" ;
				$sql = "UPDATE affaire SET confirmEx='oui' , confirmHN='oui' WHERE id_aff=$id";
				$res=$conn->query($sql) ;
				if($res) {$res3=$conn->query($sql3) ;
				 echo "<script> window.onload = function(){alert('Demande acceptée, huissier notaire et expert ajoutés .')}</script>";
			  }
			}
			 else if (isset($_POST['refuser2'])) {
				  $id=$_POST['id'] ;
				  $nameEx=$_POST['nameEx'] ;
				$nameHN=$_POST['nameHN'] ;
				$sql2="SELECT id_cin_clphy, id_ClMor from affaire where id_aff=$id";
				$res2=$conn->query($sql2) ;
				while ($row2 = $res2->fetch_assoc()){
					if ($row2['id_ClMor'] ==0) 
					    {$id_user=$row2['id_cin_clphy'] ;
						$type="clientphy" ;}
						else { $id_user=$id_user=$row2['id_ClMor'] ; ;
						$type="clientmor" ;
						}
							}
                $msg="Désolé, votre demande d'ajout du huissier notaire ".$nameHN."  pour votre affaire n° ".$id." a été refusée , ainsi que celle de l'ajout de l'expert ".$nameEX ;
				$msg1=mysqli_real_escape_string($conn,$msg) ;
				$sql3="INSERT INTO notif(id_user, user_type, msg,id_aff) VALUES ($id_user,'$type','$msg1',$id)" ;
				$sql="UPDATE affaire SET id_cin_hn=0 , id_cin_ex=0 , confirmEx='non' , confirmHN='non' 
				 WHERE id_aff=$id ";
				 $res=$conn->query($sql) ;
				 if($res)
				 {$res=$conn->query($sql3) ;
				 echo "<script> window.onload = function(){alert('Demande refusée .')}</script>";
			  }
			 }
			?>
			
                
			
			
		</div>
	</div>
	</div>
	<div class="col-div-4-1">
	<div class="box-1">
	<div class="content-box-1">
			<p class="head-1">Nos Intervenants<a href="IntervAvocatChef.php"><span class="voir-tout">Voir tout</span><a> </p>
			<?php 
			$sql9 = "SELECT nomEx, prenomEx, specialiteEx FROM expert";

			$sql10="SELECT nomHN,prenomHN FROM houss_not";
			
			
			
			$res9 = $conn->query($sql9);
			$res10 = $conn->query($sql10);
                if ($res9 && $res9->num_rows > 0) {
                  echo" <table class='table-inter' >
                <tr> <th>Type </th> <th>Nom </th><th>Prenom </th><th>Specialité </th>  </tr>";
                 while($row9 = $res9->fetch_assoc()) {
                  
                   echo"<tr>
                           <td>Expert</td>
                           <td>".$row9['nomEx']."</td>
                           <td>".$row9['prenomEx']."</td> 
                           <td>".$row9['specialiteEx']."</td> 
                           </tr>
                           
                       ";
                       break;
                 }

                 
                 }
                 if ($res10 && $res10->num_rows > 0) {
                  
                 while($row10 = $res10->fetch_assoc()) {
                   echo"<tr>
                           <td>Huissier Notaire</td>
                           <td>".$row10['nomHN']."</td>
                           <td>".$row10['prenomHN']."</td> 
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
		<div class="box-1" style="overflow-y:scroll;">
			<div class="content-box-1" >
			<p class="head-1">Consultation de ce mois<a href="consultationsAvocatChef.php"><span class="voir-tout">Voir tout</span><a> </p>
			<br/>
			<?php if (($res3 && $res3->num_rows > 0) || ($res4 && $res4->num_rows>0) ) {
                  echo" <table  >
                <tr> <th>Client </th> <th>Date </th> <th>Heure </th> </tr>";
                
                 while($row3 = $res3->fetch_assoc()) {
                  echo"<tr>
                           
                           <td>".$row3['nomClphy']."  ".$row3['prenomClphy']."</td>
                           <td>".$row3['dateCons']." </td> 
						   <td>".$row3['heure']."</td>
                           </tr>
                           
                           
                           
                       ";
					
                 } 
				
				while($row4 = $res4->fetch_assoc()) {
					echo "<tr>
						<td>".$row4['nomClMor']."</td>
						<td>".$row4['dateCons']." </td> 
						<td>".$row4['heure']."</td>
					</tr>";
				}
                 echo "</table>";
               }
               else { echo "<table>
                <tr>
                  <th>Client</th>
				  <th>Date</th>
                  <th>Heure</th>
                  

                </tr>
                <tr>
				<td>-</td>
                  <td>-</td> 
                  <td>-</td> 
                </tr>
				<tr>
				<td>-</td>
				<td>-</td> 
				<td>-</td> 
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
	<br/>
	<div class="col-div-12">
		<div class="box-8">
		<div class="content-box">
			<p class="head-1">Contacter </p>
			<br/>
			<?php $sql7="SELECT nomS ,prenomS ,emailS, num_telS FROM secretaire";
			$sql8="SELECT nomComp, prenomComp, num_telComp, emailComp FROM comptable ";
			$res7=$conn->query($sql7);
			$res8=$conn->query($sql8);
			if($res7 && $res8 && $res7->num_rows>0 && $res8->num_rows>0)
			{ $row7= mysqli_fetch_array($res7);
				$row8= mysqli_fetch_array($res8);
				echo "<table >
				<tr><td></td> <td>Nom</td> <td>Téléphone</td><td>E-mail</td></tr>
				<tr><td>Secretaire</td><td>".$row7['nomS']."  ".$row7['prenomS']."</td><td>".$row7['num_telS']."</td><td>".$row7['emailS']."</td></tr>
				<tr><td>Comptable</td><td>".$row8['nomComp']."  ".$row8['prenomComp']."</td><td>".$row8['num_telComp']."</td><td>".$row8['emailComp']."</td></tr>
				</table>
				";
			}
			



			?>
	
    

		</div>
	   </div>
	</div>

	
		
	<div class="clearfix"></div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>

  $(".menu").click(function(){
    $("#mySidenav").css('width','70px');
    $("#main").css('margin-left','70px');
    $(".logo").css('display', 'none');
    $(".logo1").css('display','block');
    $(".logo span").css('visibility', 'visible');
     $(".logo span").css('margin-left', '-10px');
     $(".icon-a").css('visibility', 'hidden');
     $(".icon-a").css('height', '55px');
     $(".icons").css('visibility', 'visible');
     $(".icons").css('margin-left', '-8px');
      $(".menu1").css('display','block');
      $(".menu").css('display','none');
  });

$(".menu1").click(function(){
    $("#mySidenav").css('width','300px');
    $("#main").css('margin-left','300px');
    $(".logo").css('visibility', 'visible');
    $(".logo").css('display','block');
     $(".icon-a").css('visibility', 'visible');
     $(".icons").css('visibility', 'visible');
     $(".menu").css('display','block');
      $(".menu1").css('display','none');
 });

</script>
<script>
$(document).ready(function(){
  $(".profile p").click(function(){
    $(".profile-div").toggle();
    
  });



  
});
</script>
</body>


</html>
