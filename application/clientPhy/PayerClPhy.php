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
<?php 


if(isset($_POST['payer']))
{
    if(isset($_POST['email'])&&isset($_POST['tel'])&&isset($_POST['type'])&&isset($_POST['carte'])&&isset($_POST['expiration'])&&isset($_POST['cvv'])&&isset($_POST['montant']))
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
 $sql="SELECT * FROM client_phy where id_cin_clphy='" . $_SESSION['id'] . "'";
 $res=$conn->query($sql);

$sql2="SELECT a.id_aff, a.commission,av.id_cin, av.emailA, av.nomA, av.prenomA, av.id_cin, cp.nomClphy, cp.prenomClphy
FROM affaire a
INNER JOIN avocat av ON a.id_cin = av.id_cin 
INNER JOIN client_phy cp ON cp.id_cin_clphy = a.id_cin_clphy
WHERE a.id_aff=$affaire AND cp.id_cin_clphy='" . $_SESSION['id'] . "'";
$res2=$conn->query($sql2);


$res2 = $conn->query($sql2);

   
   




if($res&& $res2)
{    $row2 = $res2->fetch_assoc();
    $nomAvocat=$row2['nomA'];
    $idav=$row2['id_cin'] ;
    $idcl=$_SESSION['id'] ;
$prenomAvocat=$row2['prenomA'];
$nomClient=$row2['nomClphy'];
$prenomClient=$row2['prenomClphy'];
$mailAvocat=$row2['emailA'];
$commission=$row2['commission'];
    $row = $res->fetch_assoc();
    if($tel==$row['num_telClphy'] && $email==$row['emailClphy']&& $long_num_carte==16 && $long_cvv==4 && $montant==$commission)

    { $timestamp = 1681991139;
        $date = date('Y-m-d à H:i:s', $timestamp);
        $date1=date('Y-m-d');
        $sql1 = "INSERT INTO moy_pay (id_pay_numCarte, id_cin_clphy,  type_pay, dateExp,  cvv)
        VALUES ('$num_carte', '" . $_SESSION['id'] . "', '$type_paiement', '$date_exp', '$cvv' )";
       
        if ($conn->query($sql1) === TRUE) {
            // $date = date('Y-m-d');
            // $time=time();
        
           
            $code=uniqid();
            $sql3="INSERT INTO facture (code,designation,montant,dateFact,id_aff)
            values ('$code','Facture de paiement pour affaire code $affaire', '$montant', '$date1', '$affaire')";
            $res3=$conn->query($sql3);
            

            $mess="Bonjour, Vous avez effectuer un paiement de $montant dt, le $date , au benifice de l'avocat $nomAvocat $prenomAvocat pour l'affaire code $affaire.";
            $mess1="Bonjour, Vouz avez reçu un montant de $montant dt , de la part du client(e) $nomClient $prenomClient , pour l'affaire code $affaire.";
            $headers='Content-Type: text/plain; charset="utf-8"'." ";
            mail($email,'Payement',$mess,$headers);
            mail($mailAvocat,'Payement',$mess1,$headers);
            $messs=mysqli_real_escape_string($conn, $mess);
            $messs1=mysqli_real_escape_string($conn, $mess1);
        $sql100="INSERT INTO notif(id_user,user_type,msg,id_aff) VALUES ($idcl,'clientphy','$messs',$affaire)";
        $sql101="INSERT INTO notif(id_user,user_type,msg,id_aff) VALUES ($idav,'avocat','$messs1',$affaire)";
$res100=$conn->query($sql100) ;
$res101=$conn->query($sql101) ;
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

 <p>facture :</p> $code </p>
<p> Client(e) : </p> $nomClient  $prenomClient</p>
<p> Avocat : </p> $nomAvocat  $prenomAvocat</p>
<p> Montant : </p> $montant</p>
<p> Date : </p>$date </p>
 
 


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
// WHERE user_type='clientphy'
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
                        <?php echo   $_SESSION['nom']."  " . $_SESSION['prenom']; ?> <i class="fa fa-ellipsis-v dots"></i></p>

                    <div class="profile-div">
                      
                        <a href="profileClPhy.php"><p><i class="fa fa-user"></i>&nbsp;&nbsp; Profile</p></a>
                        
                        <a href="parametresClPhy.php"><p><i class="fa fa-cogs"></i>&nbsp;&nbsp; Parametres</p></a>
                        
                       <a href="logout.php" class="logoutBtn" id="logoutBtn"><p><i class="fa fa-power-off"></i>&nbsp;&nbsp; Déconnexion</p></a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        
       
        <form action="" method="POST" class="payer">

  <input type="email" id="email" name="email" required placeholder="E-mail" ><br><br>
  
  
  <input type="number" id="tel" name="tel" required placeholder="Numéro de téléphone"><br><br>
  <input type="number" id="affaire" name="affaire" required placeholder="Numéro d'affaire"><br><br>
  
 
  <select id="type" name="type" placeholder="Type de paiement">
    <option value="carte_credit">Carte de crédit </option>
    <option value="carte_debit">Carte de débit </option>
    <option value="virement">Virement bancaire local</option>
    
  </select><br><br>
  
  
  <input type="text"  id="carte" name="carte" required placeholder="Numéro de carte"><br><br>
  
  
  <input type="text" onfocus="(this.type='month')" onblur="(this.type='text')" name="expiration" id="carte" required  placeholder="Date d'expiration"><br><br>
  
  <input type="text" id="cvv" name="cvv" required placeholder="Code de sécurité (CVV)"><br><br>
  
  
  <input type="number" id="montant" name="montant" required placeholder="Montant (dt)"><br><br>
  
  <input type="submit" name="payer" value="Payer">
</form>





        
              
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



