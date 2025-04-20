const action_post_modal = document.getElementById("id_action_modal_post");
const modal_post = document.getElementById('id_add_post_modal');
const form_post = document.getElementById('id_form_post_text'); // TODO form file

document.addEventListener('DOMContentLoaded', function () {
    modal_post.addEventListener('hidden.bs.modal', function () {
        const id_post = document.getElementById("id_section_form");
        id_post.value = "";

        clearPostForm();
    });
});


function changePostTabs(dest) {
    if (dest == "text") {
        document.getElementById("id_form_post_text").style.display = "block";
        document.getElementById("id_text_tabs").classList.add("active");
        document.getElementById("id_form_post_file").style.display = "none";
        document.getElementById("id_file_tabs").classList.remove("active");
    } else {
        document.getElementById("id_form_post_file").style.display = "block";
        document.getElementById("id_file_tabs").classList.add("active");
        document.getElementById("id_form_post_text").style.display = "none";
        document.getElementById("id_text_tabs").classList.remove("active");
    }
}


function clearPostForm() {
    form_post.reset();
}


function closeModalPost() {
    const modalInstance = bootstrap.Modal.getInstance(modal_post) || new bootstrap.Modal(modal_post);
    modalInstance.hide();
}


function displaySectionForm() {
    document.getElementById("id_display_section_form").classList.toggle("d-none");
}


function modalPost() {
    if (form_post.checkValidity()) {
        const formData = {};
        new FormData(form_post).forEach((value, key) => {
            formData[key] = value;
        });

        if (action_post_modal.innerText == "add") {
            addPost(formData);
        } else {
            editPost(formData);
        }
        closeModalPost();
    } else {
        form_post.reportValidity();
    }
}