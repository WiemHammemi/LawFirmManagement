<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bureau_avocats";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Erreur de connection : " . $conn->connect_error);
}
   $id = $_GET['id_aff'];
    $query = "SELECT * FROM document WHERE id_aff= $id
    AND typea like 'avocat%'
    ORDER BY datedoc";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
if ($result && mysqli_num_rows($result) > 0) {
     // Output the PDF file contents
    //header('Content-Type: application/pdf');
   // header('Content-Disposition: inline; filename="file.pdf"');
   echo '<a href="' . $row['nomdoc'] . '"> voir ici fichier importé le .' . $row['datedoc'] . '</a>';
  } else {
    echo "Pas de fichiers.";
  }
	?>


