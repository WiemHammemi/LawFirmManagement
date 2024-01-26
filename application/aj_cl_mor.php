
<style>
.error-form{
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
    
 }</style>
 <?php
    
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "bureau_avocats";
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Erreur de connection : " . $conn->connect_error);
    } 
    if($_SERVER["REQUEST_METHOD"] == "POST" &&  isset($_POST['enreg2']))
    {
        $NumTel2=$_POST['NumTel2'];
        $adr2=$_POST['adr2'];
        $secteur=$_POST['secteur'];
        $email2=$_POST['email2'];
        $nom2=$_POST['nom2'];
        $mdp12=$_POST['mdp12'];
        $mdp22=$_POST['mdp22'];
        $errors="";
        //if(isset($_POST['NumTel2']) && isset($_POST['adr2']) && isset($_POST['email2']) && isset($_POST['mdp12']) &&
        //isset($_POST['mdp22']) && isset($_POST['secteur']) && isset($_POST['nom2'])){
            if(empty($NumTel2) || preg_match('/^[0-9]+/', $NumTel2)!=1|| strlen((string)$NumTel2)!=8){  $errors .= "<p class='error-form'> Il faut saisir votre numéro de téléphone .</p>";}
            if(empty($adr2)){$errors .="<p class='error-form'>Il faut saisir votre adresse .</p>";}
            if (empty($email2)) {
                $errors .= "<p class='error-form'>Il faut saisir votre email. </p>";
              }else if (!filter_var($email2, FILTER_VALIDATE_EMAIL)) {
                $errors .= "<p class='error-form'>L'adresse email n'est pas valide !</p>";
              }
            if(empty($secteur)){$errors .="<p class='error-form' >Il faut saisir votre secteur. </p>";}
            if(empty($nom2)){$errors .="<p class='error-form' >Il faut remplir le champ nom. </p>";}
            if(empty($_POST['mdp12'])||empty($_POST['mdp22'])){$errors .= "<p class='error-form'>Il faut remplir les champs du  mot de passe.</p>";}
            if($_POST['mdp12']!=$_POST['mdp22']){$errors .= "<p class='error-form'>Il faut bien confirmer le mot de passe ! </p>";}
            if ($errors !="") {   
                // $errors .= "<p class='error-form'>Il faut remplir tous les champs! </p> ";
                $_SESSION['errors'] = $errors;   
                header("Location: index.php");                           
                exit;
                exit;
              }else{
                $sql1 = "SELECT count(*) FROM `client_mor` WHERE emailClMor = ?";
                $stmt = $conn->prepare($sql1);
                $stmt->bind_param("s", $_POST['email2']);
                $stmt->execute();
                $result = $stmt->get_result();
                $count = $result->fetch_array()[0];
                if ($count == 0) {
                    $sql = "INSERT INTO client_mor(id_ClMor,num_telClMor, adresseClMor, emailClMor, mdpClMor, secteur, nomClMor) 
                    VALUES ('',?, ?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssssss", $_POST['NumTel2'], $_POST['adr2'], $_POST['email2'], $_POST['mdp12'], $_POST['secteur'], $_POST['nom2']);
                    if ($stmt->execute()) {
                        $_SESSION['success'] = "Vous êtes inscrit.<br/><br/>";
                        $_SESSION['type'] ="clientMor";
                        //$_SESSION['id'] = $_POST["id_ClMor"];
                        
                        $_SESSION['nom'] = $_POST["nom2"];
                        header('location: clientMor.php');
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }                                       
                } else { $_SESSION['errors'] =  $errors .= "<p class='error-form'>Cet E-mail est déjà utilisé !";}
                if ($errors !="") { 
                    header("Location: index.php");
                    $_SESSION['errors'] = $errors;                              
                    exit;
                $stmt->close();      
            

        }

    }
}
    

$conn->close();
       
?>