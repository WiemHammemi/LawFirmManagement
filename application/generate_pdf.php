<?php

// require('fpdf/fpdf.php');
// @include('factureClPhy.php');
// // Connexion à la base de données
// $servername = "localhost";
//  $username = "root";
//  $password = "";
//  $dbname = "bureau_avocats";
//  $conn = new mysqli($servername, $username, $password, $dbname);
//  if ($conn->connect_error) {
//    die("Erreur de connection : " . $conn->connect_error);
//  }

// session_start();

// if(!($_SESSION['type']=='clientPhy')){
//    header('location:index.php');
// }
?>



<?php
// require_once('tcpdf/tcpdf.php');

// // Récupérer les informations de la facture à partir de la base de données en utilisant l'ID de la facture
// $code = $_GET['code'];
// $sql = "SELECT * FROM facture WHERE code = $code";
// $res = $conn->query($sql);
// $row = $res->fetch_assoc();

// // Créer un nouvel objet TCPDF
// $pdf = new TCPDF();

// // Ajouter une page au PDF
// $pdf->AddPage();

// // Ajouter le contenu de la facture au PDF
// $pdf->SetFont('helvetica', '', 12);
// $pdf->Cell(0, 10, 'Facture : '.$row['code'], 0, 1);
// $pdf->Cell(0, 10, 'Date : '.$row['dateFact'], 0, 1);
// // Ajouter d'autres informations de la facture ici...

// // Sortir le PDF
// $pdf->Output('facture_'.$row['code'].'.pdf', 'D');
require_once('tcpdf/tcpdf.php');

function generate_pdf($data) {
    // Créer une nouvelle instance de TCPDF
    $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    // Ajouter une page
    $pdf->AddPage();

    // Ajouter du contenu au PDF
    $pdf->SetFont('Helvetica', '', 12);
    $pdf->Write(5, 'Contenu du PDF');

    // Générer le PDF
    $pdf->Output('nom_du_fichier.pdf', 'I');
}
?>

