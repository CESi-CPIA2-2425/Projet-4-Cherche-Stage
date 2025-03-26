// Fonction de validation du formulaire
function validateForm() {
    const nom = document.querySelector('input[name="nom"]');
    const prenom = document.querySelector('input[name="prenom"]');
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');

    clearErrors();
    let isValid = true;

    if (nom.value.trim() === '') {
        displayError(nom, 'Le nom est requis.');
        isValid = false;
    }

    if (prenom.value.trim() === '') {
        displayError(prenom, 'Le prénom est requis.');
        isValid = false;
    }

    if (email.value.trim() === '') {
        displayError(email, 'L\'email est requis.');
        isValid = false;
    } else if (!/\S+@\S+\.\S+/.test(email.value)) {
        displayError(email, 'L\'email n\'est pas valide.');
        isValid = false;
    }

    if (password.value.trim() === '') {
        displayError(password, 'Le mot de passe est requis.');
        isValid = false;
    } else if (password.value.length < 6) {
        displayError(password, 'Le mot de passe doit contenir au moins 6 caractères.');
        isValid = false;
    } else if (!/[A-Z]/.test(password.value)) {
        displayError(password, 'Le mot de passe doit contenir au moins une majuscule.');
        isValid = false;
    } else if (!/[0-9]/.test(password.value)) {
        displayError(password, 'Le mot de passe doit contenir au moins un chiffre.');
        isValid = false;
    } else if (!/[!@#$%^&*(),.?":{}|<>]/.test(password.value)) {
        displayError(password, 'Le mot de passe doit contenir au moins un caractère spécial.');
        isValid = false;
    }

    document.getElementById('submit-btn').disabled = !isValid;
    return isValid;
}

// Fonction d'affichage des erreurs
function displayError(input, message) {
    const errorMessage = document.createElement('div');
    errorMessage.classList.add('error');
    errorMessage.innerText = message;
    input.parentNode.appendChild(errorMessage);
}

// Effacer les erreurs existantes
function clearErrors() {
    document.querySelectorAll('.error').forEach(error => error.remove());
}

// Gestion du formulaire en AJAX
document.querySelector('form').addEventListener('submit', function(event) {
    event.preventDefault(); // Empêcher le rechargement de la page

    if (!validateForm()) {
        alert("Veuillez corriger les erreurs avant de soumettre.");
        return;
    }

    const formData = new FormData(this);

    fetch('inscription_etu.php', {
        method: 'POST',
        body: formData
    })
        .then(response => response.text()) // Récupérer la réponse du serveur
        .then(data => {
            if (data.includes("Inscription réussie")) {
                alert("Inscription réussie !");

            } else {
                alert(data); // Afficher le message d'erreur reçu du PHP
            }
        })
        .catch(error => console.error('Erreur lors de la requête:', error));
});
