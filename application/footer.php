<style>
footer{
 background-color:  rgba(214,204,194,255) ;
 height:180px;}
section{
 
  
   max-width: 1500px;
   padding:0px;
   

}
  .footer .grid{
   display: grid;
  grid-template-columns: repeat(auto-fit, minmax(20rem, 0.8fr));
 gap:1.3rem;
   align-items: flex-start;
}

.footer .grid .box{
   border:var(--border);
   padding: 0.5rem;
   text-align: center;
}

.footer .grid .box img{
   height: 4rem;
   width:3em;
   padding-bottom:0.5px;
   width: 100%;
   object-fit: contain;
   margin-bottom: 0.5rem;
   filter: hue-rotate(90deg);
}

.footer .grid .box h3{
   margin:0.3rem 0;
   font-size: 1rem;
   padding-top:3px;
   
   /*color:var(--black);*/
   text-transform: capitalize;
   color:black;
  font-weight:bold;
}


.footer .grid .box p,
.footer .grid .box a{
   display: block;
   padding-top:3px;
   font-size: 1.3rem;
   text-decoration:none;
  color:black;
  font-weight:bold;
  /* color:var(--light-color);*/
   line-height: 1.3;
}

.credit{
   background-color:rgb(153,151,147);
   padding:0.5rem 0.5rem;
   text-align: center;
  
   color:black;
  font-weight:bold;;
   font-size: 1rem;
   text-transform: capitalize;
   /* padding-bottom: 10rem; */
}


 



</style>
<footer class="footer" id="footer">

   <section class="grid">

      <div class="box">
         <img src="images/email-icon.png" alt="">
         <h3>Notre e-mail</h3>
         <a href="mailto:shavocataffaires@gmail.com">shavocataffaires@gmail.com</a>
         
      </div>

      

      <div class="box">
         <img src="images/map-icon.png" alt="">
         <h3>Notre adresse</h3>
         <a href="#">Rue de l'espoir ,Megrine, Tunis </a>
      </div>

      <div class="box">
         <img src="images/phone-icon.png" alt="">
         <h3>Notre numéro de téléphone</h3>
         <a href="tel:1234567890">72 448 596</a>
      </div>

   </section>

   <div class="credit">&copy; copyright @ <?= date('Y'); ?> By <span>Hammemi W. & Lafi S.</span> | All rights reserved.</div>

</footer>

