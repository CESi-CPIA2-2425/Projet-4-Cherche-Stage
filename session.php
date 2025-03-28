<?php
session_start();

// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['id']) || !isset($_SESSION['role'])) {
    header("Location: login.html?erreur=non_connecte");
    exit();
}

// Si on impose un rôle spécifique pour la page
if (isset($roleAutorise) && $_SESSION['role'] !== $roleAutorise) {
    header("Location: login.html?erreur=acces_interdit");
    exit();
}
?>
