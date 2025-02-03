// Fonction de validation du formulaire
function validateForm(event) {
    event.preventDefault();  // Empêche l'envoi du formulaire si des erreurs sont présentes

    // Cibler les inputs du formulaire
    const lastname = document.querySelector('input[name="lastname"]');
    const surname = document.querySelector('input[name="surname"]');
    const email = document.querySelector('input[name="email"]');
    const password = document.querySelector('input[name="password"]');

    // Réinitialiser les messages d'erreur
    clearErrors();

    // Vérifier si le nom est vide
    if (lastname.value.trim() === '') {
        displayError(lastname, 'Le nom est requis.');
    }

    // Vérifier si le prénom est vide
    if (surname.value.trim() === '') {
        displayError(surname, 'Le prénom est requis.');
    }

    // Vérifier si l'email est vide ou mal formé
    if (email.value.trim() === '') {
        displayError(email, 'L\'email est requis.');
    } else if (!/\S+@\S+\.\S+/.test(email.value)) {
        displayError(email, 'L\'email n\'est pas valide.');
    }

    // Vérifier si le mot de passe est vide ou trop court
    if (password.value.trim() === '') {
        displayError(password, 'Le mot de passe est requis.');
    } else if (password.value.length < 6) {
        displayError(password, 'Le mot de passe doit contenir au moins 6 caractères.');
    }
}

// Fonction pour afficher un message d'erreur
function displayError(input, message) {
    const errorMessage = document.createElement('div');
    errorMessage.classList.add('error');
    errorMessage.innerText = message;

    // Afficher l'erreur sous l'input
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
const form = document.querySelector('form');
form.addEventListener('submit', validateForm);
