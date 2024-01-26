<style>
.error-form{
    margin:3px ;
    display: inline-block;
    
    color:#fff;
    border-radius: 5px;
    font-size: 12px;
    padding:5px ;
    
    /*************/ 
    
    color:black;
    border-color:red;
    padding: 20px;
    
    border-radius: 20px;
    
    opacity: 1;
    
    align-items: center;
    background: transparent;
    border:2px solid rgba(255,255,255,0.5);
    


    margin:3px ;
    display: inline-block;
    
    color:black;
    border-radius: 5px;
    font-size: 20px;
    padding:5px ;
    border-color:rgb(193, 8, 8);
    align-items:center;
    display:flex;
    align-content:center;
    
 
 };
 </style>




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
 }
 function validate($data){
  $data=trim($data);
  $data=stripcslashes($data);
  $data=htmlspecialchars($data);
  return $data;
}  
session_start();
if(isset($_COOKIE['emailUser'])&& isset($_COOKIE['pass'])){
    $id=$_COOKIE['emailUser'];
    $pass=$_COOKIE['pass'];

}else{
    $id="";
    $pass="";
}

 if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['connect'])){
    if (empty($_POST["email"]) || empty($_POST["password"])) {
        $errors .= "<p class='error-form'>S'il vous plait saisir votre email et mot de passe.</p>";
      
    } else if(isset($_POST["email"])&& isset($_POST["password"])){
        $email=validate($_POST["email"]);
        $mdp=validate($_POST["password"]);

        $sql1 = " SELECT count(*) FROM avocat WHERE emailA = '$email' && mdpA = '$mdp' && id_cin<>id_chef ";
        $sql2 = " SELECT count(*) FROM secretaire WHERE emailS = '$email' && mdpS = '$mdp' ";
        $sql3 = " SELECT count(*) FROM client_phy WHERE emailClphy = '$email' && mdpClphy = '$mdp' ";
        $sql4 = " SELECT count(*) FROM client_mor WHERE emailClMor = '$email' && mdpClMor = '$mdp' ";
      //  $sql5 = " SELECT count(*) FROM comptable WHERE emailComp = '$email' && mdpComp = '$mdp' ";
        $sql6 = " SELECT count(*) FROM avocat WHERE id_cin=id_chef && emailA = '$email' && mdpA = '$mdp'";

        $res1 = mysqli_query($conn, $sql1);
        $res2 = mysqli_query($conn, $sql2);
        $res3 = mysqli_query($conn, $sql3);
       $res4 = mysqli_query($conn, $sql4);
       // $res5 = mysqli_query($conn, $sql5);
        $res6 = mysqli_query($conn, $sql6);
        

        $sqlaff1 = " SELECT * FROM avocat WHERE emailA = '$email' && mdpA = '$mdp' ";
        $sqlaff2 = " SELECT * FROM secretaire WHERE emailS = '$email' && mdpS = '$mdp' ";
        $sqlaff3 = " SELECT * FROM client_phy WHERE emailClphy = '$email' && mdpClphy = '$mdp' ";
        $sqlaff4 = " SELECT * FROM client_mor WHERE emailClMor = '$email' && mdpClMor = '$mdp' ";
      //  $sqlaff5 = " SELECT * FROM comptable WHERE emailComp = '$email' && mdpComp = '$mdp' ";
        $sqlaff6 = " SELECT * FROM avocat WHERE id_cin=id_chef && emailA = '$email' && mdpA = '$mdp'";

        $resaff1 = mysqli_query($conn, $sqlaff1);
        $resaff2 = mysqli_query($conn, $sqlaff2);
        $resaff3 = mysqli_query($conn, $sqlaff3);
        $resaff4 = mysqli_query($conn, $sqlaff4);
      //  $resaff5 = mysqli_query($conn, $sqlaff5);
        $resaff6 = mysqli_query($conn, $sqlaff6);
        if(mysqli_fetch_array($res1)[0] > 0){
            $row = mysqli_fetch_assoc($resaff1);
            $_SESSION['type'] ="avocat";
            $_SESSION['id'] = $row["id_cin"];
            $_SESSION['nom'] = $row["nomA"];
            $_SESSION['prenom'] = $row["prenomA"];
            if(isset($_POST['remember'])){
                setcookie('emailUser',$_POST['email'],time()+(60*60*24*15));
                setcookie('pass',$_POST['password'],time()+(60*60*24*15));
            }
            header('location: avocat/avocat.php');
        }else if(mysqli_fetch_array($res2)[0] > 0){
            $row = mysqli_fetch_assoc($resaff2);
            $_SESSION['type'] ="secretaire";
            $_SESSION['id'] = $row["id_cin_s"];
            $_SESSION['nom'] = $row["nomS"];
            $_SESSION['prenom'] = $row["prenomS"];
            if(isset($_POST['remember'])){
                setcookie('emailUser',$_POST['email'],time()+(60*60*24*15));
                setcookie('pass',$_POST['password'],time()+(60*60*24*15));
            }
            header('location: secretaire/secretaire.php');
        }else if(mysqli_fetch_array($res3)[0] > 0){
            $row = mysqli_fetch_assoc($resaff3);
            $_SESSION['type'] ="clientPhy";
            $_SESSION['id'] = $row["id_cin_clphy"];
            $_SESSION['nom'] = $row["nomClphy"];
            $_SESSION['prenom'] = $row["prenomClphy"];
            if(isset($_POST['remember'])){
                setcookie('emailUser',$_POST['email'],time()+(60*60*24*15));
                setcookie('pass',$_POST['password'],time()+(60*60*24*15));
            }
            header('location: clientPhy/clientPhy.php');
        }else if(mysqli_fetch_array($res4)[0] > 0){
            $row = mysqli_fetch_assoc($resaff4);
            $_SESSION['type'] ="clientMor";
            $_SESSION['id'] = $row["id_ClMor"];
            $_SESSION['nom'] = $row["nomClMor"];
            if(isset($_POST['remember'])){
                setcookie('emailUser',$_POST['email'],time()+(60*60*24*15));
                setcookie('pass',$_POST['password'],time()+(60*60*24*15));
            }
            header('location: clientMor/clientMor.php');
        // }else if(mysqli_fetch_array($res5)[0] > 0){
        //     $row = mysqli_fetch_assoc($resaff5);
        //     $_SESSION['type'] ="comptable";
        //     $_SESSION['id'] = $row["id_cin_c"];
        //     $_SESSION['nom'] = $row["nomComp"];
        //     $_SESSION['prenom'] = $row["prenomComp"];
        //     if(isset($_POST['remember'])){
        //         setcookie('emailUser',$_POST['email'],time()+(60*60*24*15));
        //         setcookie('pass',$_POST['password'],time()+(60*60*24*15));
        //     }
        //     header('location: comptable.php');
        }
        else if(mysqli_fetch_array($res6)[0] > 0){
            $row = mysqli_fetch_assoc($resaff6);
            $_SESSION['type'] ="chef_avocat";
            $_SESSION['id'] = $row["id_cin"];
            $_SESSION['nom'] = $row["nomA"];
            $_SESSION['prenom'] = $row["prenomA"];
            if(isset($_POST['remember'])){
                setcookie('emailUser',$_POST['email'],time()+(60*60*24*15));
                setcookie('pass',$_POST['password'],time()+(60*60*24*15));
            }
            header('location:chef/chefavocat.php');
        }else{
            $errors .= "<p class='error-form'>Email ou Mot de passe incorrect,Veuillez réessayer.</p>";
            
         }
         if ($errors !="") { 
            header("Location: index.php");
            $_SESSION['errorslogin'] = $errors;                              
            exit;
          }
    }else{
        header("Location: index.php");
        exit();
    };
}
 ?>