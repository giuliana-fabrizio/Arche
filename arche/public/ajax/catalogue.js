async function deleteUe(id) {

    try {
        const request = await fetch(`/ajax/delete/ue/${id}`, {
            method: 'DELETE',
            headers: {
                "Content-Type": "application/json", // TODO cette ligne indique dans l'entête de la requête qu'il y aura du contenu JSON
                "X-Requested-with": "XMLHttpRequest" // TODO cette ligne indique dans l'entête de la requête qu'il s'agit d'une requête ajax
            }
        });

        let response = await request.text();
        response = JSON.parse(response);

        document.getElementById(id).remove()
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    }
}


async function deleteUser(id) {

    try {
        const request = await fetch(`/ajax/delete/user/${id}`, {
            method: 'DELETE',
            headers: {
                "Content-Type": "application/json", // TODO cette ligne indique dans l'entête de la requête qu'il y aura du contenu JSON
                "X-Requested-with": "XMLHttpRequest" // TODO cette ligne indique dans l'entête de la requête qu'il s'agit d'une requête ajax
            }
        });

        let response = await request.text();
        response = JSON.parse(response);

        document.getElementById(id).remove()
    } catch (error) {
        console.error("Erreur lors de la récupération des données:", error);
    }
}