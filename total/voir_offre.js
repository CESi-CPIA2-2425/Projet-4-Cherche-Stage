document.addEventListener("click", function (event) {
    if (event.target && event.target.classList.contains("verifier-btn")) {
        const id_ann = event.target.getAttribute("data-id");

        fetch("get_role.php")
        .then(response => {
            if (!response.ok) throw new Error("Erreur serveur");
            return response.json();
        })
        .then(data => {
            const role = data.role;

            if (role === "pilote") {
                Swal.fire({
                    title: "Vous êtes connecté en tant que pilote. Souhaitez-vous découvrir l'annonce et y postuler ?",
                    icon: "question",
                    showCancelButton: true,
                    confirmButtonText: "Découvrir",
                    cancelButtonText: "Retour",
                    confirmButtonColor: "#2368e1",
                    cancelButtonColor: "#d33",
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "postuler.php?id_ann=" + id_ann;
                    }
                });
            } else if (role === "etudiant") {
                window.location.href = "postuler.php?id_ann=" + id_ann;
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "Vous devez être connecté pour postuler.",
                    showConfirmButton: true
                });
            }
        })
        .catch(error => {
            console.error("Erreur AJAX :", error);
            Swal.fire({
                icon: "error",
                title: "Erreur serveur",
                text: "Impossible de vérifier votre rôle."
            });
        });
    }
});

