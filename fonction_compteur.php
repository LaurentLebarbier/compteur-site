<?php
// Script php "fonction_compteur.php" www.yakafaire.eu

// Pour connecter, votre base de données
  $db_host = "localhost";
  $db_username = "laurent";
  $db_password = "h9xt2ya1";
  $db_database = "site_visite";

$conn = new mysqli($db_host, $db_username, $db_password, $db_database);

  if ($conn->connect_error) {
    die('<p>La connexion au serveur MySQL a échoué: '. $conn->connect_error .'</p>');
  }

// Fonction pour obtenir l'adresse ip du visiteur
function getIp(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
      $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
      $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
      $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
  }

   $compteur_page = 1; // Nombre de visite du visiteur sur la page
   $date_vue_j =  date('y-m-d h:i:s'); // Date de la visite
   $ip_visite = getIp(); // Ip du visiteur

// Pour savoir si le visiteur à déja vue la page
$req = "SELECT * FROM compteur_php";
$res = $conn->query($req);
$trouve = 0;
$ajout = 0;
while ($data = mysqli_fetch_array($res) )
{
$recherche_ip = $data['ip_visite']; // Compare Ip visiteur
$recherche_page = $data['page_vue']; //Compare nom de la page

// Si le visiteur à déja vue la page
if ($recherche_ip == $ip_visite and $recherche_page == $page_vue) {
$recup_id = $data['Id']; // récupere Id du visiteur
$ajout = $data['compteur_page'] +1; // Ajoute 1 à son compteur page
$trouve = 1; // le visiteur à déja vue la page
}
}

// Si trouve = "1" modification compteur_page du visiteur
if ($trouve == 1){
$req = " UPDATE `compteur_php` SET compteur_page = $ajout WHERE `Id`= $recup_id";
$conn->query($req);
}
// Si trouve = "0" Exécute une requête sur la base de données
 if ($trouve == 0){
 $req = "INSERT INTO compteur_php (page_vue, compteur_page, date_vue, ip_visite) VALUES ('$page_vue', '$compteur_page', '$date_vue_j', '$ip_visite')";
$conn->query($req);
}

// récupere le nombre de visite de la page
 $req = "SELECT * FROM compteur_php";
 $res = $conn->query($req);
$nombre_visite = 0; // sans tenir compte de combien de fois le visiteur à vue la page
$nombre_total_visite = 0; // en tenant compte de combien de fois le visiteur à vue la page
while ($data = mysqli_fetch_array($res) )
{
$recherche_page = $data['page_vue'];
if ($recherche_page == $page_vue) {
$nombre_visite = $nombre_visite +1;
$nombre_total_visite = $nombre_total_visite + $data['compteur_page'];
}
}
// affiche le résultat sur la page
echo $nombre_total_visite.' visites';
//echo "<br>";
//echo $nombre_visite. ' visites';

mysqli_close($conn);
 ?>
