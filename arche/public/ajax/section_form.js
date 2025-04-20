async function addSection(origin, section) {
    try {
        const request = await fetch(`/teacher/ajax/create/section`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(section),
        });

        const response = await request.json();

        if (response.code == 200) {
            if (origin == "post_form") {
                const select_section = document.getElementById("id_section_post");
                const option = document.createElement("option");

                option.value = response.section_id;
                option.innerHTML = response.section_label;
                option.selected = true;

                select_section.appendChild(option);
            } else {
                const cours = document.getElementById("id_cours");
                cours.insertAdjacentHTML('beforeend', response.html); // TODO tenir compte de la position demandée par le user
            }

            document.getElementById("id_ajax_no_result").style.display = "none";
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}