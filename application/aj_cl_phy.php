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
 };
 </style>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bureau_avocats";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Erreur de connection : " . $conn->connect_error);
    }  
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['enreg'])){
      $nom=$_POST['nom'];
      $prenom=$_POST['prenom'];
      $DN=$_POST['dateNai'];
      $cin=$_POST['cin'];
      $sexe=$_POST['sexe'];
      $NT=$_POST['NumTel'];
      $adr=$_POST['adr'];
      $prof=$_POST['profession'];
      $email=$_POST['email'];
      $mdp1=$_POST['mdp1'];
      $mdp2=$_POST['mdp2'];
      $errors="";
      if (empty($nom) || preg_match('/^[a-zA-Z\s]+$/', $nom)!=1) {  $errors .= "<p class='error-form'>Il faut saisir votre nom. </p>";}
      if (empty($prenom)|| preg_match('/^[a-zA-Z\s]+$/', $prenom)!=1) {$errors .= "<p class='error-form'>Il faut saisir votre prenom. </p>";}
      if (empty($cin) || strlen((string)$cin)!=8) {$errors .= "<p class='error-form'>Il faut saisir votre numéro de CIN. </p>";}
      if (empty($NT) || strlen((string)$NT)!=8) {$errors .= "<p class='error-form'>Il faut saisir votre date de naissance.</p>";}
      if (empty($prof)) {$errors .= "<p class='error-form'>Il faut saisir votre profession. </p>";}
      if (empty($NT)) {$errors .= "<p class='error-form'>Il faut saisir votre numéro de téléphone.</p>";}
      if (empty($adr)) {$errors .= "<p class='error-form'>Il faut saisir votre adresse. </p>";}
      if (empty($sexe)) {$errors .= "<p class='error-form'>Il faut donner votre sexe. </p>";}
      if (empty($mdp1) || strlen((string)$mdp1)<5) {$errors .= "<p class='error-form'>Il faut saisir un mot de passe  de taille supérieure ou égale à 5. </p>";}
      if (empty($email)) {
        $errors .= "<p class='error-form'>Il faut saisir votre email. </p>";
      }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors .= "<p class='error-form'>L'adresse email n'est pas valide !</p>";
      }
      if($_POST['mdp1']!=$_POST['mdp2']){$errors .= "<p class='error-form'>Il faut bien confirmer le mot de passe ! </p>";}
      if ($errors !="") {   
        // $errors .= "<p class='error-form'>Il faut remplir tous les champs! </p> ";
        $_SESSION['errorsPhy'] = $errors;   
        header("Location: index.php");                           
        exit;
        exit;
      }else{
        $sqlEmail = "SELECT count(*) FROM `client_phy` WHERE emailClphy = '$_POST[email]'" ;
        $resultEmail = $conn->query($sqlEmail);
        $countEmail = $resultEmail->fetch_array()[0];

        $sqlCin= "SELECT count(*) FROM `client_phy` WHERE id_cin_clphy = '$_POST[cin]'" ;
        $resultCin = $conn->query($sqlCin);
        $countCin = $resultCin->fetch_array()[0];

        if ($resultEmail && $countEmail == 0 && $resultCin && $countCin == 0) {
          $sql = "INSERT INTO client_phy(id_cin_clphy, nomClphy, prenomClphy, date_naiss,profession,num_telClphy,adresse_Clphy,emailClphy,mdpClphy,sexe) 
          VALUES ('$_POST[cin]', '$_POST[nom]', '$_POST[prenom]','$_POST[dateNai]','$_POST[profession]','$_POST[NumTel]','$_POST[adr]','$_POST[email]','$_POST[mdp1]','$_POST[sexe]')";
          if ($conn->query($sql) === TRUE) {
            $_SESSION['success'] = "Vous êtes inscrit. <br/><br/>";
            $_SESSION['type'] ="clientPhy";
            $_SESSION['id'] = $_POST["cin"];
            $_SESSION['nom'] = $_POST["nom"];
            $_SESSION['prenom'] =$_POST["prenom"];
            header('location: clientPhy.php');
          } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
          }                                       
        }else{
          if($countEmail>0){
            $errors .= "<p class='error-form'>L'adresse Email déjà utilisé ! </p>";
          }
          if($countCin>0){
            $errors  = "<p class='error-form'>CIN déjà utilisé ! </p>";
          }
          if ($errors !="") { 
            header("Location: index.php");
            $_SESSION['errorsPhy'] = $errors;                              
            exit;
          }
        }
      }    
    } 
    $conn->close();
?>