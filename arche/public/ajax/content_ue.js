async function deletePost(id) {
    const send_id = id.replace(/^id_section_\d+_post_/, '');
    if (window.confirm("Souhaitez-vous vraiment supprimer ce post ?")) {
        try {
            const request = await fetch(`/teacher/ajax/delete/post/${send_id}`, {
                method: 'DELETE',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            let response = await request.text();
            // response = JSON.parse(response);

            if (response == 200) {
                document.getElementById(id).remove();
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des données:", error);
        }
    }
}


async function deleteSection(id) {
    const send_id = id.replace('id_section_', '');
    if (window.confirm("Souhaitez-vous vraiment supprimer cette section et tous les posts qui lui sont rattachés ?")) {
        try {
            const request = await fetch(`/teacher/ajax/delete/section/${send_id}`, {
                method: 'DELETE',
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            });

            let response = await request.text();
            //response = JSON.parse(response);

            if (response == 200) {
                document.getElementById(id).remove()
            }
            const actions = document.querySelectorAll(".bg-section-actions");
            if (actions.length == 0) {
                document.getElementById("id_ajax_no_result").style.display = "block";
            }
        } catch (error) {
            console.error("Erreur lors de la récupération des données:", error);
        }
    }
}