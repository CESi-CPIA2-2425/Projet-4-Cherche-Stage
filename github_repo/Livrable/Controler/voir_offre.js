function verifierInscription() {
    fetch("../Controler/inscription_pil.php", {
        method: "GET"
    })
    .then(response => {
        if (!response.ok) { 
            throw new Error("Réponse serveur invalide");
        }
        return response.json();
    })
    .then(data => {
        if (data.valeur) {
            alert("Validation réussie : " + data.valeur);
                Swal.fire({
                    title: "Vous êtes connecté en tant que pilote. Souhaitez vous découvrir l'annonce et y postuler ?",
                    icon: "",
                    showCancelButton: true,
                    confirmButtonText: "Découvrir",
                    cancelButtonText: "Retour",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "postuler.html";
                    }
                });
        } else {
            console.log("Aucune donnée reçue, redirection...");
            setTimeout(() => {
                window.location.href = "postuler.html"; 
            }, 2000);
        }
    })
    .catch(error => {
        console.error("Erreur AJAX :", error);

        // 🔹 Forcer la redirection immédiatement
        setTimeout(() => {
            Swal.fire({
                title: "Vous êtes connecté en tant que pilote. Souhaitez vous découvrir l'annonce et y postuler ?",
                icon: "",
                showCancelButton: true,
                confirmButtonText: "Découvrir",
                cancelButtonText: "Retour",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "postuler.html";
                }
            });
        }, 500);
    });
}

// Ajouter un écouteur d'événement sur le bouton
document.getElementById("verifier-btn").addEventListener("click", verifierInscription);
