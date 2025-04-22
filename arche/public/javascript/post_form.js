const action_post_modal = document.getElementById("id_action_modal_post");
const modal_post = document.getElementById('id_add_post_modal');
const form_post = document.getElementById('id_form_post'); // TODO form file

let fileInput = null;
document.getElementById('id_file_post_form').addEventListener('change', function (event) {
    fileInput = event.target;
});


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
    const isFile = document.getElementById("id_post_form_text").style.display == "none";
    const hasfilename = document.getElementById("id_filename_post_form").value;

    const inputToExclude = [
        "id_post_container",
        "id_post",
        "id_classement",
        "id_filename",
        isFile ? "id_type" : "id_file",
        isFile && hasfilename ? "id_file" : ""
    ];
    const formElements = form_post.querySelectorAll("input, textarea, select");
    const formData = {};
    let errors = "";

    formElements.forEach(element => {
        const key = element.name;
        const value = element.value.trim();

        if (
            (!inputToExclude.includes(key)) &&
            ((element.tagName === "SELECT" && element.options[element.selectedIndex].disabled) || (value === ""))
        ) {
            const label = document.querySelector(`label[for="${key}_post_form"]`);
            errors += `- ${label.textContent} ;\n`;
        } else {
            formData[key] = value;
        }
    });

    if (errors != "") return alert(`Veuillez remplir tous les champs requis :\n${errors}`);

    const id_div = document.getElementById("id_post_container").value;
    action_post_modal.innerText === "add" ? addPost(formData, fileInput) : editPost(formData, fileInput, id_div);
}


function wantEditPost(id_container, id_ue, id, label, description, id_section, ranking, post_type, filename) {
    document.getElementById("id_section_post_form").value = id_section;

    getPostType(id_ue, id_section);
    getSectionPosts();
    changePostTabs(post_type ? "text" : "file");

    document.getElementById("id_post_form").value = id;
    document.getElementById("id_post_container").value = id_container;

    document.getElementById("id_title_post_form").value = label;
    document.getElementById("id_description_post_form").value = description;
    document.getElementById("id_classement_post_form").value = ranking;

    document.getElementById("id_type_post_form").value = post_type;
    document.getElementById("id_filename_post_form").value = `Fichier actuel : ${filename.substring(0, 10)}...`;

    document.getElementById("id_title_modal_post").innerText = "Modifier un post";
    action_post_modal.innerText = "edit";
}