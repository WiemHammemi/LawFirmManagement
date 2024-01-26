<style>
.error-form{
    margin:3px ;
    display: inline-block;
    
    color:#fff;
    border-radius: 5px;
    font-size: 25px;
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
 $nomA=$_POST['nom'];
 $prenomA=$_POST['prenom'];
 $cv=$_POST['cv'];
 $cin=$_POST['cin'];
 $numtelA=$_POST['numtel'];
 $adresseA=$_POST['adresse'];
 $specialité=$_POST['specialité'];
 $emailA=$_POST['email'];
 $errors="";
if (empty($nomA) || preg_match('/^[a-zA-Z\s]+$/', $nomA)!=1) { $errors .= "<p class='error-form'>Il faut saisir votre nom. </p>";}
      if (empty($prenomA)|| preg_match('/^[a-zA-Z\s]+$/', $prenomA)!=1) {$errors .= "<p class='error-form'>Il faut saisir votre prenom. </p>";}
      if (empty($cin) || strlen((string)$cin)!=8) {$errors .= "<p class='error-form'>Il faut saisir le numéro de CIN. </p>";}
      if (empty($specialité)) {$errors .= "<p class='error-form'>Il faut saisir la spécialité. </p>";}
      if (empty($numtelA)||strlen((string)$numtelA)!=8) {$errors .= "<p class='error-form'>Il faut saisir votre numéro de téléphone.</p>";}
      if (empty($adresseA)) {$errors .= "<p class='error-form'>Il faut saisir votre adresse. </p>";}
      if (empty($cv)) {$errors .= "<p class='error-form'>Il faut saisir le cv. </p>";}
      if (empty($emailA)) { $errors .= "<p class='error-form'>Il faut saisir l'email. </p>";}
      else if (!filter_var($emailA, FILTER_VALIDATE_EMAIL)) {
        $errors .= "<p class='error-form'>L'adresse email n'est pas valide !</p>";
      }
      if ($errors !="") {   
        // $errors .= "<p class='error-form'>Il faut remplir tous les champs! </p> ";  
       // header("Location: ajoutavocat.php");  
        echo $errors   ;                       
        exit;
      }else{
        $host_name = "localhost";
            $database = "bureau_avocats";
            $user_name = "root";
            $password = "";
            $conn = mysqli_connect($host_name, $user_name, $password, $database);
           if(mysqli_connect_errno())
            {
              echo '<p>La connexion au serveur MySQL a échoué: '.mysqli_connect_error().'</p>';
            }
            else
            {
        $sqlEmail = "SELECT count(*) FROM `avocat` WHERE emailA = '$_POST[email]'" ;
        $resultEmail = $conn->query($sqlEmail);
        $countEmail = $resultEmail->fetch_array()[0];

        $sqlCin= "SELECT count(*) FROM `avocat` WHERE id_avocat= '$_POST[cin]'" ;
        $resultCin = $conn->query($sqlCin);
        $countCin = $resultCin->fetch_array()[0] ; }
        if ($resultEmail && $countEmail == 0 && $resultCin && $countCin == 0) {
          //Generer le mot de passe de lavocat  
          function genererMotDePasse($longueur) {
              // Definir les caracteres possibles dans le mot de passe
              $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            
              // Initialiser le mot de passe
              $mdpA = '';
            
              // Generer un caractere aleatoire et l'ajouter au mot de passe jusqu'a ce qu'il atteigne la longueur voulue
              for ($i = 0; $i < $longueur; $i++) {
                $mdpA .= $caracteres[rand(0, strlen($caracteres) - 1)];
              }
            
              // Retourner le mot de passe genere
              return $mdpA;
          
          }
          
            // Exemple d'utilisation : generer un mot de passe de  6 caracteres
          $mdpA= genererMotDePasse(6);
          $sql="INSERT INTO avocat(id_avocat,nomA,prenomA,adresseA,numtelA,emailA,specialitéA,mdpA,CV) VALUES ('$cin', '$nomA','$prenomA','$adresseA','$numtelA','$emailA','$specialité','$mdpA','$cv')" ;
           if ($conn->query($sql) === TRUE)
           { echo " Félicitation !L'avocat de cin " ;
            echo $cin ;
            echo " est inscrit au platforme!!" ;
          // Close the database connection
          $conn->close() ;
          } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
        
          }  
        }                        
        else{
          if($countEmail>0){
            $errors .= "<p class='error-form'>L'adresse Email déjà utilisé ! </p>";
          }
          if($countCin>0){
            $errors  = "<p class='error-form'>CIN déjà utilisé ! </p>";
          }
          if ($errors !="") { 
           // header("Location: ajoutavocat.php");  
                  echo $errors ;        
            exit;
          }
        }   
      }






?>