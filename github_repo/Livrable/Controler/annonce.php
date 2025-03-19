<?php
header("Content-Type: application/json"); // Indiquer que la réponse est en JSON

// Connexion à la base de données
$host = "localhost";
$dbname = "stage"; // Remplace par le bon nom de ta BDD
$username = "root"; // Remplace si besoin
$password = "root"; // Remplace si besoin

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => "Erreur de connexion : " . $e->getMessage()]);
    exit;
}

// Requête SQL pour récupérer les offres
$query = "SELECT a.ID_ano, a.description, e.nom_ent, e.activite 
          FROM Annonce a 
          JOIN Entreprise e ON a.ID_ent = e.ID_ent";
$stmt = $pdo->prepare($query);
$stmt->execute();
$annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Renvoyer les données en JSON
echo json_encode($annonces);
?>