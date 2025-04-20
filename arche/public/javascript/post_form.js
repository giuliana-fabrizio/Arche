const action_post_modal = document.getElementById("id_action_modal_post");
const modal_post = document.getElementById('id_add_post_modal');
const form_post = document.getElementById('id_form_post'); // TODO form file

document.addEventListener('DOMContentLoaded', function () {
    modal_post.addEventListener('hidden.bs.modal', function () {
        const id_post = document.getElementById("id_section_form");
        id_post.value = "";

        clearPostForm();
    });
});


function changePostTabs(dest) {
    if (dest == "text") {
        document.getElementById("id_post_form_text").style.display = "block";
        document.getElementById("id_text_tabs").classList.add("active");
        document.getElementById("id_post_form_file").style.display = "none";
        document.getElementById("id_file_tabs").classList.remove("active");
    } else {
        document.getElementById("id_post_form_file").style.display = "block";
        document.getElementById("id_file_tabs").classList.add("active");
        document.getElementById("id_post_form_text").style.display = "none";
        document.getElementById("id_text_tabs").classList.remove("active");
    }
}


function clearPostForm() {
    form_post.reset();
    document.querySelectorAll(".is-invalid").forEach(el => el.classList.remove("is-invalid"));
}


function closeModalPost() {
    const modalInstance = bootstrap.Modal.getInstance(modal_post) || new bootstrap.Modal(modal_post);
    modalInstance.hide();
}


function displaySectionForm() {
    document.getElementById("id_display_section_form").classList.toggle("d-none");
}


function isTabsText() {
    return document.getElementById("id_post_form_text").style.display == "" ||
    document.getElementById("id_post_form_text").style.display == "block";
}


function modalPost() {
    const formElements = form_post.querySelectorAll("input, textarea, select");
    const formData = {};
    let errors = "";

    formElements.forEach(element => {
        const key = element.name;
        const value = element.value.trim();

        if (
            (!["id_classement", "id_post", "id_file"].includes(key)) &&
            ((element.tagName === "SELECT" && element.options[element.selectedIndex].disabled) || (value === ""))
        ) {
            const label = document.querySelector(`label[for="${key}_post_form"]`);
            errors += `- ${label.textContent} ;\n`;
        } else {
            formData[key] = value;
        }
    });

    if (errors != "") return alert(`Veuillez remplir tous les champs requis :\n${errors}`);

    action_post_modal.innerText === "add" ? addPost(formData) : editPost(formData);
    closeModalPost();
}