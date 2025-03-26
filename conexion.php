<?php
session_start(); // Démarrer la session

$host = 'localhost';
$dbname = 'projetstage';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {

        $email = $_POST["email"]; // Pas besoin de htmlspecialchars ici
        $password = $_POST["password"];

        $sql = "SELECT mdp_crypte FROM utilisateur WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(":email", $email, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo "MDP Form : " . $password . "<br>";
            echo "MDP BDD : " . $result['mdp_crypte'] . "<br>";

            if ($password === $result['mdp_crypte']) {
                $_SESSION['email'] = $email;
                echo "Connexion réussie.";
                header("refresh:2;url=dashboard.php");
                exit();
            } else {
                echo "Échec de la connexion.";
            }
        } else {
            echo "Échec de la connexion.";
        }
    }
}
?>