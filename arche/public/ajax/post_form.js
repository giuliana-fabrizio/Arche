async function addPost(post, fileInput) {
    try {
        const request = await fetch(`/teacher/ajax/create/post`, {
            method: 'POST',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(post),
        });

        let response = await request.json();

        if (response.code == 200) {
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0]
                const id_post = response.id_post;

                const data = new FormData();
                data.append('file', file);

                response = await updatePostFile(id_post, data);
                response = await response.json()
            }

            const section_posts = document.getElementById(`id_section_${post.id_section}_posts`);
            section_posts.insertAdjacentHTML('beforeend', response.html); // TODO tenir compte de la position demandée par le user

            document.getElementById(`id_ajax_no_post_section_${post.id_section}`).style.display = "none";
            closeModalPost();
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}


async function updatePostFile(id_post, file) {
    try {
        return await fetch(`/teacher/ajax/update/post_file/${id_post}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: file
        });
    } catch (error) {
        console.error("Erreur lors de l'update du fichier:", error);
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
            removeAllChildNodes(select);

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


function removeAllChildNodes(parent) {
    const options = parent.querySelectorAll("option:not([disabled])");
    options.forEach(option => option.remove());
}