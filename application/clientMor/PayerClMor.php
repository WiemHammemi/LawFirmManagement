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
<?php 


if(isset($_POST['payer1']))
{ 
    if(isset($_POST['email'])&&isset($_POST['tel'])&&isset($_POST['type'])&&isset($_POST['carte'])&&isset($_POST['cvv'])&&isset($_POST['montant']))
    {
        
$email = $_POST['email'];
$tel = $_POST['tel'];
$type_paiement = $_POST['type'];
$affaire = $_POST['affaire'];
$num_carte = $_POST['carte'];
$date_exp = $_POST['expiration'];
$cvv = $_POST['cvv'];
$montant = $_POST['montant'];
$long_num_carte=strlen((string)$num_carte);
$long_cvv=strlen((string)$cvv);

////////////////////////
 $sql="SELECT * FROM client_mor where id_ClMor='" . $_SESSION['id'] . "'";
 $res=$conn->query($sql);
// $sql2="SELECT affaire.id_aff, affaire.commission,avocat.mailA, avocat.nomA, avocat.prenomA, avocat.id_cin ,client_mor.nomClMor, client_mor.prenomClMor
// FROM affaire 
// INNER JOIN avocat ON affaire.id_cin = avocat.id_cin 
// INNER JOIN affaire ON client_mor.id_ClMor = affaire.id_cin _id_ClMor
//  WHERE  affaire.id_aff='$affaire' AND client_mor.id_ClMor='" . $_SESSION['id'] . "'";
$sql2="SELECT a.id_aff, a.commission, av.emailA, av.nomA,av.id_cin,av.prenomA, cp.nomClMor
FROM affaire a
INNER JOIN avocat av ON a.id_cin = av.id_cin 
INNER JOIN client_mor cp ON cp.id_ClMor = a.id_ClMor
WHERE a.id_aff=$affaire AND cp.id_ClMor='" . $_SESSION['id'] . "'";
$res2=$conn->query($sql2);


$res2 = $conn->query($sql2);

   
    // rest of your code




if($res&& $res2)
{    $row2 = $res2->fetch_assoc();
    $nomAvocat=$row2['nomA'];
$prenomAvocat=$row2['prenomA'];
$nomClient=$row2['nomClMor'];
$idav=$row2['id_cin'] ;
$mailAvocat=$row2['emailA'];
$commission=$row2['commission'];
$id=$_SESSION['id'] ;
    $row = $res->fetch_assoc();
    if($tel==$row['num_telClMor'] && $email==$row['emailClMor']&& $long_num_carte==16 && $long_cvv==4 && $montant==$commission)

    {
        $sql1 = "INSERT INTO moy_pay (id_pay_numCarte, id_ClMor,  type_pay, dateExp,  cvv)
        VALUES ('$num_carte', '" . $_SESSION['id'] . "', '$type_paiement', '$date_exp', '$cvv')";
       
        if ($conn->query($sql1) === TRUE) {
            // $date = date('Y-m-d');
            // $time=time();
            $timestamp = 1681991139;
        $date = date('Y-m-d à H:i:s', $timestamp);
        $date1=date('Y-m-d');
        
           //
           $code = strval(mt_rand(0, 2147483646)); 
           //$code=uniqid();
            $sql3="INSERT INTO facture (code,designation,montant,dateFact,id_aff)
            values ('$code','Facture de paiement pour affaire code $affaire', '$montant', '$date1', '$affaire')";
            $res3=$conn->query($sql3);
            

            $mess="Bonjour, Vous avez effectuer un paiement de $montant dt, le $date , au benifice de l'avocat $nomAvocat $prenomAvocat pour l'affaire code $affaire.";
            $mess1="Bonjour, Vouz avez reçu un montant de $montant dt , de la part du client(e) $nomClient  , pour l'affaire code $affaire.";
            $headers='Content-Type: text/plain; charset="utf-8"'." ";
            $messs=mysqli_real_escape_string($conn, $mess);
            $messs1=mysqli_real_escape_string($conn, $mess1);
        $sql100="INSERT INTO notif(id_user,user_type,msg,id_aff) VALUES ($id,'clientmor','$messs',$affaire)";
        $sql101="INSERT INTO notif(id_user,user_type,msg,id_aff) VALUES ($idav,'avocat','$messs1',$affaire)";
$res100=$conn->query($sql100) ;
$res101=$conn->query($sql101) ;
           
           
           
            mail($email,'Payement',$mess,$headers);
            mail($mailAvocat,'Payement',$mess1,$headers);
       
        require_once('../tcpdf/examples/config/tcpdf_config_alt.php');
require_once('../tcpdf/tcpdf.php');
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);


$pdf->SetCreator('SHAvocats&Affaires');
$pdf->SetAuthor($nomAvocat.' '.$prenomAvocat);
$pdf->SetTitle('Facture');
$pdf->SetSubject('Facture de paiement');
$pdf->SetKeywords('TCPDF, PDF, Facture, test, guide');


$pdf->AddPage();


$pdf->SetFont('helvetica', '', 18);
               $pdf->writeHTML
               ("
<style>
*{
  text-align: center;
}
</style>
<h1> Facture </h1>

 <p>facture :</p><p> $code </p>
<p> Client : </p><p> $nomClient  </p>
<p> Avocat : </p><p> $nomAvocat  $prenomAvocat</p>
<p> Montant : </p><p> $montant (dt)</p>
<p> Date : </p> <p> $date </p>
 
 


");

$pdf->Output('facture'.'-'.$code.'.pdf', 'D');

         
           
            
                                                                  
           } 
         
        }
       else {
        echo "<script>
        window.onload = function() {
            alert('Données Incorrect, Veuillez ressayer !');
        }
      </script>";
    
       }

}
    }
   
   else {
    
    echo "<script>
        window.onload = function() {
            alert('il faut saisir tous les champs!!');
        }
      </script>";
   }
}




  
  $conn->close();

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
    <link rel="stylesheet" href="../style/styleFormPay.css " type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css"
        integrity="sha384-rz/XW1FqhNQ6C5U6f5v5M5KaUTQwKilUUIy5S6RjKfuLyK4ksd9Y+lZPxv4+Qqtn" crossorigin="anonymous">
