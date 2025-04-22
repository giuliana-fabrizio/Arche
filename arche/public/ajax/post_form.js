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


async function editPost(data, fileInput, id_div) {
    try {
        const request = await fetch(`/teacher/ajax/edit/post/${data['id_post']}`, {
            method: 'PUT',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            },
            body: JSON.stringify(data),
        });

        let response = await request.json();

        if (response.code == 200) {
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0]

                const file_data = new FormData();
                file_data.append('file', file);

                response = await updatePostFile(data['id_post'], file_data);
                response = await response.json()
            }
            document.getElementById(id_div).remove();

            const section_posts = document.getElementById(`id_section_${data.id_section}_posts`);
            section_posts.insertAdjacentHTML('beforeend', response.html); // TODO tenir compte de la position demandée par le user

            document.getElementById(`id_ajax_no_post_section_${data.id_section}`).style.display = "none";
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


async function getSectionPosts() {
    const id_section = document.getElementById("id_section_post_form").value;

    try {
        const request = await fetch(`/teacher/ajax/posts/${id_section}`, {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            }
        });

        const response = await request.json();

        if (response.code == 200) {
            const select = document.getElementById("id_classement_post_form");
            removeAllChildNodes(select);

            const posts = response.posts;

            posts.forEach((post, index) => {
                const option = document.createElement("option");
                option.value = index + 1;
                option.textContent = post.label + " : position " + (index + 1);
                select.appendChild(option);
            });
        }
    } catch (error) {
        console.error("Erreur lors de l'ajout de section:", error);
    }
}


async function getPostType(id_ue, id_section) {
    try {
        const request = await fetch(`/teacher/ajax/post_type`, {
            method: 'GET',
            headers: {
                "Content-Type": "application/json",
                "X-Requested-with": "XMLHttpRequest"
            }
        });

        const response = await request.json();
        await getSections(id_ue, "id_section_post_form", id_section);

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