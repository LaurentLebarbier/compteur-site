<?php
// Pour connecter, votre base de données

  $db_host = "localhost";
  $db_username = "laurent";
  $db_password = "h9xt2ya1";
  $db_database = "site_visite";

$conn = new mysqli($db_host, $db_username, $db_password, $db_database);

  if ($conn->connect_error) {
    die('<p>La connexion au serveur MySQL a échoué: '. $conn->connect_error .'</p>');
  }

 // affiche la table
$req = "SELECT * FROM compteur_php";
$res = $conn->query($req);

// création du tableau
echo "<table> <th>Page vue</th><th>Vue</th><th>Date</th><th>Ip</th>";

while ($data = mysqli_fetch_array($res) )
{
$affiche_page = $data['page_vue']; //récupere nom de la page
$affiche_vue = $data['compteur_page']; //récupere nombre vue
$affiche_date = $data['date_vue']; //récupere date vue
$affiche_ip = $data['ip_visite']; // récupere Ip visiteur

echo "<tr><td>".$affiche_page."</td><td>".$affiche_vue."</td><td>".$affiche_date."</td><td>".$affiche_ip."</td></tr>";
}
echo "</table>";

 mysqli_close($conn);
 ?>
