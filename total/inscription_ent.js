document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('form');
    const submitButton = document.getElementById('submit-btn');

    // Fonction de validation
    function validateForm() {
        clearErrors();

        const entreprise = document.querySelector('input[name="entreprise"]');
        const nom = document.querySelector('input[name="nom"]');
        const prenom = document.querySelector('input[name="prenom"]');
        const email = document.querySelector('input[name="email"]');
        const password = document.querySelector('input[name="password"]');
        const domaine = document.querySelector('input[name="domaine"]');
        const siret = document.querySelector('input[name="SIRET"]');

        let isValid = true;

        if (entreprise.value.trim() === '') {
            displayError(entreprise, "Le nom de l'entreprise est requis.");
            isValid = false;
        }

        if (nom.value.trim() === '') {
            displayError(nom, "Le nom est requis.");
            isValid = false;
        }

        if (prenom.value.trim() === '') {
            displayError(prenom, "Le prénom est requis.");
            isValid = false;
        }

        if (email.value.trim() === '') {
            displayError(email, "L'email est requis.");
            isValid = false;
        } else if (!/\S+@\S+\.\S+/.test(email.value)) {
            displayError(email, "L'email n'est pas valide.");
            isValid = false;
        }

        if (password.value.trim() === '') {
            displayError(password, "Le mot de passe est requis.");
            isValid = false;
        } else if (password.value.length < 6) {
            displayError(password, "Le mot de passe doit contenir au moins 6 caractères.");
            isValid = false;
        }

        if (domaine.value.trim() === '') {
            displayError(domaine, "Le domaine d'activité est requis.");
            isValid = false;
        }

        if (siret.value.trim() === '') {
            displayError(siret, "Le numéro SIRET est requis.");
            isValid = false;
        } else if (!/^\d{14}$/.test(siret.value)) {
            displayError(siret, "Le numéro SIRET doit contenir exactement 14 chiffres.");
            isValid = false;
        }

        return isValid;
    }

    function displayError(input, message) {
        const error = document.createElement("div");
        error.classList.add("error");
        error.textContent = message;
        input.parentNode.appendChild(error);
    }

    function clearErrors() {
        document.querySelectorAll(".error").forEach(err => err.remove());
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        if (!validateForm()) {
            alert("Veuillez corriger les erreurs avant de soumettre.");
            return;
        }

        const formData = new FormData(form);
        fetch("inscription_ent.php", {
            method: "POST",
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if (data.includes("Inscription réussie")) {
                    alert("Inscription réussie ! Bienvenue !");
                    window.location.href = 'accueil_ent.php';
                } else {
                    alert(data);
                }
            })
            .catch(error => {
                console.error("Erreur AJAX :", error);
                alert("Une erreur est survenue. Veuillez réessayer.");
            });
    });

    document.querySelectorAll("input").forEach(input => {
        input.addEventListener("input", validateForm);
    });
});

