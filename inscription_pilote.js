// Fonction de validation du formulaire
function validateForm() {
    // Cibler les inputs du formulaire, sauf le champ caché 'role'
    const title = document.querySelector('select[name="title"]');
    const nom = document.querySelector('input[name="lastname"]');
    const prenom = document.querySelector('input[name="surname"]');
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');

    clearErrors(); // Réinitialise les erreurs

    let isValid = true;

    // Vérifier si la civilité est sélectionnée
    if (title && title.value === '') {
        displayError(title, 'La civilité est requise.');
        isValid = false;
    }

    // Vérifier si le nom est vide
    if (nom && nom.value.trim() === '') {
        displayError(nom, 'Le nom est requis.');
        isValid = false;
    }

    // Vérifier si le prénom est vide
    if (prenom && prenom.value.trim() === '') {
        displayError(prenom, 'Le prénom est requis.');
        isValid = false;
    }

    // Vérifier si l'email est valide
    if (email && email.value.trim() === '') {
        displayError(email, 'L\'email est requis.');
        isValid = false;
    } else if (email && !/\S+@\S+\.\S+/.test(email.value)) {
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

    // Vérifier si tous les champs nécessaires sont remplis
    const submitButton = document.getElementById('submit-btn');
    if (submitButton) {
        submitButton.disabled = !isValid; // Le bouton sera désactivé si les champs ne sont pas valides
    }

    return isValid;
}

// Fonction pour afficher un message d'erreur
function displayError(input, message) {
    const errorMessage = document.createElement('div');
    errorMessage.classList.add('error');
    errorMessage.innerText = message;
    input.parentNode.appendChild(errorMessage);
}

// Fonction pour effacer les messages d'erreur existants
function clearErrors() {
    const errorMessages = document.querySelectorAll('.error');
    errorMessages.forEach((error) => {
        error.remove();
    });
}

// Ajouter l'événement de validation lors de la soumission du formulaire
const form = document.querySelector('#piloteForm');
if (form) {
    form.addEventListener('submit', function(event) {
        if (!validateForm()) {
            event.preventDefault(); // Empêche la soumission si le formulaire est invalide
            alert("Veuillez corriger les erreurs avant de soumettre.");
        }
    });
}

// Gestion du formulaire en AJAX
form.addEventListener('submit', function(event) {
    event.preventDefault(); // Empêche le rechargement de la page

    if (!validateForm()) {
        alert("Veuillez corriger les erreurs avant de soumettre.");
        return;
    }

    const formData = new FormData(this);

    fetch('inscription_pilote.php', {
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
