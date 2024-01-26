<?php
 $servername = "localhost";
 $username = "root";
 $password = "";
 $dbname = "bureau_avocats";
 $conn = new mysqli($servername, $username, $password, $dbname);
$errors = "";
 echo "<script>localStorage.setItem('errors', '" . $errors . "');</script>";
 if ($conn->connect_error) {
   die("Erreur de connection : " . $conn->connect_error);
 }?>





<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style1.css">
    <title>Mot de passe oublié</title>
  </head>
  <body>
    
    <div class="box">
      
    <form method="post">
      <h2>Mot de passe oublié </h2>
      <div class="inputBox">
       
      
        <input type="email" placeholder="" name="email" required>
        <span>Email</span>
        <i></i>
      </div>
        <div class="div"></div>
        <input type="submit" class="submit" value="Nouveau Mot de passe">
      </div>
    </form>
</div>
  </body>
</html>



<?php 
if(isset($_POST['email'])){
    $email=$_POST['email'];
    $pass= uniqid();

    $sql1 = " SELECT count(*) FROM avocat WHERE emailA = '$email'  ";
    $sql2 = " SELECT count(*) FROM secretaire WHERE emailS = '$email'  ";
    $sql3 = " SELECT count(*) FROM client_phy WHERE emailClphy = '$email'  ";
    $sql4 = " SELECT count(*) FROM client_mor WHERE emailClMor = '$email'  ";
    $sql5 = " SELECT count(*) FROM comptable WHERE emailComp = '$email'  ";

    $res1 = mysqli_query($conn, $sql1);
    $res2 = mysqli_query($conn, $sql2);
    $res3 = mysqli_query($conn, $sql3);
    $res4 = mysqli_query($conn, $sql4);
    $res5 = mysqli_query($conn, $sql5);
    


    $mess="Bonjour,\n Voici votre nouveau mot de passe :  $pass .";
    $headers='Content-Type: text/plain; charset="utf-8"'." ";
    //$headers .="From: hammemiwiem231@gmail.com\r\n";
    
    //ini_set('smtp_port', 587);
    //mail($_POST['email'],'Nouveau Mot de passe',$mess,$headers);
   // ini_set('SMTP', 'smtp.gmail.com');
   // ini_set('smtp_port', 587);

    if(mail($_POST['email'],'Nouveau Mot de passe',$mess,$headers)){
        if(mysqli_fetch_array($res1)[0] > 0){
            $sql="UPDATE avocat SET mdpA=? WHERE emailA= ?";
            $stmt= $conn->prepare($sql);
           $stmt->bind_param('ss', $mdppass,$email);
            $mdppass="$pass"; 
            $email="$_POST[email]";
            $stmt->execute();
            echo "Mail envoyé";
        }else if(mysqli_fetch_array($res2)[0] > 0){
            $sql="UPDATE secretaire SET mdpS=? WHERE emailS= ?";
            $stmt= $conn->prepare($sql);
            
            $stmt->bind_param('ss', $mdppass,$email);
            $mdppass="$pass"; 
            $email="$_POST[email]";
            $stmt->execute();
            echo "Mail envoyé";

        }else if(mysqli_fetch_array($res3)[0] > 0){
            $sql="UPDATE client_phy SET mdpClphy=? WHERE emailClphy= ?";
            $stmt= $conn->prepare($sql);
            
            $stmt->bind_param('ss', $mdppass,$email);
            $mdppass="$pass"; 
            $email="$_POST[email]";
            $stmt->execute();
            echo "Mail envoyé";

        }else if(mysqli_fetch_array($res4)[0] > 0){
            $sql="UPDATE client_mor SET mdpClMor=? WHERE emailClMor= ?";
            $stmt= $conn->prepare($sql);
            
            $stmt->bind_param('ss', $mdppass,$email);
            $mdppass="$pass"; 
            $email="$_POST[email]";
            $stmt->execute();
            echo "Mail envoyé";

        } else if(mysqli_fetch_array($res5)[0] > 0){
            $sql="UPDATE comptable SET mdpComp=? WHERE emailComp= ?";
            $stmt= $conn->prepare($sql);
            
            $stmt->bind_param('ss', $mdppass,$email);
            $mdppass="$pass"; 
            $email="$_POST[email]";
            $stmt->execute();
           // echo "Mail envoyé";

        }else{
            echo "Email n'existe pas,Veuillez réessayer.</p>";
            
         }

       
    }else{
        echo "Une erreur est survenue ...";
    }
}
?>