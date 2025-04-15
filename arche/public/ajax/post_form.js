async function addSection(section) {
    try {
        const request = await fetch(`/ajax/create/section`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(section),
        });

        let response = await request.text();
        response = JSON.parse(response);

        if (response == 200) {
            const select_section = document.getElementById("id_section_post");
            const option = document.createElement("option");
            option.value = section['name']; // TODO mettre l'id
            option.innerHTML = section['name'];
            option.selected = true;
            select_section.appendChild(option);
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}