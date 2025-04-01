<?php
session_start(); // Démarrage de session

// Connexion à la base de données
$host = 'localhost';
$dbname = 'stage';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Récupération des champs du formulaire
    $entreprise = htmlspecialchars($_POST['entreprise']);   // Nom de l'entreprise
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $adresse = htmlspecialchars($_POST['address']);
    $siret = htmlspecialchars($_POST['SIRET']);
    $siren = htmlspecialchars($_POST['SIREN']);
    $domaine = htmlspecialchars($_POST['domaine']);
    $mot_de_passe = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = 'entreprise';

    try {
        // Vérifier si l'email est déjà utilisé
        $stmt = $pdo->prepare("SELECT Id_uti FROM Utilisateur WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            echo "Erreur : cet email est déjà utilisé.";
            exit;
        }

        // Insertion dans la table Utilisateur
        $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $mot_de_passe, $role]);

        $id_utilisateur = $pdo->lastInsertId();

        // Insertion dans la table Entreprise (adapter à ta structure réelle)
        $stmt = $pdo->prepare("INSERT INTO Entreprise (nom_ent, adresse, siret, siren, domaine_activite, Id_uti) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$entreprise, $adresse, $siret, $siren, $domaine, $id_utilisateur]);

        // 🔐 Création de la session utilisateur
        $_SESSION['id'] = $id_utilisateur;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;

        // ✅ Affichage JS pour debug
        echo "<script>console.log('Session ID: " . $_SESSION['id'] . "');</script>";
        echo "Inscription réussie !";

    } catch (PDOException $e) {
        http_response_code(500);
        echo "Erreur lors de l'insertion : " . $e->getMessage();
        exit;
    }
}
?>

