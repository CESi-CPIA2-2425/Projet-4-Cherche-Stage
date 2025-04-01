<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

$host = "localhost";
$dbname = "stage";
$username = "root";
$password = "root";

// 🔐 Vérifie que l'utilisateur est bien connecté
// if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'entreprise') {
//     die("Erreur : accès réservé aux entreprises.");
// }

// 🔧 ID temporaire statique pour tests
$id_utilisateur = 9;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupère les infos de l'entreprise liée à l'utilisateur
$stmtEnt = $pdo->prepare("SELECT * FROM Entreprise WHERE Id_uti = :id_uti");
$stmtEnt->execute(['id_uti' => $id_utilisateur]);
$entreprise = $stmtEnt->fetch(PDO::FETCH_ASSOC);

if (!$entreprise) {
    die("Entreprise non trouvée.");
}

// Récupère les annonces de cette entreprise
$stmtAnnonces = $pdo->prepare("SELECT Id_ann, titre, contenu FROM Annonce WHERE Id_ent = :id_ent");
$stmtAnnonces->execute(['id_ent' => $entreprise['Id_ent']]);
$annonces = $stmtAnnonces->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Entreprise</title>
    <link rel="stylesheet" href="entreprise_ent.css">
    <link rel="icon" href="logo_chap.png">
</head>
<body>
<header style="text-align: center; padding: 20px;">
    <img src="logo.png" alt="Logo" style="width: 500px;">
</header>

<header>
    <div class="navbar">
        <button class="menu-toggle" id="menu-toggle">&#9776;</button>
        <nav class="nav-items-container">
            <ul class="main-menu" id="main-menu">
                <li class="menu-item"><a href="accueil_ent.php">Accueil</a></li>
                <li class="menu-item"><a href="contact_ent.HTML">Contact</a></li>
                <li class="menu-item"><a href="#" class="active">Entreprise</a></li>
                <li class="menu-item"><a href="offre_ent.html">Offre</a></li>
            </ul>
            <div class="auth-links">
                <a href="index.php" class="button">Déconnexion</a>
            </div>
        </nav>
    </div>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Entreprise</a></li>
        </ol>
    </nav>
    <br>
</header>

<main class="content">
    <section class="company">
        <img src="cesi.png" alt="Logo entreprise" class="company-logo">
        <div class="company-info">
            <h2><?= htmlspecialchars($entreprise['nom_ent']) ?></h2>
            <p><?= htmlspecialchars($entreprise['domaine_activite']) ?></p>
            <p><?= htmlspecialchars($entreprise['adresse']) ?></p>
            <button class="offer"><a href="creer_annonce.php" style="color:white;">+ Créer une offre</a></button>
            <button class="profile"><a href="modifierprofil_ent.html" style="color:white;">Modifier mon profil</a></button>
        </div>
    </section>

    
</main>

<footer class="footer">
  <div class="footer-container">
    <div class="footer-column">
      <img src="logo_chap.png" alt="Logo principal" class="footer-logo">
    </div>

    <div class="footer-column">
      <h3>Coordonnées</h3>
      <a style='color:#ffffff' href="https://www.google.fr/maps/place/Campus+CESI/">Immeuble Le Quatrième Zone Aéroportuaire, 34130 Mauguio</a>
      <p><i class="fa-solid fa-envelope"></i> contact@cesi.fr</p>
      <p><i class="fa-solid fa-phone"></i> +33 6 12 34 56 78</p>
    </div>

    <div class="footer-column">
      <h3>Navigation</h3>
      <ul class="footer-links">
        <li><a href="coockies_ent.html">Cookies</a></li>
        <li><a href="faq_ent.html">F.A.Q</a></li>
        <li><a href="cgu_ent.html">Conditions générales</a></li>
        <li><a href="protection_ent.html">Politique de protection des données</a></li>
        <li><a href="mentions_legales_ent.html">Mentions légales</a></li>
      </ul>
    </div>

    <div class="footer-column">
      <h3>Suivez-nous</h3>
      <div class="social-buttons">
        <a href="https://x.com/cesi_officiel" target="_blank"><img src="Twitter.png"></a>
        <a href="https://www.tiktok.com/@bde_cesi_mtp" target="_blank"><img src="tiktok.png"></a>
        <a href="https://www.instagram.com/bde.cesi.montpellier" target="_blank"><img src="instagram.png"></a>
      </div>
    </div>
  </div>

  <div class="footer-bottom">
    <p>© 2025 - Tous droits réservés. <a href="mentions_legales.html">Mentions légales</a></p>
  </div>
</footer>
</body>
</html>

