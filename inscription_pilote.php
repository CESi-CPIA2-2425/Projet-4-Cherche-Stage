<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'stage';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo "Erreur de connexion : " . $e->getMessage();
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mot_de_passe = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $civilite = htmlspecialchars($_POST['civilite']);
    $role = htmlspecialchars($_POST['role']); // "pilote" en principe

    try {
        // Vérifier si l'email existe déjà
        $stmt = $pdo->prepare("SELECT Id_uti FROM Utilisateur WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            echo "Erreur : cet email est déjà utilisé.";
            exit;
        }

        // Insertion dans utilisateur
        $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, prenom, email, mdp_crypte, civilite, role) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nom, $prenom, $email, $mot_de_passe, $civilite, $role]);

        $id_utilisateur = $pdo->lastInsertId();

        // Insertion dans pilote
        $stmt = $pdo->prepare("INSERT INTO Pilote (Id_uti) VALUES (?)");
        $stmt->execute([$id_utilisateur]);

        echo "Inscription réussie !";

    } catch (PDOException $e) {
        http_response_code(500);
        echo "Erreur lors de l'insertion : " . $e->getMessage();
        exit;
    }
}
?>
