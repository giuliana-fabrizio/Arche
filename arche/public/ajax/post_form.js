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
        const posts_to_update = response.posts_to_update;

        if (response.code == 200) {
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0]
                const id_post = response.id_post;

                const data = new FormData();
                data.append('file', file);

                response = await updatePostFile(id_post, data);
                response = await response.json()
            }

            updatePostDisplay(
                post.id_section,
                posts_to_update,
                response.html,
                response.post_ranking
            );

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
        const posts_to_update = response.posts_to_update;

        if (response.code == 200) {
            if (fileInput && fileInput.files.length > 0) {
                const file = fileInput.files[0]

                const file_data = new FormData();
                file_data.append('file', file);

                response = await updatePostFile(data['id_post'], file_data);
                response = await response.json()
            }
            document.getElementById(id_div).remove();

            updatePostDisplay(
                data.id_section,
                posts_to_update,
                response.html,
                response.post_ranking
            );

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


async function getSectionPosts(id_section) {
    id_section = id_section ? id_section : document.getElementById("id_section_post_form").value;

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


function updatePostDisplay(id_section, posts_to_update, current_html, post_ranking) {
    const posts = document.getElementById(`id_section_${id_section}_posts`);

    if (posts_to_update.length == 0) {
        posts.insertAdjacentHTML('afterend', current_html);
        return;
    }

    const first_post = posts_to_update[0];
    const last_post = posts_to_update[posts_to_update.length - 1];
    const first_post_html = document.getElementById(`id_section_${id_section}_post_${first_post.id}`);
    const last_post_html = document.getElementById(`id_section_${id_section}_post_${last_post.id}`);

    if (post_ranking < first_post.ranking) {
        first_post_html.insertAdjacentHTML('beforebegin', current_html);
    } else {
        last_post_html.insertAdjacentHTML('afterend', current_html);
    }

    posts_to_update.forEach(post => {
        const ranking = document.getElementById(`id_section_${id_section}_post_${post.id}_ranking`);
        ranking.innerText = post.ranking;

        const elem_html = document.getElementById(`id_section_${id_section}_post_${post.id}`);
        if (ranking < post_ranking) {
            first_post_html.insertAdjacentElement('afterend', elem_html)
        } else {
            last_post_html.insertAdjacentElement('beforebegin', elem_html)
        }
    });
}


function removeAllChildNodes(parent) {
    const options = parent.querySelectorAll("option:not([disabled])");
    options.forEach(option => option.remove());
}