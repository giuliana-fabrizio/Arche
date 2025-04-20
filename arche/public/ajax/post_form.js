async function addPost(post) {
    try {
        const request = await fetch(`/teacher/ajax/create/post`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(post),
        });

        const response = await request.json();

        if (response.code == 200) {
            const section_posts = document.getElementById(`id_section_${post.id_section}_posts`);
            section_posts.insertAdjacentHTML('beforeend', response.html); // TODO tenir compte de la position demandée par le user

            document.getElementById(`id_ajax_no_post_section_${post.id_section}`).style.display = "none";
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}


async function getPostType() {
    try {
        const request = await fetch(`/teacher/ajax/post_type`, {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            }
        });

        const response = await request.json();

        if (response.code == 200) {
            const select = document.getElementById("id_type_post_form");
            const post_types = response.post_type;

            post_types.forEach(type => {
                const option = document.createElement("option");
                option.value = type.id;
                option.textContent = type.label;
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}