<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SH Avocats&Affaires</title>
    <link rel="shortcut icon" href="logo/favicon.ico"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style/style.css" >
</head>
<body class="index">
  
<?php
  include("login.php");
  include("aj_cl_phy.php");
  include("aj_cl_mor.php");
  
  ?> 
    <div class="header">
        <div class="socialmedia" >
            <img class="logo" src="logo.svg" alt="logo">            
           
            <ul>
                <li> <a href=""> <img src="images/facebook.png"> </a> </li>
               <li> <a href=""><img src="images/instagram.png"> </a> </li>
                <li> <a href=""> <img src="images/twitter.png"> </a>  </li>
            </ul>
        </div> 
       
    </div>
    
    <div class="main" id="main">
    <nav >
            <div class="links" style="margin-bottom:0;">
                <ul>
                    <li><a href ="index.php" > Acceuil </a></li>
                    
                    
                    <li><a href ="#" class="logInC" > Espace Client </a></li>
                    <li><a href ="#" class="logInA" > Espace Avocat </a></li>
                    
                    
                    
                    <li><a href ="us.html"> à propos de nous </a></li>
                    <li><a href ="#footer"> Contactez-nous </a></li>
                </ul>
            </div>
        </nav>
        <div class="text-box" style="position:static;transform:none;margin-left:15px;">
            
            <h1>Les avocats les plus reputés du pays </h1>
            <p >Vous avez des problemes juridiques ? Vous necessitez un conseil , une consultation ? </p> 
            <p> Vous voulez la procuration d'un avocat pour vous defendre ?</p>
            <p > On est là pour vous assister et granatir vos droits! </p>
             <p>Prenez un rendez-vous pour une consultation en ligne dès maintenant ! </p><br> 
        </div>  
    
    <?php
        if (isset($_SESSION['errorslogin'] )) {?>
            <div id="modal1" class="modal">
                <div class="modal-content">
                    <span id="closeModal1" class="close">&times;</span>
                    <h2 class=" erreurs">Erreurs ! </h2>    
                <div id="error-form1"></div>
                </div>
            </div>
        <?php }  ?>
    <div class="form_login active " id="formLogin">
            <div class="close-icon">
                <i class="fas fa-times fa-2x"></i>
            </div>
            <div class="form-value">
                <form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" autocomplete="off">
                    <h2>Se connecter</h2>
                                     
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text" name ="email" required value="<?php echo $id ?>">
                        <label for="">Email</label> 
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline"></ion-icon>
                        <input type="password" name="password" required value="<?php echo $pass ?>">
                        <label for="">Password</label> 
                    </div>
                    <div class="forget">
                        <label for=""><input type="checkbox" name="remember" id="remember" >Se souvenir <br><a href="forget_pass.php"><b>Mot de passe oublié ?</b></a></label>            
                    </div>
                    <button id="mybtn" class="btn_connect" type="submit" name="connect">Se connecter</button>
                    <div class="register">
                        <p>Je n'ai pas de compte.<a href="#" class="insc"> Je m'en crée un.</a></p>
                    </div>
                </form>
            </div>
    </div>
    <?php
        if (isset($_SESSION['errorsPhy'] )) {?>
            <div id="modal2" class="modal">
                <div class="modal-content">
                    <span id="closeModal" class="close">&times;</span>
                    <h2 class=" erreurs">Erreurs ! </h2>    
                <div id="error-form2"></div>
                </div>
            </div>
        <?php }  ?>
    <div class="form_insc active" id="formInsc">
        <div class="close-icon2">
            <i class="fas fa-times fa-2x"></i>
        </div>    
        <div class="form-value">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" name="form2" class="form2" id="form2" novalidate>     
                    <h2>S'inscrire</h2> 
                    <div class="container-insc">
                        <div class="insc-gauche">
                            <div class="inputbox">  
                                 
                                <input  type="text" name="nom" id="nom" required  onfocusout="validationNom()" > 
                                <label for="">Nom</label> 
                            </div>
                            <span id="errNom"></span>      <!--  span nom + id   -->    
                            <div class="inputbox">  
                                            
                                <input type="text" name="prenom" id="prenom" required  onfocusout="validationPrenom()">     
                                <label for="">Prenom</label>                                     
                            </div>
                            <span id="errPrenom"></span>     <!-- span prenom +id   -->    
                            <div class="inputbox">
                                
                                <input type="text" onfocus="(this.type='date')" onblur="(this.type='text')" name="dateNai" id="dateNai" required  onfocusout="validationDateNai()">
                                <label for="">Date de naissance</label>                          
                            </div>
                            <span id="errDN"></span>
                            <div class="inputbox">
                                
                                <input type="number" size="8" name="cin" id="cin" required  onfocusout="validationCIN()">
                                <label for=""> Numéro de CIN</label>
                             </div>
                            <span id="errcin"></span>
                            <div class="inputbox">
                                <input type="radio" name="sexe" id="Sexe" value="homme" checked><span class="sexe">Homme</span>
                                <input type="radio" name="sexe" id="Sexe" value="femme"><span  class="sexe">Femme</span>
                                <label for="">Sexe</label> 
                            </div>
                            <span id="errSexe"></span>
                            <div class="inputbox">
                                
                                <input type="number" size="8" name="NumTel" id="NumTel" required  onfocusout="validationNumTel()">
                                <label for="">Numero de telephone</label>    
                            </div>
                            <span id="errNT"></span>
                        </div>
                        <div class="insc-droite">
                            <div class="inputbox">   
                                
                                <input type="text" name="adr" id="adr" required  onfocusout="validationAdr()">
                                  
                                <label for="">Adresse</label>                         
                            </div>
                            <span id="errAdr"></span>
                            
                            <div class="inputbox">    
                                
                                <input type="text" name="profession" id="profession" required  onfocusout="validationprof()">
                                 
                                
                                <label for="">Profession</label>
                               
			                     
                            </div>
                            <span id="errProf"></span>
                            
                            <div class="inputbox">
                                
                                
                                <input type="email" name="email" id="email" required  onfocusout="validationEmail()">
                                <label for="">Email</label> 
                            </div>
                            <span id="errEmail"></span>
                            <div class="inputbox">
                                
                                
        
                                <input type="password" name="mdp1" id="mdp1" required  onfocusout="validationMdp1()">
                                
                                
                                <label for="">Mot de passe</label> 
                                
                            </div>
                            <span id="errMdp1"></span>
                            <div class="inputbox">
                                
                                
                                <input type="password" name="mdp2"id="mdp2" required  onfocusout="validationMdp2()">
                                
                               
                                <label for="">Mot de passe confirmé</label>
                               
			                    
                            </div>
                            <span id="errMdp2"></span>
                            <button class="client2" id="client2" name="autre" value="autre">Si vous etes une entreprise/sociétée .. cliquez ici.</button>
                        </div>    
                    </div>
                    <button type="submit" class="btn_insc" id="enreg" name="enreg" value="enreg">Enregistrer</button>                    
                </form>
        </div>
    </div>
    <?php
        if (isset($_SESSION['errors'] )) {?>
            <div id="modal3" class="modal">
                <div class="modal-content">
                    <span id="closeModal3" class="close">&times;</span>
                    <h2 class=" erreurs">Erreurs ! </h2>    
                <div id="error-form3"></div>
                </div>
            </div>
        <?php }  ?>
    
    <div class="form_insc3 active" id="formInsc3">
        <div class="close-icon3">
            <i class="fas fa-times fa-2x"></i>
        </div>
        <div class="form-value">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" name="form3" class="form3" id="form3" novalidate>     
                    <h2>S'inscrire</h2>
                    
                    <div class="container-insc">
                        <div class="insc-gauche">
                            <div class="inputbox">  
                                 
                                <input  type="text" name="nom2" id="nom2" required onfocusout="validationNom2()" >  
                                <label for="">Nom</label> 
                                
                            </div>
                            <span id="errNom2"></span>
                            <div class="inputbox">   
                                
                                <input type="text" name="adr2" id="adr" required  onfocusout="validationAdr2()">
                                  
                                <label for="">Adresse</label>                         
                            </div>
                            <span id="errAdr2"></span>
                            <div class="inputbox">
                                
                                
                                <input type="number" size="8" name="NumTel2" id="NumTel2" required  onfocusout="validationNumTel2()">
                                
                                
                                <label for="">Numero de telephone</label> 
                                
			                    
                            </div>
                            <span id="errNT2"></span>
                             
                            <div class="inputbox">    
                                
                                <input type="text" name="secteur" id="secteur" required  onfocusout="validationSec()">
                                 
                                
                                <label for="">Secteur d'activité</label>
                               
			                     
                            </div>
                            <span id="errSec"></span>
                            
                        </div>
                        <div class="insc-droite">
                            
                           
                            
                            <div class="inputbox">
                                
                                
                                <input type="email" name="email2" id="email2" required  onfocusout="validationEmail2()">
                                
                               
                                <label for="">Email</label> 
                                
                            </div>
                            <span id="errEmail2"></span>
                            <div class="inputbox">
                                
                                
        
                                <input type="password" name="mdp12" id="mdp12" required  onfocusout="validationMdp12()">
                                
                                
                                <label for="">Mot de passe</label> 
                                
                            </div>
                            <span id="errMdp12"></span>
                            <div class="inputbox">
                                
                                
                                <input type="password" name="mdp22"id="mdp22" required  onfocusout="validationMdp22()">
                                
                               
                                <label for="">Mot de passe confirmé</label>
                               
			                    
                            </div>
                            <span id="errMdp22"></span>
                            
                        </div>    
                    </div>
                    <button type="submit" class="btn_insc" id="enreg2" name="enreg2">Enregistrer</button>                    
                </form>        
        </div>
    </div>
    <div>
        <button class="btn btn_ins"><span><b>S'inscrire</b></span></button>
        <button class="btn btn_login"><span><b>Se connecter</b></span></button>
    </div>
    </div>
    <?php
