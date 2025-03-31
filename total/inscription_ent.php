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
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mot_de_passe = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $civilite = htmlspecialchars($_POST['civilite']);
    $role = 'entreprise';

    // Informations supplémentaires entreprise (ex : domaine, SIRET, etc.)
    $domaine = isset($_POST['domaine']) ? htmlspecialchars($_POST['domaine']) : null;
    $siret = isset($_POST['siret']) ? htmlspecialchars($_POST['siret']) : null;

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

        // Insertion dans la table Entreprise (adapter les champs selon ton modèle)
        $stmt = $pdo->prepare("INSERT INTO Entreprise (nom_ent, domaine_activite, siret, Id_uti) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $domaine, $siret, $id_utilisateur]);

        // 🔐 Création de la session utilisateur
        $_SESSION['id'] = $id_utilisateur;
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;

        // ✅ Affichage JS en console pour vérifier que la session est bien créée
        echo "<script>console.log('Session ID: " . $_SESSION['id'] . "');</script>";
        echo "Inscription réussie !";

    } catch (PDOException $e) {
        http_response_code(500);
        echo "Erreur lors de l'insertion : " . $e->getMessage();
        exit;
    }
}
?>

