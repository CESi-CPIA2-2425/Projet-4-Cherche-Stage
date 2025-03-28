<?php
session_start();



if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'etudiant') {
    die("Accès interdit.");
}

$host = 'localhost';
$dbname = 'stage';
$username = 'root';
$password = '';

// Connexion BDD
try {
    $pdo = new PDO("mysql:host=localhost;dbname=stage;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur BDD : " . $e->getMessage()); // 🔥 Affiche le vrai message d'erreur
}

// Récupération des données
$id_uti = $_SESSION['id'];
$id_ann = isset($_POST['id_ann']) ? $_POST['id_ann'] : null;
$lettre = isset($_POST['message']) ? substr($_POST['message'], 0, 800) : '';
$cvPath = null;

// Upload CV
if (isset($_FILES['cv']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
    $fichierTmp = $_FILES['cv']['tmp_name'];
    $nomFichier = basename($_FILES['cv']['name']);
    $extension = strtolower(pathinfo($nomFichier, PATHINFO_EXTENSION));
    $tailleMax = 2 * 1024 * 1024; // 2Mo
    $extAutorisees = ['pdf', 'doc', 'docx', 'odt', 'rtf', 'jpg', 'png'];

    if (!in_array($extension, $extAutorisees)) {
        die("Format de fichier non autorisé.");
    }

    if ($_FILES['cv']['size'] > $tailleMax) {
        die("Fichier trop volumineux.");
    }

    $dossier = "uploads/";
    if (!is_dir($dossier)) {
        mkdir($dossier, 0777, true);
    }

    $nomUnique = uniqid("cv_") . "." . $extension;
    $cheminFinal = $dossier . $nomUnique;

    if (move_uploaded_file($fichierTmp, $cheminFinal)) {
        $cvPath = $cheminFinal;
    } else {
        die("Erreur lors du téléchargement du fichier.");
    }
} else {
    die("Aucun fichier envoyé.");
}

// Insertion en BDD
try {
    $stmt = $pdo->prepare("INSERT INTO postuler (id_uti, id_ann, cv, lettre_motivation) VALUES (:id_uti, :id_ann, :cv, :lettre)");
    ;
    $stmt->execute([
        ':id_uti' => $id_uti,
        ':id_ann' => $id_ann,
        ':cv' => $cvPath,
        ':lettre' => $lettre
    ]);

    echo "Votre candidature a été envoyée avec succès.";
    header("refresh:2;url=accueil_etu.html");
    exit();
} catch (PDOException $e) {
    die("Erreur lors de la soumission : " . $e->getMessage());


}
