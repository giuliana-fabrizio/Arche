async function deleteUe(id) {
    if (window.confirm("Souhaitez-vous vraiment supprimer cette ue ?")) {
        try {
            const request = await fetch(`/teacher/ajax/delete/ue/${id}`, {
                method: 'DELETE',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-with": "XMLHttpRequest"
                }
            });

            let response = await request.text();
            response = JSON.parse(response);

            if (response == 200) {
                document.getElementById(id).remove()
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des données:", error);
        }
    }
}


async function deleteUser(id) {
    if (window.confirm("Souhaitez-vous vraiment supprimer cet utilisateur ?")) {
        try {
            const request = await fetch(`/admin/ajax/delete/user/${id}`, {
                method: 'DELETE',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-with": "XMLHttpRequest"
                }
            });

            let response = await request.text();
            response = JSON.parse(response);

            if (response == 200) {
                document.getElementById(id).remove()
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des données:", error);
        }
    }
}