</head>
<title>  <?php echo   $_SESSION['nom']; ?> | Espace client</title>
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
//  $id=$_SESSION['id'] ;
// $sql19="SELECT msg FROM notif
// WHERE user_type='clientmor'
// AND id_user=$id
// ORDER BY datenotif DESC" ;
// $res = mysqli_query($conn, $sql19);
// if ($res && $res->num_rows > 0) {
//     echo"Notifications </br>";
//    while($row19 = $res->fetch_assoc()) {
//      echo"<tr>
//              <td>".$row19['msg']."</td>  
//              </tr>        
//          ";
//    }
//    } 
//    else echo 'aucune notification' ;
   ?>
	</div>
                </div>
                <div class="profile">


                <p> <i class="fa fa-user-circle" aria-hidden="true"></i>&nbsp;
                    <?php echo   $_SESSION['nom'].  '<br/> '; ?>  <i class="fa fa-ellipsis-v dots"
                            aria-hidden="true"></i></p>
                    <div class="profile-div">
                      
                        <a href="profileClMor.php"><p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p></a>
                        
                        <a href="parametresClMor.php"><p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p></a>
                        
                       <a href="logout.php" class="logoutBtn" id="logoutBtn"><p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p></a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
       
        <form action="PayerClMor.php" method="POST" class="payer" style="border:none;">

  <input type="email" id="email" name="email" required placeholder="E-mail" ><br><br>
  
  
  <input type="number" id="tel" name="tel" required placeholder="Numéro de téléphone"><br><br>
  <input type="number" id="affaire" name="affaire" required placeholder="Numéro d'affaire"><br><br>
  
 
  <select id="type" name="type" placeholder="Type de paiement">
    <option value="carte_credit">Carte de crédit </option>
    <option value="carte_debit">Carte de débit </option>
    <option value="virement">Virement bancaire local</option>
  
  </select><br><br>
  
  
  <input type="text"  id="carte" name="carte" required placeholder="Numéro de carte"><br><br>
  
  
  <input type="text" onfocus="(this.type='month')" onblur="(this.type='text')" name="expiration" id="carte"   placeholder="Date d'expiration"><br><br>
  
  <input type="text" id="cvv" name="cvv" required placeholder="Code de sécurité (CVV)"><br><br>
  
  
  <input type="number" id="montant" name="montant" required placeholder="Montant (dt)"><br><br>
  
  <input type="submit" name="payer1" value="Payer">
</form>



        
              
        <div class="clearfix"></div>
        <br />


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


