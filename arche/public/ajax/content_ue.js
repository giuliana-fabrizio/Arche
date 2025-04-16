async function deletePost(id) {
    if (window.confirm("Souhaitez-vous vraiment supprimer ce post ?")) {
        try {
            const request = await fetch(`/teacher/ajax/delete/post/${id}`, {
                method: 'DELETE',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
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


async function deleteSection(id) {
    if (window.confirm("Souhaitez-vous vraiment supprimer cette section et tous les posts qui lui sont rattachés ?")) {
        try {
            const request = await fetch(`/teacher/ajax/delete/section/${id}`, {
                method: 'DELETE',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
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