include("footer.php") ;
?>
    <script>
       /* var form3 = document.getElementById("form3");
        var err = ""; 
        if (err !== "") {
            function handleSubmit(event) {
                event.preventDefault();
                const errorElement = document.getElementById("error-form3");
                errorElement.textContent = err;
                                form3.removeEventListener("submit", handleSubmit); 
            }
            form3.addEventListener("submit", handleSubmit);
        }*/
    </script>    

    <script>
        var modal = document.getElementById("modal2");
        var span = document.getElementById("closeModal");
        var err2 = "<?php echo $_SESSION["errorsPhy"]; ?>"; 
        const errorElement2 = document.getElementById("error-form2");
        errorElement2.innerHTML = err2;
        if (err2 !=="") {
            modal.style.display = "block"; // Affichage de la modale
            <?php  $_SESSION["errorsPhy"]=""; ?> //supprime message de succ affiche sauf au 1er fois
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
     <script>
        var modal1 = document.getElementById("modal3");
        var span1 = document.getElementById("closeModal3");
        var err1 = "<?php echo $_SESSION["errors"]; ?>"; 
        const errorElement1 = document.getElementById("error-form3");
        errorElement1.innerHTML = err1;
        if (err1 !=="") {
            modal1.style.display = "block"; // Affichage de la modale
            <?php  $_SESSION["errors"]=""; ?> //supprime message de succ affiche sauf au 1er fois
        }
        span1.onclick = function() {
            modal1.style.display = "none";
        }
        window.onclick = function(event) {
        if (event.target == modal1) {
            modal1.style.display = "none";
        }
        }
    </script>    
    <script>
        var modal3= document.getElementById("modal1");
        var span3= document.getElementById("closeModal1");
        var err3 = "<?php echo $_SESSION["errorslogin"]; ?>"; 
        const errorElement3 = document.getElementById("error-form1");
        errorElement3.innerHTML = err3;
        if (err3 !=="") {
            modal3.style.display = "block"; // Affichage de la modale
            <?php  $_SESSION["errorslogin"]=""; ?> //supprime message de succ affiche sauf au 1er fois
        }
        span3.onclick = function() {
            modal3.style.display = "none";
        }
        window.onclick = function(event) {
        if (event.target == modal3) {
            modal3.style.display = "none";
        }
        }
    </script>    
    <script src="js/index.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>   
</body>

</html>